@extends('MasterLayout1')
@section('content')

<header class="masthead">
  <div class="container">
    <div class="intro-text">
      <div class="intro-heading">Initialize</div>
    </div>
  </div>
</header>

<div class="Gap10"></div>
{!! Form::open(
          array(
              'method'=>'POST',
              'route' => 'course.store',
              'class' => 'form',
              'novalidate' => 'novalidate',
              'files' => true))
  !!}
<div class="container">
<div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Course Title</label>
  <div class="col-10">
    <input class="form-control" type="text" value="" id="courseTitle" name="courseTitle">
  </div>
</div>

<div class="form-group row">
  <label for="example-text-input" class="col-2 col-form-label">Tag (s)</label>
  <div class="col-10">
    <input class="form-control" type="text" value="" id="tags" name="tags">
  </div>
</div>

</div>

 <button type="submit" style="margin-left: 46%; background-color: #2866b3" class="btn btn-primary">Create</button>
{!! Form::close() !!}
<div class="Gap10"></div>
@endsection