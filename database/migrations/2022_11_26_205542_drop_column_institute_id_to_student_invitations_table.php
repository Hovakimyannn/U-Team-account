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
    public function up()
    {
        Schema::table('student_invitations', function (Blueprint $table) {
            $table->dropConstrainedForeignId('institute_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_invitations', function (Blueprint $table) {
            $table->unsignedBigInteger('institute_id');
            $table->foreign('institute_id')
                ->references('id')
                ->on('institutes')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }
};
