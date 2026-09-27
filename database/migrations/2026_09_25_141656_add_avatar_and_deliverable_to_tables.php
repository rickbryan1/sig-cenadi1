<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable();
            }
        });

        Schema::table('tasks', function (Blueprint $table) {
            if (!Schema::hasColumn('tasks', 'deliverable_file')) {
                $table->string('deliverable_file')->nullable();
            }
            if (!Schema::hasColumn('tasks', 'blockage_reason')) {
                $table->text('blockage_reason')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar');
        });
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('deliverable_file');
            $table->dropColumn('blockage_reason');
        });
    }
};