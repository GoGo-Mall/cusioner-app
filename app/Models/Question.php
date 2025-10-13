<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'question_text', 'type', 'required', 'order'
    ];

    protected $casts = [
        'required' => 'boolean'
    ];

    public function options(){
        return $this->hasMany(Option::class);
    }
}
