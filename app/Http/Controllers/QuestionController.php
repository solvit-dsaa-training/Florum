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
        return response()->json(['code'=>200, 'status'=>'Success','data'=>$questions]);
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
     * @OA\Post(
     *      path="/questions",
     *      operationId="saveQuestion",
     *      tags={"Add Question"},
     *      summary="Ask new question",
     *      description="Returns question registration information",
     *      @OA\Response(
     *       response=200,
     *       description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *      ),
     *       @OA\Parameter(
     *         name="title",
     *         in="query",
     *         description="Question title",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="body",
     *         in="query",
     *         description="Question Body",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="ID of the user who asks the question",
     *         required=true,
     *      ),
     *   ),
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
     * @OA\Get(
     *      path="/questions/{id}",
     *      operationId="getQuestionDetails",
     *      tags={"View Question"},
     *      summary="Get question details",
     *      description="Returns question details on a single page",
     *      @OA\Response(
     *       response=200,
     *       description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *      ),
     *       @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Question ID",
     *         required=true,
     *      ),
     *   ),
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
     * @OA\Put(
     *      path="/questions/{id}",
     *      operationId="updateQuestion",
     *      tags={"Update Question"},
     *      summary="Update Registered question",
     *      description="Updating the already registered question",
     *      @OA\Response(
     *       response=200,
     *       description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *      ),
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Question ID",
     *         required=true,
     *      ),
     *       @OA\Parameter(
     *         name="title",
     *         in="query",
     *         description="Question title",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="body",
     *         in="query",
     *         description="Question Body",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="ID of the user who asks the question",
     *         required=true,
     *      ),
     *   ),
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
     * @OA\Delete(
     *      path="/questions/{id}",
     *      operationId="deleteQuestion",
     *      tags={"RemoveQuestion"},
     *      summary="Delete question",
     *      description="Delete question using ID",
     *      @OA\Response(
     *       response=200,
     *       description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *      ),
     *       @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Question ID",
     *         required=true,
     *      ),
     *   ),
     */

    public function destroy($id)
    {
        $question = Question::find($id)->delete();

        // return redirect()->route('questions.index')
        //     ->with('success', 'Question deleted successfully');
        return 'Question deleted successfully';
    }
}
