@extends('MasterLayout1')
@section('content')

<header class="masthead">
  <div class="container">
    <div class="intro-text">
      <div class="intro-heading">User Profile</div>
    </div>
  </div>
</header>

<div class="container" id="userProfileDiv">
<div class="proPicDiv">
  <img src="{{asset('').$user->profilePic}}" class="proPic">
  <h3>User</h3>
  <div class="profileDetails">
    <h1>{{$user->name}}</h1>
    <div class="Gap3"></div>
    <div class="profileListDiv">
      <div class="profileListTitle">
        <img src="{{asset('img/mailIcon.png')}}">
        &nbsp E-mail
      </div>
      <div class="profileListDescr">
        {{$user->email}}
      </div>
    </div>
    
  
    
    <div class="profileListDiv">
      <div class="Gap2"></div>
      <div class="profileListTitle">
        <img src="{{asset('img/joinedIcon.png')}}">
        &nbsp Joined
      </div>
      <div class="profileListDescr">
        {{$user->created_at}}
      </div>
    </div>
    <div class="profileListDiv">
      <div class="Gap2"></div>
      <div class="profileListTitle">
        <img src="{{asset('img/aboutMeIcon.png')}}">
        &nbsp Designation
      </div>
      <div class="aboutMeDescr">
        {{$user->about_me}}
      </div>
    </div>
    
    <div class="Gap2"></div>

    @if(Auth::check() == true && Auth::user()->_id==$user->_id)
      <div class="profileListDiv">
        <a class="profileUpdateButton btn btn-success" id="profileUpdateButton">Update</a>
      </div>
    @endif

    <a href="#portfolio"><div class="favCourseButton">
      @if($user->role=='teacher')
        Courses Teaching
      @else
        Favourite Courses
      @endif
    </div></a>
    
    <div class="userLevel">
    @if($user->role=='teacher')
      Instructor
    @else
      Student
    @endif
    </div>
   
  </div>
</div>
</div>



<div class="updateProfileDiv"  id="updateUserProfileDiv" style="display: none">
<div class="container">
  {!! Form::open(
       array(
            'method'=>'PUT',
            'route'=>['user.update' , Request::segment(2)],
            'class' => 'form',
            'novalidate' => 'novalidate',
            'files' => true))
   !!}
  <label class="col-md-4 control-label">Name</label>
  <div class="col-md-6">
    <input id="name" type="text" class="songUploadDiv" name="name" value="{{$user->name}}">
    <div class="Gap3"></div>
  </div>
  <label class="col-md-4 control-label">Designation</label>
  <div class="col-md-6">
    <textarea id="aboutMe" class="songUploadDiv" name="aboutMe">{{$user->about_me}}</textarea>
    <div class="Gap3"></div>
  </div>
  <label class="col-md-4 control-label">Profile Picture</label>
  <div class="col-md-6">
    <input id="proPic" class="ajaira" type="file" name="proPic">
    <div class="ajaira">(Just leave it if you don't want to change)</div>
    <div class="Gap5"></div>
  </div>
  <div class="col-md-6">
    <div class="songUploadButton">
      <button type="submit" class="btn btn-success">Update</button>
    </div>
  </div>
  <input type="text" name="id" value="userId" style="display: none">
  {!! Form::close() !!}
</div>
</div>



<div class="Gap10"></div>



<section class="bg-light" id="portfolio">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h2 class="section-heading">
            @if($user->role=='teacher')
            Courses Teaching
            @else
            Favourite Courses
            @endif
        </h2>
        <h3 class="section-subheading text-muted"></h3>
      </div>
    </div>
    <div class="row">
      @for($j=0; $j<sizeof($course_arr); $j++)
      <div class="col-md-4">
        <div class="card user-card">
          
          <div class="card-block">
          @if(Auth::check() == true && Auth::user()->_id==$uploader_arr[$j]->_id)
            <a class="editIcon2" href="/updatecourse/{{$course_arr[$j]->id}}" ><i class="fa fa-edit" style="color: black;"></i></a>
          @endif
            <h6 class="f-w-600 m-t-25 m-b-10">{{$course_arr[$j]->title}}</h6>
            <p class="text-muted">Istructor : <a href="/user/{{$uploader_arr[$j]->_id}}" style="color: darkblue;">{{$uploader_arr[$j]->name}}</a></p>
            <hr>
             @for($i=0; $i<round($course_arr[$j]->rating); $i++)
            <img src="{{asset('img/starIcon.png')}}" class="shownStar">
            @endfor
             @for($i=round($course_arr[$j]->rating)+1; $i<6; $i++)
            <img src="{{asset('img/star_empty.png')}}" class="shownStar">
            @endfor
            
            <p class="m-t-15 lecturesText">{{$lecture_arr[$j]}} Lectures</p>
            <hr>
            <div class="row justify-content-center user-social-link">
              
              <div class="circle-tile ">
                <a href="/course/{{$course_arr[$j]->_id}}"><div class="circle-tile-heading green"><i class="fa fa-arrow-right fa-fw fa-3x"></i></div></a>
                <div class="Gap3"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endfor
   
    </div>
  </div>
</section>


@endsection