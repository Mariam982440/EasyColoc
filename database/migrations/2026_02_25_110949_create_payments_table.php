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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
        
            // celui qui doit de l'argent
            $table->foreignId('debtor_id')->constrained('users');
            
            // celui qui doit recevoir l'argent
            $table->foreignId('creditor_id')->constrained('users');
            
            $table->foreignId('colocation_id')->constrained()->onDelete('cascade');
            
            $table->decimal('amount', 10, 2);
            
            // est ce que le remboursement a été fait 
            $table->boolean('is_paid')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
