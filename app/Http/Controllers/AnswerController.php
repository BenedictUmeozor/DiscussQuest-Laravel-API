<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $answers = Answer::where('question_id', request('id'))->with('user')->get();
        return $answers;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "question_id" => 'required',
            "body" => "required|string"
        ]);

        $user = $request->user();

        $answer = $user->answers()->create($validated);
        return $answer;
    }

    /**
     * Display the specified resource.
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            "body" => "required|string"
        ]);

        $answer = Answer::findOrFail($id);

        $answer->update($validated);
        return $answer;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $answer = Answer::findOrFail($id);
        $answer->delete();

        return Response("Deleted successfully");
    }
}
