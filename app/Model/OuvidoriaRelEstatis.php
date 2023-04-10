<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OuvidoriaRelEstatis extends Model
{
    protected $table = 'ouvidoria_rel_estatis';

    protected $fillable = [
        'mes',
        'ano',
        'name_arq',
        'file_path',
        'unidade_id',
        'status_ouvi_rel_estas',
        'created_at',
        'updated_at'
    ];
}
