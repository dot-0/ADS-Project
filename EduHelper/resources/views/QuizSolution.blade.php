@extends('MasterLayout1')
@section('content')

<header class="masthead">
  <div class="container">
    <div class="intro-text">
    <div class="intro-heading">Quiz Solution</div>
    </div>
  </div>
</header>


<div class="Gap10"></div>

<div class='span8 main container'>

	@for($i=0; $i<sizeof($quiz_arr); $i++)
	<div class="showQuesDiv">
		
		<div class="quesTitle">
				<h1>{{$i+1}}</h1>
				&nbsp
				<h3>{!!$quiz_arr[$i]->question!!}</h3>
		</div>

		<div class="Gap2"></div>
		
		<li>
			@if($quiz_arr[$i]->answer=='1')
			<input type="checkbox" checked>{!!$quiz_arr[$i]->option1!!}</input>
			@else
			<input type="checkbox">{!!$quiz_arr[$i]->option1!!}</input>
			@endif
		</li>
		<li>
			@if($quiz_arr[$i]->answer=='2')
			<input type="checkbox" checked>{!!$quiz_arr[$i]->option2!!}</input>
			@else
			<input type="checkbox">{!!$quiz_arr[$i]->option2!!}</input>
			@endif
		</li>
		<li>
			@if($quiz_arr[$i]->answer=='3')
			<input type="checkbox" checked>{!!$quiz_arr[$i]->option3!!}</input>
			@else
			<input type="checkbox">{!!$quiz_arr[$i]->option3!!}</input>
			@endif
		</li>
		<li>
			@if($quiz_arr[$i]->answer=='4')
			<input type="checkbox" checked>{!!$quiz_arr[$i]->option4!!}</input>
			@else
			<input type="checkbox">{!!$quiz_arr[$i]->option4!!}</input>
			@endif
		</li>


	</div>

	<div class="Gap5"></div>

	@endfor

</div>

<div class="Gap20"></div>
  


<script type="text/javascript">
	


</script>

@endsection
