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
      'recaptchaToken' => [
        'sometimes'
      ]
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

    // google recaptcha check
    $captchVerified = $this->__verifyCaptcha(@$validated['recaptchaToken']);
    if (!$captchVerified) {
      throw new \Exception('Ups! Anda terindikasi sebagai spam oleh sistem kami.', 403);
    }

    // check email/username
    $findUser = User::where('email', $validated['unameOrEmail'])
      ->orWhere('uname', $validated['unameOrEmail'])->first();
    if (!$findUser) {
      // throw new \Exception('Akun tidak ditemukan!', 404);
      throw new \Exception('Kredensial tidak valid!', 404);
    }

    // check password
    if (!Hash::check($validated['password'], $findUser->password)) {
      // throw new \Exception('Password salah!', 404);
      throw new \Exception('Kredensial tidak valid!', 404);
    }

    // check email is verified
    if ($findUser->email_verified_at === null) {
      throw new \Exception('Email Anda belum di verifikasi! Mohon cek email Anda.', 403);
    }

    // check status
    if ($findUser->type == 'Alumni' && $findUser->status === 0) {
      throw new \Exception('Akun Anda belum di verifikasi oleh Administrator!', 403);
    }

    // $token = $findUser->createToken('auth_token')->plainTextToken;
    $expiredAt = now()->addMinutes(60 * 12);
    $accessToken = $findUser->createAuthToken('access_token', $expiredAt)->plainTextToken;
    $refreshToken = $findUser->createRefreshToken('refresh_token', now()->addMinutes(60 * 24))->plainTextToken;
    $data = [
      'access_token' => $accessToken,
      'refresh_token' => $refreshToken,
      'token_type' => 'Bearer',
      'token_expires' => $expiredAt,
      'user' => [
        'name' => $findUser->name,
        'type' => $findUser->type,
      ]
    ];
    $data['message'] = 'Login success!';
    return $data;
  }

  private function __verifyCaptcha($captcha = null)
  {
    if (!$captcha) return false;

    $secret   = env('GOOGLE_RECAPTCHA');
    $response = file_get_contents(
      "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']
    );
    $response = json_decode($response);
    if ($response->success == false) return false;
    if ($response->success == true && $response->score <= 0.5) {
      return false;
    }
    return true;
  }
}
