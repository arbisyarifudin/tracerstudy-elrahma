<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Member\Form;

use App\Models\Form;
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

    $data = Form::with([
      'sections.questions.question_options',
      'sections.questions.question_rate',
      'sections.questions.question_childs.question_options',
      'sections.questions.question_childs.question_rate',
    ])->where('id', $this->data->id)->first();

    $data['message'] = 'Form active detail data!';
    return $data;
  }
}
