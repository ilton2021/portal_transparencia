<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ConselhoAdm extends Model
{
    protected $table = 'conselho_adms';
	
	protected $fillable = [
		'name',
		'cargo',
		'tipo_membro',
		'unidade_id',
		'status_conselho_adms',
		'create_at',
		'updated_at'
	];
	
	public $rules = [
		'name'  	  => 'required',
		'cargo' 	  => 'required',
		'tipo_membro' => 'required'
	];
}
