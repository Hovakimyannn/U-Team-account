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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->enum(
                'degree',
                [
                    'bachelor',
                    'master',
                    'PhD'
                ]
            );
            $table->enum(
                'type',
                [
                    'available',
                    'remotely'
                ]
            );
            $table->unsignedBigInteger('department_id');
            $table->timestamps();
            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists('courses');
    }
};
