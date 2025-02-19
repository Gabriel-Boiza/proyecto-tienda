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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();  // Esto crea un campo de tipo unsignedBigInteger
            $table->string('nombre');
            $table->string('descripcion');
            $table->float('precio');
            $table->integer('stock');
            $table->string('imagen_principal');
            $table->integer('descuento');
            $table->unsignedBigInteger('fk_marca');  // Esto debe ser unsignedBigInteger
            $table->timestamps();
        
            // Definir la clave foránea
            $table->foreign('fk_marca')->references('id')->on('marcas')->onDelete('cascade');
        });
        
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
