<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Respondent extends Model
{
    protected $fillable = [
        'agent_name', 'name', 'phone', 'product'
    ];
}
