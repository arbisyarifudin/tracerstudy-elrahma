<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;

    protected $guarded = [];

    /* RELATIONS */
    public function major()
    {
        return $this->belongsTo(Major::class);
    }
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}
