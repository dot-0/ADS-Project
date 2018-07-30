<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Tag;
use App\Course;
use App\User;
use App\Lecture;

Route::get('/query' , function(){
//    $tag_arr = Tag::all();
//    foreach ($tag_arr as $tag){
//        echo ">".$tag->name."<"."<br>";
//    }

//    $course_arr = Course::all();
//    for($i = 0 ; $i < sizeof($course_arr) ; $i++){
//        $course_arr[$i]->rating_arr = [];
//        $course_arr[$i]->users_given_rating = [];
//        $course_arr[$i]->rating = 0.0;
//        $course_arr[$i]->rating_sum = 0.0;
//        $course_arr[$i]->save();
//    }
//    $lecture_arr = Lecture::all();
//    for($i = 0 ; $i < sizeof($lecture_arr) ; $i++){
//        $lecture_arr[$i]->type = "lecture";
//        $lecture_arr[$i]->save();
//    }
});


Route::get('/', function () {
    $course_arr = Course::orderBy('created_at' , 'desc')->take(6)->get();
    $num_course = Course::orderBy('created_at' , 'desc')->count();
    $num_student = User::where('role','student')->count();
    $num_teacher = User::where('role','teacher')->count();
    $teacher_arr = User::where('role','teacher')->get();
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
    return view('Homepage' , compact('course_arr' , 'num_course' , 'num_student' , 'num_teacher' , 'teacher_arr' , 'lecture_arr' , 'uploader_arr'));
});

Route::get('/master1', function () {
    return view('MasterLayout1');
});

Route::get('/master2', function () {
    return view('MasterLayout2');
});


Route::get('/searchResult/{key}', 'CourseController@showSearchResult');
Route::get('/searchByTag/{key}', 'CourseController@searchByTag');
Route::post('/getSearchKey', 'CourseController@getSearchKey');

Route::get('/allcourses', function () {
    $course_arr = Course::orderBy('title')->paginate(16);
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

    return view('AllCourses' , compact('course_arr' , 'num_lecture' , 'uploaded_by'));
});


Route::get('/updatecourse/{id}', 'CourseController@showUpdateForm');
Route::get('/createquiz/{id}', 'QuizController@createQuiz');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('Homepage');
Route::resource('user' , 'UserController');
Route::resource('course' , 'CourseController');
Route::resource('lecture' , 'LectureController');
Route::resource('quiz' , 'QuizController');
Route::post('/addQuestion' , 'QuizController@addQuestion');
Route::get('/quizsolution/{id}' , 'QuizController@showQuizSolution');

Route::get('/deleteQuizQuestion/{id}' , 'QuizController@deleteQuizQuestion');
Route::get('/deleteLecture/{id}' , 'LectureController@deleteLecture');
Route::get('/deleteCourse/{id}' , 'CourseController@deleteCourse');