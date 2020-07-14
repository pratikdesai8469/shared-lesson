<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsDraftToLessonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lesson', function (Blueprint $table) {
            $table->tinyInteger('is_draft')->default(0)->after('user_id');
            $table->string('teacher_authors')->nullable()->change();
            $table->date('date')->nullable()->change();
            $table->string('subject')->nullable()->change();
            $table->string('grade')->nullable()->change();
            $table->string('lesson')->nullable()->change();
            $table->string('unit_topic')->nullable()->change();
            $table->string('unit')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lesson', function (Blueprint $table) {
            $table->dropColumn(['is_draft']);
        });
    }
}
