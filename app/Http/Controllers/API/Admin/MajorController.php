<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\ApiController;
use App\Repositories\Admin\Major\DestroyHandling;
use App\Repositories\Admin\Major\ListHandling;
use App\Repositories\Admin\Major\StoreHandling;
use Illuminate\Http\Request;

class MajorController extends ApiController
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

  public function store(Request $request)
  {
    try {
      $executor = new StoreHandling($request);
      $data = $executor->handle();

      return $this->responseData($data);
    } catch (\Exception $e) {
      return $this->responseException($e);
    }
  }

  public function delete(Request $request, $id)
  {
    try {
      $executor = new DestroyHandling($request, $id);
      $data = $executor->handle();

      return $this->responseData($data);
    } catch (\Exception $e) {
      return $this->responseException($e);
    }
  }
}
