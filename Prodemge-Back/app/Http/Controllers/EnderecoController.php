<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EnderecoModel;
use App\Models\PessoaModel;

class EnderecoController extends Controller
{

    /**
    * @OA\Post(
    *     path="/api/pessoas/{id}/enderecos",
    *     tags={"Endereço"},
    *     summary="Adicionar endereço para uma pessoa",
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID da pessoa",
    *         required=true,
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="tipo_endereco", type="string"),
    *             @OA\Property(property="cep", type="string"),
    *             @OA\Property(property="logradouro", type="string"),
    *             @OA\Property(property="numero", type="string"),
    *             @OA\Property(property="complemento", type="string"),
    *             @OA\Property(property="bairro", type="string"),
    *             @OA\Property(property="estado", type="string"),
    *             @OA\Property(property="cidade", type="string")
    *         )
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="Endereço adicionado com sucesso.",
    *         @OA\JsonContent(
    *             @OA\Property(property="id", type="integer"),
    *             @OA\Property(property="tipo_endereco", type="string"),
    *             @OA\Property(property="cep", type="string"),
    *             @OA\Property(property="logradouro", type="string"),
    *             @OA\Property(property="numero", type="string"),
    *             @OA\Property(property="complemento", type="string"),
    *             @OA\Property(property="bairro", type="string"),
    *             @OA\Property(property="estado", type="string"),
    *             @OA\Property(property="cidade", type="string"),
    *             @OA\Property(property="pessoa_id", type="integer")
    *         )
    *     )
    * )
    */
    public function addEndereco(Request $request, $id)
    {
        $validacao = $request->validate([
            'tipo_endereco' => 'required|string',
            'cep' => 'required|string',
            'logradouro' => 'required|string',
            'numero' => 'required|string',
            'complemento' => 'nullable|string',
            'bairro' => 'required|string',
            'estado' => 'required|string',
            'cidade' => 'required|string'
        ]);

        // Verificar se a pessoa existe
        $pessoa = PessoaModel::findOrFail($id);

        // Criar o endereço
        $endereco = new EnderecoModel($validacao);
        $endereco->pessoa_id = $id;
        $endereco->save();

        return response()->json($endereco, 201);
    }


    /**
    * @OA\Get(
    *     path="/api/endereco/{id}",
    *     tags={"Endereço"},
    *     summary="Obter endereço por ID",
    *     @OA\Parameter(
    *           name="id", 
    *           in="path", 
    *           required=true,
    *           @OA\Schema(type="integer")),
    *     @OA\Response(response="200", description="Detalhes do endereço."),
    * )
    */
    public function show($id)
    {
        $endereco = EnderecoModel::find($id);

        if (!$endereco) {
            return response()->json(['message' => 'Endereço não encontrado.'], 404);
        }

        return response()->json($endereco);
    }


    /**
    * @OA\Put(
    *     path="/api/endereco/{id}",
    *     tags={"Endereço"},
    *     summary="Atualização de endereço",
    *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="tipo_endereco", type="string"),
    *             @OA\Property(property="cep", type="string"),
    *             @OA\Property(property="logradouro", type="string"),
    *             @OA\Property(property="numero", type="string"),
    *             @OA\Property(property="complemento", type="string"),
    *             @OA\Property(property="bairro", type="string"),
    *             @OA\Property(property="estado", type="string"),
    *             @OA\Property(property="cidade", type="string")
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Endereço atualizado com sucesso.",
    *         @OA\JsonContent(
    *             @OA\Property(property="id", type="integer"),
    *             @OA\Property(property="pessoa_id", type="integer"),
    *             @OA\Property(property="tipo_endereco", type="string"),
    *             @OA\Property(property="cep", type="string"),
    *             @OA\Property(property="logradouro", type="string"),
    *             @OA\Property(property="numero", type="string"),
    *             @OA\Property(property="complemento", type="string"),
    *             @OA\Property(property="bairro", type="string"),
    *             @OA\Property(property="estado", type="string"),
    *             @OA\Property(property="cidade", type="string")
    *         )
    *     ),
    *     @OA\Response(response="404", description="Endereço não encontrado.")
    * )
    */
    public function update(Request $request, $id)
    {
        $endereco = EnderecoModel::find($id);

        if (!$endereco) {
            return response()->json(['message' => 'Endereço não encontrado.'], 404);
        }

        $validated = $request->validate([
            'tipo_endereco' => 'required|in:Residencial,Comercial',
            'cep' => 'required|string',
            'logradouro' => 'required|string',
            'numero' => 'required|string',
            'complemento' => 'nullable|string',
            'bairro' => 'required|string',
            'estado' => 'required|string',
            'cidade' => 'required|string'
        ]);

        $endereco->update($validated);
        return response()->json($endereco);
    }

    /**
    * @OA\Delete(
    *     path="/api/endereco/{id}",
    *     tags={"Endereço"},
    *     summary="Excluir endereço pelo ID",
    *     @OA\Parameter(
    *         name="id", 
    *         in="path", 
    *         required=true, 
    *         @OA\Schema(type="integer")),
    *     @OA\Response(response="204", description="Endereço deletado."),
    * )
    */
    public function destroy($id)
    {
        $endereco = EnderecoModel::find($id);

        if (!$endereco) {
            return response()->json(['message' => 'Endereço não encontrado.'], 404);
        }

        $endereco->delete();
        return response()->json(['message' => 'Endereço deletado com sucesso.']);
    }

}