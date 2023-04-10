<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BensPublicos extends Model
{
    protected $table = 'bens_publicos';

    protected $fillable = [
        'mes',
        'ano',
        'name_arq',
        'file_path',
        'unidade_id',
        'status_bens',
        'created_at',
        'updated_at',
    ];
}
