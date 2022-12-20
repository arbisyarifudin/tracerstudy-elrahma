<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Admin\Form;

use App\Models\Form;
use App\Models\FormSection;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\QuestionRate;
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
      'sections.*.questions.*.question_childs' => [
        'nullable',
        'array'
      ],
      'sections.*.questions.*.question_childs.*.text' => [
        'required'
      ],
      'sections.*.questions.*.question_childs.*.type' => [
        'required'
      ],
      'sections.*.questions.*.question_childs.*.question_options' => [
        'nullable',
        'array'
      ],
      'sections.*.questions.*.question_childs.*.question_options.*.text' => [
        'required'
      ],
      'sections.*.questions.*.question_childs.*.question_options.*.value' => [
        'required'
      ],
    ];

    $messages = [
      'sections.*.title.required' => 'Judul section diperlukan.',
      'sections.*.questions.*.text.required' => 'Judul pertanyaan wajib diisi.',
      'sections.*.questions.*.type.required' => 'Tipe pertanyaan wajib dipilih.',
      'sections.*.questions.*.question_options.*.text.required' => 'Teks opsi wajib diisi.',
      'sections.*.questions.*.question_options.*.value.required' => 'Nilai opsi wajib diisi.',
      'sections.*.questions.*.question_childs.*.text.required' => 'Judul pertanyaan wajib diisi.',
      'sections.*.questions.*.question_childs.*.type.required' => 'Tipe pertanyaan wajib dipilih.',
      'sections.*.questions.*.question_childs.*.question_options.*.text.required' => 'Teks opsi wajib diisi.',
      'sections.*.questions.*.question_childs.*.question_options.*.value.required' => 'Nilai opsi wajib diisi.',
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

      // Form Section
      foreach ($this->request->sections as $key => $section) {
        $formSection = FormSection::create([
          'form_id' => $this->data->id,
          'title' => $section['title'],
          'description' => $section['description'],
          'order' => $key,
        ]);

        // Question
        foreach ($section['questions'] as $key2 => $question) {
          $fomQuestion = Question::create([
            'form_section_id' => $formSection->id,
            'code' => $question['code'],
            'text' => $question['text'],
            'hint' => $question['hint'],
            'type' => $question['type'],
            'default_value' => $question['default_value'],
            'is_default_value_editable' => $question['is_default_value_editable'],
            'order' => $key2,
          ]);

          // Question rates (for linear scale/rating type)
          if (isset($question['question_rate']) && !empty($question['question_rate'])) {
            $questionRate = $question['question_rate'];
            $fomQuestionRate = QuestionRate::create([
              'question_id' => $fomQuestion->id,
              'lowest_rate' => $questionRate['lowest_rate'],
              'lowest_rate_label' => $questionRate['lowest_rate_label'],
              'highest_rate' => $questionRate['highest_rate'],
              'highest_rate_label' => $questionRate['highest_rate_label'],
            ]);
          }

          // Question options
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

          // Question childs
          foreach ($question['question_childs'] as $key4 => $questionChild) {
            $fomQuestionChild = Question::create([
              'parent_id' => $fomQuestion->id,
              'code' => $questionChild['code'],
              'text' => $questionChild['text'],
              'hint' => $questionChild['hint'],
              'type' => $questionChild['type'],
              'default_value' => $questionChild['default_value'],
              'is_default_value_editable' => $questionChild['is_default_value_editable'],
              'order' => $key4,
            ]);

            // Question child options
            foreach ($questionChild['question_options'] as $key4 => $questionChildOption) {
              $fomQuestionChildOption = QuestionOption::create([
                'question_id' => $fomQuestionChild->id,
                'text' => $questionChildOption['text'],
                'hint' => $questionChildOption['hint'],
                'value' => $questionChildOption['value'],
                'is_custom_value' => $questionChildOption['is_custom_value'],
                'order' => $key4,
              ]);
            }

            // Question Child rates (for linear scale/rating type)
            if (isset($questionChild['question_rate']) && !empty($questionChild['question_rate'])) {
              $questionChildRate = $questionChild['question_rate'];
              $fomQuestionRate = QuestionRate::create([
                'question_id' => $fomQuestionChild->id,
                'lowest_rate' => $questionChildRate['lowest_rate'],
                'lowest_rate_label' => $questionChildRate['lowest_rate_label'],
                'highest_rate' => $questionChildRate['highest_rate'],
                'highest_rate_label' => $questionChildRate['highest_rate_label'],
              ]);
            }
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
