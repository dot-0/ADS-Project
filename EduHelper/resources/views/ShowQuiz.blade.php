@extends('MasterLayout1')
@section('content')

<header class="masthead">
  <div class="container">
    <div class="intro-text">
    <div class="intro-heading">Quiz</div>
    </div>
  </div>
</header>


<div class="Gap10"></div>

<div class="container">
<div id="showQuizDiv" style="margin-left: 5%; width: 90%; padding: 30px; border-radius: 4px; border: solid lightgray 1px;">
    <div id='quizDiv' class="quizDiv"></div>
    <div class="Gap10"></div>
    <div class='quiz_button' >
        <a id='quizPrevButton' style="margin-right: 20px;" href='#'>Prev</a>
        <a id='quizNextButton' style="margin-left: 20px;" href='#'>Next</a>
    </div>
    <a id='startOver' style="font-size: 25px; color: black;" href='#'>Start Over</a>
    <a id='quizDone' href="/course/{{$target_course}}" style="font-size: 25px; color: black; margin-left: 60px; cursor: pointer;" >Done</a>
    <a id='quizSol' style="font-size: 20px; color: red; margin-left: 100px;" target="blank" href='/quizsolution/{{$id}}'>Solution</a>
</div>
</div>

<div class="Gap10"></div>

@include('QuizScript');

@endsection
