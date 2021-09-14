<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Processos extends Model
{
    protected $table = 'processos';
	
	protected $fillable = [
		'numeroSolicitacao',
		'dataSolicitacao',
		'numeroOC',
		'dataAutorizacao',
		'fornecedor',
		'cnpj',
		'produto',
		'tipoPedido',
		'qtdOrdemCompra',
		'qtdItens',
		'totalValorOC',
		'classificacaoItem',
		'numeroNotaFiscal',
		'quantidadeRecebida',
		'valorTotalRecebido',
		'chaveAcesso',
		'codigoIBGE',
		'unidade_id',
		'updated_at',
		'created_at'
	];
}
