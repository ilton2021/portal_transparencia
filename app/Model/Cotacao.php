<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cotacao extends Model
{
    protected $table = 'cotacaos';
	
	protected $fillable = [
		'proccess_name',
		'mes',
		'ano',
		'file_name',
		'file_path',
		'ordering',
		'unidade_id',
		'status_cotacao',
	];
	
	public $rules = [
		'file_path'    => 'required',
		'ordering'	   => 'required'
	];
}
