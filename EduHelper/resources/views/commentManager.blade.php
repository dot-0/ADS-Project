<!-- 3 is the number of comments in this lecture -->
@for($i=0; $i<sizeof($comment_arr_2D[$k]); $i++)

    <li>
        <div class="comment-main-level">
            <div class="comment-avatar"><img src="{{asset('').$commenter_arr_2D[$k][$i]->profilePic}}" alt=""></div>
            <div class="comment-box">
                <div class="comment-head">
                    @if($commenter_arr_2D[$k][$i]->role=='teacher')
                    <h6 class="comment-name by-author"><a href="/user/{{$commenter_arr_2D[$k][$i]->_id}}">{{$commenter_arr_2D[$k][$i]->name}}</a></h6>
                    @else
                    <h6 class="comment-name by-student"><ahref="/user/{{$commenter_arr_2D[$k][$i]->_id}}">{{$commenter_arr_2D[$k][$i]->name}}</a></h6>
                    @endif
                    <span>{{$comment_arr_2D[$k][$i]->created_at}}</span>
                    <i class="fa fa-reply" id="{{"replyButton".$comment_arr_2D[$k][$i]->_id}}" onclick="openReplyBox('{{$comment_arr_2D[$k][$i]->_id}}');"></i>
                </div>
                <div class="comment-content">
                    {{$comment_arr_2D[$k][$i]->comment}}
                </div>
            </div>
        </div>

        <!--Reply Box-->      <!--Form Needed-->
        @if(Auth::check())
            <ul class="comments-list reply-list" id="{{"replyBox".$comment_arr_2D[$k][$i]->_id}}" style="display: none">
                <li>
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

                        <input style="width: 100%;margin-bottom: 5px; border:none;" onkeydown="ReplyFunc(event, '{{$comment_arr_2D[$k][$i]->_id}}');" type="text" placeholder="Make a reply" class="comment-content" id="{{"replyArea".$comment_arr_2D[$k][$i]->_id}}" >

                    </div>
                </li>
            </ul>
        @endif
    <!-- End Reply Box -->

        <!-- 2 is the number of replies in this comment -->
        <div class="reply" id="{{"reply_for_".$comment_arr_2D[$k][$i]->_id}}">
        @for($j=0; $j<sizeof($reply_arr_3D[$k][$i]); $j++)

            <ul class="comments-list reply-list">
                <li>
                    <div class="comment-avatar"><img src="{{asset(''.$replier_arr_3D[$k][$i][$j]->profilePic)}}" alt=""></div>
                    <div class="comment-box">
                        <div class="comment-head">
                            @if($replier_arr_3D[$k][$i][$j]->role=='teacher')
                            <h6 class="comment-name by-author"><a href="/user/{{$replier_arr_3D[$k][$i][$j]->_id}}">{{$replier_arr_3D[$k][$i][$j]->name}}</a></h6>
                            @else
                             <h6 class="comment-name by-student"><a href="/user/{{$replier_arr_3D[$k][$i][$j]->_id}}">{{$replier_arr_3D[$k][$i][$j]->name}}</a></h6>
                             @endif
                            <span>{{$replier_arr_3D[$k][$i][$j]->created_at}}</span>
                            <i class="fa fa-reply" id="{{"replyButton".$comment_arr_2D[$k][$i]->_id}}" onclick="openReplyBox('{{$comment_arr_2D[$k][$i]->_id}}');"></i>
                        </div>
                        <div class="comment-content">
                            {{$reply_arr_3D[$k][$i][$j]->reply}}
                        </div>
                    </div>
                </li>
            </ul>
        @endfor
        </div>


    </li>

@endfor