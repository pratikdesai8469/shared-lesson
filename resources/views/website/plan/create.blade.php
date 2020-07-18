@extends('layouts.website.main')

@section('css')

<style>
    .plus_btn {
        margin-top: 35px;
        border: 1px solid red;
        padding: 7px;
    }

    .remove-btn-border {
        border: 1px solid red;
        padding: 5px;
        margin-bottom: 3px;
    }

    .standard-block {
        border: 1px solid #a4b8bd;
        width: 100%;

    }
    .diff_button {
        border: 1px solid red;
        padding: 3px;
    }

    .form-error{
        margin-bottom: 10px;
        margin-top: -10px;
        margin-left: 5px;
        color: red;
        font-size: 12px;
    }
    .send-mail{
        height: 44px !important;
        width: 134px !important;
        padding: 0px !important;
    }
    .send{
        padding: 10px !important;
        color: white !important;
    }
    .color-box{
        border: 1px solid #ddd2d2;
        height: 37px;
        max-width: 40px;
        margin-top: 30px;
    }
</style>
@endsection
@section('content')


<section class="page-title overlay" style="background-image: url({{ asset('public/website/images/background/page-title.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="text-white font-weight-bold">Plan new lesson</h2>
                <ol class="breadcrumb">
                    {{-- <li>
                        <a href="#">Home</a>
                    </li>
                    <li>Units and skills</li> --}}
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- contact -->
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-7">
                <div class="p-5 rounded box-shadow">
                    {{-- <form  class="row"> --}}
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>	
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>	
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <form class="row lession-form">
                        <div class="col-lg-3">
                            <h3>Lesson Plan</h3>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-lg-4">
                            <label for="class">Class</label>
                            {{Form::select('class',[],[],['id'=>'class','placeholder'=>'Select Class', 'class' => 'grade_options class'])}}
                            <span class="form-error d-none class-error">This field is required</span>
                        </div>
                        <div class="col-lg-4">
                            <label for="lesson">lesson #</label>
                            {{-- <input type="text" name="lesson" id="lesson" class="form-control" placeholder="Lesson" required> --}}
                            {{Form::select('lesson',$lessonData,[],['id'=>'lesson','placeholder'=>'Select lesson', 'class' => 'grade_options'])}}
                            <span class="form-error d-none lesson-error">This field is required</span>
                        </div>
                        {{ csrf_field() }}
                        {{Form::hidden('plan_id','',['class'=>'plan-id'])}}
                        <div class="col-lg-12">
                            <label for="teacher_authors">Teacher Authors</label>
                            {{-- <input type="text" name="teacher_authors" id="teacher_authors" class="form-control" placeholder="Teacher Authors" required> --}}
                            {{Form::select('teacher_authors',[],[],['id'=>'teacher_authors','placeholder'=>'Select teacher authors', 'class' => 'grade_options teacher_authors'])}}
                            <span class="form-error d-none teacher-error">This field is required</span>
                        </div>
                        <div class="col-lg-5">
                            <label for="color_label">Color</label>
                            {{Form::select('color',$color, [], ['id'=>'color_label','class'=>'color'])}}
                        </div>
                        <div class="col-md-1">
                            <div class="color-box" style="{{'border-color:'.$firstColor.';background:'.$firstColor}}"></div>
                        </div>
                        <div class="col-lg-6">
                            <label for="s_date">Date</label>
                            <input type="text" name="s_date" id="s_date" class="form-control dateJs" placeholder="Date" required autocomplete="off">
                            <span class="form-error d-none date-error">This field is required</span>
                        </div>
                        <div class="col-lg-6">
                            <label for="grade">Grade</label>
                            {{Form::select('grade',$gradeData, [], ['id'=>'grade','placeholder'=>'Select grade'])}}
                            <span class="form-error d-none grade-error">This field is required</span>
                        </div>
                        <div class="col-lg-6">
                            <label for="subject">Subject</label>
                            {{Form::select('subject',[],[],['id'=>'subject','placeholder'=>'Select subject', 'class' => 'grade_options subject', 'required'])}}
                            <span class="form-error d-none sub-error">This field is required</span>
                        </div>
                        <div class="col-lg-6">
                            <label for="unit">Unit #</label>
                            {{-- <input type="text" name="unit" id="unit" class="form-control" placeholder="Unit" required> --}}
                            {{Form::select('unit',$unitData,[],['id'=>'unit','placeholder'=>'Select unit', 'class' => 'grade_options'])}}
                            <span class="form-error d-none unit-error">This field is required</span>
                        </div> 
                        <div class="col-lg-6">
                            <label for="unit_topic">Unit Topic</label>
                            {{Form::select('unit_topic',[],[],['id'=>'unit_topic','placeholder'=>'Select unit topic', 'class' => 'grade_options unit_topic'])}}
                            <span class="form-error d-none unit-topic-error">This field is required</span>
                        </div>

                        <div class="standard-block mt-4 mb-5 objective-div">
                            <div class="row pl-3 pr-3 pt-3">
                                <div class="col-lg-11">
                                    <label for="objective" contenteditable="true" id="objectiveLabel">Learning Target / Objective</label>
                                    {{-- <input type="text" name="objective_data[1][objective]" id="objective" class="form-control" placeholder="Learning Target / Objective"> --}}
                                    {{Form::select('objective_data[1][objective]',[],[], ['id'=>'objective','placeholder'=>'Select learning target/objective', 'class' => 'grade_options objective'])}}
                                </div>
                                {{Form::hidden('learning_count', 1,['class' => 'learning-count-1 learning-count', "data-id" => 1])}}
                                <div class="col-lg-1">
                                    <a class="text-primary d-inline-block mt-50 ti-plus add_learning_btn plus_btn"> </a>
                                </div>
                            </div>
                        </div>

                        <!-- --------------------------------------------------------------------------------- -->
                        <h5 contenteditable="true" id="standardsLabel">Standards</h5>&nbsp;<a class="ti-minus remove-btn-border remove-data" data-id="standard-1" data-status="only-minus" data-label="standardsLabel"></a>
                        {{Form::hidden('standard_data[1][status]','no',['class'=>'standard-1-status'])}}
                        <div class="standard-block mb-3 remove-block standard-1 standard-div">
                            <div class="row p-3">
                                <div class="col-lg-5">
                                    <label for="standard_name">Standard #</label>
                                    {{Form::select('standard_data[1][standard_name]',[],[], ['id'=>'standard_name','placeholder'=>'Standard #', 'class' => 'grade_options standard_name'])}}
                                    <span class="form-error d-none standard-error">This field is required</span>
                                </div>
                                <div class="col-lg-7">
                                    <label for="standard_number">Standard Resource</label>
                                    {{Form::select('standard_data[1][standard_number]',[],[], ['id'=>'standard_number','placeholder'=>'Standard resource', 'class' => 'grade_options standard_number'])}}
                                </div>
                                <div class="col-lg-11">
                                    <label for="standard_description">Standard Description</label>
                                    {{Form::select('standard_data[1][standard_description]',[],[], ['id'=>'standard_description','placeholder'=>'Standard description', 'class' => 'grade_options standard_description'])}}
                                </div>
                                <div class="col-lg-1">
                                    <a class="text-primary d-inline-block mt-50 ti-plus add_button plus_btn"></a>
                                </div>
                                {{Form::hidden('s_count', 1,['class' => 's-count-1 st-count', "data-id" => 1])}}
                            </div>
                        </div>
                        <div style="width:100%;margin-top: 10px;"></div>
                        <!-- --------------------------------------------------------------------------------- -->
                        <h5 contenteditable="true" id="entryLabel">Entry Activity/ Success Starter</h5>&nbsp;&nbsp;<a class="ti-minus remove-btn-border remove-data" data-id="entry-1" data-status="only-minus" data-label="entryLabel"> </a>
                        {{Form::hidden('entry_data[1][status]','no',['class'=>'entry-1-status'])}}
                        <div class="standard-block mb-3 entry-1 entry-div">
                            <div class="row pl-3 pr-3 pt-3">
                                <div class="col-lg-10">
                                    <label for="entry_activity">&nbsp;&nbsp;</label>
                                    {{Form::select('entry_data[1][entry_activity]',[],[], ['id'=>'entry_activity','placeholder'=>'Entry Activity', 'class' => 'grade_options entry_activity'])}}
                                    <span class="form-error d-none entry-error">This field is required</span>
                                </div>
                                <div class="col-lg-2">
                                    <label for="entry_duration">&nbsp;&nbsp;</label>
                                    {{Form::select('entry_data[1][entry_duration]',$monthDays,[], ['id'=>'entry_duration','placeholder'=>'Duration', 'class' => 'form-control entry_duration duration'])}}
                                </div>
                                <div class="col-lg-5">
                                    <label for="entry_attch">Attach document</label>
                                    <input type="file" name="entry_data[1][entry_attch]" id="entry_attch" class="form-control-file" placeholder="Attach document">
                                </div>
                                <div class="col-lg-6">
                                    <label for="entry_link">Create a link</label>
                                    <input type="text" name="entry_data[1][entry_link]" id="entry_link" class="form-control create_link" placeholder="Create a link">
                                </div>
                                <div class="col-lg-1">
                                    <a class="text-primary d-inline-block mt-50 ti-plus add_entry_btn plus_btn"> </a>
                                </div>
                                {{Form::hidden('entry_count', 1,['class' => 'entry-count-1 entry-count', "data-id" => 1])}}
                            </div>
                        </div>
                        <div style="width:100%;margin-top: 10px;"></div>
                        <h5>Mini Lesson</h5> 
                        <div class="standard-block mb-3">
                            <div class="pl-3 pr-3 pt-3 notes-div">
                                <div class="row">
                                    {{Form::hidden('notes_data[1][status]','no',['class'=>'notes-1-status'])}}
                                    <div class="col-lg-10">
                                        <label for="notes" contenteditable="true" id="notesLabel">Notes</label>  &nbsp;&nbsp; <a class="ti-minus remove-btn-border remove-data" data-id="notes-1" data-status="only-minus" data-label="notesLabel"></a>
                                        {{Form::select('notes_data[1][notes]',[],[], ['id'=>'notes','placeholder'=>'Notes', 'class' => 'grade_options notes notes-1'])}}
                                        <span class="form-error d-none notes-error">This field is required</span>
                                    </div>
                                    <div class="col-lg-2 notes-1">
                                        <label for="notes_duration">&nbsp;&nbsp;</label>
                                        {{Form::select("notes_data[1][notes_duration]",$monthDays,[], ['id'=>'notes_duration','placeholder'=>'Duration', 'class' => 'form-control notes_duration duration'])}}
                                    </div>
                                    <div class="col-lg-5 notes-1">
                                        <label for="notes_attch">Attach document</label>
                                        <input type="file" name="notes_data[1][notes_attch]" id="notes_attch" class="form-control-file" placeholder="Attach document">
                                    </div>
                                    <div class="col-lg-6 notes-1">
                                        <label for="notes_link">Create a link</label>
                                        <input type="text" name="notes_data[1][notes_link]" id="notes_link" class="form-control create_link" placeholder="Create a link">
                                    </div>
                                    {{Form::hidden('notes_count', 1,['class' => 'notes-count-1 notes-count', "data-id" => 1])}}
                                    <div class="col-lg-1 notes-1">
                                        <a class="text-primary d-inline-block mt-50 ti-plus add_notes_btn plus_btn"> </a>
                                    </div>
                                </div>
                            </div>
                            <div class="pl-3 pr-3 vocabulary-div">
                                <div class="row">
                                    {{Form::hidden('vocabulary_data[1][status]','no',['class'=>'vocabulary-1-status'])}}
                                    <div class="col-lg-10">
                                        <label for="vocabulary" contenteditable="true" id="vocabularyLabel">Vocabulary</label>  &nbsp;&nbsp; <a class="ti-minus remove-btn-border remove-data" data-id="vocabulary-1" data-status="only-minus" data-label="vocabularyLabel"></a>
                                        {{-- <input type="text" name="vocabulary_data[1][vocabulary]" id="vocabulary" class="form-control" placeholder="Vocabulary"> --}}
                                        {{Form::select('vocabulary_data[1][vocabulary]',[],[], ['id'=>'vocabulary','placeholder'=>'Vocabulary', 'class' => 'grade_options vocabulary vocabulary-1'])}}
                                        <span class="form-error d-none vocabulary-error">This field is required</span>
                                    </div>
                                    <div class="col-lg-2 vocabulary-1">
                                        <label for="vocabulary_duration">&nbsp;&nbsp;</label>
                                        {{Form::select("vocabulary_data[1][vocabulary_duration]",$monthDays,[], ["id"=>"vocabulary_duration","placeholder"=>"Duration", "class" => "form-control vocabulary_duration duration"])}}
                                    </div>
                                    <div class="col-lg-5 vocabulary-1">
                                        <label for="vocabulary_attch">Attach document</label>
                                        <input type="file" name="vocabulary_data[1][vocabulary_attch]" id="vocabulary_attch" class="form-control-file" placeholder="Attach document">
                                    </div>
                                    <div class="col-lg-6 vocabulary-1">
                                        <label for="vocabulary_link">Create a link</label>
                                        <input type="text" name="vocabulary_data[1][vocabulary_link]" id="vocabulary_link" class="form-control create_link" placeholder="Create a link">
                                    </div>
                                    {{Form::hidden('vocabulary_count', 1,['class' => 'vocabulary-count-1 vocabulary-count', "data-id" => 1])}}
                                    <div class="col-lg-1 vocabulary-1">
                                        <a class="text-primary d-inline-block mt-50 ti-plus add_vocabulary_btn plus_btn"> </a>
                                    </div>
                                </div>
                            </div>
                            <div class="pl-3 pr-3 concept-div">
                                <div class="row">
                                    {{Form::hidden('concept_data[1][status]','no',['class'=>'concept-1-status'])}}
                                    <div class="col-lg-10">
                                        <label for="concept" contenteditable="true" id="conceptLabel">Concept Demonstration</label> &nbsp;&nbsp; <a class="ti-minus remove-btn-border remove-data" data-id="concept-1" data-status="only-minus" data-label="conceptLabel"></a>
                                        {{-- <input type="text" name="concept_data[1][concept]" id="concept" class="form-control" placeholder="Concept Demonstration"> --}}
                                        {{Form::select('concept_data[1][concept]',[],[], ['id'=>'concept','placeholder'=>'Concept Demonstration', 'class' => 'grade_options concept concept-1'])}}
                                        <span class="form-error d-none concept-error">This field is required</span>
                                    </div>
                                    <div class="col-lg-2 concept-1">
                                        <label for="concept_duration">&nbsp;&nbsp;</label>
                                        {{Form::select("concept_data[1][concept_duration]",$monthDays,[], ["id"=>"concept_duration","placeholder"=>"Duration", "class" => "form-control concept_duration duration"])}}
                                    </div>
                                    <div class="col-lg-5 concept-1">
                                        <label for="concept_attch">Attach document</label>
                                        <input type="file" name="concept_data[1][concept_attch]" id="concept_attch" class="form-control-file" placeholder="Attach document">
                                    </div>
                                    <div class="col-lg-6 concept-1">
                                        <label for="concept_link">Create a link</label>
                                        <input type="text" name="concept_data[1][concept_link]" id="concept_link" class="form-control create_link" placeholder="Create a link">
                                    </div>
                                    {{Form::hidden('concept_count', 1,['class' => 'concept-count-1 concept-count', "data-id" => 1])}}
                                    <div class="col-lg-1 concept-1">
                                        <a class="text-primary d-inline-block mt-50 ti-plus add_concept_btn plus_btn"> </a>
                                    </div>
                                </div>
                            </div>
                            <div class="pl-3 pr-3 guided-div">
                                <div class="row">
                                    {{Form::hidden('guided_data[1][status]','no',['class'=>'guided-1-status'])}}
                                    <div class="col-lg-10">
                                        <label for="guided_practice" contenteditable="true" id="guidedLabel">Guided Practice</label> &nbsp;&nbsp; <a class="ti-minus remove-btn-border remove-data" data-id="guided-1" data-status="only-minus" data-label="guidedLabel"></a>
                                        {{-- <input type="text" name="guided_data[1][guided_practice]" id="guided_practice" class="form-control" placeholder="Guided Practice"> --}}
                                        {{Form::select('guided_data[1][guided_practice]',[],[], ['id'=>'guided_practice','placeholder'=>'Guided Practice', 'class' => 'grade_options guided_practice guided-1'])}}
                                        <span class="form-error d-none guided-error">This field is required</span>
                                    </div>
                                    <div class="col-lg-2 guided-1">
                                        <label for="guided_duration">&nbsp;&nbsp;</label>
                                        {{Form::select("guided_data[1][guided_duration]",$monthDays,[], ["id"=>"guided_duration","placeholder"=>"Duration", "class" => "form-control guided_duration duration"])}}
                                    </div>
                                    <div class="col-lg-5 guided-1">
                                        <label for="guided_attch">Attach document</label>
                                        <input type="file" name="guided_data[1][guided_attch]" id="guided_attch" class="form-control-file" placeholder="Attach document">
                                    </div>
                                    <div class="col-lg-6 guided-1">
                                        <label for="guided_link">Create a link</label>
                                        <input type="text" name="guided_data[1][guided_link]" id="guided_link" class="form-control create_link" placeholder="Create a link">
                                    </div>
                                    {{Form::hidden('guided_count', 1,['class' => 'guided-count-1 guided-count', "data-id" => 1])}}
                                    <div class="col-lg-1 guided-1">
                                        <a class="text-primary d-inline-block mt-50 ti-plus add_guided_btn plus_btn"> </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style="width:100%;margin-top: 10px;"></div>
                        <h5>Assessments</h5> &nbsp;&nbsp; <a class="ti-plus remove-btn-border add-assessments-block" data-id="assessment-1"></a>&nbsp; <a class="ti-minus remove-btn-border remove-data" data-id="assessment-1" data-status="main"> </a>
                        {{Form::hidden('informal[1][main_status]','no',['class'=>'assessment-1-status'])}}
                        <div class="standard-block mb-3 assessment-1">
                            <div class="px-3 pt-3 informal-div">
                                <div class="row">
                                    {{Form::hidden('informal[1][status]','no',['class'=>'informal-1-status'])}}
                                    <div class="col-lg-10">
                                        <label for="informal_assessment" contenteditable="true" id="informalLabel">Informal Assessment</label> &nbsp;&nbsp; <a class="ti-minus remove-btn-border remove-data" data-id="informal-1" data-status="only-minus" data-label="informalLabel"></a>
                                        {{Form::select('informal[1][informal_assessment]',[],[], ['id'=>'informal_assessment','placeholder'=>'Informal Assessment', 'class' => 'grade_options informal_assessment informal-1'])}}
                                        <span class="form-error d-none informal-error">This field is required</span>
                                    </div>
                                    <div class="col-lg-2 informal-1">
                                        <label for="informal_assessment_duration">&nbsp;&nbsp;</label>
                                        {{Form::select("informal[1][informal_assessment_duration]",$monthDays,[], ["id"=>"informal_assessment_duration","placeholder"=>"Duration", "class" => "form-control informal_assessment_duration duration"])}}
                                    </div>
                                    <div class="col-lg-5 informal-1">
                                        <label for="informal_assessment_attch">Attach document</label>
                                        <input type="file" name="informal[1][informal_assessment_attch]" id="informal_assessment_attch" class="form-control-file" placeholder="Attach document">
                                    </div>
                                    <div class="col-lg-6 informal-1">
                                        <label for="informal_assessment_link">Create a link</label>
                                        <input type="text" name="informal[1][informal_assessment_link]" id="informal_assessment_link" class="form-control create_link" placeholder="Create a link">
                                    </div>
                                    {{Form::hidden('informal_count', 1,['class' => 'informal-count-1 informal-count', "data-id" => 1])}}
                                    <div class="col-lg-1 informal-1">
                                        <a class="text-primary d-inline-block mt-50 ti-plus add_informal_btn plus_btn"> </a>
                                    </div>
                                </div>
                            </div>
                            <div class="px-3 work-div">
                                <div class="row">
                                    {{Form::hidden('work[1][status]','no',['class'=>'work-1-status'])}}
                                    <div class="col-lg-10">
                                        <label for="student_work" contenteditable="true" id="workLabel">Student Work</label> &nbsp;&nbsp; <a class="ti-minus remove-btn-border remove-data" data-id="work-1" data-status="only-minus" data-label="workLabel"></a>
                                        {{Form::select('work[1][student_work]',[],[], ['id'=>'student_work','placeholder'=>'Student Work', 'class' => 'grade_options student_work work-1'])}}
                                        <span class="form-error d-none student-work-error">This field is required</span>
                                    </div>
                                    <div class="col-lg-2 work-1">
                                        <label for="student_work_duration">&nbsp;&nbsp;</label>
                                        {{Form::select('work[1][student_work_duration]',$monthDays,[], ["id"=>"student_work_duration","placeholder"=>"Duration", "class" => "form-control student_work_duration duration"])}}
                                    </div>
                                    <div class="col-lg-5 work-1">
                                        <label for="student_work_attch">Attach document</label>
                                        <input type="file" name="work[1][student_work_attch]" id="student_work_attch" class="form-control-file" placeholder="Attach document">
                                    </div>
                                    <div class="col-lg-6 work-1">
                                        <label for="student_work_link">Create a link</label>
                                        <input type="text" name="work[1][student_work_link]" id="student_work_link" class="form-control create_link" placeholder="Create a link">
                                    </div>
                                    {{Form::hidden('work_count', 1,['class' => 'work-count-1 work-count', "data-id" => 1])}}
                                    <div class="col-lg-1 work-1">
                                        <a class="text-primary d-inline-block mt-50 ti-plus add_work_btn plus_btn"> </a>
                                    </div>
                                </div>
                            </div>
                            <div class="px-3 formal-div">
                                <div class="row">
                                    {{Form::hidden('formal[1][status]','no',['class'=>'formal-1-status'])}}
                                    <div class="col-lg-10">
                                        <label for="formal_assessment" contenteditable="true" id="formalLabel">Formal Assessment</label> &nbsp;&nbsp; <a class="ti-minus remove-btn-border remove-data" data-id="formal-1" data-status="only-minus" data-label="formalLabel"></a>
                                        {{Form::select('formal[1][formal_assessment]',[],[], ['id'=>'formal_assessment','placeholder'=>'Formal Assessment', 'class' => 'grade_options formal_assessment formal-1'])}}
                                        <span class="form-error d-none formal-error">This field is required</span>
                                    </div>
                                    <div class="col-lg-2 formal-1">
                                        <label for="formal_assessment_duration">&nbsp;&nbsp;</label>
                                        {{Form::select('formal[1][formal_assessment_duration]',$monthDays,[], ["id"=>"formal_assessment_duration","placeholder"=>"Duration", "class" => "form-control formal_assessment_duration duration"])}}
                                    </div>
                                    <div class="col-lg-5 formal-1">
                                        <label for="formal_assessment_attch">Attach document</label>
                                        <input type="file" name="formal[1][formal_assessment_attch]" id="formal_assessment_attch" class="form-control-file" placeholder="Attach document">
                                    </div>
                                    <div class="col-lg-6 formal-1">
                                        <label for="formal_assessment_link">Create a link</label>
                                        <input type="text" name="formal[1][formal_assessment_link]" id="formal_assessment_link" class="form-control create_link" placeholder="Create a link">
                                    </div>
                                    {{Form::hidden('formal_count', 1,['class' => 'formal-count-1 formal-count', "data-id" => 1])}}
                                    <div class="col-lg-1 formal-1">
                                        <a class="text-primary d-inline-block mt-50 ti-plus add_formal_btn plus_btn"> </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="width:100%;margin-top: 10px;"></div>
                        <!-- Rubric -->
                        <h5>Rubric</h5> &nbsp;&nbsp; <a class="ti-minus remove-btn-border remove-data" data-id="rubric-1" data-status="only-minus"></a>
                        {{Form::hidden('rubric_data[1][status]','no',['class'=>'rubric-1-status'])}}
                        <div class="standard-block mb-3 rubric-div rubric-1">
                            <div class="row pl-3 pt-3">
                                <div class="col-lg-8">
                                    <label for="rubric">&nbsp;&nbsp;</label>
                                    {{-- <a class="ti-minus remove-btn-border remove-data" data-id="rubric-1"></a> --}}
                                    {{-- <input type="text" name="rubric_data[1][rubric]" id="rubric" class="form-control" placeholder="Rubric"> --}}
                                    {{Form::select('rubric_data[1][rubric]',[],[], ['id'=>'rubric','placeholder'=>'Rubric', 'class' => 'grade_options rubric'])}}
                                    <span class="form-error d-none rubric-error">This field is required</span>
                                </div>
                                <div class="col-lg-3">
                                    <label for="rubric_attch">Attach document</label>
                                    <input type="file" name="rubric_data[1][rubric_attch]" id="rubric_attch" class="form-control-file" placeholder="Attach document">
                                </div>
                                {{Form::hidden('rubric_count', 1,['class' => 'rubric-count-1 rubric-count', "data-id" => 1])}}
                                <div class="col-lg-1">
                                    <a class="text-primary d-inline-block mt-50 ti-plus add_rubric_btn plus_btn"> </a>
                                </div>
                            </div>
                        </div>
                        <div style="width:100%;margin-top: 10px;"></div>
                        <!-- ------------------------------------------------------------------------------------------------------ -->
                        <h5 contenteditable="true" id="methodLabel">Differentiation</h5>&nbsp; <a class="ti-minus remove-btn-border remove-data" data-id="diff-1" data-status="only-minus" data-label="methodLabel"> </a>
                        {{Form::hidden('method_data[1][status]','no',['class'=>'diff-1-status'])}}
                        <div class="standard-block mb-3 diffs-div diff-1">
                            <div class="row pl-3 pr-3 pt-3">
                                <div class="col-lg-2">
                                    <label for="method_name">Method name</label>
                                    {{Form::select('method_data[1][method_name]',$methodNameData,[],['id'=>'method_value','placeholder'=>'Method name', 'class' => 'grade_options'])}}
                                    <span class="form-error d-none method-name-error">This field is required</span>
                                </div>
                                <div class="col-lg-5">
                                    <label for="method_description">&nbsp;&nbsp;</label>
                                    {{-- <input type="text" name="method_data[1][method_description]"  class="form-control" placeholder="Description"> --}}
                                    {{Form::select('method_data[1][method_description]',$methodDescData,[], ['placeholder'=>'Description', 'class' => 'grade_options'])}}
                                </div>
                                <div class="col-lg-2">
                                    <label for="administering_method">&nbsp;&nbsp;</label>
                                    {{-- <input type="text" name="method_data[1][administering_method]" class="form-control" placeholder="Administered by"> --}}
                                    {{Form::select('method_data[1][administering_method]',[],[], ['id'=>'administering_method','placeholder'=>'Administered by', 'class' => 'grade_options administering_method'])}}
                                </div>
                                <div class="col-lg-2">
                                    <label for="group_served">&nbsp;&nbsp;</label>
                                    {{Form::select('method_data[1][group_served]',[],[], ['id'=>'group_served','placeholder'=>'Group served', 'class' => 'grade_options group_served'])}}
                               </div>
                               {{Form::hidden('method_count', 1,['class' => 'method-count-1 method-count', "data-id" => 1])}}
                                <div class="col-lg-1">
                                    <a class="text-primary d-inline-block  add_diff ti-plus plus_btn"> </a>
                                </div>
                                {{Form::hidden('d_count', 1,['class' => 'd-count-1 dt-count', "data-id" => 1])}}
                            </div>
                        </div>
                        <!-- ------------------------------------------------------------------------------------------------------ -->                
                        <div style="width:100%;margin-top: 10px;"></div>
                        <h5>Homework</h5>
                        <div class="standard-block mb-3">
                            <div class="row p-3">
                                <div class="row col-lg-12 pl-3">
                                    <div class="col-lg-3">
                                        <label for="homework">Homework</label>
                                        {{-- <input type="text" name="home_data[1][homework]" id="homework" class="form-control" placeholder="Homework"> --}}
                                        {{Form::select('home_data[1][homework]',[],[],['id'=>'homework','placeholder'=>'Homework', 'class' => 'grade_options homework'])}}
                                        <span class="form-error d-none homework-error">This field is required</span>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="homework_description">&nbsp;&nbsp;</label>
                                        {{-- <input type="text" name="home_data[1][homework_description]" id="homework_description" class="form-control" placeholder="Description"> --}}
                                        {{Form::select('home_data[1][homework_description]',[],[],['id'=>'homework_description','placeholder'=>'Description', 'class' => 'grade_options homework_description'])}}
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="homework_attch">Attach document</label>
                                        <input type="file" name="home_data[1][homework_attch]" id="homework_attch" class="form-control-file" placeholder="Attach document">
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="homework_due_date">&nbsp;&nbsp;</label>
                                        <input type="text" name="home_data[1][homework_due_date]" id="homework_due_date" class="form-control dateJs" autocomplete="off" placeholder="Due date">
                                        {{Form::hidden('homework_count', 1,['class' => 'homework-count-1 homework-count', "data-id" => 1])}}
                                    </div>
                                    <div class="col-lg-1">
                                        <a class="text-primary d-inline-block mt-50 ti-plus add_home_due_date_btn plus_btn"> </a>
                                    </div>
                                    
                                    <div class="row col-lg-12 homework-due-date">
                                        {{-- More date will be come here --}}
                                    </div>
                                </div>
                                
                                <div class="row col-lg-12 pl-3">
                                    <div class="col-lg-3">
                                        <label for="additional_resources">Additional Resources</label>
                                        {{-- <input type="text" name="additional_data[1][additional_resources]" id="additional_resources" class="form-control" placeholder="Additional Resources"> --}}
                                        {{Form::select('additional_data[1][additional_resources]',[],[],['id'=>'additional_resources','placeholder'=>'Additional Resources', 'class' => 'grade_options additional_resources'])}}
                                        <span class="form-error d-none additional-error">This field is required</span>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="additional_description">&nbsp;&nbsp;</label>
                                        {{-- <input type="text" name="additional_data[1][additional_description]" id="additional_description" class="form-control" placeholder="Description"> --}}
                                        {{Form::select('additional_data[1][additional_description]',[],[],['id'=>'additional_description','placeholder'=>'Additional Description', 'class' => 'grade_options additional_description'])}}
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="additional_attch">Attach document</label>
                                        <input type="file" name="additional_data[1][additional_attch]" id="additional_attch" class="form-control-file" placeholder="Attach document">
                                    </div>
                                    {{Form::hidden('additional_data[1][status]','no',['class'=>'add-due-date-1-status'])}}
                                    <div class="col-lg-2  add-due-date-1">
                                        <label for="additional_duration">&nbsp;&nbsp;</label>
                                        <input type="text" name="additional_data[1][additional_duration]" id="additional_duration" class="form-control dateJs" autocomplete="off" placeholder="Due date">
                                    </div>
                                    <div class="col-lg-1">
                                        <a class="text-primary d-inline-block mt-50 ti-minus plus_btn remove-data" data-id="add-due-date-1" data-status="only-minus"> </a>
                                    </div>
                                </div>    
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button class="btn btn-primary save1"  value="1" data-id="1">Save Lesson</button>
                            <button  class="btn btn-primary save1"  value="2" data-id="2">Save & Print</button>
                            <button  class="btn btn-info save1" data-id="3">Share Lesson</button>
                            {{-- <button  class="btn btn-info save1" value="5" data-id="5">Print Document</button> --}}
                            <a href="{{URL::to('plan')}}" class="btn btn-info">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="sendPlanDetails">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Save & Send Mail</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">      
                    <div class="col-lg-12">
                        <label for="email">Email</label>
                        <input type="text" name="email" class="form-control send-email" placeholder="Email">
                        <span class="form-error d-none email-error mb-2">This field is required</span>
                    </div>
                    <div class="col-lg-12">
                        <a  class="btn btn-danger save1 send-mail send" value="3" data-id="4">Send Mail</a>
                        <button type="button" class="btn btn-danger btn-sm send-mail" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection


@section('script')

<script type="text/javascript">

    $('#grade').selectize({
        create: true,
        sortField: 'text'
    });
    $('.color').selectize();

    $('.grade_options').selectize({
        create: true,
    });
    var selectedGrade = '';
    $(document).ready(function(){
        $('.dateJs').datepicker();

        $("select#grade").change(function(){
            // $('.standard-data').remove();
            // $('.entry-data').remove();
            // $('.notes-data1').remove();
            // $('.informal-data1').remove();
            // $('.work-data1').remove();
            // $('.formal-data1').remove();
            selectedGrade = $("#grade option:selected").val();
            if (!selectedGrade) {
                return false;
            }
            var gradeOptions = {
                1 : "subject", 2 : "unit_topic", 4 : "group_served",
                5 : "standard_name", 6 : "standard_number", 7 : "standard_description",
                8 : "entry_activity", 9 : "notes", 10 : "informal_assessment", 11 : "student_work",
                12 : "formal_assessment", 13 : "teacher_authors",
                16 : "objective", 17 : "vocabulary", 18 : "concept", 19 : "guided_practice",
                20 : "rubric", 22 : "administering_method",
                23 : "homework", 24 : "homework_description", 25 : "additional_resources", 26 : "additional_description",27 : "class",
            };
            get_form_data(selectedGrade, gradeOptions);
        });

        $(document).on('change','select.grade_options',function(){
            storeForm(0,0,1);
        });
        $(document).on('change','select.color',function(){
            var colorCode = $(this).val();
            if(colorCode != '' && typeof colorCode != 'undefined'){
                $('.color-box').css({"background":colorCode,'border-color':colorCode});
            }else{
                $('.color-box').css({"background":"white",'border-color':"#e5e5e5"});
            }
        });
        $(document).on('keyup','.create_link',function(){
            storeForm(0,0,1);
        });
        $(document).on('change','.dateJs',function(){
            storeForm(0,0,1);
        });
        $(document).on('change','select.duration',function(){
            storeForm(0,0,1);
        });
        var wrapperStandard = $('.standard-div'); //Input field wrapper
        $('.add_button').click(function(){
            // var totalStData = $('.st-count').length;
            var totalStData = $('.st-count').last().data('id');
            var finalData = totalStData + 1;
            var fieldHTML = '<div class="row standard-data pl-3 pr-3 m0">'+
                '<div class="col-lg-5">'+
                    '<label for="standard_name">Standard #</label>'+
                    '<select name="standard_data['+finalData+'][standard_name]" id="name-'+finalData+'" class= "s-name-'+finalData+' name-'+finalData+' standard_name"  placeholder="Standard #" required></select>'+
              '</div>'+
                '<div class="col-lg-7">'+
                    '<label for="standard_number">Standard Resource</label>'+
                    '<select name="standard_data['+finalData+'][standard_number]" id="number-'+finalData+'" class= " s-number-'+finalData+' number-'+finalData+' standard_number"  placeholder="Standard resource" required></select>'+
                '</div>'+
                '<div class="col-lg-11">'+
                    '<label for="standard_description">Standard Description</label>'+
                    '<select name="standard_data['+finalData+'][standard_description]"  id="description-'+finalData+'" class= "s-description-'+finalData+' standard_description description-'+finalData+'"  placeholder="Standard Description" required></select>'+
                '</div>'+
                '<div class="col-lg-1">'+
                    '<a class="text-primary d-inline-block mt-50 ti-close remove_button plus_btn"> </a>'+
                '</div>'+
                '<input type="hidden" name="s_count" class= "s-count-'+finalData+' st-count" data-id = '+finalData+'>'+
            '</div>';
            $(wrapperStandard).append(fieldHTML); //Add field html
            var sId = $(".s-count-"+finalData).data('id');
            $('.s-name-'+sId).selectize({
                create: true,
            });
            $('.s-number-'+sId).selectize({
                create: true,
            });
            $('.s-description-'+sId).selectize({
                create: true,
            });
            var gradeOptions = { 5 : "standard_name"};
            var numberData = { 6 : "standard_number"};
            var descriptionData = { 7 : "standard_description"};
            get_form_data(selectedGrade, gradeOptions,5, 'name-'+finalData);
            get_form_data(selectedGrade, numberData,6, 'number-'+finalData);
            get_form_data(selectedGrade, descriptionData,7, 'description-'+finalData);
        });

        var wrapperDiffs = $('.diffs-div'); //Input field wrapper
        //Once add button is clicked
        $('.add_diff').click(function(){
            var methodData = @json($methodNameData);
            var methodDescData = @json($methodDescData);
            // var totalStData = $('.dt-count').last().data('id');
            var totalStData = $('.dt-count').last().data('id');
            var finalData = totalStData + 1;
            var fieldDiffsHTML = '<div class="row standard-data pl-3 pr-3">'+
                '<div class="col-lg-2">'+
                    '<label for="method_name">&nbsp;&nbsp;</label>'+
                    '<select name="method_data['+finalData+'][method_name]" id="method-'+finalData+'" class= "d-name-'+finalData+' method_name method-'+finalData+'" placeholder="Method name" required>';
                        fieldDiffsHTML += '<option value="">Method name</option>';
                        $.each(methodData, function(key, value) {  
                            fieldDiffsHTML +=  '<option value="' + key + '">'+value+'</option>';
                        });
                    fieldDiffsHTML += '</select>'+
                '</div>'+
                '<div class="col-lg-5">'+
                    '<label for="method_description">&nbsp;&nbsp;</label>'+
                    '<select name="method_data['+finalData+'][method_description]" id="method-desc-'+finalData+'" class= "d-name-'+finalData+' method_description method-desc-'+finalData+'" placeholder="Description" required>';
                        fieldDiffsHTML += '<option value="">Method name</option>';
                        $.each(methodDescData, function(key, value) {  
                            fieldDiffsHTML +=  '<option value="' + key + '">'+value+'</option>';
                        });
                    fieldDiffsHTML += '</select>'+
                '</div>'+
                '<div class="col-lg-2">'+
                    '<label for="administering_method">&nbsp;&nbsp;</label>'+
                    '<select name="method_data['+finalData+'][administering_method]" id="admini-'+finalData+'" class= "d-name-'+finalData+' administering_method admini-'+finalData+'" placeholder="Administered by" required></select>'+
                '</div>'+
                '<div class="col-lg-2">'+
                    '<label for="group_served">&nbsp;&nbsp;</label>'+
                    '<select name="method_data['+finalData+'][group_served]" id="group-'+finalData+'" class= "d-name-'+finalData+' group-'+finalData+' group_served" placeholder="Group served" required></select>'+
                '</div>'+
                '<div class="col-lg-1">'+
                    '<a class="text-primary d-inline-block mt-50 ti-close remove_button plus_btn"> </a>'+
                '</div>'+
                '<input type="hidden" name="d_count" class= "d-count-'+finalData+' dt-count" data-id = '+finalData+'>'+
            '</div>';
            $(wrapperDiffs).append(fieldDiffsHTML); //Add field html
            var sId = $(".d-count-"+finalData).data('id');
            $('.d-name-'+sId).selectize({
                create: true,
            });
            // var methodData = { 3 : "method_name"};
            var groupData = { 4 : "group_served"};
            // var descData = { 21 : "method_name"};
            var adminData = { 22 : "group_served"};
            // get_form_data(selectedGrade, methodData,3, 'method-'+finalData);
            get_form_data(selectedGrade, groupData,4, 'group-'+finalData);
            // get_form_data(selectedGrade, descData,21, 'method-desc-'+finalData);
            get_form_data(selectedGrade, adminData,22, 'admini-'+finalData);
        });

        var wrapperRubric = $('.rubric-div');
        $('.add_rubric_btn').click(function(){
            var lastRubricData = $('.rubric-count').last().data('id');
            var finalData = lastRubricData + 1;
            var rubricHTML = '<div class="row pl-3 m0">'+
                '<div class="col-lg-8">'+
                    '<label for="rubric">&nbsp;&nbsp;</label>'+
                    '<select name="rubric_data['+finalData+'][rubric]" id="rubric-'+finalData+'" class= "rb-'+finalData+' rubric rubric-'+finalData+'" placeholder="Rubric" required></select>'+
                '</div>'+
                '<div class="col-lg-3">'+
                    '<label for="rubric_attch">&nbsp;&nbsp;</label>'+
                    '<input type="file" name="rubric_data['+finalData+'][rubric_attch]" id="rubric_attch" class=" form-control-file" placeholder="Attach document" required>'+
                '</div>'+
                '<div class="col-lg-1">'+
                    '<a class="text-primary d-inline-block mt-50 ti-close remove_button plus_btn"> </a>'+
                '</div>'+
                '<input type="hidden" name="rubric_count" class= "rubric-count-'+finalData+' rubric-count" data-id = '+finalData+'>'+
            '<div>';
            $(wrapperRubric).append(rubricHTML);
            var rubricId = $(".rubric-count-"+finalData).data('id');
            $('.rb-'+rubricId).selectize({
                create: true,
            });
            var rubricData = { 20 : "rubric"};
            get_form_data(selectedGrade, rubricData, 20, 'rubric-'+finalData);
        });

        var wrapperEntry = $('.entry-div');
        $('.add_entry_btn').click(function(){
            var lastEntryData = $('.entry-count').last().data('id');
            var finalData = lastEntryData + 1;
            var duration_name = 'entry_data['+finalData+'][entry_duration]';
            var duration_id = 'entry_duration'+finalData;
            var entryHTML = '<div class="row pl-3 pr-3 m0 entry-data">'+
                '<div class="col-lg-10">'+
                    '<label for="entry_activity">&nbsp;&nbsp;</label>'+
                    '<select name="entry_data['+finalData+'][entry_activity]" id="entry-'+finalData+'" class= "e-activity-'+finalData+' entry-'+finalData+' entry_activity"  placeholder="Entry Activity" required></select>'+
                '</div>'+
                '<div class="col-lg-2">'+
                    '<label for="entry_duration">&nbsp;&nbsp;</label>' + getMonthData(duration_name, duration_id) +
                '</div>'+
                '<div class="col-lg-5">'+
                    '<label for="entry_attch">Attach document</label>'+
                    '<input type="file" name="entry_data['+finalData+'][entry_attch]" id="entry_attch" class="form-control-file" placeholder="Attach document" required>'+
                '</div>'+
                '<div class="col-lg-6">'+
                    '<label for="entry_link">Create a link</label>'+
                    '<input type="text" name="entry_data['+finalData+'][entry_link]" id="entry_link" class="form-control create_link" placeholder="Create a link" required>'+
                '</div>'+
                '<div class="col-lg-1">'+
                    '<a class="text-primary d-inline-block mt-50 ti-close remove_button plus_btn"> </a>'+
                '</div>'+
                '<input type="hidden" name="entry_count" class= "entry-count-'+finalData+' entry-count" data-id = '+finalData+'>'+
            '<div>';
            $(wrapperEntry).append(entryHTML);
            var entryId = $(".entry-count-"+finalData).data('id');
            $('.e-activity-'+entryId).selectize({
                create: true,
            });
            var entryData = { 8 : "entry_activity"};
            get_form_data(selectedGrade, entryData, 8, 'entry-'+finalData);

        });

        var wrapperLearning = $('.objective-div');
        $('.add_learning_btn').click(function(){
            var lastObjId = $('.learning-count').last().data('id');
            var finalData = lastObjId + 1;
            var learningHTML = '<div class="row pl-3 pr-3 m0">'+
                '<div class="col-lg-11">'+
                    '<label for="objective">&nbsp;&nbsp;</label>'+
                    '<select name="objective_data['+finalData+'][objective]" id="objective-'+finalData+'" class= "obj-'+finalData+' objective-'+finalData+' objective"  placeholder="Select learning target/objective" required></select>'+
                '</div>'+
                '<div class="col-lg-1">'+
                    '<a class="text-primary d-inline-block mt-50 ti-close remove_button plus_btn"> </a>'+
                '</div>'+
                '<input type="hidden" name="learning" class= "learning-count-'+finalData+' learning-count" data-id = '+finalData+'>'+
            '<div>';
            $(wrapperLearning).append(learningHTML);
            var objectiveId = $(".learning-count-"+finalData).data('id');
            $('.obj-'+objectiveId).selectize({
                create: true,
            });
            var objData = { 16 : "objective"};
            get_form_data(selectedGrade, objData, 16, 'objective-'+finalData);
        });


        var wrapperNotes = $('.notes-div');
        $('.add_notes_btn').click(function(){
            var lasNotesData = $('.notes-count').last().data('id');
            var finalData = lasNotesData + 1;
            var duration_name = 'notes_data['+finalData+'][notes_duration]';
            var duration_id = 'notes_duration'+finalData;
            var notesHTML = '<div class="row notes-1 notes-data1">'+
                '<div class="col-lg-10">'+
                    '<label for="notes">Notes</label>'+
                    '<select name="notes_data['+finalData+'][notes]" id="notes-'+finalData+'" class= "nt-'+finalData+' notes-'+finalData+' notes"  placeholder="Notes" required></select>'+
                '</div>'+
                '<div class="col-lg-2">'+
                    '<label for="notes_duration">&nbsp;&nbsp;</label>'+ getMonthData(duration_name, duration_id) +
                '</div>'+
                '<div class="col-lg-5">'+
                    '<label for="notes_attch">Attach document</label>'+
                    '<input type="file" name="notes_data['+finalData+'][notes_attch]" id="notes_attch" class="form-control-file" placeholder="Attach document" required>'+
                '</div>'+
                '<div class="col-lg-6">'+
                    '<label for="notes_link">Create a link</label>'+
                    '<input type="text" name="notes_data['+finalData+'][notes_link]" id="notes_link" class="form-control create_link" placeholder="Create a link" required>'+
                '</div>'+
                '<input type="hidden" name="notes_count" class= "notes-count-'+finalData+' notes-count" data-id = '+finalData+'>'+
                '<div class="col-lg-1">'+
                    '<a class="text-primary d-inline-block mt-50 ti-close remove_button plus_btn"> </a>'+
                '</div>'+
            '<div>';
            $(wrapperNotes).append(notesHTML);
            var notesId = $(".notes-count-"+finalData).data('id');
            $('.nt-'+notesId).selectize({
                create: true,
            });
            var notesData = { 9 : "notes"};
            get_form_data(selectedGrade, notesData, 9, 'notes-'+finalData);
        });

        var wrapperVocabylary = $('.vocabulary-div');
        $('.add_vocabulary_btn').click(function(){
            var lasVocaData = $('.vocabulary-count').last().data('id');
            var finalData = lasVocaData + 1;
            var duration_name = 'vocabulary_data['+finalData+'][vocabulary_duration]';
            var duration_id = 'vocabulary_duration'+finalData;
            var vocabylaryHTML = '<div class="row vocabulary-1">'+
                '<div class="col-lg-10">'+
                    '<label for="vocabulary">Vocabulary</label>'+
                    '<select name="vocabulary_data['+finalData+'][vocabulary]" id="vocabulary-'+finalData+'" class= "voca-'+finalData+' vocabulary-'+finalData+' vocabulary"  placeholder="Vocabulary" required></select>'+
                '</div>'+
                '<div class="col-lg-2">'+
                    '<label for="vocabulary_duration">&nbsp;&nbsp;</label>'+  getMonthData(duration_name, duration_id) +
                '</div>'+
                '<div class="col-lg-5">'+
                    '<label for="vocabulary_attch">Attach document</label>'+ 
                    '<input type="file" name="vocabulary_data['+finalData+'][vocabulary_attch]" id="vocabulary_attch" class="form-control-file" placeholder="Attach document" required>'+
                '</div>'+
                '<div class="col-lg-6">'+
                    '<label for="vocabulary_link">Create a link</label>'+
                    '<input type="text" name="vocabulary_data['+finalData+'][vocabulary_link]" id="vocabulary_link" class="form-control create_link" placeholder="Create a link" required>'+
                '</div>'+
                '<input type="hidden" name="vocabulary_count" class= "vocabulary-count-'+finalData+' vocabulary-count" data-id = '+finalData+'>'+
                '<div class="col-lg-1">'+
                    '<a class="text-primary d-inline-block mt-50 ti-close remove_button plus_btn"> </a>'+
                '</div>'+
            '<div>';
            $(wrapperVocabylary).append(vocabylaryHTML);
            var vocabularyId = $(".vocabulary-count-"+finalData).data('id');
            $('.voca-'+vocabularyId).selectize({
                create: true,
            });
            var vocabularyData = { 17 : "vocabulary"};
            get_form_data(selectedGrade, vocabularyData, 17, 'vocabulary-'+finalData);
        });

        var wrapperConcept = $('.concept-div');
        $('.add_concept_btn').click(function(){
            var lastConceptData = $('.concept-count').last().data('id');
            var finalData = lastConceptData + 1;
            var duration_name = 'concept_data['+finalData+'][concept_duration]';
            var duration_id = 'concept_duration'+finalData;
            var conceptHTML = '<div class="row concept-1">'+
                '<div class="col-lg-10">'+
                    '<label for="concept">Concept Demonstration</label>'+
                    '<select name="concept_data['+finalData+'][concept]" id="concept-'+finalData+'" class= "conc-'+finalData+' concept-'+finalData+' concept"  placeholder="Concept Demonstration" required></select>'+
                '</div>'+
                '<div class="col-lg-2">'+
                    '<label for="concept_duration">&nbsp;&nbsp;</label>'+ getMonthData(duration_name, duration_id) +
                '</div>'+
                '<div class="col-lg-5">'+
                    '<label for="concept_attch">Attach document</label>'+
                    '<input type="file" name="concept_data['+finalData+'][concept_attch]" id="concept_attch" class="form-control-file" placeholder="Attach document" required>'+
                '</div>'+
                '<div class="col-lg-6">'+
                    '<label for="concept_link">Create a link</label>'+
                    '<input type="text" name="concept_data['+finalData+'][concept_link]" id="concept_link" class="form-control create_link" placeholder="Create a link" required>'+
                '</div>'+
                '<input type="hidden" name="concept_count" class= "concept-count-'+finalData+' concept-count" data-id = '+finalData+'>'+
                '<div class="col-lg-1">'+
                    '<a class="text-primary d-inline-block mt-50 ti-close remove_button plus_btn"> </a>'+
                '</div>'+
            '<div>';
            $(wrapperConcept).append(conceptHTML);
            var conceptId = $(".concept-count-"+finalData).data('id');
            $('.conc-'+conceptId).selectize({
                create: true,
            });
            var conceptData = { 18 : "concept"};
            get_form_data(selectedGrade, conceptData, 18, 'concept-'+finalData);
        });

        var wrapperGuided = $('.guided-div');
        $('.add_guided_btn').click(function(){
            var lastGuidedData = $('.guided-count').last().data('id');
            var finalData = lastGuidedData + 1;
            var duration_name = 'guided_data['+finalData+'][guided_duration]';
            var duration_id = 'guided_duration'+finalData;
            var guidedHTML = '<div class="row guided-1">'+
                '<div class="col-lg-10">'+
                    '<label for="guided_practice">Guided Practice</label>'+
                    '<select name="guided_data['+finalData+'][guided_practice]" id="guided_practice-'+finalData+'" class= "gd-'+finalData+' guided_practice-'+finalData+' guided_practice"  placeholder="Guided Practice" required></select>'+
                '</div>'+
                '<div class="col-lg-2">'+
                    '<label for="guided_duration">&nbsp;&nbsp;</label>'+ getMonthData(duration_name, duration_id) +
                '</div>'+
                '<div class="col-lg-5">'+
                    '<label for="guided_attch">Attach document</label>'+
                    '<input type="file" name="guided_data['+finalData+'][guided_attch]" id="guided_attch" class="form-control-file" placeholder="Attach document" required>'+
                '</div>'+
                '<div class="col-lg-6">'+
                    '<label for="guided_link">Create a link</label>'+
                    '<input type="text" name="guided_data['+finalData+'][guided_link]" id="guided_link" class="form-control create_link" placeholder="Create a link" required>'+
                '</div>'+
                '<input type="hidden" name="guided_count" class= "guided-count-'+finalData+' guided-count" data-id = '+finalData+'>'+
                '<div class="col-lg-1">'+
                    '<a class="text-primary d-inline-block mt-50 ti-close remove_button plus_btn"> </a>'+
                '</div>'+
            '<div>';
            $(wrapperGuided).append(guidedHTML);
            var guidedId = $(".guided-count-"+finalData).data('id');
            $('.gd-'+guidedId).selectize({
                create: true,
            });
            var guidedData = { 19 : "guided_practice"};
            get_form_data(selectedGrade, guidedData, 19, 'guided_practice-'+finalData);
        });

        var wrapperInformal = $('.informal-div');
        $('.add_informal_btn').click(function(){
            var lastInformalCount = $('.informal-count').last().data('id');
            var finalData = lastInformalCount + 1;
            var durationData = getMonthData('informal['+finalData+'][informal_assessment_duration]', 'informal_assessment_duration'+finalData);
            var informalHTML = informal_html(finalData, durationData);
            $(wrapperInformal).append(informalHTML);
            var infomalId = $(".informal-count-"+finalData).data('id');
            $('.i-informal-'+infomalId).selectize({
                create: true,
            });
            var informal1Data = { 10 : "informal_assessment"};
            get_form_data(selectedGrade, informal1Data, 10, 'informal-'+finalData);
        });

        var wrapperWork = $('.work-div');
        $('.add_work_btn').click(function(){
            var lastWorkCount = $('.work-count').last().data('id');
            var finalData = lastWorkCount + 1;
            var durationData = getMonthData('work['+finalData+'][student_work_duration]', 'student_work_duration'+finalData);
            var workHTML =  work_html(finalData, durationData);
            $(wrapperWork).append(workHTML);
            var stdWorkId = $(".work-count-"+finalData).data('id');
            $('.s-work-'+stdWorkId).selectize({
                create: true,
            });
            var work1Data = { 11 : "student_work"};
            get_form_data(selectedGrade, work1Data, 11, 'work-'+finalData);
        });

        var wrapperFormal = $('.formal-div');
        $('.add_formal_btn').click(function(){
            var lastFormalCount = $('.formal-count').last().data('id');
            var finalData = lastFormalCount + 1;
            var durationData = getMonthData('formal['+finalData+'][formal_assessment_duration]', 'formal_assessment_duration'+finalData);
            var formalHTML = formal_html(finalData, durationData);
            $(wrapperFormal).append(formalHTML);
            var formalId = $(".formal-count-"+finalData).data('id');
            $('.i-formal-'+formalId).selectize({
                create: true,
            });
            var informal1Data = { 12 : "formal_assessment"};
            get_form_data(selectedGrade, informal1Data, 12, 'formal-'+finalData);
        });


        $('.add-assessments-block').click(function(){
            var dataId = $(this).data('id');
            if($('.'+dataId).hasClass('d-none')){
                $('.'+dataId+'-status').val('no');
                $('.'+dataId).removeClass('d-none');
                return true;
            }
            var lastInformalCount = $('.informal-count').last().data('id');
            var finalData1 = lastInformalCount + 1;
            var durationData1 = getMonthData('informal['+finalData1+'][informal_assessment_duration]', 'informal_assessment_duration'+finalData1);
            var informalHTML1 = informal_html(finalData1, durationData1);


            var lastWorkCount = $('.work-count').last().data('id');
            var finalData2 = lastWorkCount + 1;
            var durationData2 = getMonthData('work['+finalData2+'][student_work_duration]', 'student_work_duration'+finalData2);
            var workHTML1 =  work_html(finalData2, durationData2);


            var lastFormalCount = $('.formal-count').last().data('id');
            var finalData3 = lastFormalCount + 1;
            var durationData3 = getMonthData('formal['+finalData3+'][formal_assessment_duration]', 'formal_assessment_duration'+finalData3);

            var formalHTML1 = formal_html(finalData3, durationData3);
            if (!isEmpty(wrapperInformal)) {
                $(wrapperInformal).append(informalHTML1);
                var infomalId = $(".informal-count-"+finalData1).data('id');
                $('.i-informal-'+infomalId).selectize({
                    create: true,
                });
                var informal1Data = { 10 : "informal_assessment"};
                get_form_data(selectedGrade, informal1Data, 10, 'informal-'+finalData1);
            }
            if (!isEmpty(wrapperWork)) {
                $(wrapperWork).append(workHTML1);
                var stdWorkId = $(".work-count-"+finalData2).data('id');
                $('.s-work-'+stdWorkId).selectize({
                    create: true,
                });
                var work1Data = { 11 : "student_work"};
                get_form_data(selectedGrade, work1Data, 11, 'work-'+finalData2);
                }
            if (!isEmpty(wrapperFormal)) {
                $(wrapperFormal).append(formalHTML1);
                var formalId = $(".formal-count-"+finalData3).data('id');
                $('.i-formal-'+formalId).selectize({
                    create: true,
                });
                var informal1Data = { 12 : "formal_assessment"};
                get_form_data(selectedGrade, informal1Data, 12, 'formal-'+finalData3);
            }
        });



        var wrapperHomeDue = $('.homework-due-date');
        $('.add_home_due_date_btn').click(function(){
            var lastDueCount = $('.homework-count').last().data('id');
            var finalData = lastDueCount + 1;
            var homeDueDateHTML =
            '<div class="col-lg-2">'+
                '<label for="homework_due_date">&nbsp;&nbsp;</label>'+
                '<input type="text" name="home_data['+finalData+'][homework_due_date]" id="homework_due_date'+finalData+'" class="form-control dateJs" autocomplete="off" placeholder="Due date" required>'+
                '<input type="hidden" name="homework_count" class= "homework-count-'+finalData+' homework-count" data-id = '+finalData+'>'+
            '</div>';
            $(wrapperHomeDue).append(homeDueDateHTML);
            $('.dateJs').datepicker();

        });


        //Remove section
        $(document).on('click', '.remove-data', function(e){
            var status = $(this).data('status');
            var dStatus = $(this).data('id');
            var attr = $('#'+$(this).data('label')).attr('contenteditable');
            if($('.'+$(this).data('id')).hasClass('d-none')){
                $('.'+dStatus+'-status').val('no');
                if(status != 'main'){
                    $('.'+$(this).data('id')).removeClass('d-none');
                }
                if(status == 'only-minus' && typeof status != 'undefined'){
                    $(this).addClass('ti-minus');
                    $(this).removeClass('ti-plus');
                }
                var checkAttr = $('#'+$(this).data('label'));
                if (typeof checkAttr !== typeof undefined && checkAttr !== false) {
                    $('#'+$(this).data('label')).attr('contenteditable','true');
                }
            }else{
                $('.'+dStatus+'-status').val('yes');
                $('.'+$(this).data('id')).addClass('d-none');
                if(status == 'only-minus' && typeof status != 'undefined'){
                    $(this).removeClass('ti-minus');
                    $(this).addClass('ti-plus');
                }
                if (typeof attr !== typeof undefined && attr !== false) {
                    $('#'+$(this).data('label')).removeAttr('contenteditable');
                }
            }
        });

        //Once remove button is clicked
        $(".row").on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent().parent('div').remove(); //Remove field html
        });

        $(document).on('click','.save1',function(e){
            e.preventDefault();
            var dId = $(this).data('id');
            var status = 0;
            $('.teacher-error').addClass('d-none');
            $('.date-error').addClass('d-none');
            $('.sub-error').addClass('d-none');
            $('.grade-error').addClass('d-none');
            $('.unit-error').addClass('d-none');
            $('.unit-topic-error').addClass('d-none');
            $('.lesson-error').addClass('d-none');
            $('.standard-error').addClass('d-none');
            $('.entry-error').addClass('d-none');
            $('.notes-error').addClass('d-none');
            $('.vocabulary-error').addClass('d-none');
            $('.concept-error').addClass('d-none');
            $('.guided-error').addClass('d-none');
            $('.informal-error').addClass('d-none');
            $('.student-work-error').addClass('d-none');
            $('.formal-error').addClass('d-none');
            $('.rubric-error').addClass('d-none');
            $('.method-name-error').addClass('d-none');
            $('.homework-error').addClass('d-none');
            $('.additional-error').addClass('d-none');
            
            var tAuthors = $('#teacher_authors').val();
            if(tAuthors == ''){
                $('.teacher-error').removeClass('d-none');
                status = 1;
            }
            var sDate = $('#s_date').val();
            if(sDate == ''){
                $('.date-error').removeClass('d-none');
                status = 1;
            }
            var subject = $('select#subject').val();
            if(subject == ''){
                $('.sub-error').removeClass('d-none');
                status = 1;
            }
            var grade = $('#grade').val();
            if(grade == ''){
                $('.grade-error').removeClass('d-none');
                status = 1;
            }
            var unit = $('#unit').val();
            if(unit == ''){
                $('.unit-error').removeClass('d-none');
                status = 1;
            }
            var unitTopic = $('select#unit_topic').val();
            if(unitTopic == ''){
                $('.unit-topic-error').removeClass('d-none');
                status = 1;
            }
            var lession = $('#lesson').val();
            if(lession == ''){
                $('.lesson-error').removeClass('d-none');
                status = 1;
            }
            var standard_name = $('#standard_name').val();
            var standard_status = $('.standard-1-status').val();
            if(standard_name == '' && standard_status == 'no'){
                $('.standard-error').removeClass('d-none');
                status = 1;
            }
            var entry_activity = $('#entry_activity').val();
            var entry_activity_status = $('.entry-1-status').val();
            if(entry_activity == '' && entry_activity_status == 'no'){
                $('.entry-error').removeClass('d-none');
                status = 1;
            }

            var notes = $('#notes').val();
            var notes_status = $('.notes-1-status').val();
            if(notes == '' && notes_status == 'no'){
                $('.notes-error').removeClass('d-none');
                status = 1;
            }
            var vocabulary = $('#vocabulary').val();
            var vocabulary_status = $('.vocabulary-1-status').val();
            if(vocabulary == '' && vocabulary_status == 'no'){
                $('.vocabulary-error').removeClass('d-none');
                status = 1;
            }
            var concept = $('#concept').val();
            var concept_status = $('.concept-1-status').val();
            if(concept == '' && concept_status == 'no'){
                $('.concept-error').removeClass('d-none');
                status = 1;
            }
            var guided = $('#guided_practice').val();
            var guided_status = $('.guided-1-status').val();
            if(guided == '' && guided_status == 'no'){
                $('.guided-error').removeClass('d-none');
                status = 1;
            }
            var informal = $('#informal_assessment').val();
            var main_informal = $('.assessment-1-status').val();
            var informal_status = $('.informal-1-status').val();
            if(informal == '' && informal_status == 'no' && main_informal == 'no'){
                $('.informal-error').removeClass('d-none');
                status = 1;
            }
            var std_work = $('#student_work').val();
            var student_status = $('.work-1-status').val();
            if(std_work == '' && student_status == 'no' && main_informal == 'no'){
                $('.student-work-error').removeClass('d-none');
                status = 1;
            }
            var formal = $('#formal_assessment').val();
            var formal_status = $('.formal-1-status').val();
            if(formal == '' && formal_status == 'no' && main_informal == 'no'){
                $('.formal-error').removeClass('d-none');
                status = 1;
            }
            var rubric = $('#rubric').val();
            var rubric_status = $('.rubric-1-status').val();
            if(rubric == '' && rubric_status == 'no'){
                $('.rubric-error').removeClass('d-none');
                status = 1;
            }
            var method_name = $('#method_value').val();
            var method_status = $('.diff-1-status').val();
            if(method_name == '' && method_status == 'no'){
                $('.method-name-error').removeClass('d-none');
                status = 1;
            }
            var homework = $('#homework').val();
            if(homework == ''){
                $('.homework-error').removeClass('d-none');
                status = 1;
            }
            var additional = $('#additional_resources').val();
            if(additional == ''){
                $('.additional-error').removeClass('d-none');
                status = 1;
            }
            if(status == 1){
                $('html, body').animate({
                    scrollTop: ($('.grade-error').offset().top - 150)
                }, 1000);
                return false;
            }

            if(dId == 3){
                $('#sendPlanDetails').modal('show');
                return true;
            }
            if(dId == 4){
                $('.send-mail').addClass('disabled');
                $('.email-error').addClass('d-none');
                $('.send-mail').removeClass('m-0');
                if($('.send-email').val() == ''){
                    $('.send-mail').addClass('m-0');
                    $('.email-error').removeClass('d-none');
                    $('.send-mail').removeClass('disabled');
                    return false;
                }
            }
            var typeSubmit = $(this).val();
            storeForm(dId,typeSubmit,0);
        });
    });

    function informal_html(finalData, durationData){
        return  '<div class="row informal-div informal-1 informal-data1">'+
            '<div class="col-lg-10">'+
                '<label for="informal_assessment">Informal Assessment</label>'+
                '<select name="informal['+finalData+'][informal_assessment]" id="informal-'+finalData+'" class= "i-informal-'+finalData+' informal-'+finalData+' informal_assessment"  placeholder="Informal Assessment" required></select>'+
            '</div>'+
            '<div class="col-lg-2">'+
                '<label for="informal_assessment_duration">&nbsp;&nbsp;</label>'+ durationData +
            '</div>'+
            '<div class="col-lg-5">'+
                '<label for="informal_assessment_attch">Attach document</label>'+
                '<input type="file" name="informal['+finalData+'][informal_assessment_attch]" id="informal_assessment_attch" class="form-control-file" placeholder="Attach document" required>'+
            '</div>'+
            '<div class="col-lg-6">'+
                '<label for="informal_assessment_link">Create a link</label>'+
                '<input type="text" name="informal['+finalData+'][informal_assessment_link]" id="informal_assessment_link" class="form-control create_link" placeholder="Create a link" required>'+
            '</div>'+
            '<input type="hidden" name="informal_count" class= "informal-count-'+finalData+' informal-count" data-id = '+finalData+'>'+
            '<div class="col-lg-1">'+
                '<a class="text-primary d-inline-block mt-50 ti-close remove_button plus_btn"> </a>'+
            '</div>'+
        '<div>';
    }

    function work_html(finalData, durationData) {
        return  '<div class="row work-div work-1 work-data1">'+
            '<div class="col-lg-10">'+
                '<label for="student_work">Student Work</label>'+
                '<select name="work['+finalData+'][student_work]" id="work-'+finalData+'" class= "s-work-'+finalData+' work-'+finalData+' student_work" placeholder="Student Work" required></select>'+
            '</div>'+
            '<div class="col-lg-2">'+
                '<label for="student_work_duration">&nbsp;&nbsp;</label>'+ durationData +
            '</div>'+
            '<div class="col-lg-5">'+
                '<label for="student_work_attch">Attach document</label>'+
                '<input type="file" name="work['+finalData+'][student_work_attch]" id="student_work_attch" class="form-control-file" placeholder="Attach document" required>'+
            '</div>'+
            '<div class="col-lg-6">'+
                '<label for="student_work_link">Create a link</label>'+
                '<input type="text" name="work['+finalData+'][student_work_link]" id="student_work_link" class="form-control create_link" placeholder="Create a link" required>'+
            '</div>'+
            '<input type="hidden" name="work_count" class= "work-count-'+finalData+' work-count" data-id = '+finalData+'>'+
            '<div class="col-lg-1">'+
                '<a class="text-primary d-inline-block mt-50 ti-close remove_button plus_btn"> </a>'+
            '</div>'+
        '<div>';
    }

    function formal_html(finalData, durationData) {
        return '<div class="row formal-div formal-1 formal-data1">'+
            '<div class="col-lg-10">'+
                '<label for="formal_assessment">Formal Assessment</label>'+
                '<select name="formal['+finalData+'][formal_assessment]" id="formal-'+finalData+'" class= "i-formal-'+finalData+' formal-'+finalData+' formal_assessment" placeholder="Formal Assessment" required></select>'+
            '</div>'+
            '<div class="col-lg-2">'+
                '<label for="formal_assessment_duration">&nbsp;&nbsp;</label>'+ durationData +
            '</div>'+
            '<div class="col-lg-5">'+
                '<label for="formal_assessment_attch">Attach document</label>'+
                '<input type="file" name="formal['+finalData+'][formal_assessment_attch]" id="formal_assessment_attch" class="form-control-file" placeholder="Attach document" required>'+
            '</div>'+
            '<div class="col-lg-6">'+
                '<label for="formal_assessment_link">Create a link</label>'+
                '<input type="text" name="formal['+finalData+'][formal_assessment_link]" id="formal_assessment_link" class="form-control create_link" placeholder="Create a link" required>'+
            '</div>'+
            '<input type="hidden" name="formal_count" class= "formal-count-'+finalData+' formal-count" data-id = '+finalData+'>'+
            '<div class="col-lg-1">'+
                '<a class="text-primary d-inline-block mt-50 ti-close remove_button plus_btn"> </a>'+
            '</div>'+
        '<div>';
    }

    function getMonthData(duration_name, duration_id){
        var entryMinutes = {!! json_encode($monthDays) !!};
        var entryDuration= '';
        entryDuration += '<select name="'+duration_name+'" id="'+duration_id+'" class="form-control duration" placeholder="Duration"  required>';
        entryDuration +=  '<option value="">Duration</option>';
        $.each(entryMinutes, function(key, value) {
            entryDuration +=  '<option value="' + key + '">'+value+'</option>';
        });
        entryDuration += "</select>";
        return entryDuration;
    }

    function isEmpty( el ){
        return !$.trim(el.html())
    }

    function set_grade_options(object, field_type) {
        $.each(object, function( key, Responsevalue ) {
            var $select = $(document.getElementsByClassName(field_type));
            $.each($select, function( key1, value ) {
                if (value.selectize != undefined) {
                    var selectize = value.selectize;
                    selectize.addOption({value: Responsevalue.name, text: Responsevalue.name});
                    selectize.addItem(Responsevalue.name);    
                }
            });
            // var $select = $(document.getElementById(field_type));
            // var selectize = $select[0].selectize;
            // selectize.addOption({value: Responsevalue.name, text: Responsevalue.name});
            // selectize.addItem(Responsevalue.name);                  
        });
    }

    function get_form_data(selectedGrade, gradeOptions,isIndex='', isId = '') {
        $.ajax({
            type: "post",
            url: "{{ route('get-grade-options') }}",
            data: {
                _token: "{{ csrf_token() }}",
                grade: selectedGrade,
            }, success: function(data){
                var indexNumber = 1;
                var isRecentId = '';
                var totalLen = Object.keys(gradeOptions).length;
                if(isIndex != ''){ 
                    indexNumber = isIndex;
                    totalLen = isIndex;
                }
                for (let index = indexNumber; index <= totalLen ; index++) {
                    isRecentId = gradeOptions[index];
                    if(isId != ''){
                        isRecentId =isId;
                    }
                    // var $select = $(document.getElementById(isRecentId));
                    // var selectize = $select[0].selectize;
                    // selectize.clear();
                    // selectize.clearOptions();
                    var $select = $(document.getElementsByClassName(isRecentId));
                    $.each($select, function( key1, value ) {
                        if (value.selectize != undefined) {
                            var selectize = value.selectize;
                            selectize.clear();
                            selectize.clearOptions();
                        }
                    });
                    set_grade_options(data[index], isRecentId);
                }
            }
        });
    }


    function storeForm(dId,typeSubmit,isDraft) {
        var formData = new FormData($(".lession-form")[0]);
        var objectiveLabel = $('#objectiveLabel').text();
        var standardsLabel = $('#standardsLabel').text();
        var entryLabel = $('#entryLabel').text();
        var notesLabel = $('#notesLabel').text();
        var vocabularyLabel = $('#vocabularyLabel').text();
        var conceptLabel = $('#conceptLabel').text();
        var guidedLabel = $('#guidedLabel').text();
        var informalLabel = $('#informalLabel').text();
        var workLabel = $('#workLabel').text();
        var formalLabel = $('#formalLabel').text();
        var methodLabel = $('#methodLabel').text();
        var mail = $('.send-email').val();

        formData.append('objectiveLabel', objectiveLabel);
        formData.append('standardsLabel', standardsLabel);
        formData.append('objectiveLabel', objectiveLabel);
        formData.append('entryLabel', entryLabel);
        formData.append('notesLabel', notesLabel);
        formData.append('vocabularyLabel', vocabularyLabel);
        formData.append('conceptLabel', conceptLabel);
        formData.append('guidedLabel', guidedLabel);
        formData.append('informalLabel', informalLabel);
        formData.append('workLabel', workLabel);
        formData.append('formalLabel', formalLabel);
        formData.append('methodLabel', methodLabel);
        formData.append('email',mail);
        formData.append('is_draft',isDraft);
        
        if(dId == 5) {
            formData.append('print_document', 1);
        }
        if(typeSubmit == 2) {
            formData.append('print', 1);
        }else {
            formData.append('print', 0);
        }

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'{{URL::to("add-plan-form")}}',
            type:'POST',
            async: false,
            enctype: 'multipart/form-data',
            dataType:'json',
            data:formData,
            cache: false,
            contentType: false,
            processData: false,
        }).done(function(data){
            if(data.status == 'true'){
                $('.plan-id').val(data.id);
                if (data.last_id) {
                    window.open('{{URL::to("pdf") }}' + '/'+  data.last_id, '_blank');
                } else if (data.print_document == 1) {
                    newWin= window.open('', "_blank");
                    newWin.document.write(data.plan);
                    setTimeout(function() {
                        newWin.print();
                    }, 3000);
                }else if(data.isDraft){
                    return true;
                }else {
                    window.location.href = '{{URL::to("plan")}}';
                    // window.open('{{URL::to("plan")}}', '_blank');

                }
            }else{
                location.reload();
            }
        });
    }


    
</script>
@endsection

