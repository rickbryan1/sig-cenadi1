<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            if (!Schema::hasColumn('projects', 'description')) $table->text('description')->nullable();
            if (!Schema::hasColumn('projects', 'resources')) $table->text('resources')->nullable();
            if (!Schema::hasColumn('projects', 'sponsor_id')) $table->unsignedBigInteger('sponsor_id')->nullable();
        });

        Schema::table('tasks', function (Blueprint $table) {
            if (!Schema::hasColumn('tasks', 'estimated_days')) $table->integer('estimated_days')->default(1);
            if (!Schema::hasColumn('tasks', 'expected_deliverables_count')) $table->integer('expected_deliverables_count')->default(1);
            if (!Schema::hasColumn('tasks', 'uploaded_deliverables_count')) $table->integer('uploaded_deliverables_count')->default(0);
        });

        // Table pivot project_user si elle n'existe pas
        if (!Schema::hasTable('project_user')) {
            Schema::create('project_user', function (Blueprint $table) {
                $table->id();
                $table->foreignId('project_id')->constrained()->onDelete('cascade');
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        // rollback si besoin
    }
};