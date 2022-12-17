<?php

namespace App\Http\Controllers\API\Member;

use App\Http\Controllers\API\ApiController;
use App\Repositories\Member\Feedback\ShowHandling;
use App\Repositories\Member\Feedback\UpdateHandling;
use Illuminate\Http\Request;

class FeedbackController extends ApiController
{
  public function show(Request $request)
  {
    try {
      $executor = new ShowHandling($request);
      $data = $executor->handle();

      return $this->responseData($data);
    } catch (\Exception $e) {
      return $this->responseException($e);
    }
  }

  public function update(Request $request)
  {
    try {
      $executor = new UpdateHandling($request);
      $data = $executor->handle();

      return $this->responseData($data);
    } catch (\Exception $e) {
      return $this->responseException($e);
    }
  }
}
