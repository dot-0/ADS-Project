<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Course;
use App\Tag;
use App\Lecture;
use App\Quiz;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $flag = true;
        try {
            $serial = (int)$request->quizNum;
        }catch(\Exception $e){
            echo 'the serial no must be a numeric value';
            $flag = false;
        }

        if($flag) {
            $target_course = $request->course_id;
            $lecture_arr = Lecture::where('target_course' , $target_course)->get();
            for($i = 0 ; $i < sizeof($lecture_arr) ; $i++){
                if($lecture_arr[$i]->serial >= $serial){
                    $lecture_arr[$i]->serial += 1;
                    $lecture_arr[$i]->save();
                }
            }
            $lecture = new Lecture();
            $lecture->title = $request->quizTitle;
            $lecture->serial = $serial;
            $lecture->target_course = $target_course;
            $lecture->type = 'quiz';
            $lecture->save();

            echo "quiz uploaded successfully";

            $lecture_arr = Lecture::where('target_course' , $target_course)->orderBy('serial')->get();
            for($i = 0 ; $i < sizeof($lecture_arr) ; $i++){
                $lecture_arr[$i]->serial = $i + 1;
                $lecture_arr[$i]->save();
            }

            return redirect('/createquiz/'.$lecture->_id);
        }
    }

    public function addQuestion(Request $request)
    {
        $quiz = new Quiz();
        $quiz->target_lecture = $request->id;
        $quiz->question = $request->QuesEditor0;
        $quiz->option1 = $request->Opt1Editor0;
        $quiz->option2 = $request->Opt2Editor0;
        $quiz->option3 = $request->Opt3Editor0;
        $quiz->option4 = $request->Opt4Editor0;
        $quiz->answer = 0;

        if($request->op1 == 'on') $quiz->answer = 1;
        else if($request->op2 == 'on') $quiz->answer = 2;
        else if($request->op3 == 'on') $quiz->answer = 3;
        else if($request->op4 == 'on') $quiz->answer = 4;

//        echo $request->id." Question ==> ".$quiz->question."<br>";
//        echo "Option1 :: ".$quiz->option1."<br>";
//        echo "Option2 :: ".$quiz->option2."<br>";
//        echo "Option3 :: ".$quiz->option3."<br>";
//        echo "Option4 :: ".$quiz->option4."<br>";
//        echo "Answer :::: ".$quiz->answer."<br>";
//        echo "1. ".$request->op1."<br>";
//        echo "2. ".$request->op2."<br>";
//        echo "3. ".$request->op3."<br>";
//        echo "4. ".$request->op4."<br>";

        $quiz->save();
        return redirect('/createquiz/'.$quiz->target_lecture);
    }

    public function createQuiz($id){
        $quiz_arr = Quiz::where('target_lecture' , $id)->get();
        $course_id = Lecture::find($id)->target_course;
        return view('CreateQuiz' , compact('quiz_arr' , 'id' , 'course_id'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
//        $quiz_target = $id;
//        $quiz_arr = Quiz::where('target_lecture' , $quiz_target)->get();
//        return view()

        $target_lecture = $id;
        $quiz_arr = Quiz::where('target_lecture' , $target_lecture)->get();
        $target_course = Lecture::find($id)->target_course;
        return view('ShowQuiz' , compact('quiz_arr', 'id', 'target_course'));
    }

    public function showQuizSolution($id)
    {
        //
//        $quiz_target = $id;
//        $quiz_arr = Quiz::where('target_lecture' , $quiz_target)->get();
//        return view()

        $target_lecture = $id;
        $quiz_arr = Quiz::where('target_lecture' , $target_lecture)->get();
        $target_course = Lecture::find($id)->target_course;

        return view('QuizSolution' , compact('quiz_arr', 'id', 'target_course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        // id = quiz_id
        $quiz = Quiz::find($id);
        $QuesEditor0 = "editQuesEditor".$id;
        $Opt1Editor0 = "editOpt1Editor".$id;
        $Opt2Editor0 = "editOpt2Editor".$id;
        $Opt3Editor0 = "editOpt3Editor".$id;
        $Opt4Editor0 = "editOpt4Editor".$id;

        $quiz->question = $request->$QuesEditor0;
        $quiz->option1 = $request->$Opt1Editor0;
        $quiz->option2 = $request->$Opt2Editor0;
        $quiz->option3 = $request->$Opt3Editor0;
        $quiz->option4 = $request->$Opt4Editor0;
        $quiz->answer = 0;

        $op1 = "editOp1";
        $op2 = "editOp2";
        $op3 = "editOp3";
        $op4 = "editOp4";
        if($request->$op1 == 'on') $quiz->answer = 1;
        else if($request->$op2 == 'on') $quiz->answer = 2;
        else if($request->$op3 == 'on') $quiz->answer = 3;
        else if($request->$op4 == 'on') $quiz->answer = 4;

        echo $request->id." Question ==> ".$quiz->question."<br>";
        echo "Option1 :: ".$quiz->option1."<br>";
        echo "Option2 :: ".$quiz->option2."<br>";
        echo "Option3 :: ".$quiz->option3."<br>";
        echo "Option4 :: ".$quiz->option4."<br>";
        echo "Answer :::: ".$quiz->answer."<br>";
//        echo "1. ".$request->op1."<br>";
//        echo "2. ".$request->op2."<br>";
//        echo "3. ".$request->op3."<br>";
//        echo "4. ".$request->op4."<br>";

        $quiz->save();
        return redirect('/createquiz/'.$quiz->target_lecture);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function deleteQuizQuestion($id){
        if(Auth::check() == false) return redirect('/');
        $question = Quiz::find($id);
        if($question == null) return redirect('/');
        $target_lecture = $question->target_lecture;
        $question->delete();
        return redirect('/createquiz/'.$target_lecture);
    }
}
