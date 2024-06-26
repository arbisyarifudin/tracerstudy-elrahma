<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Admin\Form;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Show detail Form Data.
 */
class ShowHandling
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
    $this->data = Form::where('id', $this->id)->first();

    if (!$this->data) {
      throw new \Exception('Form not found!', 404);
    }
  }

  public function handle()
  {
    $this->validate();

    $data = $this->data;

    $data['message'] = 'Form detail data!';
    return $data;
  }
}
