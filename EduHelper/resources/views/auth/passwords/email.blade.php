@extends('MasterLayout1')
@section('content')

<script type="text/javascript">
window.location = "#emailBody";
</script>

<header class="masthead">
  <div class="container">
    <div class="intro-text">
      <div class="intro-heading"></div>
    </div>
  </div>
</header>

<section class="bg-light" id="emailBody">
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">
            Reset Password
            <a id="resetpasscancel" style="cursor: pointer; float: right;"><i class="fa fa-times"></i></a>
          </div>
          <div class="panel-body">
            @if (session('status'))
              <div class="alert alert-success">
                {{ session('status') }}
              </div>
            @endif
            <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
              {{ csrf_field() }}
              <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                <div class="col-md-6">
                  <input id="resetpass_email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                  @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                  <button type="submit" class="btn btn-success">
                    Send Password Reset Link
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
