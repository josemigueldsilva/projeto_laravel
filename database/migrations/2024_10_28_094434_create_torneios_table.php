<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('torneios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->integer('quantidade_times');
            $table->json('times'); // Armazena os times que participam do torneio
            $table->string('formato');
            $table->integer('times_por_grupo')->nullable(); // Número de times por grupo, se aplicável
            $table->json('resultados')->nullable(); // Para armazenar os resultados dos jogos (atualmente não utilizado)
            $table->json('pontuacoes')->nullable(); // Para armazenar as pontuações dos times
            $table->unsignedBigInteger('user_id'); // Adicionando o campo user_id
            $table->timestamps();

            // Adicionando a chave estrangeira
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('torneios', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Remove a chave estrangeira
        });
        
        Schema::dropIfExists('torneios');
    }
};
