<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Member\Batch;

use App\Repositories\PagingData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Member > List Batch Data.
 */
class ListHandling extends PagingData
{
  public function __construct(Request $request)
  {
    $this->setRequest($request);
  }

  public function validate()
  {
    $request = $this->getRequest();
    $rules = [];

    $messages = [];

    $validated = Validator::make($request->all(), $rules, $messages)->validate();
    $this->setValidated($validated);
  }

  public function handle()
  {
    $this->validate();
    $validated = $this->getValidated();
    $searchableColumns = ['year'];
    $orderableColumns = ['year', 'created_at'];

    $this->setSearchableColumns($searchableColumns);
    $this->setOrderableColumns($orderableColumns);

    $selectedColumns = [
      'id',
      'year',
      'created_at',
      'updated_at',
    ];

    $query = DB::table('batches')->select($selectedColumns)->whereNull('deleted_at');
    $this->paginateData($query);

    return [
      'size' => $this->getSize(),
      'page' => $this->getPage(),
      'totalPage' => $this->getTotalPage(),
      'totalData' => $this->getTotalData(),
      'totalFiltered' => $this->getTotalFiltered(),
      'data' => $this->getData(),
    ];
  }
}
