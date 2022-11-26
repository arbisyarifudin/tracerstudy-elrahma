<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Member\Alumni;

use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Member > Show detail Alumni Data.
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
    $this->data = Alumni::where('id', $this->id)->orWhere('nim', $this->id)->first();

    if (!$this->data) {
      throw new \Exception('Alumni not found!', 404);
    }
  }

  public function handle()
  {
    $this->validate();

    $data = Alumni::with([
      'major',
      'batch'
    ])->where('id', $this->id)->orWhere('nim', $this->id)->first();

    if (!Auth::check()) {
      $data->nim = substr($data->nim, 0, 4);
      $data->nim .= '*****';
      $data->phone_number = substr($data->phone_number, 0, 5);
      $data->phone_number .= '*****';
      $data->wa_number = substr($data->wa_number, 0, 5);
      $data->wa_number .= '*****';
    }

    $data['message'] = 'Alumni detail data!';
    return $data;
  }
}
