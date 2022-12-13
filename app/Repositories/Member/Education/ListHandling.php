<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Member\Education;

use App\Models\Alumni;
use App\Repositories\PagingData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * List Alumni Education Data.
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
    $searchableColumns = ['institution_name', 'major_name', 'major_level', 'enter_year', 'graduate_year'];
    $orderableColumns = ['institution_name', 'major_name', 'major_level', 'enter_year', 'graduate_year', 'created_at'];

    $this->setSearchableColumns($searchableColumns);
    $this->setOrderableColumns($orderableColumns);

    $selectedColumns = [
      'id',
      'institution_name',
      'institution_address',
      'major_name',
      'major_level',
      'enter_year',
      'graduate_year',
      'created_at',
      'updated_at',
    ];

    $alumni = Alumni::where('user_id', auth()->user()->id)->first();

    $query = DB::table('alumni_educations')
      ->select($selectedColumns)
      ->where('alumni_id', $alumni->id);
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
