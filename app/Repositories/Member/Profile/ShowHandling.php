<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Member\Profile;

use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Member > Show profile data.
 */
class ShowHandling
{
  protected $request;
  protected $user;
  protected $data;

  public function __construct(Request $request)
  {
    $this->request  = $request;
    $this->user  = Auth::user();
  }

  public function validate()
  {
    $this->data = Alumni::where('user_id', $this->user->id)->first();

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
    ])->where('user_id', $this->user->id)->first();

    $data['message'] = 'Profile data.';
    return $data;
  }
}
