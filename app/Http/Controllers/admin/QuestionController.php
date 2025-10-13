<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quests = Question::all();
        return view('pages.admin.quest.index', compact('quests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'question_text' => 'required|string|max:255',
            'type' => 'required|string',
            'required' => 'boolean',
            'order' => 'required|integer',
            'options' => 'nullable|array'
        ]);

        $question = Question::create([
            'question_text' => $validate['question_text'],
            'type' => $validate['type'],
            'required' => $validate['required'] ?? false,
            'order' => $validate['order']
        ]);

        if (!empty($validate['options'])) {
            foreach ($validate['options'] as $opt) {
                Option::create([
                    'question_id' => $question->id,
                    'option_text' => $opt['text'],
                    'value' => $opt['value']
                ]);
            }
        }

        $question->load('options');

        return response()->json([
            'message' => 'Pertanyaan berhasil disimpan',
            'data' => $question
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $question = Question::findOrFail($id);
        return response()->json($question);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'question_text' => 'required|string|max:255',
            'type' => 'required|string|in:text,radio,checkbox',
            'required' => 'boolean',
            'order' => 'required|integer',
            'options' => 'nullable|array'
        ]);

        $question = Question::findOrFail($id);
        $question->update([
            'question_text' => $validate['question_text'],
            'type' => $validate['type'],
            'required' => $validate['required'],
            'order' => $validate['order']
        ]);

        if (isset($validate['options'])) {
            Option::where('question_id', $question->id)->delete();

            // Tambah Opsi Baru
            foreach ($validate['options'] as $opt) {
                Option::create([
                    'question_id' => $question->id,
                    'option_text' => $opt['text'] ?? '',
                    'value' => $opt['value'] ?? 0
                ]);
            }
        }

        $question->load('options');
        return response()->json([
            'message' => 'Pertanyaan dan opsi berhasil diperbarui',
            'data' => $question
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $question = Question::findOrFail($id);

        // 🔹 Hapus semua opsi terkait
        Option::where('question_id', $question->id)->delete();

        // 🔹 Hapus pertanyaan
        $question->delete();

        return response()->json([
            'message' => 'Pertanyaan dan semua opsi terkait berhasil dihapus.'
        ]);
    }
}
