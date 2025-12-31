<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAgent extends Model
{
    protected $fillable = [
        'agent_name',
        'product',
        'no_product',
        'customer',
        'phone',
        'flag',
        'id_docs',
        'no_docs'
    ];
}
