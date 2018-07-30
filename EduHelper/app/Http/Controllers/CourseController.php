<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Auth;
use App\User;
use App\Course;
use App\Tag;
use App\Lecture;
use App\Question;
use App\Reply;
use App\Quiz;

class CourseController extends Controller
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
        if(Auth::check() == false) return redirect('/');
        $user_id = Auth::user()->_id;
        $user = User::find($user_id);
        if($user->role !== 'teacher'){
            echo 'you must be a teacher to upload a course';
        }
        else{
            return view('CreateCourse');
        }
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
        echo "Course store called".'<br>';
        echo $request->courseTitle."<br>";
        echo $request->tags."<br>";

        if(Auth::check() == false) return redirect('/');
        $user_id = Auth::user()->_id;
        $user = User::find($user_id);

        if($user->role !== 'teacher') return redirect('/');

        $course = new Course();
        $course->title = $request->courseTitle;
        $course->uploaded_by = $user_id;
        $course->description = ""; // request->courseDescription

        $course->save();
        if($request->tags !== null) {
            $tag_arr = explode(',', $request->tags);
//            echo "HI" . " " . sizeof($tag_arr) . '<br>';
            for ($i = 0; $i < sizeof($tag_arr); $i++) {
                $tag_arr[$i] = trim($tag_arr[$i]);
                $tag_arr[$i] = strtoupper($tag_arr[$i]);
            }
//            foreach ($tag_arr as $tag) {
//                echo "--->" . $tag . "<----" . '<br>';
//            }

            $tagArr = [];
            if (sizeof($tag_arr) != 0) {
                for ($i = 0; $i < sizeof($tag_arr); $i++) {
                    //echo "===============> ".$tag_arr[$i]." ".strlen($tag_arr[$i]).'<br>';
                    $exp = '/.*' . $tag_arr[$i] . '*/i';
                    $tag_match = Tag::where('name', 'regexp', $exp)->get();
                    $tag = null;
                    if (sizeof($tag_match) != 0) {
                        foreach ($tag_match as $tg) {
                            // echo "---> ".$tg->name." ".strlen($tg->name).'<br>';
                            if (strlen($tg->name) == strlen($tag_arr[$i])) {
                                $tag = $tg;
                                break;
                            }
                        }
                    }
                    if ($tag == null) {
                        $tag = new Tag();
                        $tag->name = $tag_arr[$i];
                        $tag->course_list = [];
                    }
                    $tag->course_list = array_prepend($tag->course_list, $course->_id);
                    $tag->save();
                    $tagArr = array_prepend($tagArr, $tag->_id);
                }
            }
            $tagArr = array_reverse($tagArr);
            $course->tag_arr = $tagArr;
        }
        else $course->tag_arr = [];

        $course->rating_arr = [];
        $course->users_given_rating = [];
        $course->rating = 0.0;
        $course->rating_sum = 0.0;
        $course->save();


//        echo "exit".'<br>';
        return redirect('/updatecourse/'.$course->_id);
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
        $course = Course::find($id);
        $tag_arr = [];
        foreach($course->tag_arr as $tag_id){
            $tag = Tag::find($tag_id);
            if($tag !== null){
                $tag_arr = array_prepend($tag_arr , $tag);
            }
        }
        $tag_arr = array_reverse($tag_arr);
        $lecture_arr = Lecture::where('target_course' , $id)->orderBy('serial')->get();
        $uploader = User::find($course->uploaded_by);
//        echo sizeof($lecture_arr);

//        for ($i = 0 ; $i < sizeof($lecture_arr) ; $i++){
//            $lecture = $lecture_arr[$i];
//            echo " ====> "."<br>";
//            echo $lecture->content."<br>";
//        }
        $fav = 0;
        if(Auth::check()){
            $currentUser = Auth::user();
            if (($key = array_search($id, $currentUser->bookmarked_courses)) !== false) $fav = 1;
        }

//        echo $fav;
        $rating = 0.0;
        if(Auth::check()){
            $currentUser = Auth::user();
            for($i = 0 ; $i < sizeof($course->users_given_rating) ; $i++){
                if($course->users_given_rating[$i] == $currentUser->_id){
                    $rating = $course->rating_arr[$i];
                }
            }
        }

        $comment_arr_2D = array_fill(0 , sizeof($lecture_arr) , NULL);
        $reply_arr_3D = array_fill(0 , sizeof($lecture_arr) , NULL);
        $commenter_arr_2D = array_fill(0 , sizeof($lecture_arr) , NULL);
        $replier_arr_3D = array_fill(0 , sizeof($lecture_arr) , NULL);

        for($l = 0 ; $l < sizeof($lecture_arr) ; $l++) {
            $lecture = $lecture_arr[$l];
            $comment_arr = Question::where('target_id', $lecture->id)->orderBy('created_at', 'desc')->get();
            $reply_arr_2D = array_fill(0, sizeof($comment_arr), NULL);
            $commenter_arr = array_fill(0, sizeof($comment_arr), NULL);
            $replier_arr_2D = array_fill(0, sizeof($comment_arr), NULL);

            for ($i = 0; $i < sizeof($comment_arr); $i++) {
                $comment = $comment_arr[$i];
                $commenter_arr[$i] = User::find($comment->commenter);

                $reply_arr = Reply::where('target_id' , $comment->id)->orderBy('created_at', 'desc')->get();
                $reply_arr_2D[$i] = $reply_arr;

                $replier_arr = array_fill(0, sizeof($reply_arr), NULL);
                for ($j = 0; $j < sizeof($reply_arr); $j++) {
                    $reply = $reply_arr[$j];
                    $replier_arr[$j] = User::find($reply->replier);
                }
                $replier_arr_2D[$i] = $replier_arr;
            }

            $comment_arr_2D[$l] = $comment_arr;
            $commenter_arr_2D[$l] = $commenter_arr;
            $reply_arr_3D[$l] = $reply_arr_2D;
            $replier_arr_3D[$l] = $replier_arr_2D;
        }

//        for($k = 0 ; $k < sizeof($comment_arr_2D) ; $k++){
//            for($i = 0 ; $i < sizeof($comment_arr_2D[$k]);$i++){
//                echo "Comment:: ".$comment_arr_2D[$k][$i]->comment."<br>";
//                for($j = 0 ; $j < sizeof($reply_arr_3D[$k][$i]) ; $j++){
//                    echo "   Reply:: ".$reply_arr_3D[$k][$i][$j]->reply."<br>";
//                }
//            }
//        }

        return view('ShowCourse' , compact('course' , 'tag_arr' , 'lecture_arr' , 'uploader' , 'id' , 'fav' , 'rating' , 'comment_arr_2D' , 'reply_arr_3D' , 'commenter_arr_2D' , 'replier_arr_3D'));
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

    public function updateRating(Request $request){
        $id = $request->target_id;
        $course = Course::find($id);
        $user_id = $request->user_id;
        $len = sizeof($course->users_given_rating);
        $fl = false;
        for($i = 0 ; $i < $len ; $i++){
            if($course->users_given_rating[$i] == $user_id){
                $course->rating_sum -= $course->rating_arr[$i];
                $arr = $course->rating_arr;
                $arr[$i] = $request->given_rating;
                $course->rating_arr = $arr;
                $course->rating_sum += $course->rating_arr[$i];
                $fl = true;
                break;
            }
        }
        if($fl == false){
            $course->users_given_rating = array_prepend($course->users_given_rating , $user_id);
            $course->rating_arr = array_prepend($course->rating_arr , $request->given_rating);
            $course->rating_sum += $request->given_rating;
        }
        if(sizeof($course->rating_arr) > 0) $course->rating = $course->rating_sum/sizeof($course->rating_arr);
        else $course->rating = 0.0;
        $course->save();
        return response()->json(['success'=>'rating updated' , 'new_rating'=>$course->rating]);
    }

    public function showUpdateForm($id){
        if(Auth::check() == false) return redirect('/');
        $user_id = Auth::user()->_id;
        $user = User::find($user_id);
        if($user->role !== 'teacher') return redirect('/');

        $course = Course::find($id);
        if($course == null) return redirect('/');
        if($user->_id !== $course->uploaded_by) return redirect('/');
        $tag_text = "";
        $tag_arr = [];
        $pre = "";
        foreach($course->tag_arr as $tag_id){
            $tag = Tag::find($tag_id);
            if($tag !== null){
                $tag_arr = array_prepend($tag_arr , $tag);
                $tag_text = $tag_text.$pre.$tag->name;
                $pre = ", ";
            }
        }
        $tag_arr = array_reverse($tag_arr);
        $lecture_arr = Lecture::where('target_course' , $id)->orderBy('serial')->get();
        $course_id = $id;
        return view('UpdateCourse' , compact('course' , 'tag_arr' , 'tag_text','lecture_arr' , 'course_id'));
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
        if(Auth::check() == false) return redirect('/');
        $user_id = Auth::user()->_id;
        $user = User::find($user_id);
        if($user->role !== 'teacher') return redirect('/');


//        echo "Course update called".'<br>';
//        echo $request->courseTitle."<br>";
//        echo $request->tags."<br>";

        if(Auth::check() == false) return redirect('/');

        $course = Course::find($id);
        $course->title = $request->courseTitle;
        $course->description = ""; // request->courseDescription

        if($course == null) return redirect('/');
        if($user->_id !== $course->uploaded_by) return redirect('/');

        foreach($course->tag_arr as $tag_id){
            $tag = Tag::find($tag_id);
            $arr = $tag->course_list;
            if (($key = array_search($id, $arr)) !== false) {
                unset($arr[$key]);
            }
            $tag->course_list = $arr;
            $tag->save();
        }

        if($request->tags !== null) {
            $tag_arr = explode(',', $request->tags);
//            echo "HI" . " " . sizeof($tag_arr) . '<br>';
            for ($i = 0; $i < sizeof($tag_arr); $i++) {
                $tag_arr[$i] = trim($tag_arr[$i]);
                $tag_arr[$i] = strtoupper($tag_arr[$i]);
            }
//            foreach ($tag_arr as $tag) {
//                echo "--->" . $tag . "<----" . '<br>';
//            }

            $tagArr = [];
            if (sizeof($tag_arr) != 0) {
                for ($i = 0; $i < sizeof($tag_arr); $i++) {
                    //echo "===============> ".$tag_arr[$i]." ".strlen($tag_arr[$i]).'<br>';
                    $exp = '/.*' . $tag_arr[$i] . '*/i';
                    $tag_match = Tag::where('name', 'regexp', $exp)->get();
                    $tag = null;
                    if (sizeof($tag_match) != 0) {
                        foreach ($tag_match as $tg) {
                            // echo "---> ".$tg->name." ".strlen($tg->name).'<br>';
                            if (strlen($tg->name) == strlen($tag_arr[$i])) {
                                $tag = $tg;
                                break;
                            }
                        }
                    }
                    if ($tag == null) {
                        $tag = new Tag();
                        $tag->name = $tag_arr[$i];
                        $tag->course_list = [];
                    }
                    $tag->course_list = array_prepend($tag->course_list, $course->_id);
                    $tag->save();
                    $tagArr = array_prepend($tagArr, $tag->_id);
                }
            }
            $tagArr = array_reverse($tagArr);
            $course->tag_arr = $tagArr;
        }

        $course->save();


        echo "updated".'<br>';
        return redirect('/updatecourse/'.$course->_id);
    }

    public function getSearchKey(Request $request)
    {
        $key = $request->key;
        return redirect('/searchResult/'.$key);
    }

    public function showSearchResult($key)
    {
        $exp = '/.*'.$key.'.*/i';
        $course_arr = Course::where('title' , 'regexp' , $exp)->orderBy('title')->paginate(16);
        $num_lecture = [];
        $uploaded_by = [];
        foreach ($course_arr as $course){
            $uploader = User::find($course->uploaded_by);
            $uploaded_by = array_prepend($uploaded_by , $uploader);
            $lecture_count = Lecture::where('target_course' , $course->_id)->count();
            $num_lecture = array_prepend($num_lecture , $lecture_count);
        }

        $num_lecture = array_reverse($num_lecture);
        $uploaded_by = array_reverse($uploaded_by);

        return view('SearchResults' , compact('course_arr' , 'num_lecture' , 'uploaded_by'));
    }

    public function searchByTag($id)
    {
        $tag = Tag::find($id);
        $course_arr = [];
        foreach ($tag->course_list as $course_id){
            $course = Course::find($course_id);
            $course_arr = array_prepend($course_arr , $course);
        }
        $course_arr = array_reverse($course_arr);
        $num_lecture = [];
        $uploaded_by = [];
        foreach ($course_arr as $course){
            $uploader = User::find($course->uploaded_by);
            $uploaded_by = array_prepend($uploaded_by , $uploader);
            $lecture_count = Lecture::where('target_course' , $course->_id)->count();
            $num_lecture = array_prepend($num_lecture , $lecture_count);
        }

        $num_lecture = array_reverse($num_lecture);
        $uploaded_by = array_reverse($uploaded_by);

        return view('SearchByTag' , compact('course_arr' , 'num_lecture' , 'uploaded_by'));
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
    public function deleteCourse($id){
        if(Auth::check() == false) return redirect('/');
        $course = Course::find($id);
        if($course == null) return redirect('/');

        $user_id = Auth::user()->_id;
        $user = User::find($user_id);
        if($user->_id !== $course->uploaded_by) return redirect('/');

        $user = $course->uploaded_by;

        $lecture_arr = Lecture::where('target_course' , $id)->get();
        for($i = 0 ; $i < sizeof($lecture_arr) ; $i++){
            $lecture_arr[$i]->delete();
        }
        
        $course->delete();
        return redirect('/user/'.$user);
    }
}
