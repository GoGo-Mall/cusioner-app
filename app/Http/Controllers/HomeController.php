<?php

namespace App\Http\Controllers;

use App\Models\Answar;
use App\Models\Question;
use App\Models\Respondent;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request){
        $agent_name = $request->query('agent_name');
        $questions = Question::with('options')->get();
        return view('pages.home', compact('questions', 'agent_name'));
    }

    public function store(Request $request){
        // Validate input Umum
        $request->validate([
            'agent_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'product' => 'required|string'
        ]);
        // dd($request->all());

        // Simpan Data Responden
        $response = Respondent::create([
            'agent_name' => $request->agent_name,
            'name' => $request->name,
            'phone' => $request->phone,
            'product' => $request->product
        ]);




        // Loop semua pertanyaan untuk simpan jawaban
        $questions = Question::all();
        foreach($questions as $question){
            $fieldname = 'answer_'.$question->id;
            if($request->has($fieldname)){
                Answar::create([
                    'respondent_id' => $response->id,
                    'question_id' => $question->id,
                    'option_id' => $request->$fieldname,
                    'answer_text' => 'Data Test'
                ]);
            }
        }

        return redirect()->back()->with('success', 'Terima Kasih! Jawaban anda sudah tersimpan');
    }
}
