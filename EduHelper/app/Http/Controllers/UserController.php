<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\User;
use App\Course;
use App\Lecture;

class UserController extends Controller
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
        $user = User::find($id);
        $course_arr = [];
        if($user->role == 'teacher') {
//            echo 'HIHIHI';
            $course_arr = Course::where('uploaded_by' , $id)->get();
        }
        else{
            foreach($user->bookmarked_courses as $course_id){
                $course = Course::find($course_id);
                if($course !== null) {
                    $course_arr = array_prepend($course_arr, $course);
                }
            }
            $course_arr = array_reverse($course_arr);
        }
        $lecture_arr = [];
        $uploader_arr = [];
        foreach($course_arr as $course){
            $num_lec = Lecture::where('target_course' , $course->_id)->count();
            $uploader = User::find($course->uploaded_by);

            $lecture_arr = array_prepend($lecture_arr , $num_lec);
            $uploader_arr = array_prepend($uploader_arr , $uploader);
        }

        $lecture_arr = array_reverse($lecture_arr);
        $uploader_arr = array_reverse($uploader_arr);
//        echo $user->role."<br>";
//        echo sizeof($uploader_arr)."<br>";
//        echo sizeof($lecture_arr)."<br>";
//        echo sizeof($course_arr)."<br>";
        return view('UserProfile' , compact('user' , 'course_arr' , 'lecture_arr' , 'uploader_arr'));
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
//        echo "User update called with id ".$id.'<br>';
        if(Auth::check() == false) return redirect('/');
        if(Auth::user()->_id !== $id) return redirect('/');
        
        $user = User::find($id);
        $user->name = $request->name;
        $user->about_me = $request->aboutMe;
//
//        echo $user->name." ".$user->about_me."<br>";
//        echo $request->name." ".$request->aboutMe.'<br>';
        if($request->proPic != null){
            $img = $request->proPic;
            $name = $img->getClientOriginalName();
            $img->move('profilePic/' . $user->_id, $name);
            $user->profilePic = 'profilePic/' . $user->_id . "/" . $name;

//            echo 'image uploaded'.'<br>';
        }
        $user->save();
        return redirect('/user/'.$id);
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

    public function addToFav(Request $request)
    {
        $user_id = $request->user_id;
        $target_id = $request->target_id;
        $user = User::find($user_id);
        $arr = $user->bookmarked_courses;
        if (($key = array_search($target_id, $arr)) !== false) {
            unset($arr[$key]);
        }
        else $arr = array_prepend($arr ,  $target_id);
        $user->bookmarked_courses = $arr;
        $user->save();
        return response()->json(['success'=>'fav_list updated']);
    }
}
