<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Course;
use App\Tag;
use App\Lecture;

class LectureController extends Controller
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
        //echo "lecture store called".'<br>';
        //echo $request->lecture;
        $flag = true;
        try {
            $serial = (int)$request->lectNum;
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
            $content = $request->ck_editor;
            $lecture = new Lecture();
            $lecture->title = $request->lectTitle;
            $lecture->serial = $serial;
            $lecture->content = $content;
            $lecture->target_course = $target_course;
            $lecture->type = 'lecture';
            $lecture->save();

//            echo "lecture uploaded successfully";
//
//            echo $lecture->content;

            $lecture_arr = Lecture::where('target_course' , $target_course)->orderBy('serial')->get();
            for($i = 0 ; $i < sizeof($lecture_arr) ; $i++){
                $lecture_arr[$i]->serial = $i + 1;
                $lecture_arr[$i]->save();
            }

            return redirect('/updatecourse/'.$target_course);
        }
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
        //
//        echo "Lecture update called with id".$id."<br>";
        $serial = "lectNum".$id;
        $serial = $request->$serial;
        $title = "lectTitle".$id;
        $title = $request->$title;
        $flag = true;
        try {
            $serial = (int)$serial;
        }catch(\Exception $e){
            echo 'the serial no must be a numeric value';
            $flag = false;
        }
//
        if($flag) {
            $lecture = Lecture::find($id);
            $target_course = $lecture->target_course;
            $lecture_arr = Lecture::where('target_course' , $target_course)->get();
            for($i = 0 ; $i < sizeof($lecture_arr) ; $i++){
                if($lecture_arr[$i]->_id == $id) continue;
                if($lecture_arr[$i]->serial >= $serial){
                    $lecture_arr[$i]->serial += 1;
                    $lecture_arr[$i]->save();
                }
            }
            $content = "ck_editor".$id;
            $content = $request->$content;
            $lecture->title = $title;
            $lecture->serial = $serial;
            $lecture->content = $content;
            $lecture->target_course = $target_course;
            $lecture->save();
//
//            echo "lecture updated successfully";
//
//            echo $lecture->serial."<br>";
//            echo $lecture->title."<br>";
//            echo $lecture->content;

            $lecture_arr = Lecture::where('target_course' , $target_course)->orderBy('serial')->get();
            for($i = 0 ; $i < sizeof($lecture_arr) ; $i++){
                $lecture_arr[$i]->serial = $i + 1;
                $lecture_arr[$i]->save();
            }

            return redirect('/updatecourse/'.$target_course);
        }
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

    public function deleteLecture($id){
        if(Auth::check() == false) return redirect('/');
        $lecture = Lecture::find($id);
        if($lecture == null) return redirect('/');
        $target_course = $lecture->target_course;
        $lecture->delete();
        return redirect('/updatecourse/'.$target_course);
    }
}
