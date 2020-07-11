@extends('layouts.website.sub')
@section('css')
<style>
    .form-control::-webkit-input-placeholder {
        color: #bbb;
    }
</style>
@endsection
@section('content')
<section class="d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="signup">
                    <div class="row">
                        <div class="col-md-5 signup-greeting overlay"
                            style="background-image: url({{ asset('public/website/images/background/signup.jpg') }});">
                            <!-- <img src="images/logo-signup.png" alt="logo"> -->
                            <h4>Welcome!</h4>
                            <p>Make the lesson planning process easier and smoother.</p>
                        </div>
                        <div class="col-md-7">
                            <div class="signup-form">
                                <form action="{{url('user/login-check')}}" method="POST" class="row">
                                    <div class="col-lg-12">
                                        <h4>Login</h4>
                                        <p class="float-sm-right">Need An Account?
                                            <a href="{{url('/signup')}}">Sign Up</a>
                                        </p>
                                    </div>
                                    @if ($message = Session::get('success'))
                                    <div class="col-lg-12">
                                        <div class="alert alert-success alert-block">
                                            <button type="button" class="close" data-dismiss="alert">×</button>	
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($message = Session::get('error'))
                                    <div class="col-lg-12">
                                        <div class="alert alert-danger alert-block">
                                            <button type="button" class="close" data-dismiss="alert">×</button>	
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    </div>
                                    @endif
                                    {{ csrf_field() }}
                                    <div class="col-lg-12">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" value="{{old('email')}}">
                                        @if ($errors->has('email')) <p class="text-danger" style="margin-top:-12px;">{{ $errors->first('email') }}</p> @endif
                                    </div>
                                    <div class="col-lg-12">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                        @if ($errors->has('password')) <p class="text-danger" style="margin-top:-12px;">{{ $errors->first('password') }}</p> @endif
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <input type="checkbox" id="is_subscribe" name="is_subscribe" @if (old('is_subscribe')) checked  @endif>
                                            </div>
                                            <div class="col-md-10">
                                                <span class="s-text">Subscribe our newsletter  and receive notifications for professional development</span>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control" id="lession_id" name="lession_id" value="{{!empty(Request::segment(2)) ? Request::segment(2) : null }}">
                                    <div class="col-sm-12">
                                        <input type="submit" class="btn btn-primary btn-sm" value="Login">
                                    </div>
                                    <div class="col-sm-8">
                                        <br>
                                        <a href="{{url('/forgot')}}" style="color:red;">Forgot password!</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection