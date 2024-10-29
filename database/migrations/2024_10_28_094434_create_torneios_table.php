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
            $table->id(); // ID do torneio
            $table->string('nome'); // Nome do torneio
            $table->text('descricao')->nullable(); // Descrição do torneio
            $table->integer('quantidade_times'); // Número total de times
            $table->json('times'); // Armazena os times que participam do torneio
            $table->json('confrontos')->nullable(); // Armazena os confrontos do torneio de eliminação
            $table->json('pontuacoes')->nullable(); // Armazena as pontuações dos times
            $table->string('campeao')->nullable(); // Adiciona a coluna campeao
            $table->unsignedBigInteger('user_id'); // ID do usuário que criou o torneio
            $table->timestamps(); // Campos para controle de data de criação e atualização

            // Adicionando a chave estrangeira para o usuário
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('torneios', function (Blueprint $table) {
            // Remove a chave estrangeira antes de excluir a tabela
            $table->dropForeign(['user_id']); 
        });
        
        Schema::dropIfExists('torneios'); // Exclui a tabela
    }
};
