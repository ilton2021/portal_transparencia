<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AssistencialDoc extends Model
{
    protected $table = 'assitencials_docs';

    protected $fillable = [
        'titulo',
        'ano',
        'file_path',
        'name_arq',
        'unidade_id',
        'status_ass_doc',
        'created_at',
        'updated_at'
    ];
}
