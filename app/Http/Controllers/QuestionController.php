<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Validator;

/**
 * Class QuestionController
 * @package App\Http\Controllers
 */
class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::all();

        // return view('question.index', compact('questions'))
        //     ->with('i', (request()->input('page', 1) - 1) * $questions->perPage());
        return $questions;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $question = new Question();
        return view('question.create', compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // request()->validate(Question::$rules);

        $validator = Validator::make($request->all(), [ 
            'title' => 'required|max:400|unique:questions,title',
            'body' => 'required',
            'user_id'=>'required|numeric',
        ]);
      
        if ($validator->fails()) {
          return response()->json($validator->errors(), 422);
        }
        

        if($question = Question::create(['title'=>$request->title,'body'=>$request->body,'status'=>$request->status,'user_id'=>$request->user_id]))
        {
            return 'Question posted successfully';
        }
        else
        {
            return 'Error when saving question';
        }

        // return redirect()->route('questions.index')
        //     ->with('success', 'Question created successfully.');
        // return $question;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::find($id);

        // return view('question.show', compact('question'));
        return $question;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::find($id);

        return view('question.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Question $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        $validator = Validator::make($request->all(), [ 
            'title' => 'required|max:400',
            'body' => 'required',
            'user_id'=>'required|numeric',
        ]);
      
        if ($validator->fails()) {
          return response()->json($validator->errors(), 422);
        }
        if($question->update($request->all())){
            return 'Question updated successfully';
        }
        else{
            return 'Error occured when updating question';
        }

        // return redirect()->route('questions.index')
        //     ->with('success', 'Question updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $question = Question::find($id)->delete();

        // return redirect()->route('questions.index')
        //     ->with('success', 'Question deleted successfully');
        return 'Question deleted successfully';
    }
}
