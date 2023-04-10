<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RelatorioFinanceiro extends Model
{
    protected $table = 'relatorio_financeiro';
	
	protected $fillable = [
		'title',
		'ano',
		'file_path',
		'nome_arq',
		'unidade_id',
		'status_financeiro',
		'created_at',
		'updated_at'
	];
}
