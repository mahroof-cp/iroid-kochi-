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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); 
            $table->text('description');
            $table->string('logo')->nullable(); 
            $table->string('contact_number'); 
            $table->decimal('annual_turnover', 15, 2); 
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users'); 
            $table->timestamps(); 
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
