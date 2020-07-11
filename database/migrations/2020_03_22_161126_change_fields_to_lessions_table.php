<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldsToLessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lessions', function (Blueprint $table) {
            $table->text('objective')->nullable(true)->change();
            $table->text('standard')->nullable(true)->change();
            $table->text('standard_duration')->nullable(true)->change();
            $table->text('starter')->nullable(true)->change();
            $table->text('starter_duration')->nullable(true)->change();
            $table->text('mini_lession')->nullable(true)->change();
            $table->text('mini_lession_duration')->nullable(true)->change();
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
            $table->text('objective')->nullable(false)->change();
            $table->text('standard')->nullable(false)->change();
            $table->text('standard_duration')->nullable(false)->change();
            $table->text('starter')->nullable(false)->change();
            $table->text('starter_duration')->nullable(false)->change();
            $table->text('mini_lession')->nullable(false)->change();
            $table->text('mini_lession_duration')->nullable(false)->change();
        });
    }
}
