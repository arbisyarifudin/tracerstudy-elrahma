<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Member\Alumni;

use App\Models\Batch;
use App\Repositories\PagingData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Member > List Alumni Data.
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
      'batch_id' => [
        'nullable',
        Rule::exists(Batch::class, 'id')
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
    $searchableColumns = ['nim', 'fullname', 'majors.name', 'majors.name', 'batches.year'];
    $orderableColumns = ['nim', 'fullname', 'created_at'];

    $this->setSearchableColumns($searchableColumns);
    $this->setOrderableColumns($orderableColumns);

    $selectedColumns = [
      'alumnis.*',
      'majors.id as major_id',
      'majors.name as major_name',
      'majors.level as major_level',
      'batches.id as batch_id',
      'batches.year as enter_year',
    ];

    $query = DB::table('alumnis')->select($selectedColumns)
      ->join('users', 'users.id', '=', 'alumnis.user_id')
      ->leftJoin('majors', 'majors.id', '=', 'alumnis.major_id')
      ->leftJoin('batches', 'batches.id', '=', 'alumnis.batch_id')
      ->whereNull('users.deleted_at');

    if (isset($validated['batch_id']) && !empty($validated['batch_id'])) {
      $query->where('batch_id', $validated['batch_id']);
    }

    if (Auth::check()) {
      $query->whereNotIn('user_id', [auth()->user()->id]);
    }

    $this->paginateData($query);

    $data = $this->getData();

    if (!Auth::check()) {
      foreach ($data as $key => $dataRow) {
        $dataRow->nim = substr($dataRow->nim, 0, 4);
        $dataRow->nim .= '*****';

        $dataRow->fullname = substr($dataRow->fullname, 0, 5);
        $dataRow->fullname .= ' *****';

        $dataRow->phone_number = substr($dataRow->phone_number, 0, 5);
        $dataRow->phone_number .= $dataRow->phone_number ?? '*****';
        $dataRow->phone_number .= '*****';
        $dataRow->wa_number = substr($dataRow->wa_number, 0, 5);
        $dataRow->wa_number = $dataRow->wa_number ?? '*****';
        $dataRow->wa_number .= '*****';
      }
    }

    return [
      'size' => $this->getSize(),
      'page' => $this->getPage(),
      'totalPage' => $this->getTotalPage(),
      'totalData' => $this->getTotalData(),
      'totalFiltered' => $this->getTotalFiltered(),
      'data' => $data,
    ];
  }
}
