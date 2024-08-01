<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PessoaModel;

/**
* @OA\Info(
*     title="API Documentation",
*     version="1.0.0",
*     description="Documentação da API"
* )
* @OA\Tag(name="Pessoa", description="API Endpoints")
*/

class PessoaController extends Controller
{
    /**
    * @OA\Get(
    *     path="/api/pessoas",
    *     tags={"Pessoas"},
    *     summary="Lista de pessoas",
    *     @OA\Response(response="200", description="Toda a Lista de Pessoas.")
    * )
    */
    public function index()
    {
        return PessoaModel::all();
    }


    /**
    * @OA\Post(
    *     path="/api/pessoas",
    *     tags={"Pessoas"},
    *     summary="Criação de pessoa",
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="nome", type="string"),
    *             @OA\Property(property="nome_social", type="string"),
    *             @OA\Property(property="cpf", type="string"),
    *             @OA\Property(property="nome_pai", type="string"),
    *             @OA\Property(property="nome_mae", type="string"),
    *             @OA\Property(property="telefone", type="string"),
    *             @OA\Property(property="email", type="string")
    *         )
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="Pessoa criada com sucesso.",
    *         @OA\JsonContent(
    *             @OA\Property(property="id", type="integer"),
    *             @OA\Property(property="nome", type="string"),
    *             @OA\Property(property="nome_social", type="string"),
    *             @OA\Property(property="cpf", type="string"),
    *             @OA\Property(property="nome_pai", type="string"),
    *             @OA\Property(property="nome_mae", type="string"),
    *             @OA\Property(property="telefone", type="string"),
    *             @OA\Property(property="email", type="string")
    *         )
    *     )
    * )
    */
    public function store(Request $request)
    {
        // Validação de entrada
        $validacao = $request->validate([
            'nome' => 'required|string',
            'nome_social' => 'required|string',
            'cpf' => 'required|string|unique:pessoas',
            'nome_pai' => 'required|string',
            'nome_mae' => 'required|string',
            'telefone' => 'required|string',
            'email' => 'required|string',
        ]);

        $pessoa = PessoaModel::create($validacao);
        return response()->json($pessoa, 201);
    }


    /**
    * @OA\Get(
    *     path="/api/pessoas/{id}",
    *     tags={"Pessoas"},
    *     summary="GET pessoas por ID",
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="Id de pessoas",
    *         required=true,
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(response="200", description="Dados de pessoas.")
    * )
    */
    public function show($id)
    {
        return PessoaModel::findOrFail($id);
    }


    /**
    * @OA\Put(
    *     path="/api/pessoas/{id}",
    *     tags={"Pessoas"},
    *     summary="Atualização de pessoa",
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="ID da pessoa a ser atualizada",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="nome", type="string"),
    *             @OA\Property(property="nome_social", type="string"),
    *             @OA\Property(property="cpf", type="string"),
    *             @OA\Property(property="nome_pai", type="string"),
    *             @OA\Property(property="nome_mae", type="string"),
    *             @OA\Property(property="telefone", type="string"),
    *             @OA\Property(property="email", type="string")
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Pessoa atualizada com sucesso.",
    *         @OA\JsonContent(
    *             @OA\Property(property="id", type="integer"),
    *             @OA\Property(property="nome", type="string"),
    *             @OA\Property(property="nome_social", type="string"),
    *             @OA\Property(property="cpf", type="string"),
    *             @OA\Property(property="nome_pai", type="string"),
    *             @OA\Property(property="nome_mae", type="string"),
    *             @OA\Property(property="telefone", type="string"),
    *             @OA\Property(property="email", type="string")
    *         )
    *     )
    * )
    */
    public function update(Request $request, $id)
    {
        $pessoa = PessoaModel::findOrFail($id);
        $pessoa->update($request->all());
        return response()->json($pessoa);
    }


    /**
    * @OA\Delete(
    *     path="/api/pessoas/{id}",
    *     tags={"Pessoas"},
    *     summary="Excluir pessoas pelo ID",
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID de pessoas",
    *         required=true,
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(response="204", description="Pessoa Deletada.")
    * )
    */
    public function destroy($id)
    {
        $pessoa = PessoaModel::findOrFail($id);

        if (!$pessoa) {
            return response()->json(['message' => 'Pessoa não encontrado.'], 404);
        }

        $pessoa->delete();
        return response()->json(null, 204);
    }

}