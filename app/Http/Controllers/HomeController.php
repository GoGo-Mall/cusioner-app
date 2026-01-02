<?php

namespace App\Http\Controllers;

use App\Models\Answar;
use App\Models\CustomerAgent;
use App\Models\Question;
use App\Models\Respondent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $agent_name = $request->query('agent_name');
        $questions = Question::with('options')->get();
        return view('pages.home', compact('questions', 'agent_name'));
    }

    public function store(Request $request)
    {
        // Validate input Umum
        $request->validate([
            'agent_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'product' => 'required|string'
        ]);
        // dd($request->all());

        $customer = CustomerAgent::where('phone', $request->phone)
            ->where('flag', '0')
            ->orderby('created_at', 'desc')
            ->first();

        $customer->update([
            'flag' => '1'
        ]);

        // Simpan Data Responden
        $response = Respondent::create([
            'agent_name' => $request->agent_name,
            'name' => $request->name,
            'phone' => $request->phone,
            'product' => $request->product
        ]);

        Http::asForm()->post('https://sisgesit.site/sisgesit/api/quiz/updateQuiz', [
            'user'     => 'quiz_gogomall',
            'password' => 'Quiz@yXm0UW',
            'id'       => $customer->id_docs,
        ]);




        // Loop semua pertanyaan untuk simpan jawaban
        $questions = Question::all();
        foreach ($questions as $question) {
            $fieldname = 'answer_' . $question->id;
            if ($request->has($fieldname)) {
                Answar::create([
                    'respondent_id' => $response->id,
                    'question_id' => $question->id,
                    'option_id' => $request->$fieldname,
                    'answer_text' => 'Data Test'
                ]);
            }
        }

        return redirect()->route('end.cusioner');
    }

    public function cusioner_end(){
        return view('pages.terimakasih');
    }
}
