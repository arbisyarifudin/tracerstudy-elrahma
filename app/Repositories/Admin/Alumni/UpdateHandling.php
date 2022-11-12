<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Admin\Alumni;

use App\Models\Alumni;
use App\Models\Batch;
use App\Models\Province;
use App\Models\Regency;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
    $this->data = Alumni::where('id', $this->id)->orWhere('nim', $this->id)->first();

    if (!$this->data) {
      throw new \Exception('Alumni not found!', 404);
    }

    $rules = [
      'nim' => [
        'required',
        Rule::unique(Alumni::class, 'nim')->ignore($this->id, 'id')
      ],
      'fullname' => [
        'required',
      ],
      'gender' => [
        'required'
      ],
      'batch_id' => [
        'required',
        Rule::exists(Batch::class, 'id')
      ],
      'graduate_year' => [
        'required',
      ],
      'province_id' => [
        'nullable',
        Rule::exists(Province::class, 'id')
      ],
      'regency_id' => [
        'nullable',
        Rule::exists(Regency::class, 'id')
      ],
      'email' => [
        'nullable',
        'email',
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
      if ($this->request->has('password') && empty($this->request->password)) {
        $userUpdateData['password'] = Hash::make($this->request->password);
      }
      $user->update($userUpdateData);

      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }

    $data['message'] = 'Alumni updated successfully!';
    return $data;
  }
}
