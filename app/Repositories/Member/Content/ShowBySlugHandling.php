<?php

/**
 * @author Arbi Syarifudin <arbisyarifudin@gmail.com>
 */

namespace App\Repositories\Member\Content;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Member > Show detail Content data by Slug.
 */
class ShowBySlugHandling
{
  protected $request;
  protected $slug;
  protected $data;

  public function __construct(Request $request, $slug)
  {
    $this->request  = $request;
    $this->slug  = $slug;
  }

  public function validate()
  {
    $this->data = Content::where('slug', $this->slug)->first();

    if (!$this->data) {
      throw new \Exception('Content not found!', 404);
    }
  }

  public function handle()
  {
    $this->validate();

    $data = Content::with([
      'categories',
    ])->where('slug', $this->slug)->first();

    $data['message'] = 'Content detail data!';
    return $data;
  }
}
