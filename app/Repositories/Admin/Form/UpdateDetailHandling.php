<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Admin\Form;

use App\Models\Form;
use App\Models\FormSection;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Update Detail Form Data (Section & Question).
 */
class UpdateDetailHandling
{
  protected $request;
  protected $id;
  protected $data;

  public function __construct(Request $request, $id)
  {
    $this->request  = $request;
    $this->id  = $id;
  }

  public function validate()
  {
    $this->data = Form::where('id', $this->id)->orWhere('slug', $this->id)->first();

    if (!$this->data) {
      throw new \Exception('Form not found!', 404);
    }

    $rules = [
      'sections' => [
        'required',
        'array'
      ],
      'sections.*.title' => [
        'required',
        'string',
      ],
      'sections.*.description' => [
        'nullable',
        'string',
      ],
      'sections.*.questions' => [
        'required',
        'array'
      ],
      'sections.*.questions.*.text' => [
        'required',
        'string'
      ],
      'sections.*.questions.*.type' => [
        'required',
        'string'
      ],
      'sections.*.questions.*.question_options' => [
        'nullable',
        'array'
      ],
      'sections.*.questions.*.question_options.*.text' => [
        'required'
      ],
      'sections.*.questions.*.question_options.*.value' => [
        'required'
      ],
    ];

    $messages = [
      'sections.*.title.required' => 'Judul section diperlukan.',
      'sections.*.questions.*.text.required' => 'Judul pertanyaan wajib diisi.',
      'sections.*.questions.*.type.required' => 'Tipe pertanyaan wajib dipilih.',
      'sections.*.questions.*.question_options.*.text.required' => 'Teks opsi wajib diisi.',
      'sections.*.questions.*.question_options.*.value.required' => 'Nilai opsi wajib diisi.',
    ];
    $validated = Validator::make($this->request->all(), $rules, $messages)->validate();
    return $validated;
  }

  public function handle()
  {
    $validated = $this->validate();

    DB::beginTransaction();
    try {
      FormSection::where('form_id', $this->data->id)->delete();
      foreach ($this->request->sections as $key => $section) {
        $formSection = FormSection::create([
          'form_id' => $this->data->id,
          'title' => $section['title'],
          'description' => $section['description'],
          'order' => $key,
        ]);

        foreach ($section['questions'] as $key2 => $question) {
          $fomQuestion = Question::create([
            'form_section_id' => $formSection->id,
            'code' => $question['code'],
            'text' => $question['text'],
            'type' => $question['type'],
            'default_value' => $question['default_value'],
            'is_default_value_editable' => $question['is_default_value_editable'],
            'order' => $key2,
          ]);
          foreach ($question['question_options'] as $key3 => $option) {
            $fomQuestionOption = QuestionOption::create([
              'question_id' => $fomQuestion->id,
              'text' => $option['text'],
              'hint' => $option['hint'],
              'value' => $option['value'],
              'is_custom_value' => $option['is_custom_value'],
              'order' => $key3,
            ]);
          }
          foreach ($question['question_childs'] as $key4 => $questionChild) {
            $fomQuestionChild = Question::create([
              'parent_id' => $fomQuestion->id,
              'code' => $questionChild['code'],
              'text' => $questionChild['text'],
              'type' => $questionChild['type'],
              'default_value' => $questionChild['default_value'],
              'is_default_value_editable' => $questionChild['is_default_value_editable'],
              'order' => $key4,
            ]);
          }
        }
      }

      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }

    $result = $this->data;
    $result['message'] = 'Questionnaire updated successfully!';
    return $result;
  }
}
