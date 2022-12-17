<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Member\Job;

use App\Models\AlumniJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Update Alumni Job Data.
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
    $this->data = AlumniJob::find($this->id);

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
      'institution_contacts' => [
        'nullable',
        'array',
      ],
      'job_title' => [
        'required',
      ],
      'start_year' => [
        'required',
        'numeric',
        'max:' . date('Y'),
        'date_format:Y',
      ],
      'end_year' => [
        'nullable',
        'numeric',
        'date_format:Y',
      ],
    ];

    $messages = [
      'institution_name.required' => 'Nama Tempat Kerja/Usaha/Institusi wajib diisi.',
      'institution_address.required' => 'Alamat Tempat Kerja/Usaha/Institusi wajib diisi.',
      'job_title.required' => 'Jabatan/Posisi wajib diisi.',
      'start_year.required' => 'Tahun Masuk wajib diisi.',
      'start_year.date_format' => 'Format tahun tidak sesuai.',
      'start_year.max' => 'Tahun maksimal :max.',
      'end_year.date_format' => 'Format tahun tidak sesuai.',
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
