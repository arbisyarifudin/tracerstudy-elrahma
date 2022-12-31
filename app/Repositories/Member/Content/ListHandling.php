<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Member\Content;

use App\Models\Batch;
use App\Repositories\PagingData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Member > List Content Data.
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
    $searchableColumns = ['title', 'body'];
    $orderableColumns = ['title', 'body', 'created_at'];

    $this->setSearchableColumns($searchableColumns);
    $this->setOrderableColumns($orderableColumns);

    $selectedColumns = [
      'contents.id',
      'contents.slug',
      'contents.title',
      'contents.excerpt',
      'contents.created_at',
      'users.name as author_name',
    ];

    $query = DB::table('contents')
      ->select($selectedColumns)
      ->leftJoin('users', 'users.id', '=', 'contents.author_id')
      ->where('published', true)
      ->whereNull('contents.deleted_at');

    $this->paginateData($query);

    $data = $this->getData();

    foreach ($data as $key => $dataRow) {
      $dataRow->categories = DB::table('content_has_categories')
        ->select([
          'categories.id',
          'categories.title',
        ])
        ->join('categories', 'categories.id', '=', 'content_has_categories.category_id')
        ->where('content_has_categories.content_id', $dataRow->id)
        ->get();
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
