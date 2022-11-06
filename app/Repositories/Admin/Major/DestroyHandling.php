<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Admin\Major;

use App\Models\Major;
use Illuminate\Http\Request;

/**
 * Delete Major Data.
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
    $this->data = Major::find($this->id);

    if (!$this->data) {
      throw new \Exception('Major not found!', 404);
    }
  }

  public function handle()
  {
    $this->validate();
    $data = $this->data;

    $this->data->delete();

    $data['message'] = 'Major deleted successfully!';
    return $data;
  }
}
