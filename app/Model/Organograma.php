<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Organograma extends Model
{
    protected $table = 'organograma';
	
	protected $fillable = [
		'file',
		'file_path',
		'unidade_id',
		'status_organograma',
		'created_at',
		'updated_at'
	];
}

