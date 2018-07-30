@extends('MasterLayout1')
@section('content')


<header class="masthead">
  <div class="container">
    <div class="intro-text">
      <div class="intro-heading">Update</div>
    </div>
  </div>
</header>

<div class="Gap10"></div>

<div class="container" id="detailDiv">
<div class="courseContainer">
<div class="circle-tile">
  <a href="#"><div class="circle-tile-heading green"><i class="fa fa-book fa-fw fa-3x"></i></div></a>
  <div class="Gap3"></div>
</div>
</div>
<div class="courseNameTag">
  <h1>{{$course->title}}</h1>
  <h3>
    @for($i = 0 ; $i < sizeof($tag_arr) ; $i++)
      @if($i > 0)
        ,&nbsp
      @endif
      {{$tag_arr[$i]->name}}
    @endfor
  </h3>
  <a class="editIcon" id="editButton"><i class="fa fa-edit" style="color: white;"></i></a>
  <a id="deleteCourseButton" onclick="deleteItem('course', '0');" class="deleteCourseIcon"><i class="fa fa-times" style="color: white;"></i></a>
</div>
</div>

<div id="courseDelConf" class="delConfDiv" style="display: none;">
  <h1 style="font-size: 20px;">Are you sure you want to delete this Course?</h1>
  <div class="Gap5"></div>
  <button id="courseDelYes" onclick="window.location = '/deleteCourse/{{$course_id}}';" style="margin-right: 70px; width: 80px;">Yes</button>
  <button id="courseDelNo" onclick="noClicked('course', '0')" style="margin-left: 60px; width: 80px;">No</button>
</div>



<div class="container" id="editDiv" style="display: none">
    {!! Form::open(
       array(
            'method'=>'PUT',
            'route'=>['course.update' , Request::segment(2)],
            'class' => 'form',
            'novalidate' => 'novalidate',
            'files' => true))
   !!}
<div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Course Title</label>
  <div class="col-10">
    <input class="form-control" type="text" value="{{$course->title}}" id="courseTitle" name="courseTitle">
  </div>
</div>

<div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Tag (s)</label>
  <div class="col-10">
    <input class="form-control" type="text" value="{{$tag_text}}" id="tags" name="tags">
  </div>
</div>

 <button type="submit" style="margin-left: 46%; background-color: #2866b3" class="btn btn-primary">Done</button>
    {!! Form::close() !!}
 </div>


<div class="container" id="lectDiv">
  <div style="display: none;">{{$i=0}}</div>
@foreach($lecture_arr as $lecture)
<div class="lectNumber">
  <button type="button" class="btn btn-default btn_num-circle btn_num-lg">{{$lecture->serial}}</button>
</div>
<div class="lecturesDiv">
  <h1>{{$lecture->title}}</h1>
  @if($lecture->type=='quiz')
  <a class="editIcon2" id="{{"editLectButton".$i}}" href="/createquiz/{{$lecture->id}}" ><i class="fa fa-edit" style="color: white;"></i></a>
  @else
  <a class="editIcon2" id="{{"editLectButton".$i}}" onclick="openEditLectureDiv({{$i}}, {{sizeof($lecture_arr)}});" ><i class="fa fa-edit" style="color: white;"></i></a>
  @endif
  <a id="{{"deleteLectButton".$i}}" onclick="deleteItem('lect', {{$i}});" class="deleteLectIcon"><i class="fa fa-times" style="color: white;"></i></a>
</div>
    <div  id="{{"editLectDiv".$i}}" style="margin-top: -20px; margin-bottom: 20px; display: none;">
      <div class="Gap10"></div>
      <div class="ckeditor_Div">
        {!! Form::open(
       array(
            'method'=>'PUT',
            'route'=>['lecture.update' , $lecture->_id],
            'class' => 'form',
            'novalidate' => 'novalidate',
            'files' => true))
   !!}
          <a id="{{"editLectCancel".$i}}" onclick="closeEditLectureDiv({{$i}});" style="cursor: pointer; float: right;"><i class="fa fa-times"></i></a>
          <div class="form-group row">
            <label for="example-text-input" class="col-2 col-form-label">Lecture No.</label>
            <div class="col-10">
              <input class="form-control" style="width: 20%;" type="number" min="1" value="{{$lecture->serial}}" id="{{"lectNum".$i}}" name="{{"lectNum".$lecture->_id}}">
            </div>
          </div>
          <div class="form-group row">
            <label for="example-text-input" class="col-2 col-form-label">Lecture Title</label>
            <div class="col-10">
              <input class="form-control" style="margin-left: -7px;" type="text" value="{{$lecture->title}}" id="{{"lectTitle".$i}}" name="{{"lectTitle".$lecture->_id}}">
            </div>
          </div>
        <textarea  class="ckeditorclass" name="{{"ck_editor".$lecture->_id}}" id="{{"ck_editor".$i}}" rows="10" cols="80">{{$lecture->content}}
        </textarea>
          <div class="Gap7"></div>
          <button type="submit" style="margin-left: 46%;" class="btn btn-success" id="{{"addButton".$i}}">Done</button>
        {!! Form::close() !!}
      </div>
    </div>

<div id="{{"lectDelConf".$i}}" class="delConfDiv" style="display: none;">
  <h1 style="font-size: 20px;">Are you sure you want to delete Lectue No. {{$i+1}}?</h1>
  <div class="Gap5"></div>
  <button id="{{"lectDelYes".$lecture->_id}}" onclick="window.location = '/deleteLecture/{{$lecture->_id}}';" style="margin-right: 70px; width: 80px;">Yes</button>
  <button id="{{"lectDelNo".$lecture->_id}}" onclick="noClicked('lect', {{$i}})" style="margin-left: 60px; width: 80px;">No</button>
</div>


    <div style="display: none;">{{$i=$i+1}}</div>
@endforeach
</div>

<div class="container" id="ckeditorDiv" style="display: none;">
  <div class="Gap10"></div>
  <div class="ckeditor_Div">
    {!! Form::open(
           array(
               'method'=>'POST',
               'route' => 'lecture.store',
               'class' => 'form',
               'novalidate' => 'novalidate',
               'files' => true))
   !!}

     <a onclick="closeEditLectureDiv({{"-1"}});" style="cursor: pointer; float: right;"><i class="fa fa-times"></i></a>

      <div class="form-group row">
        <label for="example-text-input" class="col-2 col-form-label">Lecture No.</label>
        <div class="col-10">
          <input class="form-control" style="width: 20%;" type="number" min="1" value="" id="lectNum" name="lectNum">
        </div>
      </div>

      <div class="form-group row">
        <label for="example-text-input" class="col-2 col-form-label">Lecture Title</label>
        <div class="col-10">
          <input class="form-control" style="margin-left: -7px;" type="text" value="" id="lectTitle" name="lectTitle">
        </div>
      </div>

      <textarea class="ckeditorclass" name="ck_editor" id="ck_editor" rows="10" cols="80">
      </textarea>

      <div class="Gap7"></div>

      <button type="submit" style="margin-left: 46%;" class="btn btn-success" id="addButton">Add</button>
      <input type="text" name="course_id" value="{{$course->_id}}" style="display: none">
    {!! Form::close() !!}
  </div>
</div>

 <div class="container">
   <div class="addLectButton" id="addLectureButton">
     <h1>Add Lecture</h1>
   </div>
 </div>




<div class="container" id="addQuizDiv" style="display: none;">
  <div class="Gap10"></div>
  <div class="ckeditor_Div">

    {!! Form::open(
           array(
               'method'=>'POST',
               'route' => 'quiz.store',
               'class' => 'form',
               'novalidate' => 'novalidate',
               'files' => true))
   !!}
    <a onclick="closeEditLectureDiv({{"-2"}});" style="cursor: pointer; float: right;"><i class="fa fa-times"></i></a>
      <div class="form-group row">
        <label for="example-text-input" class="col-2 col-form-label">Lecture No.</label>
        <div class="col-10">
          <input class="form-control" style="width: 20%; margin-left: 7px;" type="number" min="1" value="" id="quizNum" name="quizNum">
        </div>
      </div>
      <div class="form-group row">
        <label for="example-text-input" class="col-2 col-form-label">Lecture Title</label>
        <div class="col-10">
          <input class="form-control" type="text" value="Quiz" style="width: 98%;" id="quizTitle" name="quizTitle">
        </div>
      </div>

      <button type="submit" style="margin-left: 46%;" class="btn btn-success" id="addButton">Add Questions</button>
        <input type="text" name="course_id" value="{{$course->_id}}" style="display: none">
    {!! Form::close() !!}
  </div>
</div>



<div class="container">
  
    <div class="circle-tile" style="width: 50px; margin-left: 46.5%;" title="Add Quiz" id="addQuizButton">
      <a href="">
      <div class="circle-tile-heading green" style="margin-top: 20px;">
        <img style="height: 35px; width: 35px; margin-top: 17px;" src="{{asset('img/quizIcon.png')}}">
      </div>
      </a>
      <div class="Gap3"></div>
    </div>
</div>

<div class="Gap10"></div>



@endsection
