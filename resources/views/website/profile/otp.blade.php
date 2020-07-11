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
                    <div class="row">
                        <div class="col-md-5 signup-greeting overlay"
                            style="background-image: url({{ asset('public/website/images/background/signup.jpg') }});">
                            <!-- <img src="images/logo-signup.png" alt="logo"> -->
                            <h4>Welcome!</h4>
                            <p>Make the lesson planning process easier and smoother.</p>
                        </div>
                        <div class="col-md-7">
                            <div class="signup-form">
                                <form action="{{url('user/verify-otp')}}" method="post" class="row">
                                    <div class="col-lg-12">
                                        <h3>Verify OTP</h3>
                                        <br><br>
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
                                    <div class="col-lg-12 ">
                                        <input type="text" name="otp" class="form-control" placeholder="OTP" required>
                                        @if ($errors->has('otp')) <p class="text-danger" style="margin-top:-12px;">{{ $errors->first('otp') }}</p> @endif
                                    </div>
                                    <input type="hidden" name="email" class="form-control" value="{{Session::get('email')}}">
                                    <input type="hidden" name="lession_id" class="form-control" value="{{Session::get('lession_id')}}">
                                    <div class="col-lg-12">
                                        <button class="btn btn-primary" type="submit" value="send">Submit</button>
                                        <p class="float-sm-right" style="margin-top: 30px;">
                                            <a href="#" style="color:red;" class="resendOtp" data-id="{{Session::get('email')}}">Resend OTP</a>
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                
            </div>
        </div>
    </div>
</section>
@endsection


@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click','.resendOtp',function(e){
            var sendOtpButton = this;
            sendOtpButton.disabled = true;
            sendOtpButton.style.color = 'grey';
            e.preventDefault();
            var emailAddress = $(this).data('id');
            bootbox.confirm("Are you sure you want to Resend OTP?", function(result) {
                if(result){
                    if (!emailAddress) {
                        bootbox.alert('Something went wrong. Please try again');
                        sendOtpButton.disabled = false;
                        sendOtpButton.style.color = 'red';
                    }
                    var formData = new  FormData();
                    formData.append('email',emailAddress);
                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url:'{{URL::to("send-otp")}}',
                        type:'POST',
                        enctype: 'multipart/form-data',
                        dataType:'json',
                        data:formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                    }).done(function(data){
                        if(data.status == 'true'){
                            setTimeout(function() {
                                sendOtpButton.disabled = false;
                                sendOtpButton.style.color = 'red';
                            }, 10000);
                            bootbox.alert('Resend OTP successfully!');
                        }else{
                            sendOtpButton.disabled = false;
                            sendOtpButton.style.color = 'red';
                            bootbox.alert('Something went wrong.');
                        }
                    });
                } else {
                    sendOtpButton.disabled = false;
                    sendOtpButton.style.color = 'red';
                }
            });

        });
    });
</script>

@endsection