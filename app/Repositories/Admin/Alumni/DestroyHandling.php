<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Admin\Alumni;

use App\Models\Alumni;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Delete Alumni Data.
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
    $this->data = Alumni::find($this->id);

    if (!$this->data) {
      throw new \Exception('Alumni not found!', 404);
    }
  }

  public function handle()
  {
    $this->validate();
    $data = $this->data;

    $user = User::find($data->user_id);
    $user->delete();

    $data['message'] = 'Alumni deleted successfully!';
    return $data;
  }
}
