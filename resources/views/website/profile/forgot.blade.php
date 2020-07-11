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
                                <form action="{{ route('password.email') }}" method="POST" class="row">
                                    {{ csrf_field() }}
                                    <div class="col-lg-12">
                                        <h3>Forgot password</h3>
                                        <br><br>
                                        @if (session('status'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('status') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-lg-12">
                                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                     @enderror
                                    </div>
                                    <div class="col-lg-12">
                                        <button class="btn btn-primary" type="submit" value="send">Submit</button>
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


