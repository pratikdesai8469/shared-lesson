@extends('layouts.website.main')

@section('css')
<style>

    .plus_btn {
        margin-top: 35px;
        border: 1px solid red;
        padding: 7px;
    }

    .standard-block {
        border: 1px solid #a4b8bd;
        width: 100%;

    }
    .diff_button {
        border: 1px solid red;
        padding: 3px;
    }

    .form-control::-webkit-input-placeholder {
        color: #bbb;
    }
    .duration {
        color: #bbb;
    }
    .std_link {
        color: blue !important;
    }

    </style>
@endsection
@section('content')
<section class="page-title overlay" style="background-image: url({{ asset('public/website/images/background/page-title.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="text-white font-weight-bold">View Form</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="#">Home</a>
                    </li>
                    <li>View Form</li>
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
            <div class="col-lg-10 ">
                <div class="p-5 rounded box-shadow">
                    <h4 class="text-color mb-40">
                        View Form
                        <p class="float-sm-right" >
                           <a href="{{url('/edit-plan-form')}}/{{encrypt($plan['id'])}}"> <button type="button" class="btn btn-primary btn-sm">Edit</button></a>
                           <a href="{{url('delete-plan/'.encrypt($plan['id']))}}" onclick="return confirm('Are you sure you want to delete this item?');"><button type="button" class="btn btn-primary btn-sm">Delete</button></a>
                        </p>
                    </h4>
                    
                
                    <!-- overview -->
                    <div class="p-4 rounded border mb-50">
                        <ul class="pl-0 mb-20">
                            <li class="py-3 border-bottom">
                               <div class="row">
                                    <div class="col-lg-3">Teacher Authors:</div>
                                    <div class="col-lg-9">{{$plan['teacher_authors']}}</div>
                                </div>
                            </li>
                            <li class="py-3 border-bottom">
                                <div class="row">
                                    <div class="col-lg-3">Grade:</div>
                                    <div class="col-lg-9">{{$plan['grade']}}</div>
                                </div>
                            </li>
                            <li class="py-3 border-bottom">
                                <div class="row">
                                    <div class="col-lg-3">Subject:</div>
                                    <div class="col-lg-9">{{$plan['subject']}}</div>
                                </div>
                            </li>
                            <li class="py-3 border-bottom">
                                <div class="row">
                                    <div class="col-lg-3">Date:</div>
                                    <div class="col-lg-9">{{$plan['date']}}</div>
                                </div>
                            </li>
                            <li class="py-3 border-bottom">
                                <div class="row">
                                    <div class="col-lg-3">Unit Topic:</div>
                                    <div class="col-lg-9">{{$plan['unit_topic']}}</div>
                                </div>
                            </li>
                            <li class="py-3 border-bottom">
                                <div class="row">
                                    <div class="col-lg-3">Class:</div>
                                    <div class="col-lg-9">{{$plan['class']}}</div>
                                </div>
                            </li>
                            <li class="py-3 border-bottom">
                                <div class="row">
                                    <div class="col-lg-3">Lession:</div>
                                    <div class="col-lg-9">{{$plan['lesson']}}</div>
                                </div>
                            </li>
                            <li class="py-3 border-bottom">
                                <div class="row">
                                    <div class="col-lg-3">Unit:</div>
                                    <div class="col-lg-9">{{$plan['unit']}}</div>
                                </div>
                            </li>
                        </ul>
                        <!-- <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#updateProfile">Edit</a> -->
                    </div>
                    @if($plan['standards']['standard_data'][1]['status'] == 'no')
                        <h6>
                            @if(isset($plan['standards']['label'])) {{$plan['standards']['label']}} @else Standards @endif
                        </h6>
                        <div class="p-4 rounded border mb-50">
                            <ul class="pl-0 mb-20">
                                @isset($plan['standards']['standard_data'][1]['standard_name'])
                                    @foreach ($plan['standards']['standard_data'] as $item)
                                    <li class="py-3 border-bottom">
                                        <div class="row">
                                            <div class="col-lg-3">Standard name:</div>
                                            <div class="col-lg-9">{{ $item['standard_name'] }}</div>
                                        </div>
                                    </li>
                                    <li class="py-3 border-bottom">
                                        <div class="row">
                                            <div class="col-lg-3">Number:</div>
                                            <div class="col-lg-9">{{ $item['standard_number'] }}</div>
                                        </div>
                                    </li>
                                    <li class="py-3 border-bottom">
                                        <div class="row">
                                            <div class="col-lg-3">Description:</div>
                                            <div class="col-lg-9">{{ $item['standard_description'] }}</div>
                                        </div>
                                    </li>
                                    <br><br>
                                    @endforeach
                                @endisset
                            </ul>
                        </div>
                    @endif
                    <h6>
                        @if (isset($plan['objective']['label'])) {{$plan['objective']['label']}} @else Learning Target / Objective @endif
                    </h6>
                    <div class="p-4 rounded border mb-50">
                        <ul class="pl-0 mb-20">
                            @isset($plan['objective']['objective'][1]['objective'])
                            @foreach ($plan['objective']['objective'] as $item)
                            <li class="py-3 border-bottom">
                                <div class="row">
                                    <div class="col-lg-3">Objecive:</div>
                                    <div class="col-lg-9">{{ $item['objective'] }}</div>
                                </div>
                            </li>
                            @endforeach
                            @endisset
                        </ul>
                    </div>
                    @if($plan['entry_activity']['entry_data'][1]['status'] == 'no')
                        @php
                            $entryLabel = "Entry Activity/ Success Starter";
                            if (isset($plan['entry_activity']['label'])) {
                                $entryLabel = $plan['entry_activity']['label'];
                            }
                        @endphp
                        <h6>{{ $entryLabel}}</h6>
                        <div class="p-4 rounded border mb-50">
                            <ul class="pl-0 mb-20">
                                @isset($plan['entry_activity']['entry_data'][1]['entry_activity'])
                                @foreach ($plan['entry_activity']['entry_data'] as $item)
                                <li class="py-3 border-bottom">
                                    <div class="row">
                                        <div class="col-lg-3">{{$entryLabel}}:</div>
                                        <div class="col-lg-9">
                                            {{ $item['entry_activity'] }} <br>
                                            <span class="duration">{{  $item['entry_duration'] }}</span> <br>
                                            <a class="std_link" target="_blank" href="{{ $item['entry_link'] }}">{{ $item['entry_link'] }}</a>
                                            @isset($item['entry_attch'])
                                                <br><a target="_blank" href="{{ url($item['entry_attch'])  }}">See Attach </a>
                                            @endisset
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                                @endisset
                            </ul>
                        </div>
                    @endif
                    @if($plan['notes']['notes_data'][1]['status'] == 'no' || $plan['vocabulary']['vocabulary_data'][1]['status'] == 'no' || $plan['concept_demonstration']['concept_data'][1]['status'] == 'no' || $plan['guided_practice']['guided_data'][1]['status'] == 'no')
                        <h6>
                            Mini Lesson
                        </h6>
                        <div class="p-4 rounded border mb-50">
                            <ul class="pl-0 mb-20">
                                @php
                                $notesLabel = "Notes";
                                if (isset($plan['notes']['label'])) {
                                    $notesLabel = $plan['notes']['label'];
                                }
                                @endphp
                                @if($plan['notes']['notes_data'][1]['status'] == 'no')
                                    @isset($plan['notes']['notes_data'][1]['notes'])
                                    @foreach ($plan['notes']['notes_data'] as $item)
                                    <li class="py-3 border-bottom">
                                        <div class="row">
                                            <div class="col-lg-3">{{$notesLabel}}:</div>
                                            <div class="col-lg-9">
                                                {{ $item['notes'] }} <br>
                                                <span class="duration">{{ $item['notes_duration'] }}</span> <br>
                                                <a class="std_link" target="_blank" href="{{ $item['notes_link'] }}">{{ $item['notes_link'] }}</a>
                                                {{-- <a href="{{ asset('public/website/images/upload/' . $item['notes_attch'] ) }}"></a> --}}
                                                @isset($item['notes_attch'])
                                                    <br><a target="_blank" href="{{ url($item['notes_attch'])  }}">See Attach</a>
                                                @endisset
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                    <br><br>
                                    @endisset
                                @endif
                                @if($plan['vocabulary']['vocabulary_data'][1]['status'] == 'no')
                                    @php
                                    $vocabularyLabel = "Vocabulary";
                                    if (isset($plan['vocabulary']['label'])) {
                                        $vocabularyLabel = $plan['vocabulary']['label'];
                                    }
                                    @endphp
                                    @isset($plan['vocabulary']['vocabulary_data'][1]['vocabulary'])
                                        @foreach ($plan['vocabulary']['vocabulary_data'] as $item)
                                            <li class="py-3 border-bottom">
                                                <div class="row">
                                                    <div class="col-lg-3">{{$vocabularyLabel}}:</div>
                                                    <div class="col-lg-9">
                                                        {{ $item['vocabulary'] }} <br>
                                                        <span class="duration">{{ $item['vocabulary_duration'] }}</span> <br>
                                                        <a class="std_link" target="_blank" href="{{ $item['vocabulary_link'] }}" >{{ $item['vocabulary_link'] }}</a>
                                                        @isset($item['vocabulary_attch'])
                                                            <br><a target="_blank" href="{{ url($item['vocabulary_attch'])  }}">See Attach </a>
                                                        @endisset
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                        <br><br>
                                    @endisset
                                @endif
                                @if($plan['concept_demonstration']['concept_data'][1]['status'] == 'no')
                                    @php
                                        $conceptLabel = "Concept Demonstration";
                                        if (isset($plan['concept_demonstration']['label'])) {
                                            $conceptLabel = $plan['concept_demonstration']['label'];
                                        }
                                    @endphp
                                    @isset($plan['concept_demonstration']['concept_data'][1]['concept'])
                                        @foreach ($plan['concept_demonstration']['concept_data'] as $item)
                                            <li class="py-3 border-bottom">
                                                <div class="row">
                                                    <div class="col-lg-3">{{$conceptLabel}}:</div>
                                                    <div class="col-lg-9">
                                                        {{ $item['concept'] }} <br>
                                                        <span class="duration">{{ $item['concept_duration'] }}</span> <br>
                                                        <a class="std_link" target="_blank" href="{{ $item['concept_link'] }}" >{{ $item['concept_link'] }}</a>
                                                        @isset($item['concept_attch'])
                                                        <br><a target="_blank" href="{{ url($item['concept_attch'])  }}">See Attach </a>
                                                        @endisset
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                        <br><br>
                                    @endisset
                                @endif
                                @if($plan['guided_practice']['guided_data'][1]['status'] == 'no')
                                    @php
                                        $guidedLabel = "Guided Practice";
                                        if (isset($plan['guided_practice']['label'])) {
                                            $guidedLabel = $plan['guided_practice']['label'];
                                        }
                                    @endphp
                                    @isset($plan['guided_practice']['guided_data'][1]['guided_practice'])
                                        @foreach ($plan['guided_practice']['guided_data'] as $item)
                                            <li class="py-3 border-bottom">
                                                <div class="row">
                                                    <div class="col-lg-3">{{$guidedLabel}}:</div>
                                                    <div class="col-lg-9">
                                                        {{ $item['guided_practice'] }} <br>
                                                        <span class="duration">{{ $item['guided_duration'] }}</span> <br>
                                                        <a class="std_link" target="_blank" href="{{ $item['guided_link'] }}" >{{ $item['guided_link'] }}</a>
                                                        @isset($item['guided_attch'])
                                                        <br><a target="_blank" href="{{ url($item['guided_attch'])  }}">See Attach </a>
                                                        @endisset
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                        <br><br>
                                    @endisset
                                @endif
                            </ul>
                        </div>
                    @endif
                    @if($plan['informal_assessment']['informal_data'][1]['main_status'] == 'no' && ($plan['informal_assessment']['informal_data'][1]['status'] == 'no' || $plan['student_work']['student_work_data'][1]['status'] == 'no' || $plan['formal_assessment']['formal_assessment_data'][1]['status'] == 'no'))
                        <h6>
                            Assessments
                        </h6>
                        @if($plan['informal_assessment']['informal_data'][1]['status'] == 'no' || $plan['student_work']['student_work_data'][1]['status'] == 'no' || $plan['formal_assessment']['formal_assessment_data'][1]['status'] == 'no')
                            <div class="p-4 rounded border mb-50">
                                <ul class="pl-0 mb-20">
                                    @php
                                    $informalLabel = "Informal Assessment";
                                    if (isset($plan['informal_assessment']['label'])) {
                                        $informalLabel = $plan['informal_assessment']['label'];
                                    }
                                    @endphp
                                    @if($plan['informal_assessment']['informal_data'][1]['status'] == 'no')
                                        @isset($plan['informal_assessment']['informal_data'][1]['informal_assessment'])
                                            @foreach ($plan['informal_assessment']['informal_data'] as $item)
                                                <li class="py-3 border-bottom">
                                                    <div class="row">
                                                        <div class="col-lg-3">{{$informalLabel}}:</div>
                                                        <div class="col-lg-9">
                                                            {{ $item['informal_assessment'] }} <br>
                                                            <span class="duration">{{ $item['informal_assessment_duration'] }}</span><br>
                                                            <a class="std_link" target="_blank" href="{{ $item['informal_assessment_link'] }}" >{{ $item['informal_assessment_link'] }}</a>
                                                            @isset($item['informal_assessment_attch'])
                                                            <br><a target="_blank" href="{{ url($item['informal_assessment_attch'])  }}">See Attach </a>
                                                            @endisset
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                            <br><br>
                                        @endisset
                                    @endif
        
                                    @php
                                    $studentWorkLabel = "Student Work";
                                    if (isset($plan['student_work']['label'])) {
                                        $studentWorkLabel = $plan['student_work']['label'];
                                    }
                                    @endphp
                                    @if($plan['student_work']['student_work_data'][1]['status'] == 'no')
                                        @isset($plan['student_work']['student_work_data'][1]['student_work'])
                                            @foreach ($plan['student_work']['student_work_data'] as $item)
                                                <li class="py-3 border-bottom">
                                                    <div class="row">
                                                        <div class="col-lg-3">{{$studentWorkLabel}}:</div>
                                                        <div class="col-lg-9">
                                                            {{ $item['student_work'] }} <br>
                                                            <span class="duration">{{ $item['student_work_duration'] }}</span><br>
                                                            <a class="std_link" target="_blank" href="{{ $item['student_work_link'] }}" >{{ $item['student_work_link'] }}</a>
                                                            @isset($item['student_work_attch'])
                                                            <br><a target="_blank" href="{{ url($item['student_work_attch'])  }}">See Attach </a>
                                                            @endisset
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                            <br><br>
                                        @endisset
                                    @endif
                                    @php
                                    $formalLabel = "Formal Assessment";
                                    if (isset($plan['formal_assessment']['label'])) {
                                        $formalLabel = $plan['formal_assessment']['label'];
                                    }
                                    @endphp
                                    @if($plan['formal_assessment']['formal_assessment_data'][1]['status'] == 'no')
                                        @isset($plan['formal_assessment']['formal_assessment_data'][1]['formal_assessment'])
                                            @foreach ($plan['formal_assessment']['formal_assessment_data'] as $item)
                                                <li class="py-3 border-bottom">
                                                    <div class="row">
                                                        <div class="col-lg-3">{{$formalLabel}}:</div>
                                                        <div class="col-lg-9">
                                                            {{ $item['formal_assessment'] }} <br>
                                                            <span class="duration">{{ $item['formal_assessment_duration'] }}</span><br>
                                                            <a class="std_link" target="_blank" href="{{ $item['formal_assessment_link'] }}" >{{ $item['formal_assessment_link'] }}</a>
                                                            @isset($item['formal_assessment_attch'])
                                                            <br><a target="_blank" href="{{ url($item['formal_assessment_attch'])  }}">See Attach </a>
                                                            @endisset
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endisset
                                    @endif
                                </ul>
                            </div>
                        @endif
                    @endif
                    @if($plan['rubric']['rubric'][1]['status'] == 'no')
                        <h6>Rubric</h6>
                        <div class="p-4 rounded border mb-50">
                            <ul class="pl-0 mb-20">
                                @isset($plan['rubric']['rubric'][1]['rubric'])
                                @foreach ($plan['rubric']['rubric'] as $item)
                                <li class="py-3 border-bottom">
                                    <div class="row">
                                        <div class="col-lg-3">Rubric:</div>
                                        <div class="col-lg-9">
                                            {{ $item['rubric'] }} 
                                            @isset($item['rubric_attch'])
                                            <br><a target="_blank" href="{{ url($item['rubric_attch'])  }}">See Attach </a>
                                            @endisset    
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                                @endisset
                            </ul>
                        </div>
                    @endif
                    @if($plan['differentiation']['method_name'][1]['status'] == 'no')
                        @php
                            $diffLabel = "Differentiation";
                            if (isset($plan['differentiation']['label'])) {
                                $diffLabel = $plan['differentiation']['label'];
                            }
                        @endphp
                        <h6>{{ $diffLabel }}</h6>
                        <div class="p-4 rounded border mb-50">
                            <ul class="pl-0 mb-20">
                                @isset($plan['differentiation']['method_name'][1]['method_name'])
                                @foreach ($plan['differentiation']['method_name'] as $item)
                                <li class="py-3 border-bottom">
                                    <div class="row">
                                        <div class="col-lg-3">Method name:</div>
                                        <div class="col-lg-9">{{ $item['method_name'] }}</div>
                                    </div>
                                </li>
                                <li class="py-3 border-bottom">
                                    <div class="row">
                                        <div class="col-lg-3">Description:</div>
                                        <div class="col-lg-9">{{ $item['method_description'] }}</div>
                                    </div>
                                </li>
                                <li class="py-3 border-bottom">
                                    <div class="row">
                                        <div class="col-lg-3">Administered by:</div>
                                        <div class="col-lg-9">{{ $item['administering_method'] }}</div>
                                    </div>
                                </li>
                                <li class="py-3 border-bottom">
                                    <div class="row">
                                        <div class="col-lg-3">Group served:</div>
                                        <div class="col-lg-9">{{ $item['group_served'] }}</div>
                                    </div>
                                </li>
                                <br>
                                @endforeach
                                @endisset
                                
                            </ul>
                        </div>
                    @endif
                    <h6>Homework</h6>
                    <div class="p-4 rounded border mb-50">
                        <ul class="pl-0 mb-20">
                            @isset($plan['homework']['home_data'][1]['homework'])
                            @php
                                $homeObj = $plan['homework']['home_data'][1];
                                $homeworkDueDte = array_column($plan['homework']['home_data'], 'homework_due_date');
                            @endphp
                            <li class="py-3 border-bottom">
                                <div class="row">
                                    <div class="col-lg-3">Homework:</div>
                                    <div class="col-lg-9">{{ $homeObj['homework'] }}</div>
                                </div>
                            </li>
                            <li class="py-3 border-bottom">
                                <div class="row">
                                    <div class="col-lg-3">Description:</div>
                                    <div class="col-lg-9">{{ $homeObj['homework_description'] }}</div>
                                </div>
                            </li>
                            <li class="py-3 border-bottom">
                                <div class="row">
                                    <div class="col-lg-3">Due date:</div>
                                    <div class="col-lg-9">
                                        @php
                                            echo implode(", <br>",$homeworkDueDte);
                                        @endphp
                                    </div>
                                </div>
                            </li>
                            @isset($homeObj['homework_attch'])
                            <li class="py-3 border-bottom">
                                <div class="row">
                                    <div class="col-lg-3">Attachment:</div>
                                    <div class="col-lg-9">
                                        <a target="_blank" href="{{ url($homeObj['homework_attch'])  }}">See Attach </a>
                                    </div>
                                </div>
                            </li>
                            @endisset
                            <br><br>
                            @endisset
                            @isset($plan['additional_resources']['additional_data'][1]['additional_resources'])
                            @php
                                $additionalObj = $plan['additional_resources']['additional_data'][1];
                                // $additionalAttach = $plan['additional_resources']['additional_attch'];
                            @endphp
                            <li class="py-3 border-bottom">
                                <div class="row">
                                    <div class="col-lg-3">Additional Resources:</div>
                                    <div class="col-lg-9">{{ $additionalObj['additional_resources'] }}</div>
                                </div>
                            </li>
                            <li class="py-3 border-bottom">
                                <div class="row">
                                    <div class="col-lg-3">Description:</div>
                                    <div class="col-lg-9">{{ $additionalObj['additional_description'] }}</div>
                                </div>
                            </li>
                            @if($plan['additional_resources']['additional_data'][1]['status'] == 'no')
                                @isset($additionalObj['additional_duration'])
                                    <li class="py-3 border-bottom">
                                        <div class="row">
                                            <div class="col-lg-3">Due date:</div>
                                            <div class="col-lg-9">
                                                {{$additionalObj['additional_duration']}}
                                            </div>
                                        </div>
                                    </li>
                                @endisset
                            @endif
                            @isset($additionalObj['additional_attch'])
                            <li class="py-3 border-bottom">
                                <div class="row">
                                    <div class="col-lg-3">Attachment:</div>
                                    <div class="col-lg-9">
                                        <a target="_blank" href="{{ url($additionalObj['additional_attch'])  }}">See Attach </a>
                                    </div>
                                </div>
                            </li>
                            @endisset

                            @endisset
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection