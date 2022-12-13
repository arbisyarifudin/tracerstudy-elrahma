<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Member\Education;

use App\Models\AlumniEducation;
use Illuminate\Http\Request;

/**
 * Delete Alumni Education Data.
 */
class DestroyHandling
{
  protected $request;
  protected $id;

  public function __construct(Request $request, $id)
  {
    $this->request  = $request;
    $this->id  = $id;
  }

  public function validate()
  {
    $this->data = AlumniEducation::find($this->id);

    if (!$this->data) {
      throw new \Exception('Alumni education not found!', 404);
    }
  }

  public function handle()
  {
    $this->validate();
    $data = $this->data;

    $this->data->delete();

    $data['message'] = 'Alumni education deleted successfully!';
    return $data;
  }
}
