<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidatos', function (Blueprint $table) {
            $table->id();
            $table->string('DNI')->nullable();
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('fecha_nacimiento');    
            $table->boolean('javascript')->default(false);
            $table->boolean('php')->default(false);
            $table->boolean('html')->default(false);
            $table->boolean('css')->default(false);
            $table->string('curriculum')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidatos');
    }
};