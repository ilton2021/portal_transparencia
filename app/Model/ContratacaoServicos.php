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
<<<<<<< HEAD
        'tipoPrazo',
=======
        'prazo',
>>>>>>> c2b9c8598cba56d118c909d292282c02ebe42549
        'nome_arq',
        'nome_arq_errat',
        'arquivo_errat',
        'arquivo',
        'unidade_id',
		'created_at',
		'updated_at'
	];
}
