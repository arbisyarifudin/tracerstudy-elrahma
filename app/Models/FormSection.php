<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSection extends Model
{
    use HasFactory;

    protected $guarded = [];

    /* RELATIONS */
    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('order', 'asc');;
    }
}
