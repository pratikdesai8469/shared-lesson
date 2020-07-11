<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeperateGradeFieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('separate_grade_field', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('type')->comment('1=unit,2=lesson,3=method_name,4=method_description');
            $table->timestamps();
        });

        Schema::table('lesson', function (Blueprint $table) {
            $table->string('class')->nullable()->after('grade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('separate_grade_field');

        Schema::table('lesson', function (Blueprint $table) {
            $table->dropColumn('class');
        });
    }
}
