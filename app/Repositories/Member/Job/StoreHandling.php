<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Member\Job;

use App\Models\Alumni;
use App\Models\AlumniJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Add new Alumni Job Data.
 */
class StoreHandling
{
  protected $request;

  public function __construct(Request $request)
  {
    $this->request  = $request;
  }

  public function validate()
  {
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

    $alumni = Alumni::where('user_id', auth()->user()->id)->first();
    $validated['alumni_id'] = $alumni->id;
    $data  = AlumniJob::create($validated);
    $data['message'] = 'Alumni Job created successfully!';
    return $data;
  }
}
