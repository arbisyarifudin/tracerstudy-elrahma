<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Member\Form;

use App\Models\Form;
use App\Models\FormResponse;
use App\Models\FormResponseAnswer;
use App\Models\Question;
use App\Models\User;
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
      // validate required question 
      foreach ($questionData as $key => $question) {
        $questionDetailData = Question::find($question['id']);
        if ($questionDetailData->is_required == 1 && empty($question['response'])) {
          // if (empty($question['question_childs'])) {
          $errorMessages["questions.$key.response"] = [
            // "Jawaban untuk pertanyaan <b>{$questionDetailData->text}</b> diperlukan."
            "Jawaban untuk pertanyaan ini diperlukan."
          ];
          // }
        }
        if (count($question['question_childs']) > 0) {
          foreach ($question['question_childs'] as $key2 => $questionChild) {
            $questionChildDetailData = Question::find($questionChild['id']);
            if ($questionChildDetailData->is_required == 1 && empty($questionChild['response'])) {
              $errorMessages["questions.$key.question_childs.$key2.response"] = [
                // "Jawaban untuk pertanyaan <b>{$questionChildDetailData->text}</b> diperlukan."
                "Jawaban untuk pertanyaan ini diperlukan."
              ];
            }
          }
        }
      }

      // throw validation error
      if (!empty($errorMessages)) {
        throw ValidationException::withMessages($errorMessages);
      }

      $user = User::getProfile();

      // save question answer (response)
      $formResponse = FormResponse::where(['form_id' => $validated['id'], 'alumni_id' => $user->alumni->id])->first();
      $formResponseExists = false;
      if ($formResponse) {
        $formResponseExists = true;
      } else {
        $formResponse =  FormResponse::create([
          'form_id' => $validated['id'],
          'alumni_id' => $user->alumni->id
        ]);
      }

      if ($formResponseExists) {
        foreach ($questionData as $key => $question) {
          $questionDetailData = Question::find($question['id']);
          $formResponseAnswerDetailData = FormResponseAnswer::where([
            'form_response_id' => $formResponse->id,
            'question_id' => $question['id'],
          ]);
          if ($formResponseAnswerDetailData->count() > 0) {
            $formResponseAnswerDetailData->update([
              'question_text' => $questionDetailData?->text,
              'question_code' => $questionDetailData?->code,
              'response_answer' => @$question['response']
            ]);
          } else {
            FormResponseAnswer::create([
              'form_response_id' => $formResponse->id,
              'question_id' => $question['id'],
              'question_text' => $questionDetailData?->text,
              'question_code' => $questionDetailData?->code,
              'response_answer' => @$question['response']
            ]);
          }

          foreach ($question['question_childs'] as $key => $questionChild) {
            $questionChildDetailData = Question::find($questionChild['id']);
            $formResponseAnswer2DetailData = FormResponseAnswer::where([
              'form_response_id' => $formResponse->id,
              'question_id' => $questionChild['id'],
            ]);
            if ($formResponseAnswer2DetailData->count() > 0) {
              $formResponseAnswer2DetailData->update([
                'question_text' => $questionChildDetailData?->text,
                'question_code' => $questionChildDetailData?->code,
                'response_answer' => @$questionChild['response']
              ]);
            } else {
              FormResponseAnswer::create([
                'form_response_id' => $formResponse->id,
                'question_id' => $questionChild['id'],
                'question_text' => $questionChildDetailData?->text,
                'question_code' => $questionChildDetailData?->code,
                'response_answer' => @$questionChild['response']
              ]);
            }
          }
        }
      } else {
        $formResponseAnswerInsertData = [];
        foreach ($questionData as $key => $question) {
          $questionDetailData = Question::find($question['id']);
          $formResponseAnswerInsertData[] = [
            'form_response_id' => $formResponse->id,
            'question_id' => $question['id'],
            'question_text' => $questionDetailData?->text,
            'question_code' => $questionDetailData?->code,
            'response_answer' => @$question['response']
          ];

          foreach ($question['question_childs'] as $key => $questionChild) {
            $questionChildDetailData = Question::find($questionChild['id']);
            $formResponseAnswerInsertData[] = [
              'form_response_id' => $formResponse->id,
              'question_id' => $questionChild['id'],
              'question_text' => $questionChildDetailData?->text,
              'question_code' => $questionChildDetailData?->code,
              'response_answer' => @$questionChild['response']
            ];
          }
        }

        if (!empty($formResponseAnswerInsertData)) {
          FormResponseAnswer::insert($formResponseAnswerInsertData);
        }
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
