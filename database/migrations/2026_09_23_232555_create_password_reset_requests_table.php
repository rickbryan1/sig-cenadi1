<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordResetRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
Schema::create('password_reset_requests', function (Blueprint $table) {
    $table->id();
    $table->string('email');
    $table->string('reason');
    $table->string('document_path')->nullable(); // Chemin vers le badge ou la CNI
    $table->string('status')->default('en_attente'); // en_attente,resolu
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
        Schema::dropIfExists('password_reset_requests');
    }
}
