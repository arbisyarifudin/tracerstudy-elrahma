<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Admin\Major;

use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Update Major Data.
 */
class UpdateHandling
{
  protected $request;
  protected $id;
  protected $data;

  public function __construct(Request $request, $id)
  {
    $this->request  = $request;
    $this->id  = $id;
  }

  public function validate()
  {
    $this->data = Major::find($this->id);

    if (!$this->data) {
      throw new \Exception('Major not found!', 404);
    }

    $rules = [
      'code' => [
        'required',
        'numeric',
        Rule::unique(Major::class, 'code')->whereNull('deleted_at')->ignore($this->request->code, 'code')
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

    $this->data->update($validated);

    $data['message'] = 'Major updated successfully!';
    return $data;
  }
}
