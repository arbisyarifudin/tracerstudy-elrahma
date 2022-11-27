<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Member\Profile;

use App\Models\Alumni;
use App\Models\Batch;
use App\Models\Major;
use App\Models\Province;
use App\Models\Regency;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Member > Update profile data.
 */
class UpdateHandling
{
  protected $request;
  protected $user;
  protected $data;

  public function __construct(Request $request)
  {
    $this->request  = $request;
    $this->user  = Auth::user();
  }

  public function validate()
  {
    $this->data = Alumni::where('user_id', $this->user->id)->first();

    if (!$this->data) {
      throw new \Exception('Alumni not found!', 404);
    }

    $rules = [
      'email' => [
        'email',
        'required',
        Rule::unique(User::class, 'email')->ignore($this->user->id, 'id')
        // ->whereNotNull('email_verified_at')
      ],
      'password' => [
        'nullable',
        'min:6',
        'string'
      ],
      'nim' => [
        'required',
        'min:6',
        Rule::unique(User::class, 'uname')->ignore($this->user->id, 'id'),
        Rule::unique(Alumni::class, 'nim')->ignore($this->data->id, 'id'),
      ],
      'fullname' => [
        'required',
        'min:5',
        'string'
      ],
      'gender' => [
        'required'
      ],
      'place_of_birth' => [
        'required'
      ],
      'date_of_birth' => [
        'required',
        'date_format:Y-m-d'
      ],
      'province_id' => [
        'required',
        Rule::exists(Province::class, 'id')
      ],
      'regency_id' => [
        'required',
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
      'phone_number' => [
        'required',
      ],
      'wa_number' => [
        'required',
      ],
      'gpa' => [
        'required',
      ],
      'photo' => [
        'nullable',
        'file',
        'mimes:jpg,png,jpeg',
        'max:2048',
      ],
    ];

    $messages = [
      // 'required' => ':Attribute wajib diisi.',
      'fullname.required' => 'Nama lengkap wajib diisi.',
      'nim.required' => 'NIM lengkap wajib diisi.',
      'nim.unique' => 'NIM sudah terdaftar di sistem.',
      'email.required' => 'Email wajib diisi.',
      'email.unique' => 'Email sudah terdaftar di sistem.',
      'email.email' => 'Email harus valid.',
      'password.required' => 'Kata sandi wajib diisi.',
      'gender.required' => 'Jenis kelamin wajib diisi.',
      'place_of_birth.required' => 'Tempat lahir wajib diisi.',
      'date_of_birth.required' => 'Tanggal lahir wajib diisi.',
      'province_id.required' => 'Provinsi wajib dipilih.',
      'regency_id.required' => 'Kota/Kabupaten wajib dipilih.',
      'batch_id.required' => 'Thn. masuk / Angkatan wajib dipilih.',
      'graduate_year.required' => 'Tahun lulus wajib dipilih.',
      'major_id.required' => 'Program studi wajib dipilih.',
      'phone_number.required' => 'No. Telp/HP wajib diisi.',
      'wa_number.required' => 'No. Whatsapp wajib diisi.',
      'gpa.required' => 'IPK wajib diisi.',
      'photo.required' => 'Foto wajib diunggah.',
    ];

    $validated = Validator::make($this->request->all(), $rules, $messages)->validate();
    return $validated;
  }

  public function handle()
  {
    $validated = $this->validate();

    DB::beginTransaction();
    $alumniData = $this->request->except(['password']);
    try {
      if ($this->request->has('photo') && !empty($this->request->photo)) {
        $uploadDir = 'uploads/alumni/';
        $photo = $this->request->file('photo');
        $photoName = time() . '.' . $photo->getClientOriginalExtension();
        $photo->move(public_path($uploadDir), $photoName);
        $alumniData['photo'] =  $uploadDir . $photoName;

        if (file_exists(public_path($this->data->photo)) && !empty($this->data->photo)) {
          unlink(public_path($this->data->photo));
        }
      }
      $this->data->update($alumniData);
      $data = $this->data->refresh();

      $user = User::find($this->data->user_id);
      $userUpdateData['uname'] = $this->request->nim;
      $userUpdateData['name'] = $this->request->fullname;
      $userUpdateData['email'] = $this->request->email;
      if ($this->request->has('password') && !empty($this->request->password)) {
        $userUpdateData['password'] = Hash::make($this->request->password);
      }
      $user->update($userUpdateData);

      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }

    $data['message'] = 'Profile updated successfully!';
    return $data;
  }
}
