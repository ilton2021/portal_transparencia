<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DocumentacaoRegularidade extends Model
{
    protected $table = 'documentacao_regularidades';

    protected $fillable = [
		'name',
		'path_file',
		'type_id',
		'unidade_id',
		'status_documentos',
		'created_at',
		'updated_at'	
	];

	public $rules = [
		'name'		=> 'required',
		'type_id'   => 'required'
	];
}
