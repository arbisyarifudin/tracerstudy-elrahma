<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Admin\Form;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

/**
 * Add new Form Data.
 */
class StoreHandling
{
  protected $request;
  protected $model;

  public function __construct(Request $request)
  {
    $this->request  = $request;
    $this->model  = new Form();
  }

  public function validate()
  {
    $rules = [
      'name' => [
        'required',
        Rule::unique(Form::class, 'name')
      ],
      'description' => [
        'nullable'
      ],
      'is_active' => [
        'nullable',
        'boolean'
      ]
    ];

    $messages = [
      'name.required' => 'Nama Formulir wajib diisi.',
      'name.unique' => 'Nama Formulir sudah terdaftar.',
    ];

    $validated = Validator::make($this->request->all(), $rules, $messages)->validate();
    return $validated;
  }

  public function handle()
  {
    $validated = $this->validate();

    if ($validated['is_active'] == true) {
      Form::where('is_active', true)->update(['is_active' => false]);
    }

    $validated['slug'] = Str::slug($validated['name']);
    $data = Form::create($validated);

    $data['message'] = 'Form created successfully!';
    return $data;
  }
}
