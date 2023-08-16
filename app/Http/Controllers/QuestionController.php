<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::with('user:id,name,gender,avatar')->with('category')->withCount(['answers', 'likes'])->latest()->limit(6)->get();

        return $questions;
    }

    public function all()
    {
        $questions = Question::with('user:id,name,gender,avatar')->with('category')->withCount(['answers', 'likes'])->latest()->get();

        return $questions;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "category_id" => "required",
            "title" => "required|string|unique:questions,title",
            "body" => "required|string"
        ]);

        $user = $request->user();

        $question = $user->questions()->create($validated);


        return $question;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $question = Question::with('user:id,name,gender,avatar')
            ->with('category')
            ->withCount(['answers', 'likes'])
            ->findOrFail($id);

        $answers = Question::find($id)->answers;

        $response = [
            "question" => $question,
            "answers" => $answers
        ];

        return $response;
    }

    public function question($id)
    {
        $question = Question::with('user:id,name,gender,avatar')
            ->with('category')
            ->withCount(['answers', 'likes'])
            ->where('category_id', $id)
            ->get();

        return $question;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $question = Question::findOrFail($id);

        $question->delete();

        return Response("deleted successfully");
    }
}
