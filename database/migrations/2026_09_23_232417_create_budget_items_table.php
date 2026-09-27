<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
    Schema::create('budget_items', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('project_id'); // Projet concerné
        $table->string('type'); // 'rh' (Ressources Humaines) ou 'materiel' (Équipements) ou 'prestation'
        $table->string('label'); // Intitulé de la ressource ou de la dépense (ex: "Ingénieur Système", "Baies Serveurs")
        $table->decimal('daily_rate', 12, 2)->nullable(); // Taux journalier (pour les RH)
        $table->integer('estimated_volume')->default(0); // Volume estimé (ex: jours prévus)
        $table->integer('actual_volume')->default(0); // Volume effectif (ex: jours réalisés)
        $table->decimal('estimated_cost', 15, 2); // Coût total prévisionnel (FCFA)
        $table->decimal('actual_cost', 15, 2); // Coût total réel / facturé (FCFA)
        
        // Relation
        $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        
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
        Schema::dropIfExists('budget_items');
    }
}
