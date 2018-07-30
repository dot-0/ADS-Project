<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>ADS Project</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{URL::asset('css/style.css')}}" rel="stylesheet">
        <link href="{{URL::asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{URL::asset('font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{URL::asset('https://fonts.googleapis.com/css?family=Montserrat:400,700')}}" rel="stylesheet" type="text/css">
        <link href="{{URL::asset('https://fonts.googleapis.com/css?family=Kaushan+Script')}}" rel='stylesheet' type='text/css'>
        <link href="{{URL::asset('https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic')}}" rel='stylesheet' type='text/css'>
        <link href="{{URL::asset('https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700')}}" rel='stylesheet' type='text/css'>
        <link href="{{URL::asset('css/agency.min.css')}}" rel="stylesheet">

        <script src="{{asset('jquery/jquery.min.js')}}"></script>

    </head>


    <body id="page-top">
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand js-scroll-trigger" href="/">ADS Project</a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fa fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav text-uppercase ml-auto">

                        @if(Auth::check() && Auth::user()->role=='teacher')
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="/course/create">Create Course</a>
                        </li>
                        @endif
                        
                        @guest
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="{{route('login')}}" style="cursor: pointer">Login</a>
                        </li>
                        @else
                        <li class="nav-item">
                            <div class="login_div">
                                <a  href="/user/{{Auth::user()->id}}"><img src="{{asset('').Auth::user()->profilePic}}" class="profilePicRound"></a>
                                <a  href="/user/{{Auth::user()->id}}">{{ Auth::user()->name }}</a>
                                <a title="logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><img src="{{asset('img/logout_icon.png')}}" class="logoutText"></a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                                
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>




        @yield('content')



        



        <hr>
        <!-- Footer -->
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <span class="copyright">Copyright &copy; Osprishyo</span>
                    </div>
                    <div class="col-md-4">
                        <ul class="list-inline social-buttons">
                            <li class="list-inline-item">
                                <a href="#">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#">
                                    <i class="fa fa-linkedin"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="list-inline quicklinks">
                            <li class="list-inline-item">
                                <i class="fa fa-phone">&nbsp 01XXXXXXXXX</i>
                            </li>
                            <li class="list-inline-item">
                                <i class="fa fa-envelope">&nbsp abc@gmail.com</i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>



        <script src="{{asset('bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('jquery-easing/jquery.easing.min.js')}}"></script>
        <script src="{{asset('js/jqBootstrapValidation.js')}}"></script>
        <script src="{{asset('js/contact_me.js')}}"></script>
        <script src="{{asset('js/agency.min.js')}}"></script>
        <script src = "{{asset('js/plugins/ckeditor/ckeditor.js')}}"></script>

        <script type="text/javascript">

        
        $("#addLectureButton").click(function(e) {
            $("#ckeditorDiv").delay(100).fadeIn(100, function() {
                $("html,body").animate({
                    scrollTop: $("#ckeditorDiv").offset().top
                }, 500);
            });
            e.preventDefault();
        });

        $("#addLectCancel").click(function(e) {
            $("#ckeditorDiv").slideToggle();
            e.preventDefault();
        });

        $('#profileUpdateButton').click(function(e) {
            $("#updateUserProfileDiv").delay(100).fadeIn(100);
            $("#userProfileDiv").fadeOut(100);
            e.preventDefault();
        });

        $('#editButton').click(function(e) {
            $("#editDiv").delay(100).fadeIn(100);
            $("#detailDiv").fadeOut(100);
            e.preventDefault();
        });

        function openEditLectureDiv(id, tot) {
            for (i = 0; i < tot; i++) {
                $("#editLectDiv" + i).fadeOut(100);
            }
            $("#editLectDiv" + id).delay(100).fadeIn(100);
        }

        function closeEditLectureDiv(id) {
            if(id==-1)  $("#ckeditorDiv").slideToggle();
            if(id==-2)  $("#addQuizDiv").slideToggle();
            else $("#editLectDiv" + id).slideToggle();
        }


        function openReplyBox(id) {
            $("#replyBox" + id).slideToggle();
        }

        function changeMainDivContent(id, tot) {
            for (i = 0; i < tot; i++) {
                $("#mainContent" + i).fadeOut(100);
                $("#LectNo" + i).css("background-color", "white");
                $("#LectNo" + i).css("margin-bottom", ".5px");
            }
            $("#mainContent" + id).delay(100).fadeIn(100);
            $("#LectNo" + id).css("background-color", "#ececec");
        }


        $('#addQuizButton').click(function(e) {
            $("#addQuizDiv").delay(100).fadeIn(100);
            e.preventDefault();
        });

        function deleteItem(tp, id) {
            if(tp=='course') 
                $("#courseDelConf").delay(100).fadeIn(100);
            else if(tp=='lect') 
                $("#lectDelConf" + id).delay(100).fadeIn(100);

            else if(tp=='quiz') 
                $("#quizDelConf").delay(100).fadeIn(100);
            else if(tp=='ques') 
                $("#quesDelConf" + id).delay(100).fadeIn(100);
        }

         function noClicked(tp, id) {
            if(tp=='course') 
                $("#courseDelConf").fadeOut(100);
            else if(tp=='lect') 
                $("#lectDelConf" + id).fadeOut(100);
            else if(tp=='quiz') 
                $("#quizDelConf").fadeOut(100);
            else if(tp=='ques') 
                $("#quesDelConf" + id).fadeOut(100);
        }



        CKEDITOR.replaceAll( 'ckeditorclass' ,function( textarea, config )
            {
            });


        </script>



    </body>
</html>
</html>