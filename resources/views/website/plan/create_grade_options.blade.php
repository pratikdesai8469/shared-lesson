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
                <h2 class="text-white font-weight-bold">Form</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="#">Home</a>
                    </li>
                    <li>Grade Field</li>
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
                <div class="p-5 rounded box-shadow">
                    <form action="{{url('/add-grade-options')}}"  method="POST" class="row">
                        <div class="col-lg-12">
                            <h3>Add Grade Options</h3>
                            @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>	
                                <strong>{{ $message }}</strong>
                            </div>
                            @endif
                        </div>
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
                        {{-- <div class="col-lg-12">
                            <label for="method_name">Method name</label>
                            <input type="text" name="method_name" id="method_name" class="form-control" placeholder="Method name">
                        </div> --}}
                        <div class="col-lg-12">
                            <label for="group_served">Group served</label>
                            <input type="text" name="group_served" id="group_served" class="form-control" placeholder="Group served">
                        </div>
                        <div class="col-lg-12">
                            <label for="standard_name">Standard name</label>
                            <input type="text" name="standard_name" id="standard_name" class="form-control" placeholder="Standard name">
                        </div>
                        <div class="col-lg-12">
                            <label for="standard_number">Standard number</label>
                            <input type="text" name="standard_number" id="standard_number" class="form-control" placeholder="Standard number">
                        </div>
                        <div class="col-lg-12">
                            <label for="standard_description">Standard Description</label>
                            <input type="text" name="standard_description" id="standard_description" class="form-control" placeholder="Standard description">
                        </div>
                        <div class="col-lg-12">
                            <label for="entry_activity">Entry Activity/ Success Starter</label>
                            <input type="text" name="entry_activity" id="entry_activity" class="form-control" placeholder="Entry Activity/ Success Starter">
                        </div>
                        <div class="col-lg-12">
                            <label for="notes">Notes</label>
                            <input type="text" name="notes" id="notes" class="form-control" placeholder="Notes">
                        </div>
                        <div class="col-lg-12">
                            <label for="informal_assessment">Informal assessment</label>
                            <input type="text" name="informal_assessment" id="informal_assessment" class="form-control" placeholder="Informal assessment">
                        </div>
                        <div class="col-lg-12">
                            <label for="student_work">Student work</label>
                            <input type="text" name="student_work" id="student_work" class="form-control" placeholder="Student work">
                        </div>
                        <div class="col-lg-12">
                            <label for="formal_assessment">Formal assessment</label>
                            <input type="text" name="formal_assessment" id="formal_assessment" class="form-control" placeholder="Formal assessment">
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



