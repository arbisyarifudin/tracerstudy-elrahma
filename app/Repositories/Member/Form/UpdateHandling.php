<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Member\Form;

use App\Models\AlumniForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Update Alumni Form Data.
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
    $this->data = AlumniForm::find($this->id);

    if (!$this->data) {
      throw new \Exception('Alumni education not found!', 404);
    }

    $rules = [
      'institution_name' => [
        'required',
      ],
      'institution_address' => [
        'required',
      ],
      'major_name' => [
        'nullable',
      ],
      'major_level' => [
        'required',
      ],
      'enter_year' => [
        'required',
        'numeric',
        'min:2000',
        'max:' . date('Y'),
        'date_format:Y',
      ],
      'graduate_year' => [
        'nullable',
        'numeric',
        'date_format:Y',
      ],
    ];

    $messages = [
      'institution_name.required' => 'Nama Sekolah/Perguruan/Institusi wajib diisi.',
      'institution_address.required' => 'Alamat Sekolah/Perguruan/Institusi wajib diisi.',
      'major_level.required' => 'Jenjang wajib diisi.',
      'enter_year.required' => 'Tahun Masuk wajib diisi.',
      'enter_year.date_format' => 'Format tahun tidak sesuai.',
      'enter_year.min' => 'Tahun minimal :min.',
      'enter_year.max' => 'Tahun maksimal :max.',
      'graduate_year.date_format' => 'Format tahun tidak sesuai.',
    ];

    $validated = Validator::make($this->request->all(), $rules, $messages)->validate();
    return $validated;
  }

  public function handle()
  {
    $validated = $this->validate();

    $this->data->update($validated);

    $data = $this->data->refresh();
    $data['message'] = 'Alumni education updated successfully!';
    return $data;
  }
}
