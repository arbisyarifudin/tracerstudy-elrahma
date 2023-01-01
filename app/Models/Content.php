<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model
{
    use HasFactory, SoftDeletes;

    /* RELATIONS */

    // categories
    public function categories()
    {
        return $this->hasManyThrough(Categories::class, ContentHasCategories::class, 'category_id', 'id', 'content_id', 'category_id');
    }
}
