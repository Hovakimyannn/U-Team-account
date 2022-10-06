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
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('adminEmail')->index();
            $table->string('studentEmail')->index();
            $table->string('teacherEmail')->index();
            $table->foreign('adminEmail')->references('email')->on('admins');
            $table->foreign('studentEmail')->references('email')->on('students');
            $table->foreign('teacherEmail')->references('email')->on('teachers');
            $table->string('token');
            $table->timestamp('created_at')->nullable();
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
