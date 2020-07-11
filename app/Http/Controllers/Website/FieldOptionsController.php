<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GradeField;
use Validator;
use Auth;

class FieldOptionsController extends Controller
{
    private $gradeField;

    private $types= [
        "subject"=> 1,
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
    ];

    public function __construct()
    {
        $this->gradeField = new GradeField();
    }

    public function create()
    {
        $gradeData = $this->gradeField::pluck('grade', 'grade')->toArray();
        return view('website.plan.create_grade_options', compact('gradeData'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'grade' => 'required',
        ]);
        $predefineArray = [
            'subject', 'unit_topic', 'method_name', 'group_served', 'standard_name', 'standard_number', 'standard_description',
            'entry_activity', 'notes', 'informal_assessment', 'student_work', 'formal_assessment'
        ];
        $data = array_filter($request->all($predefineArray));
        foreach ($data as $key => $value) {
            $this->gradeField::updateOrCreate(
                ['grade' => strtolower($request->grade), 'type'=>  $this->types[$key], 'name' => $value],
                ['grade' => strtolower($request->grade), 'type'=>  $this->types[$key], 'name' => $value]
            );
        }
        return back()->with('success','Add successfully!');
    }

    public function getOptions(Request $request)
    {
        $data = $this->gradeField->where(function ($query) {
                    $query->whereNull('user_id')
                        ->orWhere('user_id',Auth::user()->id);
                    })->where('grade', $request->grade)->get();
        // $data = $this->gradeField->where('grade', $request->grade)->get();
        $grouped = $data->groupBy('type');
        return response()->json($grouped);
    }
}
