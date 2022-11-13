<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $hidden = ['deleted_at'];

    /* RELATIONS */
    public function sections()
    {
        return $this->hasMany(FormSection::class)->orderBy('order', 'asc');
    }
}
