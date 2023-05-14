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
        Schema::table('schedules', function (Blueprint $table) {
            if (!Schema::hasColumn('schedules', 'name')) {
                $table->string('name');
            }

            if (!Schema::hasColumn('schedules', 'size')) {
                $table->integer('size');
            }

            if (!Schema::hasColumn('schedules', 'extension')) {
                $table->string('extension');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedules', function (Blueprint $table) {
            if (Schema::hasColumn('schedules', 'name')) {
                $table->dropColumn('name');
            }

            if (Schema::hasColumn('schedules', 'size')) {
                $table->dropColumn('size');
            }

            if (Schema::hasColumn('schedules', 'extension')) {
                $table->dropColumn('extension');
            }
        });
    }
};
