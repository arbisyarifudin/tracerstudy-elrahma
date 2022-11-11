<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\API\ApiController;
use App\Repositories\Admin\Province\ListHandling;
use Illuminate\Http\Request;

class ProvinceController extends ApiController
{

  public function list(Request $request)
  {
    try {
      $executor = new ListHandling($request);
      $data = $executor->handle();

      return $this->responsePagedList($data);
    } catch (\Exception $e) {
      return $this->responseException($e);
    }
  }
}
