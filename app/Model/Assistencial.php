<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Assistencial extends Model
{
	protected $table = 'assistencials';
	
	protected $fillable = [
		'descricao',
		'indicador_id',
		'meta',
		'janeiro',
		'fevereiro',
		'marco',
		'abril',
		'maio',
		'junho',
		'julho',
		'agosto',
		'setembro',
		'outubro',
		'novembro',
		'dezembro',
		'unidade_id',
		'ano_ref',
		'created_at',
		'updated_at',
		'validar'
	];
	
	public $rules = [
		'indicador_id' => 'required',
		'ano_ref' 	   => 'required|digits:4'
	];
}
