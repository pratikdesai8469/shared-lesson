<?php

namespace App\Models;

use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use App\Models\SeperateGradeField;

class MethodDatabase implements ToCollection
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
                    $this->checkMethodData($row[0],3);
                }
                if(!empty($row[1])){
                    $this->checkMethodData($row[1],4);
                }
        }
    }


    public function getProjectData()
    {
        return $this->data;
    }

    private function checkMethodData($name,$type){
        $checkData = SeperateGradeField::where('name',$name)->where('type',$type)->first();
        if(!$checkData){
            $newData = new SeperateGradeField;
            $newData->name = $name;
            $newData->type = $type;
            $newData->save();
        }
        return true;
    }
}

