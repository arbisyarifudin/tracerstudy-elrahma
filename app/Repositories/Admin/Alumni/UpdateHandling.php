<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Admin\Alumni;

use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Update Alumni Data.
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
    $this->data = Alumni::find($this->id);

    if (!$this->data) {
      throw new \Exception('Alumni not found!', 404);
    }

    $rules = [
      'nim' => [
        'required',
        Rule::unique(Alumni::class, 'nim')->whereNull('deleted_at')->ignore($this->id, 'id')
      ],
      'fullname' => [
        'required',
      ],
      'gender' => [
        'required'
      ],
      'enter_year' => [
        'required',
      ],
      'graduate_year' => [
        'required',
      ],
    ];

    $messages = [
      'nim.required' => 'NIM wajib diisi.',
      'nim.unique' => 'NIM sudah terdaftar.',
      'fullname.required' => 'Nama Lengkap wajib diisi.',
      'gender.required' => 'Jenis Kelamin wajib diisi.',
      'enter_year.required' => 'Tahun Masuk wajib diisi.',
      'graduate_year.required' => 'Tahun Lulus wajib diisi.',
    ];

    $validated = Validator::make($this->request->all(), $rules, $messages)->validate();
    return $validated;
  }

  public function handle()
  {
    $validated = $this->validate();

    $this->data->update($validated);

    $data['message'] = 'Alumni updated successfully!';
    return $data;
  }
}
