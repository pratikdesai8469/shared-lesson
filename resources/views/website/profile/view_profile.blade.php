@extends('layouts.website.main')
@section('css')
<style>
    .form-control::-webkit-input-placeholder {
        color: #bbb;
    }
</style>
@endsection

@section('content')
<section class="page-title overlay" style="background-image: url({{ asset('public/website/images/background/page-title.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="text-white font-weight-bold">View Profile</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="#">Home</a>
                    </li>
                    <li>View Profile</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- contact --> 
<section class="section " >
    <div class="container ">
        <div class="row d-flex justify-content-around">
            <!-- form -->
            <div class="col-lg-6 col-md-7">
                <div class="p-5 rounded box-shadow">
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
                    <div class="p-4 rounded border mb-50">
                        <h4 class="text-color mb-20">Profile</h4>
                        <ul class="pl-0 mb-20">
                            <li class="py-3 border-bottom">
                                <span class="d-inline-block" style="width: 140px;">Name:</span>{{$user->name}}</li>
                            <li class="py-3 border-bottom">
                                <span class="d-inline-block" style="width: 140px;">Email:</span>{{$user->email}}</li>
                        </ul>
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#updateProfile">Edit</a>
                    </div>
                    <div class="col-lg-12">
                        <a href="#" style="color:red;" data-toggle="modal" data-target="#changePassword">Change password</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- The Modal for change password -->
<div class="modal fade" id="changePassword">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Change Password</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">      
                <form action="{{url('user/change-password')}}" method="POST" class="row">
                    {{ csrf_field() }}
                    <div class="col-lg-12">
                        <label for="old_password">Old Password</label>
                        <input type="password" name="old_password" class="form-control" placeholder="Old Password" required>
                        @if ($errors->has('old_password')) <p class="text-danger" style="margin-top:-12px;">{{ $errors->first('old_password') }}</p> @endif
                    </div>
                    <div class="col-lg-12">
                        <label for="new_password">New Password</label>
                        <input type="password" name="password" class="form-control" placeholder="New Password" required>
                        @if ($errors->has('password')) <p class="text-danger" style="margin-top:-12px;">{{ $errors->first('password') }}</p> @endif
                    </div>
                    <div class="col-lg-12">
                        <label for="password_confirmation">Confirm password</label>
                        <input type="password" name="password_confirmation"  class="form-control" placeholder="Confirm password" required>
                    </div>
                    <div class="col-lg-12">
                        <input type="submit" class="btn btn-danger btn-sm"  value="Submit">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
            <!-- Modal footer -->
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div> -->
        </div>
    </div>
</div>

<!-- The Modal for update profile -->
<div class="modal fade" id="updateProfile">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update Profile</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">      
                <form action="{{url('user/update')}}" method="POST" class="row">
                    {{ csrf_field() }}
                    <div class="col-lg-12">
                        <label for="username">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Name" value="{{$user->name}}" required>
                    </div>
                    <div class="col-lg-12">
                        <label for="email">Email</label>
                        <input type="text" name="email" class="form-control" placeholder="Email" value="{{old('email',$user->email)}}" required>
                        @if ($errors->has('email')) <p class="text-danger" style="margin-top:-12px;">{{ $errors->first('email') }}</p> @endif
                    </div>
                    <div class="col-lg-12">
                        <input type="submit" class="btn btn-danger btn-sm"  value="Update">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
@if ($errors->has('email'))
    <script type="text/javascript">
        $(window).on('load',function(){
            $('#updateProfile').modal('show');
        });
    </script>
@endif

@if ($errors->has('password')  || $errors->has('old_password')) 
   <script type="text/javascript">
        $(window).on('load',function(){
            $('#changePassword').modal('show');
        });
    </script>
@endif
@endsection
