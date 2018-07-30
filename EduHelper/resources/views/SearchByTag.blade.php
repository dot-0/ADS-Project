@extends('MasterLayout1')
@section('content')

    <header class="masthead">
        <div class="container">
            <div class="intro-text">
                <div class="intro-heading">{{"Search Results (".sizeof($course_arr).")"}}</div>
            </div>
        </div>
    </header>

    <section class="bg-light" id="portfolio">
        <div class="container">
            <div class="row">
            </div>
            <div class="row">
                @for($j=0; $j<sizeof($course_arr); $j++)
                    <div class="col-md-4">
                        <div class="card user-card">

                            <div class="card-block">
                                @if(Auth::check() == true && Auth::user()->_id==$uploaded_by[$j]->_id)
                                <a class="editIcon2" href="/updatecourse/{{$course_arr[$j]->id}}" ><i class="fa fa-edit" style="color: black;"></i></a>
                                @endif
                                <h6 class="f-w-600 m-t-25 m-b-10">{{$course_arr[$j]->title}}</h6>
                                <p class="text-muted">Instructor : &nbsp <a style="color: blue;" href="/user/{{$uploaded_by[$j]->_id}}"> {{$uploaded_by[$j]->name}}</a></p>
                                <hr>

                                @for($i=0; $i<round($course_arr[$j]->rating); $i++)
                                <img src="{{asset('img/starIcon.png')}}" class="shownStar">
                                @endfor
                                @for($i=round($course_arr[$j]->rating)+1; $i<6; $i++)
                                <img src="{{asset('img/star_empty.png')}}" class="shownStar">
                                @endfor

                                <p class="m-t-15 lecturesText">{{$num_lecture[$j]." Lectures"}}</p>
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