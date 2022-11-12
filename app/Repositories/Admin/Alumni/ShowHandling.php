<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Admin\Alumni;

use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Show detail Alumni Data.
 */
class ShowHandling
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
  }

  public function handle()
  {
    $this->validate();

    $data = $this->data;

    $data['message'] = 'Alumni detail data!';
    return $data;
  }
}
