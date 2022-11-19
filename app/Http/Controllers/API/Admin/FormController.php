<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\API\ApiController;
use App\Repositories\Admin\Form\DestroyHandling;
use App\Repositories\Admin\Form\ListHandling;
use App\Repositories\Admin\Form\ShowDetailHandling;
use App\Repositories\Admin\Form\ShowHandling;
use App\Repositories\Admin\Form\StoreHandling;
use App\Repositories\Admin\Form\UpdateHandling;
use App\Repositories\Admin\Form\UpdateDetailHandling;
use Illuminate\Http\Request;

class FormController extends ApiController
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

  public function showDetail(Request $request, $id)
  {
    try {
      $executor = new ShowDetailHandling($request, $id);
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

  public function updateDetail(Request $request, $id)
  {
    try {
      $executor = new UpdateDetailHandling($request, $id);
      $data = $executor->handle();

      return $this->responseData($data);
    } catch (\Exception $e) {
      return $this->responseException($e);
    }
  }
}
