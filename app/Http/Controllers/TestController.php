<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Test;
use App\Models\UserTest;
use Illuminate\Http\Request;

class TestController extends Controller
{
    //

    public function getAllTests()
    {
        $tests = Test::withCount('questions') // Include users and questions
            ->get();

        return response()->json($tests);
    }

    public function getQuestions($id)
    {
        $test = Test::with('questions.choices')->find($id);

        if (!$test) {
            return response()->json(['message' => 'Test not found'], 404);
        }

        return response()->json([
            'test_title' => $test->test_title,
            'questions' => $test->questions,
            'test_duration' => $test->test_duration
        ]);
    }

    public function submitTest(Request $request)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'test_id' => 'required|exists:tests,id',
            'score' => 'required|integer',
            'number_of_total_questions' => 'required|integer',
            'number_of_answred_questions' => 'required|integer',
            'number_of_correct_answers' => 'required|integer',
            'taken_time_to_complete_the_test' => 'required|integer',
            'results' => 'required|array', // Must be an array
            'results.*.question_id' => 'required|exists:questions,id',
            'results.*.choice_id' => 'required|exists:choices,id',
            'results.*.is_correct' => 'required|boolean'
        ]);


        // Save User Test
        $userTest = UserTest::create([
            'user_id' => $validatedData['user_id'],
            'test_id' => $validatedData['test_id'],
            'score' => $validatedData['score'],
            'number_of_total_questions' => $validatedData['number_of_total_questions'],
            'number_of_answred_questions' => $validatedData['number_of_answred_questions'],
            'number_of_correct_answers' => $validatedData['number_of_correct_answers'],
            'taken_time_to_complete_the_test' => $validatedData['taken_time_to_complete_the_test'],
        ]);

        // Save Results (Loop through each question answer)
        foreach ($validatedData['results'] as $result) {
            Result::create([
                'user_test_id' => $userTest->id,
                'question_id' => $result['question_id'],
                'choice_id' => $result['choice_id'],
                'is_correct' => $result['is_correct'],
            ]);
        }



        return response()->json([
            'status' => 'success',
            'message' => 'Test submitted successfully',
            'user_test_id' => $userTest->id
        ], 201);


    }

    public function getCompletedTests(Request $request)
    {
        $userId = $request->input('user_id'); // Get user_id from the request

        // Fetch completed tests for the authenticated user
        $completedTests = UserTest::where('user_id', $userId)
            ->pluck('test_id'); // Return an array of completed test IDs

        return response()->json($completedTests);


    }


}
