<?php

use App\Http\Controllers\api\CustomerAgentContoller;
use App\Models\CustomerAgent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('store/respon', [CustomerAgentContoller::class, 'store']);
