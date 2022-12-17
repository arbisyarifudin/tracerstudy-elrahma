<?php

namespace App\Http\Controllers\API\Member;

use App\Http\Controllers\API\ApiController;
use App\Repositories\Member\Job\ListHandling;
use App\Repositories\Member\Job\ShowHandling;
use App\Repositories\Member\Job\StoreHandling;
use App\Repositories\Member\Job\UpdateHandling;
use App\Repositories\Member\Job\DestroyHandling;
use Illuminate\Http\Request;

class JobController extends ApiController
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
