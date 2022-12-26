<?php

namespace App\Http\Controllers\API\Member;

use App\Http\Controllers\API\ApiController;
use App\Repositories\Member\Form\ShowActiveHandling;
use App\Repositories\Member\Form\SubmitHandling;
use Illuminate\Http\Request;

class FormController extends ApiController
{

  public function submit(Request $request)
  {
    try {
      $executor = new SubmitHandling($request);
      $data = $executor->handle();

      return $this->responseData($data);
    } catch (\Exception $e) {
      return $this->responseException($e);
    }
  }

  public function showActive(Request $request)
  {
    try {
      $executor = new ShowActiveHandling($request);
      $data = $executor->handle();

      return $this->responseData($data);
    } catch (\Exception $e) {
      return $this->responseException($e);
    }
  }
}
