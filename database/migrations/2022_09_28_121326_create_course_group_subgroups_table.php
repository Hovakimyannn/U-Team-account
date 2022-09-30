<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_group_subgroups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('subGroup_id');
            $table->unique(['course_id', 'group_id', 'subGroup_id']);
            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('group_id')->references('id')->on('groups');
            $table->foreign('subGroup_id')->references('id')->on('subgroups');
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
        Schema::dropIfExists('course_group_subgroups');
    }
};
