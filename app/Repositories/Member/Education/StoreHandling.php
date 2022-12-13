<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Member\Education;

use App\Models\Alumni;
use App\Models\AlumniEducation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Add new Alumni Education Data.
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

    $alumni = Alumni::where('user_id', auth()->user()->id)->first();
    $validated['alumni_id'] = $alumni->id;
    $data  = AlumniEducation::create($validated);
    $data['message'] = 'Alumni Education created successfully!';
    return $data;
  }
}
