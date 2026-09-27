<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
    Schema::create('tasks', function (Blueprint $table) {
        $table->id();
        $table->string('title'); // Intitulé de la tâche
        $table->text('description')->nullable(); // Description détaillée
        $table->integer('estimated_days')->default(1); // Durée estimée en jours
        $table->date('start_date')->nullable(); // Date de début
        $table->date('due_date')->nullable(); // Date d'échéance
        $table->integer('progress')->default(0); // Pourcentage d'avancement (0 à 100)
        $table->string('status')->default('en_cours'); // en_cours, bloque, en_validation, termine
        $table->text('blockage_reason')->nullable(); // Motif du blocage si signalé
        $table->string('deliverable_file')->nullable(); // Chemin du fichier livrable / preuve
        
        // Relations
        $table->unsignedBigInteger('project_id'); // Projet lié
        $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        
        $table->unsignedBigInteger('user_id'); // Membre de l'équipe assigné
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        
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
        Schema::dropIfExists('tasks');
    }
}
