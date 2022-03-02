<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class ContratacaoServicos extends Model
{
    protected $table = 'contratacao_servicos';

    protected $fillable = [
		'id',
        'titulo',
        'texto',
        'prazoInicial',
        'prazoFinal',
        'prazoProrroga',
        'tipoPrazo',
        'nome_arq',
        'nome_arq_errat',
        'arquivo_errat',
        'arquivo',
        'unidade_id',
		'created_at',
		'updated_at'
	];
}
