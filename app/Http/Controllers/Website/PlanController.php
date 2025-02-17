<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\GradeField;
use App\Models\SeperateGradeField;
use App\Models\UserExcelImport;
use App\Models\ExcelImport;
use App\Models\Lesson;
use App\Models\MetaSeo;
use App\Models\Color;
use App\Models\MethodDatabase;
use Carbon\Carbon;
use App\User;
use Validator;
use Session;
use Mail;
use Auth;
use PDF;
use URL;
use View;


class PlanController extends Controller
{
    private $gradeField;

    private $types = [
        "subject" => 1,
        "unit_topic" => 2,
        "method_name" => 3,
        "group_served" => 4,
        "standard_name" => 5,
        "standard_number" => 6,
        "standard_description" => 7,
        "entry_activity" => 8,
        "notes" => 9,
        "informal_assessment" => 10,
        "student_work" => 11,
        "formal_assessment" => 12,
        "teacher_authors" => 13,
        "objective" => 16,
        "vocabulary" => 17,
        "concept" => 18,
        "guided_practice" => 19,
        "rubric" => 20,
        "method_description" => 21,
        "administering_method" => 22,
        "homework" => 23,
        "homework_description" => 24,
        "additional_resources" => 25,
        "additional_description" => 26,
        "class" => 27,
    ];


    public function __construct()
    {
        $this->middleware('auth');
        $this->gradeField = new GradeField();
        $this->lesson = new Lesson();
        $this->Color = new Color();
    }

    public function create()
    {
        $gradeData = $this->gradeField->where(function ($query) {
            $query->whereNull('user_id')
                ->orWhere('user_id',Auth::user()->id);
            })->pluck('grade', 'grade')->toArray();
        // $gradeData = $this->gradeField->whereNull('user_id')->orWhere('user_id',Auth::user()->id)->pluck('grade', 'grade')->toArray();
        $minitArray = range(1, 30);
        $suffixedArray = preg_filter('/$/', ' Minutes', $minitArray);
        $monthDays = array_combine($suffixedArray, $suffixedArray);
        $unitData = $this->getSeperateData(1);
        $lessonData = $this->getSeperateData(2);
        $methodNameData = $this->getSeperateData(3);
        $methodDescData = $this->getSeperateData(4);
        $draftLesson = $this->lesson->whereUserId(Auth::user()->id)->whereIsDraft(1)->first();
        $color = $this->Color->select('id','code', \DB::raw("CONCAT(name,' - ',code) AS color"))->pluck('color', 'code')->toArray();
        $firstColor = array_key_first($color);
        if($draftLesson){
            return redirect('edit-plan-form/'.encrypt($draftLesson->id));
        }
        return view('website.plan.create', compact('gradeData', 'monthDays','unitData','lessonData','methodNameData','methodDescData','color','firstColor'));
    }

    public function store(Request $request)
    {
        try {
            $this->identifyAndAddGradeOptions($request);
            $this->seperateData($request);
            // dd($request->all());
            $userId = Auth::user()->id ?? null;
            if ($request->plan_id) {
                $methodType = "Update";
                $lessionForm = $planData = $this->lesson->whereId($request->plan_id)->first();
            } else {
                $methodType = "Add";
                $lessionForm = $this->lesson;
            }
            $lessionForm->teacher_authors = $request->teacher_authors;
            $lessionForm->date = $request->s_date ? Carbon::parse($request->s_date)->format('Y-m-d') : null;
            $lessionForm->subject = $request->subject;
            $lessionForm->grade = $request->grade;
            $lessionForm->class = $request->class;
            $lessionForm->unit = $request->unit;
            $lessionForm->color = $request->color;
            $lessionForm->is_draft = $request->is_draft;
            $lessionForm->unit_topic = $request->unit_topic;
            $lessionForm->lesson = $request->lesson;
            if (!empty($request->objective_data)) {
                $obData['objective'] =  $this->reIndexArray($request->objective_data);
                $obData['label'] = $request->objectiveLabel;
                $lessionForm->objective = json_encode($obData);
            }
            if (!empty($request->standard_data)) {
                $standardData['standard_data'] =  $this->reIndexArray($request->standard_data);
                $standardData['label'] = $request->standardsLabel;
                $lessionForm->standards = json_encode($standardData);
            }
            if (!empty($request->entry_data)) {
                $entryData['entry_data'] =  $this->reIndexArray($request->entry_data);
                $entryData['label'] = $request->entryLabel;
                foreach ($entryData['entry_data'] as $key => $row) {
                    if (!empty($row['entry_attch'])) {
                        if ($row['entry_attch'] == 1) {
                            $index = array_keys($request->entry_data)[$key - 1];
                            if(count($entryData['entry_data']) >= count(json_decode($planData->entry_activity, true)['entry_data'])) {
                                $index = $key;
                            }
                            $oldAttach = json_decode($planData->entry_activity, true)['entry_data'][$index]['entry_attch'];
                            $entryData['entry_data'][$key]['entry_attch'] = $oldAttach;
                        } else {
                            $name = $this->uploadImage($row['entry_attch'], 'public/website/images/upload');
                            $entryData['entry_data'][$key]['entry_attch'] = 'public/website/images/upload/' . $name;
                        }
                    }
                }
                $lessionForm->entry_activity = json_encode($entryData);
            }
            if (!empty($request->notes_data)) {
                $nData['notes_data'] =  $this->reIndexArray($request->notes_data);
                $nData['label'] = $request->notesLabel;
                foreach ($nData['notes_data'] as $key => $row) {
                    if (!empty($row['notes_attch'])) {
                        if ($row['notes_attch'] == 1) {
                            $index = array_keys($request->notes_data)[$key - 1];
                            if(count($nData['notes_data']) >= count(json_decode($planData->notes, true)['notes_data'])) {
                                $index = $key;
                            }
                            $oldAttach = json_decode($planData->notes, true)['notes_data'][$index]['notes_attch'];
                            $nData['notes_data'][$key]['notes_attch'] = $oldAttach;
                        } else {
                            $name = $this->uploadImage($row['notes_attch'], 'public/website/images/upload');
                            $nData['notes_data'][$key]['notes_attch'] = 'public/website/images/upload/' . $name;
                        }
                    }
                }
                $lessionForm->notes = json_encode($nData);
            }
            if (!empty($request->vocabulary_data)) {
                $vData['vocabulary_data'] =  $this->reIndexArray($request->vocabulary_data);
                foreach ($vData['vocabulary_data'] as $key => $row) {
                    if (!empty($row['vocabulary_attch'])) {
                        if ($row['vocabulary_attch'] == 1) {
                            $index = array_keys($request->vocabulary_data)[$key - 1];
                            if(count($vData['vocabulary_data']) >= count(json_decode($planData->vocabulary, true)['vocabulary_data'])) {
                                $index = $key;
                            }
                            $oldAttach = json_decode($planData->vocabulary, true)['vocabulary_data'][$index]['vocabulary_attch'];
                            $vData['vocabulary_data'][$key]['vocabulary_attch'] = $oldAttach;
                        } else {
                            $name = $this->uploadImage($row['vocabulary_attch'], 'public/website/images/upload');
                            $vData['vocabulary_data'][$key]['vocabulary_attch'] = 'public/website/images/upload/' . $name;
                        }
                    }
                }
                $vData['label'] = $request->vocabularyLabel;
                $lessionForm->vocabulary = json_encode($vData);
            }
            if (!empty($request->concept_data)) {
                $cData['concept_data'] =  $this->reIndexArray($request->concept_data);
                foreach ($cData['concept_data'] as $key => $row) {
                    if (!empty($row['concept_attch'])) {
                        if ($row['concept_attch'] == 1) {
                            $index = array_keys($request->concept_data)[$key - 1];
                            if(count($cData['concept_data']) >= count(json_decode($planData->concept_demonstration, true)['concept_data'])) {
                                $index = $key;
                            }
                            $oldAttach = json_decode($planData->concept_demonstration, true)['concept_data'][$index]['concept_attch'];
                            $cData['concept_data'][$key]['concept_attch'] = $oldAttach;
                        } else {
                            $name = $this->uploadImage($row['concept_attch'], 'public/website/images/upload');
                            $cData['concept_data'][$key]['concept_attch'] = 'public/website/images/upload/' . $name;
                        }
                    }
                }
                $cData['label'] = $request->conceptLabel;
                $lessionForm->concept_demonstration = json_encode($cData);
            }
            if (!empty($request->guided_data)) {
                $gData['guided_data'] =  $this->reIndexArray($request->guided_data);
                foreach ($gData['guided_data'] as $key => $row) {
                    if (!empty($row['guided_attch'])) {
                        if ($row['guided_attch'] == 1) {
                            $index = array_keys($request->guided_data)[$key - 1];
                            if(count($gData['guided_data']) >= count(json_decode($planData->guided_practice, true)['guided_data'])) {
                                $index = $key;
                            }
                            $oldAttach = json_decode($planData->guided_practice, true)['guided_data'][$index]['guided_attch'];
                            $gData['guided_data'][$key]['guided_attch']  = $oldAttach;
                        } else {
                            $name = $this->uploadImage($row['guided_attch'], 'public/website/images/upload');
                            $gData['guided_data'][$key]['guided_attch'] = 'public/website/images/upload/' . $name;
                        }
                    }
                }
                $gData['label'] = $request->guidedLabel;
                $lessionForm->guided_practice = json_encode($gData);
            }
            if (!empty($request->informal)) {
                $informalData['informal_data'] =  $this->reIndexArray($request->informal);
                foreach ($informalData['informal_data'] as $key => $row) {
                    if (!empty($row['informal_assessment_attch'])) {
                        if ($row['informal_assessment_attch'] == 1) {
                            $index = array_keys($request->formal)[$key - 1];
                            if(count($informalData['informal_data']) >= count(json_decode($planData->informal_assessment, true)['informal_data'])) {
                                $index = $key;
                            }
                            $oldAttach = json_decode($planData->informal_assessment, true)['informal_data'][$index]['informal_assessment_attch'];
                            $informalData['informal_data'][$key]['informal_assessment_attch'] = $oldAttach;
                        } else {
                            $name = $this->uploadImage($row['informal_assessment_attch'], 'public/website/images/upload');
                            $informalData['informal_data'][$key]['informal_assessment_attch'] = 'public/website/images/upload/' . $name;
                        }
                    }
                }
                $informalData['label'] = $request->informalLabel;
                $lessionForm->informal_assessment = json_encode($informalData);
                // $informalData['informal_data'] =  $this->reIndexArray($request->informal);
                // $informalData['label'] = $request->informalLabel;
                // $lessionForm->informal_assessment = json_encode($informalData);
            }
            if (!empty($request->work)) {
                $workData['student_work_data'] =  $this->reIndexArray($request->work);
                foreach ($workData['student_work_data'] as $key => $row) {
                    if (!empty($row['student_work_attch'])) {
                        if ($row['student_work_attch'] == 1) {
                            // dump($workData['student_work_data']);
                            // dump(json_decode($planData->student_work, true)['student_work_data']);
                            $index = array_keys($request->work)[$key - 1];
                            if(count($workData['student_work_data']) >= count(json_decode($planData->student_work, true)['student_work_data'])) {
                                $index = $key;
                            }
                            // dump($index);
                            $oldAttach = json_decode($planData->student_work, true)['student_work_data'][$index]['student_work_attch'];
                            $workData['student_work_data'][$key]['student_work_attch']  = $oldAttach;
                        } else {
                            $name = $this->uploadImage($row['student_work_attch'], 'public/website/images/upload');
                            $workData['student_work_data'][$key]['student_work_attch'] = 'public/website/images/upload/' . $name;
                        }
                    }
                }
                $workData['label'] = $request->workLabel;
                $lessionForm->student_work = json_encode($workData);
                // dump(json_encode($workData));
            }
            if (!empty($request->formal)) {
                $formalData['formal_assessment_data'] =  $this->reIndexArray($request->formal);
                foreach ($formalData['formal_assessment_data'] as $key => $row) {
                    if (!empty($row['formal_assessment_attch'])) {
                        if ($row['formal_assessment_attch'] == 1) {
                            $index = array_keys($request->formal)[$key - 1];
                            if(count($formalData['formal_assessment_data']) >= count(json_decode($planData->formal_assessment, true)['formal_assessment_data'])) {
                                $index = $key;
                            }
                            $oldAttach = json_decode($planData->formal_assessment, true)['formal_assessment_data'][$index]['formal_assessment_attch'];
                            $formalData['formal_assessment_data'][$key]['formal_assessment_attch'] = $oldAttach;
                        } else {
                            $name = $this->uploadImage($row['formal_assessment_attch'], 'public/website/images/upload');
                            $formalData['formal_assessment_data'][$key]['formal_assessment_attch'] = 'public/website/images/upload/' . $name;
                        }
                    }
                }
                $formalData['label'] = $request->formalLabel;
                $lessionForm->formal_assessment = json_encode($formalData);
            }
            if (!empty($request->method_data)) {
                $methodData['method_name'] =  $this->reIndexArray($request->method_data);
                $methodData['label'] = $request->methodLabel;
                $lessionForm->differentiation = json_encode($methodData);
            }
            if (!empty($request->rubric_data)) {
                $rubricData['rubric'] =  $this->reIndexArray($request->rubric_data);
                foreach ($rubricData['rubric'] as $key => $row) {
                    if (!empty($row['rubric_attch'])) {
                        if ($row['rubric_attch'] == 1) {
                            $index = array_keys($request->rubric_data)[$key - 1];
                            if(count($rubricData['rubric']) >= count(json_decode($planData->rubric, true)['rubric'])) {
                                $index = $key;
                            }
                            $oldAttach = json_decode($planData->rubric, true)['rubric'][$index]['rubric_attch'];
                            $rubricData['rubric'][$key]['rubric_attch'] = $oldAttach;
                        } else {
                            $name = $this->uploadImage($row['rubric_attch'], 'public/website/images/upload');
                            $rubricData['rubric'][$key]['rubric_attch'] = 'public/website/images/upload/' . $name;
                        }
                    }
                }
                $lessionForm->rubric = json_encode($rubricData);
            }
            if (!empty($request->home_data)) {
                $homeData['home_data'] =  $this->reIndexArray($request->home_data);
                foreach ($homeData['home_data'] as $key => $row) {
                    if (!empty($row['homework_attch'])) {
                        if ($row['homework_attch'] == 1) {
                            $oldAttach = json_decode($planData->homework, true)['home_data'][$key]['homework_attch'];
                            $homeData['home_data'][$key]['homework_attch'] = $oldAttach;
                        } else {
                            $name = $this->uploadImage($row['homework_attch'], 'public/website/images/upload');
                            $homeData['home_data'][$key]['homework_attch'] = 'public/website/images/upload/' . $name;
                        }
                    }
                }
                $lessionForm->homework = json_encode($homeData);
            }
            if (!empty($request->additional_data)) {
                $addData['additional_data'] =  $this->reIndexArray($request->additional_data);
                foreach ($addData['additional_data'] as $key => $row) {
                    if (!empty($row['additional_attch'])) {
                        if ($row['additional_attch'] == 1) {
                            $oldAttach = json_decode($planData->additional_resources, true)['additional_data'][$key]['additional_attch'];
                            $addData['additional_data'][$key]['additional_attch'] = $oldAttach;
                        } else {
                            $name = $this->uploadImage($row['additional_attch'], 'public/website/images/upload');
                            $addData['additional_data'][$key]['additional_attch'] = 'public/website/images/upload/' . $name;
                        }
                    }
                }
                $lessionForm->additional_resources = json_encode($addData);
            }
            $lessionForm->user_id = $userId;
            $lessionForm->save();
            
            session()->flash('success', "$methodType record successfully!");
            if ($request->print) {
                $lessionForm->is_draft = 0;
                $lessionForm->save();
                $insertedId = $lessionForm->id;
                return ['status' => 'true', 'last_id' => $insertedId, 'id' => $lessionForm->id];
            } else if ($request->print_document) {
                $data = $this->lesson->whereId($lessionForm->id)->first();
                $data->is_draft = 0;
                $data->save();
                $plan = $data->toArray();
                if ($plan) {
                    $plan['objective'] = json_decode($plan['objective'], true);
                    $plan['standards'] = json_decode($plan['standards'], true);
                    $plan['entry_activity'] = json_decode($plan['entry_activity'], true);
                    $plan['notes'] = json_decode($plan['notes'], true);
                    $plan['vocabulary'] = json_decode($plan['vocabulary'], true);
                    $plan['concept_demonstration'] = json_decode($plan['concept_demonstration'], true);
                    $plan['guided_practice'] = json_decode($plan['guided_practice'], true);
                    $plan['informal_assessment'] = json_decode($plan['informal_assessment'], true);
                    $plan['student_work'] = json_decode($plan['student_work'], true);
                    $plan['formal_assessment'] = json_decode($plan['formal_assessment'], true);
                    $plan['rubric'] = json_decode($plan['rubric'], true);
                    $plan['differentiation'] = json_decode($plan['differentiation'], true);
                    $plan['homework'] = json_decode($plan['homework'], true);
                    $plan['additional_resources'] = json_decode($plan['additional_resources'], true);
                }
                return [
                    'status' => 'true',
                    'plan' =>  View::make('website.plan.print_document', ['plan' => $plan])->render(),
                    'print_document' => 1
                ];
            } else if($request->is_draft){
                $insertedId = $lessionForm->id;
                return ['status' => 'true','isDraft'=>true, 'id' => $lessionForm->id];
            }else {
                $lessionForm->is_draft = 0;
                $lessionForm->save();
                if ($request->email) {
                    $lessionForm['objective'] = json_decode($lessionForm['objective'], true);
                    $lessionForm['standards'] = json_decode($lessionForm['standards'], true);
                    $lessionForm['entry_activity'] = json_decode($lessionForm['entry_activity'], true);
                    $lessionForm['notes'] = json_decode($lessionForm['notes'], true);
                    $lessionForm['vocabulary'] = json_decode($lessionForm['vocabulary'], true);
                    $lessionForm['concept_demonstration'] = json_decode($lessionForm['concept_demonstration'], true);
                    $lessionForm['guided_practice'] = json_decode($lessionForm['guided_practice'], true);
                    $lessionForm['informal_assessment'] = json_decode($lessionForm['informal_assessment'], true);
                    $lessionForm['student_work'] = json_decode($lessionForm['student_work'], true);
                    $lessionForm['formal_assessment'] = json_decode($lessionForm['formal_assessment'], true);
                    $lessionForm['rubric'] = json_decode($lessionForm['rubric'], true);
                    $lessionForm['differentiation'] = json_decode($lessionForm['differentiation'], true);
                    $lessionForm['homework'] = json_decode($lessionForm['homework'], true);
                    $lessionForm['additional_resources'] = json_decode($lessionForm['additional_resources'], true);
                    $email = $request->email;
                    $shareLink = null;
                    $userExists = User::whereEmail($email)->first();
                    $shareLink = URL::to('signup') . '/' . encrypt($lessionForm->id);
                    if ($userExists) {
                        $shareLink = URL::to('web-login') . '/' . encrypt($lessionForm->id);
                    }

                    $pdf = PDF::loadView('website.plan.view_pdf', ['plan' => $lessionForm]);
                    Mail::send('website.plan.share_pdf', ['plan' => $lessionForm, 'shareLink' => $shareLink], function ($message) use ($pdf, $email) {
                        $message->from('info@shared-lessons.org', 'Lesson Planning');
                        $message->to($email)->subject('Share Lesson')
                            ->attachData($pdf->output(), "lesson.pdf");
                    });
                    session()->flash('success', 'Shared lesson successfully!');
                }
                return ['status' => 'true', 'last_id' => 0, 'id' => $lessionForm->id];
            }
        } catch (\Throwable $th) {
            dd($th);
            Log::info($th);
            session()->flash('error', 'Something went wrong!');
            return response()->json(['status' => false]);
        }
    }


    public function shareLesson(Request $request)
    {
        if ($request->email && $request->id) {
            $lessionForm = $this->lesson->whereId(decrypt($request->id))->first();
            $lessionForm['objective'] = json_decode($lessionForm['objective'], true);
            $lessionForm['standards'] = json_decode($lessionForm['standards'], true);
            $lessionForm['entry_activity'] = json_decode($lessionForm['entry_activity'], true);
            $lessionForm['notes'] = json_decode($lessionForm['notes'], true);
            $lessionForm['vocabulary'] = json_decode($lessionForm['vocabulary'], true);
            $lessionForm['concept_demonstration'] = json_decode($lessionForm['concept_demonstration'], true);
            $lessionForm['guided_practice'] = json_decode($lessionForm['guided_practice'], true);
            $lessionForm['informal_assessment'] = json_decode($lessionForm['informal_assessment'], true);
            $lessionForm['student_work'] = json_decode($lessionForm['student_work'], true);
            $lessionForm['formal_assessment'] = json_decode($lessionForm['formal_assessment'], true);
            $lessionForm['rubric'] = json_decode($lessionForm['rubric'], true);
            $lessionForm['differentiation'] = json_decode($lessionForm['differentiation'], true);
            $lessionForm['homework'] = json_decode($lessionForm['homework'], true);
            $lessionForm['additional_resources'] = json_decode($lessionForm['additional_resources'], true);
            $email = $request->email;

            $shareLink = null;
            $userExists = User::whereEmail($email)->first();
            $shareLink = URL::to('signup') . '/' . encrypt($lessionForm->id);
            if ($userExists) {
                $shareLink = URL::to('web-login') . '/' . encrypt($lessionForm->id);
            }

            $pdf = PDF::loadView('website.plan.view_pdf', ['plan' => $lessionForm]);
            Mail::send('website.plan.share_pdf', ['plan' => $lessionForm, 'shareLink' => $shareLink], function ($message) use ($pdf, $email) {
                $message->from('info@shared-lessons.org', 'Lesson Planning');
                $message->to($email)->subject('Share Lesson')
                    ->attachData($pdf->output(), "lesson.pdf");
            });
            session()->flash('success', 'Shared lesson successfully!');
        }
        return ['status' => 'true'];
    }

    public function edit($id)
    {
        $minitArray = range(1, 30);
        $suffixedArray = preg_filter('/$/', ' Minutes', $minitArray);
        $monthDays = array_combine($suffixedArray, $suffixedArray);
        $id = decrypt($id);
        $plan = $this->lesson->whereId($id)->first();
        $gradeData = $this->gradeField->whereNull('user_id')->orWhere('user_id',Auth::user()->id)->pluck('grade', 'grade')->toArray();
        $subjectData = $this->getGradeData($plan->grade, 1);
        $unitData = $this->getGradeData($plan->grade, 2);
        $methodData = $this->getSeperateData(3);
        $methodGroup = $this->getGradeData($plan->grade, 4);
        $sName = $this->getGradeData($plan->grade, 5);
        $sNumber = $this->getGradeData($plan->grade, 6);
        $sDescription = $this->getGradeData($plan->grade, 7);
        $eActivity = $this->getGradeData($plan->grade, 8);
        $eNotes = $this->getGradeData($plan->grade, 9);
        $aInformal = $this->getGradeData($plan->grade, 10);
        $aWork = $this->getGradeData($plan->grade, 11);
        $aFormal = $this->getGradeData($plan->grade, 12);
        $tAuthor = $this->getGradeData($plan->grade, 13);

        $unitD = $this->getSeperateData(1);
        $lessonD = $this->getSeperateData(2);
        $objData = $this->getGradeData($plan->grade, 16);
        $vocaData = $this->getGradeData($plan->grade, 17);
        $conData = $this->getGradeData($plan->grade, 18);
        $guideData = $this->getGradeData($plan->grade, 19);
        $rubricData = $this->getGradeData($plan->grade, 20);
        $methodDescData = $this->getSeperateData(4);
        $adminiData = $this->getGradeData($plan->grade, 22);
        $hWork = $this->getGradeData($plan->grade, 23);
        $hDescData = $this->getGradeData($plan->grade, 24);
        $addiResource = $this->getGradeData($plan->grade, 25);
        $addiDesc = $this->getGradeData($plan->grade, 26);
        $classData = $this->getGradeData($plan->grade, 27);
        $color = $this->Color->select('id','code', \DB::raw("CONCAT(name,' - ',code) AS color"))->pluck('color', 'code')->toArray();
        $firstColor = array_key_first($color);
        if ($plan) {
            $plan['date'] =  Carbon::parse($plan['date'])->format('m/d/Y');
            $plan['objective'] = json_decode($plan['objective'], true);
            $plan['standards'] = json_decode($plan['standards'], true);
            $plan['entry_activity'] = json_decode($plan['entry_activity'], true);
            $plan['notes'] = json_decode($plan['notes'], true);
            $plan['vocabulary'] = json_decode($plan['vocabulary'], true);
            $plan['concept_demonstration'] = json_decode($plan['concept_demonstration'], true);
            $plan['guided_practice'] = json_decode($plan['guided_practice'], true);
            $plan['informal_assessment'] = json_decode($plan['informal_assessment'], true);
            $plan['student_work'] = json_decode($plan['student_work'], true);
            $plan['formal_assessment'] = json_decode($plan['formal_assessment'], true);
            $plan['rubric'] = json_decode($plan['rubric'], true);
            $plan['differentiation'] = json_decode($plan['differentiation'], true);
            $plan['homework'] = json_decode($plan['homework'], true);
            $plan['additional_resources'] = json_decode($plan['additional_resources'], true);
        }
        return view('website.plan.edit', compact(
            'gradeData', 'monthDays', 'plan', 'subjectData', 'unitData',
            'sName', 'sNumber', 'sDescription', 'eActivity', 'eNotes', 'aInformal', 'aWork', 'aFormal',
            'methodData', 'methodGroup', 'tAuthor', 'unitD', 'lessonD', 'objData', 'vocaData',  'conData',
            'guideData', 'rubricData', 'methodDescData', 'adminiData', 'hWork', 'hDescData',
            'addiResource', 'addiDesc','classData','color','firstColor'
        ));
    }

    public function getList()
    {
        $userId = Auth::user()->id ?? null;
        $plan = $this->lesson->whereUserId($userId)->whereIsDraft(0)->orderBy('id','desc')->paginate(9);
        return view('website.plan.plan', compact('plan'));
    }

    public function getById($id)
    {
        $id = decrypt($id);
        $data = $this->lesson->whereId($id)->first();
        $plan = $data->toArray();
        if ($plan) {
            $plan['objective'] = json_decode($plan['objective'], true);
            $plan['standards'] = json_decode($plan['standards'], true);
            $plan['entry_activity'] = json_decode($plan['entry_activity'], true);
            $plan['notes'] = json_decode($plan['notes'], true);
            $plan['vocabulary'] = json_decode($plan['vocabulary'], true);
            $plan['concept_demonstration'] = json_decode($plan['concept_demonstration'], true);
            $plan['guided_practice'] = json_decode($plan['guided_practice'], true);
            $plan['informal_assessment'] = json_decode($plan['informal_assessment'], true);
            $plan['student_work'] = json_decode($plan['student_work'], true);
            $plan['formal_assessment'] = json_decode($plan['formal_assessment'], true);
            $plan['rubric'] = json_decode($plan['rubric'], true);
            $plan['differentiation'] = json_decode($plan['differentiation'], true);
            $plan['homework'] = json_decode($plan['homework'], true);
            $plan['additional_resources'] = json_decode($plan['additional_resources'], true);
        }
        return view('website.plan.view_form', compact('plan'));
    }

    public function generatePdf($id)
    {
        $data = $this->lesson->whereId($id)->first();
        $plan = $data->toArray();
        if ($plan) {
            $plan['objective'] = json_decode($plan['objective'], true);
            $plan['standards'] = json_decode($plan['standards'], true);
            $plan['entry_activity'] = json_decode($plan['entry_activity'], true);
            $plan['notes'] = json_decode($plan['notes'], true);
            $plan['vocabulary'] = json_decode($plan['vocabulary'], true);
            $plan['concept_demonstration'] = json_decode($plan['concept_demonstration'], true);
            $plan['guided_practice'] = json_decode($plan['guided_practice'], true);
            $plan['informal_assessment'] = json_decode($plan['informal_assessment'], true);
            $plan['student_work'] = json_decode($plan['student_work'], true);
            $plan['formal_assessment'] = json_decode($plan['formal_assessment'], true);
            $plan['rubric'] = json_decode($plan['rubric'], true);
            $plan['differentiation'] = json_decode($plan['differentiation'], true);
            $plan['homework'] = json_decode($plan['homework'], true);
            $plan['additional_resources'] = json_decode($plan['additional_resources'], true);
        }
        $pdf = PDF::loadView('website.plan.view_pdf', ['plan' => $plan]);
        return $pdf->stream('invoice.pdf');

        // return view('website.plan.view_pdf', compact('plan'));
    }

    public function deletePlan($id)
    {
        $id = decrypt($id);
        $lesson = $this->lesson->whereId($id)->first();
        $lesson->delete();
        session()->flash('success', 'Deleted lesson successfully!');
        return redirect('plan');
    }

    private function reIndexArray($field)
    {
        if (!empty($field) && !empty(array_filter($field))) {
            $data = array_combine(range(1, count($field)), array_values($field));
            return $data;
        }
        return $field;
    }

    private function uploadImage($imageData, $path)
    {
        $name = \Carbon\Carbon::now()->format('YmdHisu') . '.' . $imageData->getClientOriginalExtension();
        $destinationPath = $path;
        $imageData->move($destinationPath, $name);
        return $name;
    }

    private function getGradeData($grade, $type)
    {
        $data = $this->gradeField->whereGrade($grade)->whereType($type)->pluck('name', 'name')->toArray();
        return $data;
    }

    private function identifyAndAddGradeOptions($request)
    {
        $gradeData = array_filter($request->all([
            'teacher_authors','subject', 'unit_topic', 'method_data', 'standard_data', 'entry_data',
            'notes_data', 'informal', 'work', 'formal', 'objective_data', 'vocabulary_data', 'concept_data',
            'guided_data', 'rubric_data', 'home_data', 'additional_data','class'
        ]));
        $insideOptions = [
            'group_served','administering_method', 'standard_name', 'standard_number', 'standard_description',
            'entry_activity', 'notes', 'informal_assessment', 'student_work', 'formal_assessment',
            'objective', 'vocabulary', 'concept', 'guided_practice', 'rubric', 'homework',
            'homework_description', 'additional_resources', 'additional_description'
        ];
        $arrayOptions = [
            'method_data', 'standard_data', 'entry_data', 'notes_data', 'informal', 'work', 'formal',
            'objective_data', 'vocabulary_data', 'concept_data', 'guided_data', 'rubric_data',
            'home_data', 'additional_data'
        ];
        $gradeNewData  = [];
        if($request->grade){
            foreach ($gradeData as $key => $value) {
                if (in_array($key, $arrayOptions)) {
                    foreach ($value as $key2 => $value2) {
                        foreach ($value2 as $key3 => $value3) {
                            if (in_array($key3, $insideOptions) && $value3) {
                                $gradeNewData[$key3][] = $value3;
                            }
                        }
                    }
                } else {
                    $this->gradeField::updateOrCreate(
                        ['grade' => $request->grade, 'type' =>  $this->types[$key], 'name' => $value],
                        ['grade' => $request->grade, 'type' =>  $this->types[$key], 'name' => $value]
                    );
                }
            }
            foreach ($gradeNewData as $key => $value) {
                $value = array_unique($value);
                foreach ($value as $key1 => $value1) {
                    $this->gradeField::updateOrCreate(
                        ['grade' => $request->grade, 'type' =>  $this->types[$key], 'name' => $value1],
                        ['grade' => $request->grade, 'type' =>  $this->types[$key], 'name' => $value1]
                    );
                }
            }
        }
       
    }

    public function getSeperateData($type){
        $seperateGradeField = SeperateGradeField::where('type',$type)->pluck('name', 'name')->toArray();
        return $seperateGradeField;
    }

    public function seperateData($request){
        $methodName = $request->method_data;
        $mName = [];
        $mDesc = [];
        if(!empty($methodName)){
            $mName = array_column($methodName, 'method_name');
            $mName = array_filter($mName);
            $mDesc = array_column($methodName, 'method_description');
            $mDesc = array_filter($mDesc);
        }
        if(!empty($mDesc)){
            foreach($mDesc as $row){
                $this->checkSeperateData(4,$row);
            }
        }
        if(!empty($mName)){
            foreach($mName as $row){
                $this->checkSeperateData(3,$row);
            }
        }
        if($request->unit){
            $checkSData = $this->checkSeperateData(1,$request->unit);
        }
        if($request->lesson){
            $checkSData = $this->checkSeperateData(2,$request->lesson);
        }
    } 

    public function checkSeperateData($type,$name){
        $checkSData = SeperateGradeField::where('name',$name)->where('type',$type)->first();
        if(!$checkSData){
            $sData = new SeperateGradeField;
            $sData->type = $type;
            $sData->name = $name;
            $sData->save();
        }
    }

    public function importGradeField(Request $request){
        return view('website.plan.import.main_grade');
    }

    public function importMainGrade(Request $request){
        $extensions = array("xls","xlsx","xlm","xla","xlc","xlt","xlw",'csv');
        if(!$request->upload){
            Session::flash('upload_error','Please upload valid format.');
            return back();
        }
        $result = array($request->file('upload')->getClientOriginalExtension());

        if(!in_array($result[0],$extensions)){
            Session::flash('upload_error','Please upload valid format.');
            return back();
        }
        $import = new ExcelImport;
        \Excel::import($import, $request->upload);
        Session::flash('success','Your sheet successfully uploaded.');
        return back();
    }

    public function createDatabase(){
        $gradeData = $this->gradeField->where(function ($query) {
            $query->whereNull('user_id')
                ->orWhere('user_id',Auth::user()->id);
            })->pluck('grade', 'grade')->toArray();
        // $gradeData = $this->gradeField->whereNull('user_id')->orWhere('user_id',Auth::user()->id)->pluck('grade', 'grade')->toArray();
        return view('website.plan.database',compact('gradeData'));
    }

    public function storeDatabase(Request $request){
        $grade = $request->grade;
        if(!empty($request->subject) || !empty($request->unit_topic) || !empty($request->learning_target)){
            if(!empty($request->subject)){
                $this->sotreGData($grade,1,$request->subject);
            }
            if(!empty($request->unit_topic)){
                $this->sotreGData($grade,2,$request->unit_topic);
            }
            if(!empty($request->learning_target)){
                $this->sotreGData($grade,16,$request->learning_target);
            }
            Session::flash('success','Your data successfully added.');
            return back();
        }else{
            Session::flash('error','Please fill at least one field.');
            return back()->withInput();
        }
    }

    private function sotreGData($grade,$type,$name){
        $userId = Auth::user()->id;
        $checkGradeData = $this->gradeField->where('grade',$grade)->where('type',$type)->where('name',$name)->where('user_id',$userId)->first();
        if(!$checkGradeData){
            $gradeData = new $this->gradeField;
            $gradeData->grade = $grade;
            $gradeData->type = $type;
            $gradeData->name = $name;
            $gradeData->user_id = $userId;
            $gradeData->save();
        }
    }

    public function uploadSheetData(Request $request){
        $extensions = array("xls","xlsx","xlm","xla","xlc","xlt","xlw",'csv');
        if(!$request->upload){
            Session::flash('error','Please upload valid format.');
            return back();
        }
        $result = array($request->file('upload')->getClientOriginalExtension());
        if(!in_array($result[0],$extensions)){
            Session::flash('error','Please upload valid format.');
            return back();
        }
        $import = new UserExcelImport;
        \Excel::import($import, $request->upload);
        Session::flash('success','Your sheet successfully uploaded.');
        return back();
    }

    public function seo(){
        $seo = MetaSeo::first();
        return view('website.plan.meta',compact('seo'));
    }

    public function storeSeo(Request $request){
        if(!empty($request->description) || !empty($request->keywords) || !empty($request->author) || !empty($request->subject)){
            $checkSeo = MetaSeo::first();
            $metaSeo = new MetaSeo;
            if($checkSeo){
                $metaSeo = $checkSeo; 
            }
            $metaSeo->description = $request->description;
            $metaSeo->keywords = $request->keywords;
            $metaSeo->author = $request->author;
            $metaSeo->subject = $request->subject;
            $metaSeo->save();
            Session::flash('success','Your meta successfully added.');
            return back();
        }else{
            Session::flash('error','Please fill at least one field.');
            return back()->withInput();
        }
    }

    public function methodData(){
        return view('website.plan.import.method');
    }

    public function uploadMethodData(Request $request){
        $extensions = array("xls","xlsx","xlm","xla","xlc","xlt","xlw",'csv');
        if(!$request->upload){
            Session::flash('upload_error','Please upload sheet.');
            return back();
        }
        $result = array($request->file('upload')->getClientOriginalExtension());
        if(!in_array($result[0],$extensions)){
            Session::flash('upload_error','Please upload valid format.');
            return back();
        }
        $import = new MethodDatabase;
        \Excel::import($import, $request->upload);
        Session::flash('success','Your sheet successfully uploaded.');
        return back();
    }

    public function formCopy($planId){
        try{
            $planId = decrypt($planId);
            $plan = $this->lesson->find($planId);
            $copyPlan = $this->lesson;
            $copyPlan->user_id = Auth::user()->id;
            $copyPlan->is_draft = 0;
            $copyPlan->is_copy = 1;
            $copyPlan->teacher_authors = $plan->teacher_authors;
            $copyPlan->date = $plan->date;
            $copyPlan->subject = $plan->subject;
            $copyPlan->grade = $plan->grade;
            $copyPlan->class = $plan->class;
            $copyPlan->unit = $plan->unit;
            $copyPlan->unit_topic = $plan->unit_topic;
            $copyPlan->lesson = $plan->lesson;
            $copyPlan->objective = $plan->objective;
            $copyPlan->standards = $plan->standards;
            // entryData
            $oldEntryData = json_decode($plan->entry_activity,true);
            $entryData = $oldEntryData;
            if(!empty($oldEntryData['entry_data'])){
                foreach($oldEntryData['entry_data'] as $key=>$row){
                    $entryData['entry_data'][$key] = $row;
                    if(!empty($row['entry_attch'])){
                        $imageName = $this->getStringBetween($row['entry_attch'],'upload/','.');
                        $newPath = str_replace($imageName,$imageName.'_copy',$row['entry_attch']);
                        $this->docCopy($row['entry_attch'],$newPath);
                        $entryData['entry_data'][$key]['entry_attch'] = $newPath;
                    }
                }
            }
            $copyPlan->entry_activity = json_encode($entryData);
            // notesData
            $oldNotesData = json_decode($plan->notes,true);
            $notesData = $oldNotesData;
            if(!empty($oldNotesData['notes_data'])){
                foreach($oldNotesData['notes_data'] as $key=>$row){
                    $notesData['notes_data'][$key] = $row;
                    if(!empty($row['notes_attch'])){
                        $imageName = $this->getStringBetween($row['notes_attch'],'upload/','.');
                        $newPath = str_replace($imageName,$imageName.'_copy',$row['notes_attch']);
                        $this->docCopy($row['notes_attch'],$newPath);
                        $notesData['notes_data'][$key]['notes_attch'] = $newPath;
                    }
                }
            }
            $copyPlan->notes = json_encode($notesData);

            // vocabularyData
            $oldVocData = json_decode($plan->vocabulary,true);
            $vocData = $oldVocData;
            if(!empty($oldVocData['vocabulary_data'])){
                foreach($oldVocData['vocabulary_data'] as $key=>$row){
                    $vocData['vocabulary_data'][$key] = $row;
                    if(!empty($row['vocabulary_attch'])){
                        $imageName = $this->getStringBetween($row['vocabulary_attch'],'upload/','.');
                        $newPath = str_replace($imageName,$imageName.'_copy',$row['vocabulary_attch']);
                        $this->docCopy($row['vocabulary_attch'],$newPath);
                        $vocData['vocabulary_data'][$key]['vocabulary_attch'] = $newPath;
                    }
                }
            }
            $copyPlan->vocabulary = json_encode($vocData);

            // concept_demonstration
            $oldCDData = json_decode($plan->concept_demonstration,true);
            $cdData = $oldCDData;
            if(!empty($oldCDData['concept_data'])){
                foreach($oldCDData['concept_data'] as $key=>$row){
                    $cdData['concept_data'][$key] = $row;
                    if(!empty($row['concept_attch'])){
                        $imageName = $this->getStringBetween($row['concept_attch'],'upload/','.');
                        $newPath = str_replace($imageName,$imageName.'_copy',$row['concept_attch']);
                        $this->docCopy($row['concept_attch'],$newPath);
                        $cdData['concept_data'][$key]['concept_attch'] = $newPath;
                    }
                }
            }
            $copyPlan->concept_demonstration = json_encode($cdData);
            
            // guided_practice
            $oldGDData = json_decode($plan->guided_practice,true);
            $gdData = $oldGDData;
            if(!empty($oldGDData['guided_data'])){
                foreach($oldGDData['guided_data'] as $key=>$row){
                    $gdData['guided_data'][$key] = $row;
                    if(!empty($row['guided_attch'])){
                        $imageName = $this->getStringBetween($row['guided_attch'],'upload/','.');
                        $newPath = str_replace($imageName,$imageName.'_copy',$row['guided_attch']);
                        $this->docCopy($row['guided_attch'],$newPath);
                        $gdData['guided_data'][$key]['guided_attch'] = $newPath;
                    }
                }
            }
            $copyPlan->guided_practice = json_encode($gdData);

            // informal_assessment
            $oldInformalData = json_decode($plan->informal_assessment,true);
            $informalData = $oldInformalData;
            if(!empty($oldInformalData['informal_data'])){
                foreach($oldInformalData['informal_data'] as $key=>$row){
                    $informalData['informal_data'][$key] = $row;
                    if(!empty($row['informal_assessment_attch'])){
                        $imageName = $this->getStringBetween($row['informal_assessment_attch'],'upload/','.');
                        $newPath = str_replace($imageName,$imageName.'_copy',$row['informal_assessment_attch']);
                        $this->docCopy($row['informal_assessment_attch'],$newPath);
                        $informalData['informal_data'][$key]['informal_assessment_attch'] = $newPath;
                    }
                }
            }
            $copyPlan->informal_assessment = json_encode($informalData);

            // student_work
            $oldStData = json_decode($plan->student_work,true);
            $stData = $oldStData;
            if(!empty($oldStData['student_work_data'])){
                foreach($oldStData['student_work_data'] as $key=>$row){
                    $stData['student_work_data'][$key] = $row;
                    if(!empty($row['student_work_attch'])){
                        $imageName = $this->getStringBetween($row['student_work_attch'],'upload/','.');
                        $newPath = str_replace($imageName,$imageName.'_copy',$row['student_work_attch']);
                        $this->docCopy($row['student_work_attch'],$newPath);
                        $stData['student_work_data'][$key]['student_work_attch'] = $newPath;
                    }
                }
            }
            $copyPlan->student_work = json_encode($stData);

            // formal_assessment
            $oldFormalAssementData = json_decode($plan->formal_assessment,true);
            $fiData = $oldFormalAssementData;
            if(!empty($oldFormalAssementData['formal_assessment_data'])){
                foreach($oldFormalAssementData['formal_assessment_data'] as $key=>$row){
                    $fiData['formal_assessment_data'][$key] = $row;
                    if(!empty($row['formal_assessment_attch'])){
                        $imageName = $this->getStringBetween($row['formal_assessment_attch'],'upload/','.');
                        $newPath = str_replace($imageName,$imageName.'_copy',$row['formal_assessment_attch']);
                        $this->docCopy($row['formal_assessment_attch'],$newPath);
                        $fiData['formal_assessment_data'][$key]['formal_assessment_attch'] = $newPath;
                    }
                }
            }
            $copyPlan->formal_assessment = json_encode($fiData);

            // rubric
            $oldRubricData = json_decode($plan->rubric,true);
            $rubData = $oldRubricData;
            if(!empty($oldRubricData['rubric'])){
                foreach($oldRubricData['rubric'] as $key=>$row){
                    $rubData['rubric'][$key] = $row;
                    if(!empty($row['rubric_attch'])){
                        $imageName = $this->getStringBetween($row['rubric_attch'],'upload/','.');
                        $newPath = str_replace($imageName,$imageName.'_copy',$row['rubric_attch']);
                        $this->docCopy($row['rubric_attch'],$newPath);
                        $rubData['rubric'][$key]['rubric_attch'] = $newPath;
                    }
                }
            }
            $copyPlan->rubric = json_encode($rubData);

            $copyPlan->differentiation = $plan->differentiation;

            // homework
            $oldHomeWorkData = json_decode($plan->homework,true);
            $homeData = $oldHomeWorkData;
            if(!empty($oldHomeWorkData['home_data'])){
                foreach($oldHomeWorkData['home_data'] as $key=>$row){
                    $homeData['home_data'][$key] = $row;
                    if(!empty($row['homework_attch'])){
                        $imageName = $this->getStringBetween($row['homework_attch'],'upload/','.');
                        $newPath = str_replace($imageName,$imageName.'_copy',$row['homework_attch']);
                        $this->docCopy($row['homework_attch'],$newPath);
                        $homeData['home_data'][$key]['homework_attch'] = $newPath;
                    }
                }
            }
            $copyPlan->homework = json_encode($homeData);
            
            // additional_resources
            $oldAdditionalData = json_decode($plan->additional_resources,true);
            $additionalData = $oldAdditionalData;
            if(!empty($oldAdditionalData['additional_data'])){
                foreach($oldAdditionalData['additional_data'] as $key=>$row){
                    $additionalData['additional_data'][$key] = $row;
                    if(!empty($row['additional_attch'])){
                        $imageName = $this->getStringBetween($row['additional_attch'],'upload/','.');
                        $newPath = str_replace($imageName,$imageName.'_copy',$row['additional_attch']);
                        $this->docCopy($row['additional_attch'],$newPath);
                        $additionalData['additional_data'][$key]['additional_attch'] = $newPath;
                    }
                }
            }
            $copyPlan->additional_resources = json_encode($additionalData);
            $copyPlan->save();
            Session::flash('success','Your plan successfully copied.');
            return back();
        }catch(Exception $e){
            return back();
        }
    }

    private function docCopy($mainPath,$copyPath){
        if(file_exists($mainPath)){
            \File::copy($mainPath,$copyPath);
        }
        return true;
    }

    private function getStringBetween($str,$from,$to){
        $sub = substr($str, strpos($str,$from)+strlen($from),strlen($str));
        return substr($sub,0,strpos($sub,$to));
    }
}
