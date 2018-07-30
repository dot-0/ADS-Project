@extends('MasterLayout1')
@section('content')

<header class="masthead">
  <div class="container">
    <div class="intro-text">
    <div class="intro-heading">Create Quiz</div>
    </div>
  </div>
</header>

<div class="Gap10"></div>
<div class="container" id="quizLectDiv">
<div class="courseContainer">
<div class="circle-tile">
  <a href="#"><div class="circle-tile-heading green"><i class="fa fa-book fa-fw fa-3x"></i></div></a>
  <div class="Gap3"></div>
</div>
</div>
<div class="courseNameTag">
  <h1>Quiz</h1>
  <h3>
  Update
  </h3>
  
</div>
</div>

<div id="quizDelConf" class="delConfDiv" style="display: none;">
  <h1 style="font-size: 20px;">Are you sure you want to delete this Quiz?</h1>
  <div class="Gap5"></div>
  <button id="{{"quizDelYes"}}" style="margin-right: 70px; width: 80px;">Yes</button>
  <button id="{{"quizDelNo"}}" onclick="noClicked('quiz', '0')" style="margin-left: 60px; width: 80px;">No</button>
</div>


<div class="container" id="quizLectEditDiv" style="display: none">
<form>
<div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Lecture No.</label>
  <div class="col-10">
    <input class="form-control" type="text" value="Previous Lecture No" id="courseTitle" name="courseTitle">
  </div>
</div>

 <button type="submit" style="margin-left: 46%; background-color: #2866b3" class="btn btn-primary">Done</button>
 </form>
 </div>


<div class="container">
  <div style="display: none;">{{$i=0}}</div>
  @for($k=0; $k<sizeof($quiz_arr); $k++)
  
  <div class="lecturesDiv">
    <h1>Question {{$k+1}}</h1>
      <a class="editIcon2" id="{{"editQuesButton".$i}}" onclick="openEditQuesDiv({{$k}}, {{sizeof($quiz_arr)}});" ><i class="fa fa-edit" style="color: white;"></i></a>
    <a id="{{"deleteQuesButton".$quiz_arr[$k]->_id}}" onclick="deleteItem('ques', '{{$quiz_arr[$k]->_id}}')" class="deleteLectIcon"><i class="fa fa-times" style="color: white;"></i></a>
  </div>




















<!-- Edit Question-->




        <div class="container" id="{{"editQuesDiv".$k}}" style="display: none;">
            <div class="Gap10"></div>
            <div class="ckeditor_Div">

                <a onclick="closeEditQuesDiv({{$k}});" style="cursor: pointer; float: right;"><i class="fa fa-times"></i></a>

              


                <div class="container">
                    <div class="carousel slide" data-interval="false">
                        <div class="carousel-inner">
                            @for($i=0; $i<1; $i++)
                                @if($i==0)
                                    <div class="carousel-item active">
                                        @else
                                            <div class="carousel-item">
                                                @endif
                                                {!! Form::open(
                                                       array(
                                                            'method'=>'PUT',
                                                            'route'=>['quiz.update' , $quiz_arr[$k]->_id],
                                                            'class' => 'form',
                                                            'novalidate' => 'novalidate',
                                                            'files' => true))
                                                   !!}
                                                <div style="width: 100%;">

                                                    <div class='container' style="margin-left: 20%;">
                                                        <div id="{{"quesContent".$k}}" class='row'>
                                                            <div class='span2 sidebar'>
                                                                <ul class="nav nav-tabs nav-stacked">
                                                                    <li><a style="color: #33719e; font-weight: 400; cursor: pointer; background-color: #ececec"  id="{{"editQues".$quiz_arr[$k]->_id}}" onclick="changeQuesEditDivContent('0', '{{$quiz_arr[$k]->_id}}');">Question</a></li>
                                                                    <li><a style="color: #33719e; font-weight: 400; cursor: pointer"  id="{{"editOpt1".$quiz_arr[$k]->_id}}" onclick="changeQuesEditDivContent('1', '{{$quiz_arr[$k]->_id}}');">Option 1</a></li>
                                                                    <li><a style="color: #33719e; font-weight: 400; cursor: pointer"  id="{{"editOpt2".$quiz_arr[$k]->_id}}" onclick="changeQuesEditDivContent('2', '{{$quiz_arr[$k]->_id}}');">Option 2</a></li>
                                                                    <li><a style="color: #33719e; font-weight: 400; cursor: pointer"  id="{{"editOpt3".$quiz_arr[$k]->_id}}" onclick="changeQuesEditDivContent('3', '{{$quiz_arr[$k]->_id}}');">Option 3</a></li>
                                                                    <li><a style="color: #33719e; font-weight: 400; cursor: pointer"  id="{{"editOpt4".$quiz_arr[$k]->_id}}" onclick="changeQuesEditDivContent('4', '{{$quiz_arr[$k]->_id}}');">Option 4</a></li>
                                                                    <li><a style="color: #33719e; font-weight: 400; cursor: pointer"  id="{{"editCorrAns".$quiz_arr[$k]->_id}}" onclick="changeQuesEditDivContent('5', '{{$quiz_arr[$k]->_id}}');">Answer</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div id="{{"editQuesContent".$quiz_arr[$k]->_id}}">
                                                        <div class='span8 main'>
                      <textarea class="ckeditorclass" name="{{"editQuesEditor".$quiz_arr[$k]->_id}}" id="{{"editQuesEditor".$quiz_arr[$k]->_id}}" rows="10" cols="80">{{$quiz_arr[$k]->question}}
                      </textarea>
                                                        </div>
                                                    </div>

                                                    <div id="{{"editOpt1Content".$quiz_arr[$k]->_id}}" style="display: none;">
                                                        <div class='span8 main'>
                      <textarea class="ckeditorclass" name="{{"editOpt1Editor".$quiz_arr[$k]->_id}}" id="{{"editOpt1Editor".$quiz_arr[$k]->_id}}" rows="10" cols="80">{{$quiz_arr[$k]->option1}}
                      </textarea>
                                                        </div>
                                                    </div>

                                                    <div id="{{"editOpt2Content".$quiz_arr[$k]->_id}}" style="display: none;">
                                                        <div class='span8 main'>
                      <textarea class="ckeditorclass" name="{{"editOpt2Editor".$quiz_arr[$k]->_id}}" id="{{"editOpt2Editor".$quiz_arr[$k]->_id}}" rows="10" cols="80">{{$quiz_arr[$k]->option2}}
                      </textarea>
                                                        </div>
                                                    </div>

                                                    <div id="{{"editOpt3Content".$quiz_arr[$k]->_id}}" style="display: none;">
                                                        <div class='span8 main'>
                      <textarea class="ckeditorclass" name="{{"editOpt3Editor".$quiz_arr[$k]->_id}}" id="{{"editOpt3Editor".$quiz_arr[$k]->_id}}" rows="10" cols="80">{{$quiz_arr[$k]->option3}}
                      </textarea>
                                                        </div>
                                                    </div>

                                                    <div id="{{"editOpt4Content".$quiz_arr[$k]->_id}}" style="display: none;">
                                                        <div class='span8 main'>
                      <textarea class="ckeditorclass" name="{{"editOpt4Editor".$quiz_arr[$k]->_id}}" id="{{"editOpt4Editor".$quiz_arr[$k]->_id}}" rows="10" cols="80">{{$quiz_arr[$k]->option4}}
                      </textarea>
                                                        </div>
                                                    </div>


                                                    <div id="{{"editAnsContent".$quiz_arr[$k]->_id}}" style="display: none;">
                                                        <div class='span8 main quizAns'>
                                                            @for($jt = 1 ; $jt <=4; $jt++)
                                                                @if($jt == $quiz_arr[$k]->answer)
                                                                    <li><input type="checkbox" name="{{"editOp".$jt}}" checked >&nbsp Option {{$jt}} </input></li>
                                                                @else
                                                                    <li><input type="checkbox" name="{{"editOp".$jt}}">&nbsp Option {{$jt}} </input></li>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                        <div class="Gap10"></div>
                                                    </div>

                                                </div>

                                                <div class="Gap5"></div>
                                                <button type="submit" style="margin-left: 46.5%;" class="btn btn-primary" id="editQuesAddButton">Update</button>
                                                <input type="text" name="id" value={{$id}} style="display: none">
                                                {!! Form::close() !!}
                                                <hr>

                                            </div>
                                            @endfor

                                    </div>

                        </div>
                    </div>

                    <div class="Gap7"></div>
                    <button type="submit" style="margin-left: 46%;" class="btn btn-success" id="quizAddButton">Create</button>

                    <input type="text" name="" value="" style="display: none">

                </div>
            </div>



<!-- End Edit Question -->














            <div id="{{"quesDelConf".$quiz_arr[$k]->_id}}" class="delConfDiv" style="display: none;">
    <h1 style="font-size: 20px;">Are you sure you want to delete Ques No. {{$i+1}}?</h1>
    <div class="Gap5"></div>
    <button id="{{"quesDelYes".$quiz_arr[$k]->_id}}" onclick="window.location = '/deleteQuizQuestion/{{$quiz_arr[$k]->_id}}';" style="margin-right: 70px; width: 80px;">Yes</button>
    <button id="{{"quesDelNo".$quiz_arr[$k]->_id}}" onclick="noClicked('ques', '{{$quiz_arr[$k]->_id}}')" style="margin-left: 60px; width: 80px;">No</button>
  </div>
  <div style="display: none;">{{$i=$i+1}}</div>
  @endfor
</div>

<div class="container" id="addQuizDiv">
  <div class="Gap10"></div>
  <div class="ckeditor_Div">


      <div class="container">
        <div id="carouselExampleControls" class="carousel slide" data-interval="false" id="carousel">
          <div class="carousel-inner">
            @for($i=0; $i<1; $i++)
            @if($i==0)
            <div class="carousel-item active">
              @else
              <div class="carousel-item">
                @endif
                  {!! Form::open(
                        array(
                            'method'=>'POST',
                            'action' => 'QuizController@addQuestion',
                            'class' => 'form',
                            'novalidate' => 'novalidate',
                            'files' => true))
                       !!}
                <div style="width: 100%;">

                  <div class='container' style="margin-left: 20%;">
                    <div id='quesContent' class='row'>
                      <div class='span2 sidebar'>
                        <ul class="nav nav-tabs nav-stacked">
                          <li><a style="color: #33719e; font-weight: 400; cursor: pointer; background-color: #ececec"  id="{{"Ques".$i}}" onclick="changeQuesDivContent('0', {{$i}});">Question</a></li>
                          <li><a style="color: #33719e; font-weight: 400; cursor: pointer"  id="{{"Opt1".$i}}" onclick="changeQuesDivContent('1', {{$i}});">Option 1</a></li>
                          <li><a style="color: #33719e; font-weight: 400; cursor: pointer"  id="{{"Opt2".$i}}" onclick="changeQuesDivContent('2', {{$i}});">Option 2</a></li>
                          <li><a style="color: #33719e; font-weight: 400; cursor: pointer"  id="{{"Opt3".$i}}" onclick="changeQuesDivContent('3', {{$i}});">Option 3</a></li>
                          <li><a style="color: #33719e; font-weight: 400; cursor: pointer"  id="{{"Opt4".$i}}" onclick="changeQuesDivContent('4', {{$i}});">Option 4</a></li>
                          <li><a style="color: #33719e; font-weight: 400; cursor: pointer"  id="{{"CorrAns".$i}}" onclick="changeQuesDivContent('5', {{$i}});">Answer</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>


                  <div id="{{"QuesContent".$i}}">
                    <div class='span8 main'>
                      <textarea class="ckeditorclass" name="{{"QuesEditor".$i}}" id="{{"QuesEditor".$i}}" rows="10" cols="80">
                      </textarea>
                    </div>
                  </div>

                  <div id="{{"Opt1Content".$i}}" style="display: none;">
                    <div class='span8 main'>
                      <textarea class="ckeditorclass" name="{{"Opt1Editor".$i}}" id="{{"Opt1Editor".$i}}" rows="10" cols="80">
                      </textarea>
                    </div>
                  </div>

                  <div id="{{"Opt2Content".$i}}" style="display: none;">
                    <div class='span8 main'>
                      <textarea class="ckeditorclass" name="{{"Opt2Editor".$i}}" id="{{"Opt2Editor".$i}}" rows="10" cols="80">
                      </textarea>
                    </div>
                  </div>

                  <div id="{{"Opt3Content".$i}}" style="display: none;">
                    <div class='span8 main'>
                      <textarea class="ckeditorclass" name="{{"Opt3Editor".$i}}" id="{{"Opt3Editor".$i}}" rows="10" cols="80">
                      </textarea>
                    </div>
                  </div>

                  <div id="{{"Opt4Content".$i}}" style="display: none;">
                    <div class='span8 main'>
                      <textarea class="ckeditorclass" name="{{"Opt4Editor".$i}}" id="{{"Opt4Editor".$i}}" rows="10" cols="80">
                      </textarea>
                    </div>
                  </div>


                  <div id="{{"AnsContent".$i}}" name="{{"AnsContent".$i}}" style="display: none;">
                    <div class='span8 main quizAns'>
                     <li><input type="checkbox" name="op1" >&nbsp Option 1</input></li>
                     <li><input type="checkbox" name="op2" >&nbsp Option 2</input></li>
                     <li><input type="checkbox" name="op3" >&nbsp Option 3</input></li>
                     <li><input type="checkbox" name="op4" >&nbsp Option 4</input></li>
                    </div>
                    <div class="Gap10"></div>
                  </div>

                </div>

                <div class="Gap5"></div>
                <button type="submit" style="margin-left: 46.5%;" class="btn btn-primary" id="quesAddButton">Next</button>
                  <input type="text" name="id" value={{$id}} style="display: none">
                  {!! Form::close() !!}
                <hr>
                
              </div>
              @endfor
              
            </div>
          
          </div>
        </div>
        
        <div class="Gap7"></div>
        <a href="/updatecourse/{{$course_id}}" type="submit" style="margin-left: 46%;" class="btn btn-success" id="quizAddButton">Create</a>
        
        <input type="text" name="" value="" style="display: none">

    </div>
  </div>


<div class="Gap10"></div>





<script type="text/javascript">



    function openEditQuesDiv(id, tot) {
        for (i = 0; i < tot; i++) {
            $("#editQuesDiv" + i).fadeOut(100);
        }
        $("#editQuesDiv" + id).delay(100).fadeIn(100);
    }

    function closeEditQuesDiv(id) {
        $("#editQuesDiv" + id).slideToggle();
    }



    $('#quizLectEditButton').click(function(e) {
            $("#quizLectEditDiv").delay(100).fadeIn(100);
            $("#quizLectDiv").fadeOut(100);
            e.preventDefault();
        });

  
function changeQuesDivContent(id, x) {
            for (i = x; i < x+1; i++) {
                $("#QuesContent" + i).fadeOut(100);
                $("#Opt1Content" + i).fadeOut(100);
                $("#Opt2Content" + i).fadeOut(100);
                $("#Opt3Content" + i).fadeOut(100);
                $("#Opt4Content" + i).fadeOut(100);
                $("#AnsContent" + i).fadeOut(100);
                $("#Ques" + i).css("background-color", "white");
                $("#Ques" + i).css("margin-bottom", ".5px");
                $("#Opt1" + i).css("background-color", "white");
                $("#Opt1" + i).css("margin-bottom", ".5px");
                $("#Opt2" + i).css("background-color", "white");
                $("#Opt2" + i).css("margin-bottom", ".5px");
                $("#Opt3" + i).css("background-color", "white");
                $("#Opt3" + i).css("margin-bottom", ".5px");
                $("#Opt4" + i).css("background-color", "white");
                $("#Opt4" + i).css("margin-bottom", ".5px");
                $("#CorrAns" + i).css("background-color", "white");
                $("#CorrAns" + i).css("margin-bottom", ".5px");
            }

            if(id==0)
            {
              $("#QuesContent" + x).delay(100).fadeIn(100);
              $("#Ques" + x).css("background-color", "#ececec");
            }

            else if(id==1)
            {
              $("#Opt1Content" + x).delay(100).fadeIn(100);
              $("#Opt1" + x).css("background-color", "#ececec");
            }

            else if(id==2)
            {
              $("#Opt2Content" + x).delay(100).fadeIn(100);
              $("#Opt2" + x).css("background-color", "#ececec");
            }

            else if(id==3)
            {
              $("#Opt3Content" + x).delay(100).fadeIn(100);
              $("#Opt3" + x).css("background-color", "#ececec");
            }

            else if(id==4)
            {
              $("#Opt4Content" + x).delay(100).fadeIn(100);
              $("#Opt4" + x).css("background-color", "#ececec");
            }

            else if(id==5)
            {
              $("#AnsContent" + x).delay(100).fadeIn(100);
              $("#CorrAns" + x).css("background-color", "#ececec");
            }
        }






    function changeQuesEditDivContent(id, i) {

        $("#editQuesContent" + i).fadeOut(100);
        $("#editOpt1Content" + i).fadeOut(100);
        $("#editOpt2Content" + i).fadeOut(100);
        $("#editOpt3Content" + i).fadeOut(100);
        $("#editOpt4Content" + i).fadeOut(100);
        $("#editAnsContent" + i).fadeOut(100);
        $("#editQues" + i).css("background-color", "white");
        $("#editQues" + i).css("margin-bottom", ".5px");
        $("#editOpt1" + i).css("background-color", "white");
        $("#editOpt1" + i).css("margin-bottom", ".5px");
        $("#editOpt2" + i).css("background-color", "white");
        $("#editOpt2" + i).css("margin-bottom", ".5px");
        $("#editOpt3" + i).css("background-color", "white");
        $("#editOpt3" + i).css("margin-bottom", ".5px");
        $("#editOpt4" + i).css("background-color", "white");
        $("#editOpt4" + i).css("margin-bottom", ".5px");
        $("#editCorrAns" + i).css("background-color", "white");
        $("#editCorrAns" + i).css("margin-bottom", ".5px");


        if(id==0)
        {
            $("#editQuesContent" + i).delay(100).fadeIn(100);
            $("#editQues" + i).css("background-color", "#ececec");
        }

        else if(id==1)
        {
            $("#editOpt1Content" + i).delay(100).fadeIn(100);
            $("#editOpt1" + i).css("background-color", "#ececec");
        }

        else if(id==2)
        {
            $("#editOpt2Content" + i).delay(100).fadeIn(100);
            $("#editOpt2" + i).css("background-color", "#ececec");
        }

        else if(id==3)
        {
            $("#editOpt3Content" + i).delay(100).fadeIn(100);
            $("#editOpt3" + i).css("background-color", "#ececec");
        }

        else if(id==4)
        {
            $("#editOpt4Content" + i).delay(100).fadeIn(100);
            $("#editOpt4" + i).css("background-color", "#ececec");
        }

        else if(id==5)
        {
            $("#editAnsContent" + i).delay(100).fadeIn(100);
            $("#editCorrAns" + i).css("background-color", "#ececec");
        }
    }

</script>



@endsection
