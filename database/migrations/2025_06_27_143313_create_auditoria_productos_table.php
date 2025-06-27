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
        Schema::create('auditoria_productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto_id');
            $table->string('accion'); // 'eliminado', 'restaurado', 'eliminado_permanente'
            $table->text('razon')->nullable(); // Razón del evento
            $table->unsignedBigInteger('user_id'); // Usuario que realizó la acción
            $table->json('datos_antes')->nullable(); // Estado anterior del producto
            $table->json('datos_despues')->nullable(); // Estado posterior del producto
            $table->timestamp('fecha_evento');
            $table->timestamps();

            // Índices para mejor rendimiento
            $table->index(['producto_id', 'accion']);
            $table->index('user_id');
            $table->index('fecha_evento');

            // Relaciones foráneas
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditoria_productos');
    }
};
