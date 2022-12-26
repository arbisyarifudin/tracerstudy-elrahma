<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Member\Form;

use App\Models\Form;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

/**
 * Submit Form response
 */
class SubmitHandling
{
  protected $request;
  protected $data;

  public function __construct(Request $request)
  {
    $this->request  = $request;
  }

  public function validate()
  {
    // $this->data = Form::where('id', $this->id)->orWhere('slug', $this->id)->first();

    // if (!$this->data) {
    //   throw new \Exception('Form not found!', 404);
    // }

    $rules = [
      'id' => [
        'required',
        Rule::exists(Form::class, 'id')
      ],
      'questions' => [
        'required',
        'array'
      ],
      'questions.*.id' => [
        'required',
        Rule::exists(Question::class, 'id')->whereNull('parent_id')
      ],
      'questions.*.response' => [
        'nullable',
      ],
      'questions.*.question_childs' => [
        'nullable',
        'array'
      ],
      'questions.*.question_childs.*.id' => [
        'required',
        Rule::exists(Question::class, 'id')->whereNotNull('parent_id')
      ],
      'questions.*.question_childs.*.response' => [
        'nullable',
      ],
    ];

    $messages = [
      'questions.*.id.required' => 'ID pertanyaan diperlukan.',
      // 'questions.*.response.required' => 'Jawaban pertanyaan wajib diisi.',
      'questions.*.question_childs.*.id.required' => 'ID pertanyaan diperlukan.',
    ];
    $validated = Validator::make($this->request->all(), $rules, $messages)->validate();
    return $validated;
  }

  public function handle()
  {
    $validated = $this->validate();

    DB::beginTransaction();
    try {
      $questionData = $this->request->input('questions');
      $errorMessages = [];
      foreach ($questionData as $key => $question) {
        if ($question['is_required'] == 1 && empty($question['response'])) {
          // if (empty($question['question_childs'])) {
          $errorMessages["questions.$key.response"] = [
            'Jawaban untuk pertanyaan ini diperlukan.'
          ];
          // }
        }
        if (count($question['question_childs']) > 0) {
          foreach ($question['question_childs'] as $key2 => $questionChild) {
            if ($questionChild['is_required'] == 1 && empty($questionChild['response'])) {
              $errorMessages["questions.$key.question_childs.$key2.response"] = [
                'Jawaban untuk pertanyaan ini diperlukan.'
              ];
            }
          }
        }
      }
      if (!empty($errorMessages)) {
        throw ValidationException::withMessages($errorMessages);
      }

      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }

    $result = $this->data;
    $result['message'] = 'Form submitted successfully!';
    return $result;
  }
}
