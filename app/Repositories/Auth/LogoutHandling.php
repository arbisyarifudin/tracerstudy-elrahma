<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Auth Logout Handling.
 */
class LogoutHandling
{
  protected $request;

  public function __construct(Request $request)
  {
    $this->request  = $request;
  }

  public function validate()
  {
    if (!Auth::check()) {
      throw new \Exception('You are not logged in yet!', 401);
    }
  }

  public function handle()
  {
    $this->validate();
    $user = Auth::user();
    $user->tokens()->delete();
    $data['message'] = 'Logout success!';
    return $data;
  }
}
