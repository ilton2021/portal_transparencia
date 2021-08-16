<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\Unidade;
use App\Model\Contrato;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EnviarEmailContratos extends Command
{
    protected $signature   = 'enviar:emails';
    protected $description = 'Enviar E-mail dos Contratos';

    public function __construct(Unidade $unidade)
    {
	    parent::__construct();
		$this->unidade = $unidade;
    }
	
    public function handle (Unidade $unidade, Contrato $contrato)
    {
	}
}
