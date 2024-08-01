<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnderecoModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'pessoa_id', 
        'tipo_endereco', 
        'cep', 
        'logradouro', 
        'numero', 
        'complemento', 
        'bairro', 
        'estado', 
        'cidade'
    ];

    public function pessoa()
    {
        return $this->belongsTo(PessoaModel::class);
    }

    protected $table = 'enderecos';

}
