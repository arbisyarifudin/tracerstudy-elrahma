<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

/**
 * Auth Login Handling.
 */
class LoginHandling
{
  protected $request;

  public function __construct(Request $request)
  {
    $this->request  = $request;
  }

  public function validate()
  {
    $rules = [
      'unameOrEmail' => [
        'required',
      ],
      'password' => [
        'required'
      ],
    ];

    $messages = [
      'unameOrEmail.required' => 'Kolom wajib diisi.',
      'password.required' => 'Kolom wajib diisi.',
    ];

    $validated = Validator::make($this->request->all(), $rules, $messages)->validate();
    return $validated;
  }

  public function handle()
  {
    $validated = $this->validate();

    // check email/username
    $findUser = User::where('email', $validated['unameOrEmail'])
      ->orWhere('uname', $validated['unameOrEmail'])->first();
    if (!$findUser) {
      throw new \Exception('Akun tidak ditemukan!', 404);
    }

    if (!Hash::check($validated['password'], $findUser->password)) {
      throw new \Exception('Password salah!', 404);
    }

    // $token = $findUser->createToken('auth_token')->plainTextToken;
    $accessToken = $findUser->createAuthToken('access_token', now()->addMinutes(10))->plainTextToken;
    $refreshToken = $findUser->createRefreshToken('refresh_token', now()->addMinutes(30))->plainTextToken;
    $data = [
      'access_token' => $accessToken,
      'refresh_token' => $refreshToken,
      'token_type' => 'Bearer'
    ];
    $data['message'] = 'Login success!';
    return $data;
  }
}
