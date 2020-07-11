<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson', function (Blueprint $table) {
            $table->id();
            $table->string('teacher_authors', 100);
            $table->date('date');
            $table->string('subject');
            $table->string('grade');
            $table->string('unit');
            $table->string('unit_topic');
            $table->string('lesson');
            $table->text('objective')->nullable();
            $table->text('standards')->nullable();
            $table->text('entry_activity')->nullable();
            $table->text('notes')->nullable();
            $table->text('vocabulary')->nullable();
            $table->text('concept_demonstration')->nullable();
            $table->text('guided_practice')->nullable();
            $table->text('informal_assessment')->nullable();
            $table->text('student_work')->nullable();
            $table->text('formal_assessment')->nullable();
            $table->text('rubric')->nullable();
            $table->text('differentiation')->nullable();
            $table->text('homework')->nullable();
            $table->text('additional_resources')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lesson');
    }
}
