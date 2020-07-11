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
                        <div class="col-md-5 signup-greeting overlay" style="background-image: url({{ asset('public/website/images/background/signup.jpg') }});">
                            <!-- <img src="images/logo-signup.png" alt="logo"> -->
                            <h4>Welcome!</h4>
                            <p>Make the lesson planning process easier and smoother.</p>
                        </div>
                        <div class="col-md-7">
                            <div class="signup-form">
                                <form action="{{url('user/register')}}" class="row" method="post">
                                    <div class="col-lg-12">
                                        <h4>Sign Up</h4>
                                        <p class="float-sm-right">Already Have Account?
                                            <a href="{{url('/web-login')}}">Log In</a>
                                        </p>
                                    </div>
                                    {{-- @if($errors->any())
                                        {{ implode('', $errors->all('<div>:message</div>')) }}
                                    @endif --}}
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
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{old('name')}}">
                                        @if ($errors->has('name')) <p class="text-danger" style="margin-top:-12px;">{{ $errors->first('name') }}</p> @endif
                                    </div>
                                    <div class="col-lg-12">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" value="{{old('email')}}">
                                        @if ($errors->has('email')) <p class="text-danger" style="margin-top:-12px;">{{ $errors->first('email') }}</p> @endif
                                    </div>
                                    <div class="col-lg-12">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                        @if ($errors->has('password')) <p class="text-danger" style="margin-top:-12px;">{{ $errors->first('password') }}</p> @endif
                                    </div>
                                    <input type="hidden" class="form-control" id="lession_id" name="lession_id" value="{{!empty(Request::segment(2)) ? Request::segment(2) : null }}">
                                    <div class="col-lg-12">
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                                        @if ($errors->has('password_confirmation')) <p class="text-danger" style="margin-top:-12px;">{{ $errors->first('password_confirmation') }}</p> @endif
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
                                    <div class="col-sm-4">
                                        <input class="btn btn-primary btn-sm" type="submit" value="Sign Up">
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