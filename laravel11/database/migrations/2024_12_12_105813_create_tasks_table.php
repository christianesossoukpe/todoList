<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Titre de la tâche
            $table->text('description'); // Description de la tâche
            $table->enum('status', ['in_progress', 'completed']); // Statut de la tâche
            $table->enum('category', ['work', 'personal', 'urgent', 'low_priority']); // Catégories de la tâche
            $table->date('due_date'); // Date limite
             $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
