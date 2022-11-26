<?php

namespace App\Http\Controllers\API\Member;

use App\Http\Controllers\API\ApiController;
use App\Repositories\Member\Alumni\ListHandling;
use App\Repositories\Member\Alumni\ShowHandling;
use Illuminate\Http\Request;

class AlumniController extends ApiController
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

  public function show(Request $request, $id)
  {
    try {
      $executor = new ShowHandling($request, $id);
      $data = $executor->handle();

      return $this->responseData($data);
    } catch (\Exception $e) {
      return $this->responseException($e);
    }
  }
}
