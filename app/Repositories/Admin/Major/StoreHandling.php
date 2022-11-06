<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Admin\Major;

use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Add new Major Data.
 */
class StoreHandling
{
  protected $request;
  protected $model;

  public function __construct(Request $request)
  {
    $this->request  = $request;
    $this->model  = new Major();
  }

  public function validate()
  {
    $rules = [
      'code' => [
        'required',
        'numeric',
        Rule::unique(Major::class, 'code')->whereNull('deleted_at')
      ],
      'name' => [
        'required',
        'string',
      ],
      'level' => [
        'required'
      ]
    ];

    $messages = [
      'code.required' => 'Kode Prodi wajib diisi.',
      'code.unique' => 'Kode Prodi sudah ada.',
      'name.required' => 'Nama Prodi wajib diisi.',
    ];

    $validated = Validator::make($this->request->all(), $rules, $messages)->validate();
    return $validated;
  }

  public function handle()
  {
    $validated = $this->validate();

    $find = $this->model->where('code', $validated['code'])->withTrashed();
    if ($find->count() > 0) {
      $data = $find->first();
      $data->restore();
    } else {
      $data = Major::create([
        'code' => $validated['code'],
        'name' => $validated['name'],
        'level' => $validated['level'],
      ]);
    }

    $data['message'] = 'Major created successfully!';
    return $data;
  }
}
