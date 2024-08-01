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
        // Criar Tabelas para Pessoas
        Schema::create('pessoas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('nome_social')->nullable();
            $table->string('cpf')->unique();
            $table->string('nome_pai')->nullable();
            $table->string('nome_mae')->nullable();
            $table->string('telefone')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });

        // Criar Tabelas para Endereços
        Schema::create('enderecos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pessoa_id')->constrained()->onDelete('cascade');
            $table->string('tipo_endereco');
            $table->string('cep');
            $table->string('logradouro');
            $table->string('numero');
            $table->string('complemento')->nullable();
            $table->string('bairro');
            $table->string('estado');
            $table->string('cidade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pessoas');
        Schema::dropIfExists('enderecos');
    }
};
