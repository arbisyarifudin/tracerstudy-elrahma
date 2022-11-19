<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\API\ApiController;
use App\Repositories\Auth\LoginHandling;
use App\Repositories\Auth\LogoutHandling;
use Illuminate\Http\Request;

class AuthController extends ApiController
{
  public function login(Request $request)
  {
    try {
      $executor = new LoginHandling($request);
      $data = $executor->handle();

      return $this->responseData($data);
    } catch (\Exception $e) {
      return $this->responseException($e);
    }
  }
  public function logout(Request $request)
  {
    try {
      $executor = new LogoutHandling($request);
      $data = $executor->handle();

      return $this->responseData($data);
    } catch (\Exception $e) {
      return $this->responseException($e);
    }
  }
}
