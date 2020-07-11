<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use App\Models\GradeField;

class ExcelImport implements ToCollection
{

    private $data = [];

    /**
     * Refer : //https://stackoverflow.com/questions/58304723/too-few-arguments-to-function-maatwebsite-excel-excelimport-1-passed-and-at
     */
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
                    $this->checkGradeData($row[0],2,$row[1]);
                }
                if(!empty($row[2])){
                    $this->checkGradeData($row[0],5,$row[2]);
                }
                if(!empty($row[3])){
                    $this->checkGradeData($row[0],6,$row[3]);
                }
                if(!empty($row[4])){
                    $this->checkGradeData($row[0],7,$row[4]);
                }
            }
        }
    }


    public function getProjectData()
    {
        return $this->data;
    }

    private function checkGradeData($grade,$type,$name){
        $checkData = GradeField::where('grade',$grade)->where('type',$type)->where('name',$name)->first();
        if(!$checkData){
            $newData = new GradeField;
            $newData->grade = $grade;
            $newData->type = $type;
            $newData->name = $name;
            $newData->save();
        }
        return true;
    }
}
