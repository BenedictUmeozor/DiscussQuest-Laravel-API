<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
    public function show(Request $request)
    {
        $user = $request->user();
        $questions = $user->questions()->get();

        $data = [
            "user" => $user,
            "questions" => $questions
        ];

        return $data;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string",
            "bio" => "required|string",
            "gender" => "required|string",
        ]);

        $user = $request->user();

        $user->update($validated);

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function getUser($id)
    {

        $user = User::findOrFail($id);
        $questions = $user->questions()->get();

        $data = [
            "user" => $user,
            "questions" => $questions
        ];

        return $data;
    }
}
