<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Lesson</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <style>
        .heading-que {
            font-size: 20px;
            font-weight: 500;
        }
        .heading-ans {
            font-size: 20px;
            font-weight: bold;

        }
        .pdl-250 {
            padding-left: 250px;
        }
        .pdl-350 {
            padding-left: 350px;
        }
        .pdl-500 {
            padding-left: 500px;
        }

        .pdl-450 {
            padding-left: 450px;
        }

        .pdl-200 {
            padding-left: 200px;
        }

        .pdl-60 {
            padding-left: 60px;
        }

        .pdl-120 {
            padding-left: 120px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    
    {{-- {{  dd($plan)  }} --}}

        <div class="container-fluid">
            <div class="row ">
                <div class="col-lg-12">
                    <h2 class=" text-center">Lesson Plan</h2>
                </div>
            </div>
            <div class="row" style="margin-top: -50px">
                <div class="col-lg-6">
                    <div class="heading-que">Teacher Authors</div>
                    <div class="heading-ans">{{$plan['teacher_authors']}} </div>
                </div>
                <div class="col-lg-6">
                    <div class="pdl-500 heading-que">Date</div>
                    <div class="pdl-500 heading-ans">{{$plan['date']}}</div>
                </div>
            </div>
            <div class="row" style="margin-top: -90px">
                <div class="col-lg-4">
                    <div class="heading-que">Subject</div>
                    <div class="heading-ans">{{$plan['subject']}}</div>
                </div>
                <div class="col-lg-4">
                    <div class="pdl-200 heading-que">Grade</div>
                    <div class="pdl-200 heading-ans">{{$plan['grade']}}</div>
                </div>
                <div class="col-lg-4">
                    <div class="pdl-500 heading-que">Class</div>
                    <div class="pdl-500 heading-ans">{{$plan['class']}}</div>
                </div>
            </div>

            <div class="row"  style="margin-top: -90px">
                <div class="col-lg-4">
                    <div class="heading-que">Unit #</div>
                    <div class="heading-ans">{{$plan['unit']}} </div>
                </div>
                <div class="col-lg-4">
                    <div class="pdl-200 heading-que">Unit Topic</div>
                    <div class="pdl-200 heading-ans">{{$plan['unit_topic']}} </div>
                </div>
                <div class="col-lg-4">
                    <div class="pdl-500  heading-que">Lesson #</div>
                    <div class="pdl-500 heading-ans">{{$plan['lesson']}}</div>
                </div>
            </div>

            @isset($plan['objective']['objective'][1]['objective'])
            @foreach ($plan['objective']['objective'] as $item)
            <div class="row pt-4" >
                <div class="col-lg-12">
                    <div class="heading-que">@if (isset($plan['objective']['label'])) {{$plan['objective']['label']}} @else Learning Target / Objective @endif</div>
                    <div class="heading-ans">
                        {{ $item['objective'] }}
                    </div>
                </div>
            </div>
            @endforeach
            <br>
            @endisset


            @if($plan['standards']['standard_data'][1]['status'] == 'no')
                @isset($plan['standards']['standard_data'][1]['standard_name'])
                    <div class="heading-que"> @if (isset($plan['standards']['label'])) {{$plan['standards']['label']}} @else Standards @endif</div>
                    @foreach ($plan['standards']['standard_data'] as $item)
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="heading-que">Standards #</div>
                            <div class="heading-ans">{{ $item['standard_name'] }} </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="heading-que">Standards Resource</div>
                            <div class="heading-ans">{{ $item['standard_number'] }}</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="heading-que">Standards Description</div>
                            <div class="heading-ans">
                                {{ $item['standard_description'] }}
                            </div>
                        </div>
                    </div>
                    <br><br>
                    @endforeach
                @endisset
            @endif
            @if($plan['entry_activity']['entry_data'][1]['status'] == 'no')
                @isset($plan['entry_activity']['entry_data'][1]['entry_activity'])
                    <br><br>   
                    <div class="row pt-5">
                        <div class="col-lg-12">
                            @foreach ($plan['entry_activity']['entry_data'] as $item)
                            <div class="heading-que">@if (isset($plan['entry_activity']['label'])) {{$plan['entry_activity']['label']}} @else Learning Target / Objective @endif</div>
                            <div class="heading-ans">
                                {{ $item['entry_activity']}}
                                <br>
                                <a target="_blank" href="{{ $item['entry_link'] }}"> {{ $item['entry_link'] }}</a>
                                @isset($item['entry_attch'])
                                <br><a target="_blank" href="{{ url($item['entry_attch'])  }}">See Attach</a>
                                @endisset
                                <div class="heading-que" style="text-align: right;">Duration   {{ $item['entry_duration'] }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endisset
            @endif
       
            @if($plan['notes']['notes_data'][1]['status'] == 'no' || $plan['vocabulary']['vocabulary_data'][1]['status'] == 'no' || $plan['concept_demonstration']['concept_data'][1]['status'] == 'no' || $plan['guided_practice']['guided_data'][1]['status'] == 'no')
                @if(empty($plan['notes']['notes_data'][1]['notes']) &&
                    empty($plan['vocabulary']['vocabulary_data'][1]['vocabulary']) &&
                    empty($plan['concept_demonstration']['concept_data'][1]['concept']) &&
                    empty($plan['guided_practice']['guided_data'][1]['guided_practice'])
                )
                @else
                    <div class="heading-que pt-2">Mini Lesson</div>
                    <br>
                @endif
            @endif
            @if($plan['notes']['notes_data'][1]['status'] == 'no')
                @if(!empty($plan['notes']['notes_data'][1]['notes']))
                    @foreach ($plan['notes']['notes_data'] as $item)
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="heading-que">@if (isset($plan['notes']['label'])) {{$plan['notes']['label']}} @else Notes @endif</div>
                                <div class="heading-ans">
                                    {{ $item['notes'] }}
                                    <br>
                                    <a  target="_blank" href="{{ $item['notes_link'] }}"> {{ $item['notes_link'] }}</a>
                                    @isset($item['notes_attch'])
                                    <br><a target="_blank" href="{{ url($item['notes_attch'])  }}">See Attach </a>
                                    @endisset
                                    <div class="heading-que" style="text-align: right;">Duration  {{ $item['notes_duration'] }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endif
            @if($plan['vocabulary']['vocabulary_data'][1]['status'] == 'no')
                @if(!empty($plan['vocabulary']['vocabulary_data'][1]['vocabulary']))
                    @foreach ($plan['vocabulary']['vocabulary_data'] as $item)
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="heading-que">@if (isset($plan['vocabulary']['label'])) {{$plan['vocabulary']['label']}} @else Vocabulary @endif</div>
                                <div class="heading-ans">
                                    {{ $item['vocabulary'] }}
                                    <br>
                                    <a target="_blank" href="{{ $item['vocabulary_link'] }}"> {{ $item['vocabulary_link'] }}</a>
                                    @isset($item['vocabulary_attch'])
                                    <br><a target="_blank" href="{{ url($item['vocabulary_attch'])  }}">See Attach </a>
                                    @endisset
                                    <div class="heading-que" style="text-align: right;">Duration  {{ $item['vocabulary_duration'] }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endif
            @if($plan['concept_demonstration']['concept_data'][1]['status'] == 'no')
                @if(!empty($plan['concept_demonstration']['concept_data'][1]['concept']))
                    @foreach ($plan['concept_demonstration']['concept_data'] as $item)
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="heading-que">@if (isset($plan['concept_demonstration']['label'])) {{$plan['concept_demonstration']['label']}} @else Guided Practice @endif</div>
                                <div class="heading-ans">
                                    {{ $item['concept'] }}
                                    <br>
                                    <a target="_blank" href="{{ $item['concept_link'] }}"> {{ $item['concept_link'] }}</a>
                                    @isset($item['concept_attch'])
                                    <br><a target="_blank" href="{{ url($item['concept_attch'])  }}">See Attach</a>
                                    @endisset
                                    <div class="heading-que" style="text-align: right;">Duration  {{ $item['concept_duration'] }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endif
            @if($plan['guided_practice']['guided_data'][1]['status'] == 'no')
                @if(!empty($plan['guided_practice']['guided_data'][1]['guided_practice']))
                    @foreach ($plan['guided_practice']['guided_data'] as $item)
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="heading-que">@if (isset($plan['guided_practice']['label'])) {{$plan['guided_practice']['label']}} @else Guided Practice @endif</div>
                                <div class="heading-ans">
                                    {{ $item['guided_practice'] }}
                                    <br>
                                    <a target="_blank" href="{{ $item['guided_link'] }}"> {{ $item['guided_link'] }}</a>
                                    @isset($item['guided_attch'])
                                    <br><a target="_blank" href="{{ url($item['guided_attch'])  }}">See Attach </a>
                                    @endisset
                                    <div class="heading-que" style="text-align: right;">Duration  {{ $item['guided_duration'] }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endif

            @if($plan['informal_assessment']['informal_data'][1]['main_status'] == 'no' && ($plan['informal_assessment']['informal_data'][1]['status'] == 'no' || $plan['student_work']['student_work_data'][1]['status'] == 'no' || $plan['formal_assessment']['formal_assessment_data'][1]['status'] == 'no'))
                @if(empty($plan['informal_assessment']['informal_data'][1]['informal_assessment']) &&
                    empty($plan['student_work']['student_work_data'][1]['student_work']) &&
                    empty($plan['formal_assessment']['formal_assessment_data'][1]['formal_assessment'])
                )
                @else   
                    <div class="heading-que pt-2">Assessments</div>
                @endif
            @endif
            @if($plan['informal_assessment']['informal_data'][1]['status'] == 'no')
                @if(!empty($plan['informal_assessment']['informal_data'][1]['informal_assessment']))
                    @foreach ($plan['informal_assessment']['informal_data'] as $item)
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="heading-que">@if (isset($plan['informal_assessment']['label'])) {{$plan['informal_assessment']['label']}} @else Informal Assessment @endif </div>
                                <div class="heading-ans">
                                    {{ $item['informal_assessment'] }}
                                    @isset($item['informal_assessment_link'])
                                    <br>
                                    <a target="_blank" href="{{ $item['informal_assessment_link'] }}"> {{ $item['informal_assessment_link'] }}</a>
                                    @endisset
                                    @isset($item['informal_assessment_attch'])
                                    <br><a target="_blank" href="{{ url($item['informal_assessment_attch'])  }}">See Attach </a>
                                    @endisset
                                    <div class="heading-que" style="text-align: right;">Duration  {{ $item['informal_assessment_duration'] }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endif
            @if($plan['student_work']['student_work_data'][1]['status'] == 'no')
                @if(!empty($plan['student_work']['student_work_data'][1]['student_work']))
                    @foreach ($plan['student_work']['student_work_data'] as $item)
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="heading-que">@if (isset($plan['student_work']['label'])) {{$plan['student_work']['label']}} @else Formal Assessment @endif </div>
                                <div class="heading-ans">
                                    {{ $item['student_work'] }}
                                    @isset($item['student_work_link'])
                                    <br>
                                    <a target="_blank" href="{{ $item['student_work_link'] }}"> {{ $item['student_work_link'] }}</a>
                                    @endisset
                                    @isset($item['student_work_attch'])
                                    <br><a target="_blank" href="{{ url($item['student_work_attch'])  }}">See Attach </a>
                                    @endisset
                                    <div class="heading-que" style="text-align: right;">Duration  {{ $item['student_work_duration'] }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endif
            @if($plan['formal_assessment']['formal_assessment_data'][1]['status'] == 'no')
                @if(!empty($plan['formal_assessment']['formal_assessment_data'][1]['formal_assessment']))
                    @foreach ($plan['formal_assessment']['formal_assessment_data'] as $item)
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="heading-que">@if (isset($plan['formal_assessment']['label'])) {{$plan['formal_assessment']['label']}} @else Formal Assessment @endif </div>
                                <div class="heading-ans">
                                    {{ $item['formal_assessment'] }}
                                    @isset($item['formal_assessment_link'])
                                    <br>
                                    <a target="_blank" href="{{ $item['formal_assessment_link'] }}"> {{ $item['formal_assessment_link'] }}</a>
                                    @endisset
                                    @isset($item['formal_assessment_attch'])
                                    <br><a target="_blank" href="{{ url($item['formal_assessment_attch'])  }}">See Attach </a>
                                    @endisset
                                    <div class="heading-que" style="text-align: right;">Duration  {{ $item['formal_assessment_duration'] }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endif

            @if($plan['rubric']['rubric'][1]['status'] == 'no')
                @isset($plan['rubric']['rubric'][1]['rubric'])
                    @foreach ($plan['rubric']['rubric'] as $item)
                        <div class="row pt-2">
                            <div class="col-lg-12">
                                <div class="heading-que">Rubric</div>
                                <div class="heading-ans"> {{ $item['rubric'] }} </div>
                                @isset($item['rubric_attch'])
                                <div class="heading-que"> <a target="_blank" href="{{ url($item['rubric_attch'])  }}">See Attach </a></div>
                                @endisset    
                            </div>
                        </div>
                    @endforeach
                @endisset
            @endif

            @if($plan['differentiation']['method_name'][1]['status'] == 'no')
                @isset($plan['differentiation']['method_name'][1]['method_name'])
                    <div class="heading-que pt-2">@if (isset($plan['differentiation']['label'])) {{$plan['differentiation']['label']}} @else Differentiation  @endif</div>
                    @foreach ($plan['differentiation']['method_name'] as $item)
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="heading-ans">
                                    Differentiation Method: {{ $item['method_name'] }}<br>
                                    {{ $item['method_description'] }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="heading-que">Administered by: {{ $item['administering_method'] }}</div>
                            </div>
                            <div class="col-lg-6">
                                <div class="heading-que"style="text-align: right;" >Group Served: {{ $item['group_served'] }}</div>
                            </div>
                        </div>
                    @endforeach
                @endisset
            @endif

            @isset($plan['homework']['home_data'][1]['homework'])
                @php
                    $homeObj = $plan['homework']['home_data'][1];
                    $homeworkDueDte = array_column($plan['homework']['home_data'], 'homework_due_date');
                @endphp
                <div class="row pt-2">
                    <div class="col-lg-12">
                        <div class="heading-que">Homework</div>
                        <div class="heading-ans">
                            {{ $homeObj['homework'] }} <br>
                            {{ $homeObj['homework_description'] }} 

                            @isset($homeObj['homework_attch'])
                            <br>
                            <a target="_blank" href="{{ url($homeObj['homework_attch'])  }}">See Attach </a>
                            @endisset
                            <div class="heading-que" style="text-align: right;">
                                Due date:  
                                @php
                                    echo implode(", <br>",$homeworkDueDte);
                                @endphp
                            </div>
                        </div>
                    </div>
                </div>
         
            @endisset
            @isset($plan['additional_resources']['additional_data'][1]['additional_resources'])
            @php
                $additionalObj = $plan['additional_resources']['additional_data'][1];
            @endphp
          
            <div class="row pt-2">
                <div class="col-lg-12">
                    <div class="heading-que">Additional Resources</div>
                    <div class="heading-ans">
                        {{ $additionalObj['additional_resources'] }} <br>
                        {{ $additionalObj['additional_description'] }}<br>
                        @isset($additionalObj['additional_attch'])
                        <a target="_blank" href="{{ url($additionalObj['additional_attch'])  }}">See Attach </a>
                        <br>
                        @endisset
                        @if($plan['additional_resources']['additional_data'][1]['status'] == 'no')
                            @isset($additionalObj['additional_duration'])
                                <div class="heading-que" style="text-align: right;">
                                    Due date:   {{$additionalObj['additional_duration']}}
                                </div>
                            @endisset
                        @endif
                    </div>
                </div>
            </div>
            @endisset

        </div>

</body>
</html>