<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Admin\Batch;

use App\Models\Batch;
use Illuminate\Http\Request;

/**
 * Delete Batch Data.
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
    $this->data = Batch::find($this->id);

    if (!$this->data) {
      throw new \Exception('Batch not found!', 404);
    }
  }

  public function handle()
  {
    $this->validate();
    $data = $this->data;

    $this->data->delete();

    $data['message'] = 'Batch deleted successfully!';
    return $data;
  }
}
