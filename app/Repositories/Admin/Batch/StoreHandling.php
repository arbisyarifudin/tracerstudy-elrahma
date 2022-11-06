<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Admin\Batch;

use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Add new Batch Data.
 */
class StoreHandling
{
  protected $request;
  protected $model;

  public function __construct(Request $request)
  {
    $this->request  = $request;
    $this->model  = new Batch();
  }

  public function validate()
  {
    $rules = [
      'year' => [
        'required',
        'date_format:Y',
        Rule::unique(Batch::class, 'year')->whereNull('deleted_at')
      ]
    ];

    $messages = [
      'year.required' => 'Tahun wajib diisi.',
      'year.unique' => 'Tahun sudah ada.',
      'year.date_format' => 'Format tahun tidak sesuai.',
    ];

    $validated = Validator::make($this->request->all(), $rules, $messages)->validate();
    return $validated;
  }

  public function handle()
  {
    $validated = $this->validate();

    $find = $this->model->where('year', $validated['year'])->withTrashed();
    if ($find->count() > 0) {
      $data = $find->first();
      $data->restore();
    } else {
      $data = Batch::create([
        'year' => $validated['year']
      ]);
    }

    $data['message'] = 'Batch created successfully!';
    return $data;
  }
}
