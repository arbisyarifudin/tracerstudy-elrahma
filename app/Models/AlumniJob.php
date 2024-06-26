<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumniJob extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'institution_contacts' => 'json'
    ];
}
