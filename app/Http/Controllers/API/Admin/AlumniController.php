<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\API\ApiController;
use App\Repositories\Admin\Alumni\DestroyHandling;
use App\Repositories\Admin\Alumni\ListHandling;
use App\Repositories\Admin\Alumni\ShowHandling;
use App\Repositories\Admin\Alumni\StoreHandling;
use App\Repositories\Admin\Alumni\UpdateHandling;
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

  public function update(Request $request, $id)
  {
    try {
      $executor = new UpdateHandling($request, $id);
      $data = $executor->handle();

      return $this->responseData($data);
    } catch (\Exception $e) {
      return $this->responseException($e);
    }
  }
}
