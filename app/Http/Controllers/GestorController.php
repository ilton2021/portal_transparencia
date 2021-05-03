<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Gestor;
use App\Model\Contrato;
use App\Model\Unidade;
use App\Model\LoggerUsers;
use App\Model\PermissaoUsers;
use Auth;
use Illuminate\Support\Facades\DB;

class GestorController extends Controller
{
    public function __construct(Unidade $unidade, Request $request, LoggerUsers $logger_users)
	{
		$this->unidade 		= $unidade;
		$this->request 		= $request;
		$this->logger_users = $logger_users;
	}
	
	public function index()
    {
        $unidades = $this->associado->all();
		return view('home', compact('unidades')); 		
    }
	
	public function cadastroGestor($id, Request $request)
	{
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
		for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id) {
				$validacao = 'ok';
				break;
			} else {
				$validacao = 'erro';
			}
		}
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id);
		$gestores = $this->gestor->all();
		$lastUpdated = $gestores->max('last_updated');
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_gestor_cadastro', compact('unidades','unidadesMenu','lastUpdated','unidade','associados','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
}
