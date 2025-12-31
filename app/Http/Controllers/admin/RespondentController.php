<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Answar;
use App\Models\Respondent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RespondentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $respondents = DB::table('answars as a')
            ->leftJoin('respondents as r', 'a.respondent_id', '=', 'r.id')
            ->leftJoin('options as o', 'a.option_id', '=', 'o.id')
            ->leftJoin('customer_agents as ca', 'ca.phone', '=', 'r.phone')
            ->select(
                'r.agent_name',
                DB::raw('SUM(o.value) AS score'),
                DB::raw("
            COUNT(
                DISTINCT CASE
                    WHEN ca.flag = '0' OR ca.flag IS NULL
                    THEN ca.phone
                END
            ) AS norespon
        "),
                DB::raw("
            COUNT(
                DISTINCT CASE
                    WHEN ca.flag = '1'
                    THEN ca.phone
                END
            ) AS respon
        ")
            )
            ->groupBy('r.agent_name')
            ->get();

        return view('pages.admin.respondent.index', compact('respondents'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $respondents = Respondent::findOrFail($id);

        $answers = Answar::with(['question', 'option'])
            ->where('respondent_id', $id)
            ->orderBy('question_id')
            ->get();

        return view('pages.admin.respondent.show', compact('respondents', 'answers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
