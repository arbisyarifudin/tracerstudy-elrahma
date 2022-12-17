<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Member\Feedback;

use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Update Alumni feedback Data.
 */
class UpdateHandling
{
  protected $request;
  protected $data;

  public function __construct(Request $request)
  {
    $this->request  = $request;
  }

  public function validate()
  {
    $this->id = auth()->user()->id;
    $this->data = Alumni::where('user_id', $this->id)->first();

    if (!$this->data) {
      throw new \Exception('Alumni not found!', 404);
    }

    $rules = [
      'suggestion' => [
        'required',
      ],
    ];

    $messages = [
      'suggestion.required' => 'Input wajib diisi.',
    ];

    $validated = Validator::make($this->request->all(), $rules, $messages)->validate();
    return $validated;
  }

  public function handle()
  {
    $validated = $this->validate();

    $this->data->update($validated);

    $data['message'] = 'Alumni feedback updated successfully!';
    return $data;
  }
}
