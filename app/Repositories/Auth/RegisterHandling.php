<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Auth;

use App\Models\Alumni;
use App\Models\Batch;
use App\Models\Major;
use App\Models\Province;
use App\Models\Regency;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

/**
 * Auth Register Handling (for Alumni / Member type user).
 */
class RegisterHandling
{
  protected $request;

  public function __construct(Request $request)
  {
    $this->request  = $request;
  }

  public function validate()
  {
    $rules = [
      'email' => [
        'email',
        'required',
        Rule::unique(User::class, 'email')
        // ->whereNotNull('email_verified_at')
      ],
      'password' => [
        'required',
        'min:6',
        'string'
      ],
      'nim' => [
        'required',
        'min:6',
        Rule::unique(Alumni::class, 'nim')
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
        'file',
        'mimes:jpg,png,jpeg',
        'max:2048',
        'required',
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
    try {
      $user = User::create([
        'uname' => $validated['nim'],
        'name' => $validated['fullname'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'status' => 0, // not active / verified by admin
        'type' => 'Alumni',
      ]);

      $alumniData = $validated;
      $alumniData['user_id'] = $user->id;
      // unset($alumniData['email']);
      unset($alumniData['password']);

      if ($this->request->has('photo') && !empty($this->request->photo)) {
        $uploadDir = 'uploads/alumni/';
        $photo = $this->request->file('photo');
        $photoName = 'photo-' . $validated['nim'] . '.' . $photo->getClientOriginalExtension();
        $photo->move(public_path($uploadDir), $photoName);
        $alumniData['photo'] =  $uploadDir . $photoName;
      }

      $data = Alumni::create($alumniData);

      DB::commit();

      // TODO:
      // Kirim email verifikasi ke user yang baru mendaftar

    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }

    $data['message'] = 'Alumni registered successfully!';
    return $data;
  }
}
