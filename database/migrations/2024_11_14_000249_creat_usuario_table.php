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
        Schema::create('usuario', function (Blueprint $table) {
            $table->id(); 
            $table->string('nombre', 100); 
            $table->string('correo_electronico', 100)->unique(); 
            $table->string('usuario', 50)->unique(); 
            $table->string('clave'); 
            $table->date('fecha_nacimiento')->nullable(); 
            $table->string('telefono', 20)->nullable(); 
            $table->string('direccion', 255)->nullable(); 
            $table->timestamps(); 
            $table->enum('rol', ['admin', 'usuario', 'moderador'])->default('usuario'); 
            $table->enum('estado', ['activo', 'inactivo'])->default('activo'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
