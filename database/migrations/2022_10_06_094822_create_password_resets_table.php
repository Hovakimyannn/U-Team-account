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
    public function up() : void
    {
//        Schema::create('password_resets', function (Blueprint $table) {
//            $table->string('admin_email')->index();
//            $table->string('student_email')->index();
//            $table->string('teacher_email')->index();
//            $table->foreign('admin_email')->references('email')->on('admins');
//            $table->foreign('student_email')->references('email')->on('students');
//            $table->foreign('teacher_email')->references('email')->on('teachers');
//            $table->string('token');
//            $table->timestamp('created_at')->nullable();
//        });
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists('password_resets');
    }
};
