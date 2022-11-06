<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\ApiController;
use App\Repositories\Admin\Batch\DestroyHandling;
use App\Repositories\Admin\Batch\ListHandling;
use App\Repositories\Admin\Batch\StoreHandling;
use App\Repositories\Admin\Batch\UpdateHandling;
use Illuminate\Http\Request;

class BatchController extends ApiController
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
