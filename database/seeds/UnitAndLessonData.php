<?php

use Illuminate\Database\Seeder;
use App\Models\SeperateGradeField;

class UnitAndLessonData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i<=30; $i++){
            $sData = new SeperateGradeField;
            $sData->name = $i;
            $sData->type = 1;
            $sData->save();
        }
        
        for($i=1; $i<=100; $i++){
            $sData = new SeperateGradeField;
            $sData->name = $i;
            $sData->type = 2;
            $sData->save();
        }
    }
}
