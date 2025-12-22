<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\CustomerAgent;
use Illuminate\Http\Request;

class CustomerAgentContoller extends Controller
{
    public function store(Request $request){
        $request->validate([
            'agent_name' => 'required|string|max:255',
            'product' => 'required|string|max:255',
            'no_product' => 'required|integer',
            'customer' => 'required|string|max:255',
            'phone' => 'required|string'
        ]);

        $data = CustomerAgent::create([
            'agent_name' => $request->agent_name,
            'product' => $request->product,
            'no_product' => $request->no_product,
            'customer' => $request->customer,
            'phone' => $request->phone
        ]);

        return response()->json([
            'status' => true,
            'message' => "Data berhasil ditambahkan",
            'data' => $data
        ], 200);
    }
}
