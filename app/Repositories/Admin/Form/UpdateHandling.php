<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Admin\Form;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Update Form Data.
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
    $this->data = Form::where('id', $this->id)->orWhere('slug', $this->id)->first();

    if (!$this->data) {
      throw new \Exception('Form not found!', 404);
    }

    $rules = [
      'name' => [
        'required',
        Rule::unique(Form::class, 'name')->ignore($this->data->id, 'id')
      ],
      'description' => [
        'nullable'
      ],
      'is_active' => [
        'sometimes',
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
      Form::where('is_active', true)->update(['is_active', false]);
    }
    $this->data->update($validated);

    $data = $this->data->refresh();
    $data['message'] = 'Form updated successfully!';
    return $data;
  }
}
