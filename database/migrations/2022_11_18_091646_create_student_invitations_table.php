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
        Schema::create('student_invitations', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('Last_name');
            $table->string('patronymic');
            $table->date('birth_date');
            $table->string('email')->unique();
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('group_id');
            $table->string('token');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('group_id')->references('id')->on('groups');
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
        Schema::dropIfExists('student_invitations');
    }
};
