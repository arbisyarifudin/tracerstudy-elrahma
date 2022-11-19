<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Auth Refresh Token Handling.
 */
class RefreshTokenHandling
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
    $findUser = Auth::user();
    // $accessToken = $findUser->createAuthToken('access_token', now()->addMinutes(10))->plainTextToken;
    $refreshToken = $findUser->createRefreshToken('refresh_token', now()->addMinutes(30))->plainTextToken;
    $data = [
      // 'access_token' => $accessToken,
      'refresh_token' => $refreshToken,
      'token_type' => 'Bearer'
    ];
    $data['message'] = 'Refresh token success!';
    return $data;
  }
}
