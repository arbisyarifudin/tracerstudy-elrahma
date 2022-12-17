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
 * Show Alumni feedback Data.
 */
class ShowHandling
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
  }

  public function handle()
  {
    $this->validate();
    $data['suggestion'] = $this->data->suggestion;
    $data['message'] = 'Alumni feedback data.';
    return $data;
  }
}
