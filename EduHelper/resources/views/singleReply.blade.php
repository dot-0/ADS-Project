<ul class="comments-list reply-list">
    <li>
        <div class="comment-avatar"><img src="{{asset(''.$replier->profilePic)}}" alt=""></div>
        <div class="comment-box">
            <div class="comment-head">
                @if($replier->role=='teacher')
                <h6 class="comment-name by-author"><a href="/user/{{$replier->_id}}">{{$replier->name}}</a></h6>
                @else
                <h6 class="comment-name by-student"><a href="/user/{{$replier->_id}}">{{$replier->name}}</a></h6>
                @endif
                <span>{{$reply->created_at}}</span>
                <i class="fa fa-reply" id="{{"replyButton".$comment_id}}" onclick="openReplyBox('{{$comment_id}}');"></i>
            </div>
            <div class="comment-content">
                {{$reply->reply}}
            </div>
        </div>
    </li>
</ul>