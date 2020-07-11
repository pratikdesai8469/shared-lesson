@extends('layouts.website.main')

@section('css')
<style>
.form-control::-webkit-input-placeholder {
    color: #bbb;
}
.add-btn{
   padding: 11px 30px !important;
}
</style>
@endsection
@section('content')


<section class="page-title overlay" style="background-image: url({{ asset('public/website/images/background/page-title.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="text-white font-weight-bold">Form</h2>
                <ol class="breadcrumb">
                    <li>Create Your Database</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- contact -->
<section class="section ">
    <div class="container ">
        <div class="row align-items-center justify-content-center">
            <!-- form -->
            <div class="col-lg-9 col-md-9">
                @if($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>	
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                @if($message = Session::get('error'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>	
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <div class="p-5 rounded box-shadow">
                    <form action="{{url('upload-user-sheet')}}"  enctype="multipart/form-data" method="POST" class="row">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-lg-5">
                                <h3>Add Grade Options</h3>
                            </div>
                            <div class="col-md-3">
                                <label for="s_date">Choose Sheet</label>
                                {{Form::file('upload')}}
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-1">
                                <input class="btn btn-primary add-btn" type="submit" value="Add">
                            </div>
                        </div>
                    </form>
                    <form action="{{url('create-database')}}"  method="POST" class="row">
                        {{ csrf_field() }}
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="grade">Select Grade</label>
                                {{Form::select('grade',$gradeData,'',['id'=>'grade','placeholder'=>'Select Grade', 'required'])}}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label for="subject">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject">
                        </div>
                        <div class="col-lg-12">
                            <label for="unit_topic">Unit topic</label>
                            <input type="text" name="unit_topic" id="unit_topic" class="form-control" placeholder="Unit topic">
                        </div>
                        <div class="col-lg-12">
                            <label for="l_name">Learning Target / Objective</label>
                            <input type="text" name="learning_target" id="l_name" class="form-control" placeholder="Learning Target">
                        </div>
                        <div class="col-lg-12">
                            <input class="btn btn-primary" type="submit" value="Add">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection


@section('script')

<script type="text/javascript">
    $('#grade').selectize({
        create: true,
        sortField: 'text'
    });
</script>
@endsection



