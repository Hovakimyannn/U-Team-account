<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() : void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('LastName');
            $table->string('patronymic');
            $table->date('birthDate');
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedBigInteger('departmentId');
            $table->enum('position',
                [
                    'assistant',
                    'lecturer',
                    'seniorLecturer',
                    'associateProfessor',
                    'Professors'
                ]
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists('teachers');
    }
};
