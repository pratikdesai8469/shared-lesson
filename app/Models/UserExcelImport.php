<?php

namespace App\Models;

use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use App\Models\GradeField;
use Auth;

class UserExcelImport implements ToCollection
{

    private $data = [];

    public function collection(Collection $rows)
    {
        $this->data = [];
        foreach ($rows as $key => $row) {
            if($key == 0) {
                continue;
            }
            $gData = [];
            if(!empty($row[0])){
                if(!empty($row[1])){
                    $this->checkGradeData($row[0],1,$row[1]);
                }
                if(!empty($row[2])){
                    $this->checkGradeData($row[0],2,$row[2]);
                }
                if(!empty($row[3])){
                    $this->checkGradeData($row[0],16,$row[3]);
                }
            }
        }
    }


    public function getProjectData()
    {
        return $this->data;
    }

    private function checkGradeData($grade,$type,$name){
        $userId = Auth::user()->id;
        $checkGradeData = GradeField::where('grade',$grade)->where('type',$type)->where('name',$name)->where('user_id',$userId)->first();
        if(!$checkGradeData){
            $newData = new GradeField;
            $newData->grade = $grade;
            $newData->type = $type;
            $newData->name = $name;
            $newData->user_id = $userId;
            $newData->save();
        }
        return true;
    }
}
