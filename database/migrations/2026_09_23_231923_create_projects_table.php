<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
    Schema::create('projects', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Nom officiel du projet
        $table->text('objectives')->nullable(); // Objectifs institutionnels
        $table->date('start_date')->nullable(); // Date de début
        $table->date('end_date')->nullable(); // Date de fin prévue
        $table->decimal('budget_allocated', 15, 2)->default(0); // Budget global alloué (FCFA)
        $table->string('status')->default('brouillon'); // brouillon, en_attente_validation, planifie, archive
        $table->unsignedBigInteger('user_id'); // Chef de projet responsable
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->timestamps();
        if (!Schema::hasColumn('projects', 'evaluation_report')) {
        $table->string('evaluation_report')->nullable();
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
        Schema::dropIfExists('projects');
    }
}
