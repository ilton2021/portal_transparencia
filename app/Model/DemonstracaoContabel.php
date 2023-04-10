<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DemonstracaoContabel extends Model
{
    protected $table = 'demonstracao_contabels';
	
	protected $fillable = [
		'title',
		'ano',
		'name_arq',
		'file_path',
		'unidade_id',
		'status_contabel',
		'created_at',
		'updated_at'
	];
	
	public $rules = [
		'title' 	=> 'required',
		'ano'   	=> 'required'
	];
}
