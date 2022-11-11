<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Admin\Regency;

use App\Models\Province;
use App\Repositories\PagingData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * List Regency Data.
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
    $rules = [
      'province_id' => [
        'required',
        Rule::exists(Province::class, 'id')
      ]
    ];

    $messages = [];

    $validated = Validator::make($request->all(), $rules, $messages)->validate();
    $this->setValidated($validated);
  }

  public function handle()
  {
    $this->validate();
    $validated = $this->getValidated();
    $searchableColumns = ['code', 'name'];
    $orderableColumns = ['code', 'name', 'created_at'];

    $this->setSearchableColumns($searchableColumns);
    $this->setOrderableColumns($orderableColumns);

    $selectedColumns = [
      'regencies.*',
      'provinces.code as province_code',
      'provinces.name as province_name',
    ];

    $query = DB::table('regencies')->select($selectedColumns)
      ->join('provinces', 'provinces.id', '=', 'regencies.province_id')
      ->where('regencies.province_id', $validated['province_id']);
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
