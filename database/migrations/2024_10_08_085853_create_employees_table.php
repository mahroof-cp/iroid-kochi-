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
        Schema::create('employees', function (Blueprint $table) {
            $table->id(); 
            $table->string('name'); 
            $table->string('email')->unique(); 
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade'); 
            $table->string('mobile_number'); 
            $table->string('image')->nullable(); 
            $table->date('join_date'); 
            $table->foreignId('created_by')->constrained('users'); 
            $table->foreignId('updated_by')->constrained('users'); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
