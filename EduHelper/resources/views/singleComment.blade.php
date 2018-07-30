<li>
    <div class="comment-main-level">
        <div class="comment-avatar"><img src="{{asset('').$commenter->profilePic}}" alt=""></div>
        <div class="comment-box">
            <div class="comment-head">
                @if($commenter->role == 'teacher')
                <h6 class="comment-name by-author"><a href="/user/{{$commenter->_id}}">{{$commenter->name}}</a></h6>
                @else
                <h6 class="comment-name by-student"><a href="/user/{{$commenter->_id}}">{{$commenter->name}}</a></h6>
                @endif
                <span>{{$comment->created_at}}</span>
                <i class="fa fa-reply" id="{{"replyButton".$comment->_id}}" onclick="openReplyBox('{{$comment->_id}}');"></i>
            </div>
            <div class="comment-content">
                {{$comment->comment}}
            </div>
        </div>
    </div>

        <ul class="comments-list reply-list" id="{{"replyBox".$comment->_id}}" style="display:none;">
            <li>
                <div class="comment-avatar"><img src="{{asset('').$commenter->profilePic}}" alt=""></div>
                <div class="comment-box">
                    <div class="comment-head">
                        @if($commenter->role == 'teacher')
                        <h6 class="comment-name by-author"><a href="/user/{{$commenter->_id}}">{{$commenter->name}}</a></h6>
                        @else
                        <h6 class="comment-name by-student"><a href="/user/{{$commenter->_id}}">{{$commenter->name}}</a></h6>
                        @endif
                        <span>Now</span>
                    </div>

                    <input style="width: 100%;margin-bottom: 5px; border:none;" type="text"  onkeydown="ReplyFunc(event, '{{$comment->_id}}');" placeholder="Make a reply" class="comment-content" id="{{"replyArea".$comment->_id}}">

                </div>
            </li>
        </ul>

    <div class="reply" id="{{"reply_for_".$comment->_id}}">

    </div>
</li>