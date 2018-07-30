@extends('MasterLayout1')
@section('content')

<header class="masthead">
  <div class="container">
    <div class="intro-text">

    </div>
  </div>
</header>

<style type="text/css">
    a{
        color: blue;
    }
</style>

<div class="Gap10"></div>



<div class="container">

  <div class="detailContainer">
    <div class="showCourseContainer">
      <div class="circle-tile">

        <div class="team-member">
          <img style="height: 115px; width: 115px; margin-top: -10px;" class="mx-auto rounded-circle" src="{{asset('').$uploader->profilePic}}" alt="">
          <a href="/user/{{$uploader->_id}}"  style="color: black; background-color: white; padding: 5px;">{{$uploader->name}}</a>
        </div>


        <div class="Gap3"></div>
      </div>
    </div>
    <div class="showCourseNameTag">
      <h1>{{$course->title}}</h1>
      <h3>
        @for($i = 0 ; $i < sizeof($tag_arr) ; $i++)
          @if($i > 0)
            ,&nbsp
          @endif
          <a style="color: #ecdf0f;" href='/searchByTag/{{$tag_arr[$i]->_id}}'> {{$tag_arr[$i]->name}}</a>
        @endfor
      </h3>
      <div class="Gap2"></div>
        <div id="courseRating">
              @for($i=0; $i<round($course->rating); $i++)
            <img src="{{asset('img/starIcon.png')}}" class="shownStar">
            @endfor
             @for($i=round($course->rating)+1; $i<6; $i++)
            <img src="{{asset('img/star_empty.png')}}" class="shownStar">
            @endfor
        </div>
    </div>
  </div>
</div>

<div class="container">

    @if(Auth::check())
 <div class="rateDiv">
        <div class="ratingStars">
            <form id="ratingsForm">
                <div class="stars">
                    <input type="radio" name="star_1" class="star-1" id="star-1" />
                    <label class="star-1" for="star-1">1</label>
                    <input type="radio" name="star_2" class="star-2" id="star-2" />
                    <label class="star-2" for="star-2">2</label>
                    <input type="radio" name="star_3" class="star-3" id="star-3" />
                    <label class="star-3" for="star-3">3</label>
                    <input type="radio" name="star_4" class="star-4" id="star-4" />
                    <label class="star-4" for="star-4">4</label>
                    <input type="radio" name="star_5" class="star-5" id="star-5" />
                    <label class="star-5" for="star-5">5</label>
                    <span></span>
                </div>
            </form>
        </div>
    </div>
    @endif


    @if(Auth::check())
<div class="addToFavDiv">
  <div class="fav_click">
    <fav_span class="fa fa-heart-o"></fav_span>
    <div class="fav_ring"></div>
    <div class="fav_ring2"></div>
    <p class="fav_info">Added to favourites!</p>
  </div>
</div>
    @endif


</div>


<div class="Gap3"></div>


<div class='container'>
  <div id='content' class='row'>
    <div class='span2 sidebar'>
      <ul class="nav nav-tabs nav-stacked">
        @for($i=0; $i<sizeof($lecture_arr); $i++)
        @if($i==0)
        <li><a style="color: #33719e; background-color: #ececec; font-weight: 400; cursor: pointer"  id="{{"LectNo".$i}}" onclick="changeMainDivContent({{$i}}, '{{sizeof($lecture_arr)}}');">Lecture {{$i+1}}</a></li>
        @else
        @if($lecture_arr[$i]->type!='quiz')
        <li><a style="color: #33719e; font-weight: 400; cursor: pointer"  id="{{"LectNo".$i}}" onclick="changeMainDivContent({{$i}}, '{{sizeof($lecture_arr)}}');">Lecture {{$i+1}}</a></li>
        @else
        <li><a style="color: #33719e; font-weight: 400; cursor: pointer"  id="{{"LectNo".$i}}" href="/quiz/{{$lecture_arr[$i]->_id}}">Quiz</a></li>
        @endif
        @endif
        @endfor
      </ul>
    </div>
  </div>
</div>


<div class="Gap7"></div>

<div style="display: none;">{{$cnt=0}}</div>


<!-- 10 is the number of lectures -->
@for($k=0; $k<sizeof($lecture_arr); $k++)

@if($k==0)
<div id="{{"mainContent".$k}}">
@else
<div id="{{"mainContent".$k}}" style="display: none;">
@endif


<div class='span8 main container'>

<h1 style="font-size: 25px; margin-top: -20px; margin-bottom: 15px; background-color: #ececec; padding: 7px;">{{$lecture_arr[$k]->title}}</h1>




<!-- if Lecture is Quiz-->




<!--End Quiz-->





<!-- Output from CKeditor -->

@if($lecture_arr[$k]->type!='quiz')
  {!! $lecture_arr[$k]->content !!}
@endif
<!-- End of output -->

</div>
    <div class="container">
        <div class="commentSection">
            <div class="row">
                <div class="comments-container">


                    <h1>Comments ({{sizeof($comment_arr_2D[$k])}})</h1>
                    <hr>


                    <ul id="comments-list" class="comments-list">

                        <!-- Comment Box-->   <!--Form Needed-->
                        @if(Auth::check())
                            <li>
                                <div class="comment-main-level">
                                    <div class="comment-avatar"><img src="{{asset('').Auth::user()->profilePic}}" alt=""></div>
                                    <div class="comment-box">
                                        <div class="comment-head">
                                            @if(Auth::user()->role=='teacher')
                                            <h6 class="comment-name by-author"><a href="/user/{{Auth::user()->_id}}">{{Auth::user()->name}}</a></h6>
                                            @else
                                            <h6 class="comment-name by-student"><a href="/user/{{Auth::user()->_id}}">{{Auth::user()->name}}</a></h6>
                                            @endif
                                            <span>Now</span>
                                        </div>
                                        <input style="width: 100%;margin-bottom: 5px; border:none;" onkeydown="CommentFunc('{{$lecture_arr[$k]->_id}}');" type="text" placeholder="Join the conversation" class="comment-content" id="{{"comArea".$lecture_arr[$k]->_id}}">
                                    </div>
                                </div>
                            </li>
                        @endif
                    <!-- End Comment Box -->
                        <div class="comments" id="{{"allcomments".$lecture_arr[$k]->_id}}">
                            @include('commentManager');
                        </div>
                    </ul>


                </div>
            </div>
        </div>
    </div>
</div>
@endfor

<div class="Gap10"></div>

<script type="text/javascript">

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function CommentFunc(id, e) {
    var charCode;

    if (e && e.which) {
        charCode = e.which;
    } else if (window.event) {
        e = window.event;
        charCode = e.keyCode;
    }

    if (charCode == 13) {
        console.log("Hit");
        e.preventDefault();
        var user_id = -1;
        @if(Auth::check()) {
            user_id = "{{ Auth::user()->id }}";
        }
        @endif
        var target_id = id;
        console.log(target_id);
        var content = $('#comArea' + target_id).val();
        var data = {
            comment: content,
            user_id: user_id,
            target_id: target_id
        };
        var pre = {!!json_encode(url('/')) !!};
        var url = pre + '/api/addComment';
        console.log(url, data);
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function(data) {
                console.log("SSuccess");
                $('#allcomments' + target_id).prepend(data);
                $('#comArea' + target_id).val("");
            },
            error: function(data) {
                console.log('EError:', data);
            }
        });
    }
}

function ReplyFunc(id, e) {
    var charCode;

    if (e && e.which) {
        charCode = e.which;
    } else if (window.event) {
        e = window.event;
        charCode = e.keyCode;
    }

    if (charCode == 13) {
        console.log("Hit reply");
        e.preventDefault();
        var user_id = -1;
        @if(Auth::check()) {
            user_id = "{{ Auth::user()->id }}";
        }
        @endif
        var target_id = id;
        var content = $('#replyArea' + target_id).val();
        var data = {
            reply: content,
            user_id: user_id,
            target_id: target_id
        };
        var pre = {!!json_encode(url('/'))!!};
        var url = pre + '/api/addReply';
        console.log(url, data);
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function(data) {
                console.log("SSuccess");
                $('#reply_for_' + target_id).prepend(data);
                $('#replyArea' + target_id).val("");
            },
            error: function(data) {
                console.log('EError:', data);
            }
        });

        openReplyBox(id);
    }
}



$(".addToFavDiv").on('click', function(e) {
    console.log("Hit Fav Icon");
    e.preventDefault();
    var user_id = -1;
    @if(Auth::check()) {
        user_id = "{{ Auth::user()->id }}";
    }
    @endif
    var target_id = {!!json_encode($id) !!};
    var data = {
        user_id: user_id,
        target_id: target_id
    };
    var pre = {!!json_encode(url('/')) !!};
    var url = pre + '/api/addToFav';
    console.log(url, data);
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: function(data) {
            console.log("Success", data);
        },
        error: function(data) {
            console.log('Error:', data);
        }
    });
});

@if($fav == 1)

$('.fav_click').addClass('fav_active');
$('.fav_click').addClass('fav_active-2');
setTimeout(function() {
    $('.fav_click fav_span').addClass('fa-heart');
    $('.fav_click fav_span').removeClass('fa-heart-o')
}, 150);
setTimeout(function() {
    $('.fav_click').addClass('fav_active-3')
}, 150);

@endif

$('.fav_click').click(function() {
    if ($('fav_span').hasClass("fa-heart")) {
        $('.fav_click').removeClass('fav_active');
        setTimeout(function() {
            $('.fav_click').removeClass('fav_active-2')
        }, 30);
        $('.fav_click').removeClass('fav_active-3');
        setTimeout(function() {
            $('fav_span').removeClass('fa-heart');
            $('fav_span').addClass('fa-heart-o')
        }, 15)
    } else {
        $('.fav_click').addClass('fav_active');
        $('.fav_click').addClass('fav_active-2');
        setTimeout(function() {
            $('fav_span').addClass('fa-heart');
            $('fav_span').removeClass('fa-heart-o')
        }, 150);
        setTimeout(function() {
            $('.fav_click').addClass('fav_active-3')
        }, 150);
        $('.fav_info').addClass('fav_info-tog');
        setTimeout(function() {
            $('.fav_info').removeClass('fav_info-tog')
        }, 1000)
    }
});

function updateRating(val) {
    console.log("Hit star ", val);
    var user_id = -1;
    @if(Auth::check()) {
        user_id = "{{ Auth::user()->id }}";
    }
    @endif
    var target_id = {!!json_encode($id) !!};
    var data = {
        user_id: user_id,
        target_id: target_id,
        given_rating: val
    };
    var pre = {!!json_encode(url('/')) !!};
    var url = pre + '/api/updateRating';
    console.log("oka",  url, data);
    $.ajax({
        type: 'POST',
        url: url,
        data: data,

        success: function(data) {
            console.log("Success", data);
            rate = Math.round(data.new_rating);
            var add = '<div id="courseRating">';

            for (i = 0; i < rate; i++) {
                add += "<img src=\"{{asset('img/starIcon.png')}}\" class=\"shownStar\">";
            }

            $('#courseRating').replaceWith(add);
            $("#star-1").prop("checked", false);
            $("#star-2").prop("checked", false);
            $("#star-3").prop("checked", false);
            $("#star-4").prop("checked", false);
            $("#star-5").prop("checked", false);
            $("#star-" + val).prop("checked", true);
        },
        error: function(data) {
            console.log('Error:', data);
        }
    });
}

var rate = {!!json_encode($rating) !!};
rate = Math.round(rate);

console.log(rate);

$("#star-" + rate).prop("checked", true);

$("input[name='star_1']").on('click', function(e) {
    e.preventDefault();
    updateRating(1);
});

$("input[name='star_2']").on('click', function(e) {
    e.preventDefault();
    updateRating(2);
});

$("input[name='star_3']").on('click', function(e) {
    e.preventDefault();
    updateRating(3);
});

$("input[name='star_4']").on('click', function(e) {
    e.preventDefault();
    updateRating(4);
});

$("input[name='star_5']").on('click', function(e) {
    e.preventDefault();
    updateRating(5);
});

</script>


@endsection
