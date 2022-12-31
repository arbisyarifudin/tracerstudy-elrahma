<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Member\Form;

use App\Models\Alumni;
use App\Models\Form;
use App\Models\FormResponseAnswer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Show active Form Tracerstudy detail data.
 */
class ShowActiveHandling
{
  protected $request;
  protected $data;
  protected $alumni;

  public function __construct(Request $request)
  {
    $this->request  = $request;
  }

  public function validate()
  {
    $this->data = Form::where('is_active', true)->first();

    if (!$this->data) {
      throw new \Exception('Form not found!', 404);
    }
  }

  public function handle()
  {
    $this->validate();
    $user = User::getProfile();

    $data = Form::with([
      'sections.questions.question_options',
      'sections.questions.question_rate',
      'sections.questions.question_childs.question_options',
      'sections.questions.question_childs.question_rate',
    ])->where('id', $this->data->id)->first();

    $this->alumni = Alumni::with(['batch', 'major'])->where('id', $user->alumni->id)->first();

    foreach ($data->sections as $key2 => $section) {
      foreach ($section->questions as $key3 => $question) {
        // get question response
        $answer = FormResponseAnswer::select([
          'form_response_answers.*',
          'form_responses.form_id',
          'form_responses.alumni_id',
        ])
          ->leftJoin('form_responses', 'form_responses.id', '=', 'form_response_answers.form_response_id')
          ->where('form_responses.form_id', $this->data->id)
          ->where('form_responses.alumni_id', $user->alumni?->id)
          ->where('form_response_answers.question_id', $question->id)
          ->first();
        if ($answer) {
          $question->response = $answer->response_answer;
        } else {
          $question->response = '';
        }

        if (!empty($question->default_value)) {
          $question->default_value = $this->__getQuestionDefaultValue($question->default_value);
          if ($question->is_default_value_editable === 0) {
            $question->response = $question->default_value;
          }
        }

        foreach ($question->question_childs as $key4 => $questionChild) {
          $answerChild = FormResponseAnswer::select([
            'form_response_answers.*',
            'form_responses.form_id',
            'form_responses.alumni_id',
          ])
            ->leftJoin('form_responses', 'form_responses.id', '=', 'form_response_answers.form_response_id')
            ->where('form_responses.form_id', $this->data->id)
            ->where('form_responses.alumni_id', $user->alumni?->id)
            ->where('form_response_answers.question_id', $questionChild->id)
            ->first();
          if ($answerChild) {
            $questionChild->response = $answerChild->response_answer;
          } else {
            $questionChild->response = '';
          }
        }
      }
    }

    $data['message'] = 'Form active detail data!';
    return $data;
  }

  private function __getQuestionDefaultValue($defaultValue)
  {
    // echo $this->alumni->nim;
    if (str_contains($defaultValue, '{')) {
      $defaultValue = str_replace('{', '', $defaultValue);
      $defaultValue = str_replace('}', '', $defaultValue);

      $defaultValueVar = $this;
      foreach (explode('.', $defaultValue) as $key => $value) {
        $defaultValueVar = $defaultValueVar->{$value};
      }
      // var_dump($this->{$defaultValue});
      // var_dump($this->alumni->batch->year);
      // var_dump($defaultValue);
      return $defaultValueVar;
    }
    return $defaultValue;
  }
}
