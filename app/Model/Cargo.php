<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
	protected $table = 'cargos';
	
	protected $fillable = [
		'cargo_name',
		'status_cargo',
		'created_at',
		'updated_at'
	];
	
	public $rules = [
		'cargo_name' => 'required|unique:cargos'
	];
}
