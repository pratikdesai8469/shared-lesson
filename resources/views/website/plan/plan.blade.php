@extends('layouts.website.main')



@section('css')
<style>
    .btn {
        font-size: 0px;
        padding: 16px 15px;
    }
    .btn-custom {
        background-color: black;
    }
    .icon-custom {
        font-size: 20px;
        text-align:center;
        color:white;
    }

    .btn1 {
        font-size: 14px;
        font-family: "Open Sans", sans-serif;
        text-transform: capitalize;
        padding: 16px 44px;
        border-radius: 35px;
        font-weight: 600;
        border: 0;
        position: relative;
        z-index: 1;
        transition: .2s ease;
    }

</style>
@endsection

@section('content')
    <section class="page-title overlay" style="background-image: url({{ asset('public/website/images/background/page-title.jpg') }});">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="text-white font-weight-bold">Lesson Plans</h2>
                    {{-- <ol class="breadcrumb">
                        <li>
                            <a href="#">Home</a>
                        </li>
                        <li>Unit plans</li>
                    </ol> --}}
                </div>
            </div>
        </div>
    </section>


    <!-- service -->
    <section class="section">
        <div class="container">
            <div class="col-lg-12 text-center">
                <h5 class="section-title-sm">Your Saved</h5>
                <h2 class="section-title section-title-border">Lesson Plans</h2>
            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>	
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            <div class="row">
                @if ($plan)
                    @foreach ($plan as $item)
                    @php
                        $objective = null;
                        if ($item->objective) {
                        $obj = json_decode($item->objective, true);
                        $objective = $obj['objective'][1]['objective'] ?? null;
                        }
                    @endphp
                            <!-- service item -->
                        <div class="col-lg-4 col-sm-6 mb-5">
                            <div class="card text-center">
                                <div class="card-body p-0">
                                    {{-- <a class="text-primary ti-trash d-flex flex-row-reverse pt-1 pr-1"> </a> --}}
                                    <h4 class="card-title pt-3">Lesson: {{$item->lesson ? $item->lesson: null  }} {{$item->is_copy == 1 ? '- Copy' : ''}}</h4>
                                    @if ($objective)
                                        <p class="card-text mx-2 mb-0"><b>Objective :</b> {{$objective  }}</p>
                                    @endif
                                    <a href="{{url('/form-details')}}/{{encrypt($item->id)}}" class="btn btn-custom btn-secondary translateY-25"><span class="icon-custom  ti-eye "></span></a>
                                    <a href="{{url('/pdf')}}/{{$item->id}}" target="_blank" class="btn btn-custom btn-secondary translateY-25"><span class="icon-custom ti-printer "></span></a>
                                    <a href="{{url('/edit-plan-form')}}/{{encrypt($item->id)}}" class="btn btn-custom btn-secondary translateY-25"><span class="icon-custom  ti-pencil-alt "></span></a>
                                    <a href="{{url('delete-plan/'.encrypt($item->id))}}" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-custom btn-secondary translateY-25"><span class="icon-custom ti-trash "></span></a>
                                    <a href="" class="btn btn-custom btn-secondary translateY-25 save2" data-id="{{encrypt($item->id)}}"><span class="icon-custom ti-sharethis"></span></a>
                                    <a href="{{url('/form-copy')}}/{{encrypt($item->id)}}" onclick="return confirm('Are you sure you want to copy this item?');" class="btn btn-custom btn-secondary translateY-25"><span class="icon-custom ti-save"></span></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="row justify-content-center align-items-center text-center">
                {{ $plan->links() }}
            </div>
        </div>
    </section>
    <!-- /service -->

    <div class="modal fade" id="sendPlanDetails">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Send Mail</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">      
                        <div class="col-lg-12">
                            <label for="email">Email</label>
                            <input type="text" name="email" class="form-control send-email" placeholder="Email" required>
                            <input type="hidden" name="plan_id" id="plan_id" class="form-control" value="">
                            <span class="form-error d-none email-error text-danger">Provide valid email address</span>
                        </div>
                        <div class="col-lg-12">
                            <br>
                            <button type="button" class="btn1 btn-danger btn-sm save2 saveBtn" value="3" data-id="1">Send Mail</button>
                            <button type="button" class="btn1 btn-danger btn-sm " data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

<script type="text/javascript">


    $(document).ready(function(){
        $(document).on('click','.save2',function(e){
            e.preventDefault();
            var dId = $(this).data('id');
            if(dId != 1){
                $('.send-email').val('');
                $('#sendPlanDetails').modal('show');
                $('#plan_id').val(dId);
                return true;
            }
            $('.send-mail').addClass('disabled');
            $('.email-error').addClass('d-none');
            $('.send-mail').removeClass('m-0');
            if($('.send-email').val() == '' || !isEmail($('.send-email').val())){
                $('.send-mail').addClass('m-0');
                $('.email-error').removeClass('d-none');
                $('.send-mail').removeClass('disabled');
                return false;
            }
            var formData = new  FormData();
            var mail = $('.send-email').val();
            var planId = $('#plan_id').val();
            formData.append('email',mail);
            formData.append('id',planId);
            formData.append('_token', "{{ csrf_token() }}");
            storeForm(formData);
        });
    });


    function storeForm(data) {
        $('.saveBtn').prop('disabled', true);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'{{URL::to("share-plan")}}',
            type:'POST',
            enctype: 'multipart/form-data',
            dataType:'json',
            data:data,
            cache: false,
            contentType: false,
            processData: false,
        }).done(function(data){
            $('.saveBtn').prop('disabled', false);
            if(data.status == 'true'){
                window.location.href = '{{URL::to("plan")}}';
            }else{
                location.reload();
            }
        });
    }

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
    
</script>

@endsection