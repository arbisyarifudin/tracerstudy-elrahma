<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Admin\Batch;

use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Update Batch Data.
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
    $this->data = Batch::find($this->id);

    if (!$this->data) {
      throw new \Exception('Batch not found!', 404);
    }

    $rules = [
      'year' => [
        'required',
        'date_format:Y',
        Rule::unique(Batch::class, 'year')->whereNull('deleted_at')->ignore($this->id, 'id')
      ]
    ];

    $messages = [
      'year.required' => 'Tahun wajib diisi.',
      'year.unique' => 'Tahun sudah ada.',
      'year.date_format' => 'Format tahun tidak sesuai.',
    ];

    $validated = Validator::make($this->request->all(), $rules, $messages)->validate();
    return $validated;
  }

  public function handle()
  {
    $validated = $this->validate();

    $this->data->update($validated);

    $data = $this->data->refresh();
    $data['message'] = 'Batch updated successfully!';
    return $data;
  }
}
