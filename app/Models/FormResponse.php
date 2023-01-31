<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormResponse extends Model
{
    use HasFactory;

    protected $guarded = [];

    /* RELATIONS */

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }
}
