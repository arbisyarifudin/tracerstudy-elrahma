<?php

namespace App\Http\Controllers\API\Member;

use App\Http\Controllers\API\ApiController;
use App\Repositories\Member\Inbox\StoreHandling;
use Illuminate\Http\Request;

class InboxController extends ApiController
{

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
}
