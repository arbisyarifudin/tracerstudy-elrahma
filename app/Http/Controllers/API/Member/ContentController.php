<?php

namespace App\Http\Controllers\API\Member;

use App\Http\Controllers\API\ApiController;
use App\Repositories\Member\Content\ListHandling;
use App\Repositories\Member\Content\ShowBySlugHandling;
use Illuminate\Http\Request;

class ContentController extends ApiController
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

  public function showBySlug(Request $request, $slug)
  {
    try {
      $executor = new ShowBySlugHandling($request, $slug);
      $data = $executor->handle();

      return $this->responseData($data);
    } catch (\Exception $e) {
      return $this->responseException($e);
    }
  }
}
