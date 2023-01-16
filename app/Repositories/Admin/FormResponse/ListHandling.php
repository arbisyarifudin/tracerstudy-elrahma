<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Admin\FormResponse;

use App\Models\Form;
use App\Repositories\PagingData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * List Form Response Data.
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
      'form_id' => [
        'nullable',
        Rule::exists(Form::class, 'id')
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
    $searchableColumns = ['name'];
    $orderableColumns = ['name', 'created_at'];

    $this->setSearchableColumns($searchableColumns);
    $this->setOrderableColumns($orderableColumns);

    $selectedColumns = [
      'form_responses.id',
      'fullname',
      'nim',
      'form_responses.created_at',
      'form_responses.updated_at',
    ];

    $query = DB::table('form_responses')
      ->select($selectedColumns)
      ->join('alumnis', 'alumnis.id', '=', 'form_responses.alumni_id')
      ->whereNull('deleted_at');

    if (isset($validated['form_id']) && !empty($validated['form_id'])) {
      $query->where('form_id', $validated['form_id']);
    }

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
