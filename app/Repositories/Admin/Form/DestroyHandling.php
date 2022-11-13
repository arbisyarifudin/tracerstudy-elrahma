<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Admin\Form;

use App\Models\Form;
use Illuminate\Http\Request;

/**
 * Delete Form Data.
 */
class DestroyHandling
{
  protected $request;
  protected $id;

  public function __construct(Request $request, $id)
  {
    $this->request  = $request;
    $this->id  = $id;
  }

  public function validate()
  {
    $this->data = Form::find($this->id);

    if (!$this->data) {
      throw new \Exception('Form not found!', 404);
    }
  }

  public function handle()
  {
    $this->validate();
    $data = $this->data;
    $this->data->delete();
    $data['message'] = 'Form deleted successfully!';
    return $data;
  }
}
