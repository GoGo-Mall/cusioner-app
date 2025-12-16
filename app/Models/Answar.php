<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answar extends Model
{
    protected $fillable = [
        'respondent_id', 'question_id', 'option_id', 'answare_text'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function option(){
        return $this->belongsTo(Option::class);
    }
}
