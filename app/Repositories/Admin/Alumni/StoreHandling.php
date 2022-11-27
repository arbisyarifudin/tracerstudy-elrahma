<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Admin\Alumni;

use App\Models\Alumni;
use App\Models\Batch;
use App\Models\Major;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Add new Alumni Data.
 */
class StoreHandling
{
  protected $request;
  protected $model;

  public function __construct(Request $request)
  {
    $this->request  = $request;
    $this->model  = new Alumni();
  }

  public function validate()
  {
    $rules = [
      'nim' => [
        'required',
        Rule::unique(Alumni::class, 'nim')
      ],
      'fullname' => [
        'required',
      ],
      'gender' => [
        'required'
      ],
      'province_id' => [
        'nullable',
        Rule::exists(Province::class, 'id')
      ],
      'regency_id' => [
        'nullable',
        Rule::exists(Regency::class, 'id')
      ],
      'batch_id' => [
        'required',
        Rule::exists(Batch::class, 'id')
      ],
      'major_id' => [
        'required',
        Rule::exists(Major::class, 'id')
      ],
      'graduate_year' => [
        'required',
      ],
      'email' => [
        'nullable',
        'email',
        Rule::unique(User::class, 'email')
        // ->whereNotNull('email_verified_at')
      ],
      'password' => [
        'nullable',
      ],
    ];

    $messages = [
      'nim.required' => 'NIM wajib diisi.',
      'nim.unique' => 'NIM sudah terdaftar.',
      'fullname.required' => 'Nama Lengkap wajib diisi.',
      'gender.required' => 'Jenis Kelamin wajib diisi.',
      'batch_id.required' => 'Tahun Masuk/Angkatan wajib diisi.',
      'major_id.required' => 'Program Studi wajib diisi.',
      'graduate_year.required' => 'Tahun Lulus wajib diisi.',
      'email.email' => 'Email tidak valid.',
    ];

    $validated = Validator::make($this->request->all(), $rules, $messages)->validate();
    return $validated;
  }

  public function handle()
  {
    $validated = $this->validate();

    DB::beginTransaction();
    try {
      $user = User::create([
        'uname' => $validated['nim'],
        'name' => $validated['fullname'],
        'email' => @$validated['email'],
        'password' => Hash::make(isset($validated['password']) ? $validated['password'] : $validated['nim']),
      ]);

      $alumniData = $validated;
      $alumniData['user_id'] = $user->id;
      // unset($alumniData['email']);
      unset($alumniData['password']);

      if ($this->request->has('photo') && !empty($this->request->photo)) {
        $uploadDir = 'uploads/alumni/';
        $photo = $this->request->file('photo');
        $photoName = time() . '.' . $photo->getClientOriginalExtension();
        $photo->move(public_path($uploadDir), $photoName);
        $alumniData['photo'] =  $uploadDir . $photoName;
      }

      $data = Alumni::create($alumniData);

      DB::commit();

      // TODO:
      // Kirim email pemberitahuan ke alumni

    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }


    $data['message'] = 'Alumni created successfully!';
    return $data;
  }
}
