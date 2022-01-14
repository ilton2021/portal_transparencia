<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class contratacao_servicos extends Model
{
    protected $table = 'contratacao_servicos';

    protected $fillable = [
		'id',
        'titulo',
        'texto',
        'prazoInicial',
        'prazoFinal',
        'prazoProrroga',
        'prazo',
        'nome_arq',
        'arquivo',
        'unidade_id',
		'created_at',
		'updated_at'
	];
}
