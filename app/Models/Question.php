<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $guarded = [];

    /* RELATIONS */
    public function question_options()
    {
        return $this->hasMany(QuestionOption::class)->orderBy('order', 'asc');
    }

    public function question_childs()
    {
        return $this->hasMany(Question::class, 'parent_id', 'id')->whereNotNull('parent_id')->orderBy('order', 'asc');
    }

    public function question_rate()
    {
        return $this->hasOne(QuestionRate::class);
    }
}
