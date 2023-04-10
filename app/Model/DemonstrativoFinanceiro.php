<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DemonstrativoFinanceiro extends Model
{
    protected $table = 'financial_reports';
	
	protected $fillable = [
		'title',
		'tipodoc',
		'mes',
		'ano',
		'tipoarq',
		'file_path',
		'file_link',
		'name_arq',
		'unidade_id',
		'status_financeiro',
		'created_at',
		'updated_at'
	];
	
	public $rules = [
		'title' => 'required',
		'mes' => 'required|numeric',
		'ano' => 'required|numeric'
	];
}
