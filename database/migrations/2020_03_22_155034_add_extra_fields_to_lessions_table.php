<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldsToLessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lessions', function (Blueprint $table) {
            $table->text('guided_practice')->nullable(true)->after('mini_lession_duration');
            $table->text('guided_practice_duration')->nullable(true)->after('guided_practice');
            $table->text('informal_assessment')->nullable(true)->after('guided_practice_duration');
            $table->text('informal_assessment_duration')->nullable(true)->after('informal_assessment');
            $table->text('student_work')->nullable(true)->after('informal_assessment_duration');
            $table->text('student_work_duration')->nullable(true)->after('student_work');
            $table->text('student_work_option_1')->nullable(true)->after('student_work_duration');
            $table->text('student_work_option_1_duration')->nullable(true)->after('student_work_option_1');
            $table->text('student_work_option_2')->nullable(true)->after('student_work_option_1_duration');
            $table->text('student_work_option_2_duration')->nullable(true)->after('student_work_option_2');
            $table->text('extra_credit')->nullable(true)->after('student_work_option_2_duration');
            $table->text('extra_credit_duration')->nullable(true)->after('extra_credit');
            $table->text('differentiation')->nullable(true)->after('extra_credit_duration');
            $table->text('differentiation_duration')->nullable(true)->after('differentiation');
            $table->text('materials')->nullable(true)->after('differentiation_duration');
            $table->text('materials_duration')->nullable(true)->after('materials');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lessions', function (Blueprint $table) {
            $table->dropColumn([
                'guided_practice', 'guided_practice_duration', 'informal_assessment', 'informal_assessment_duration', 'student_work', 'student_work_duration',
                'student_work_option_1', 'student_work_option_1_duration', 'student_work_option_2', 'student_work_option_2_duration', 'extra_credit', 'extra_credit_duration', 'differentiation', 'differentiation_duration', 'materials', 'materials_duration'
            ]);
        });
    }
}


