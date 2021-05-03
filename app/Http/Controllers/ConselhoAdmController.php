<?php

namespace App\Http\Controllers;

use App\Model\ConselhoAdm;
use App\Model\Unidade;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use App\Model\PermissaoUsers;
use Auth;
use Illuminate\Support\Facades\DB;

class ConselhoAdmController extends Controller
{
	public function __construct(Unidade $unidade, Request $request, ConselhoAdm $conselhoAdm, LoggerUsers $logger_users)
	{
		$this->unidade 		= $unidade;
		$this->request 		= $request;
		$this->conselhoAdm  = $conselhoAdm;
		$this->logger_users = $logger_users;
	}
   
   public function index()
    {
        $unidades = $this->unidade->all();
		return view('home', compact('unidades'));
    }

	public function listarConselhoAdm($id, Request $request)
	{	
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
	    for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id && ($permissao_users[$i]->unidade_id == 1)) {
				$validacao = 'ok';
				break;
			} else {
				$validacao = 'erro';
			}
		}
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);
		$conselhoAdms = $this->conselhoAdm->all();
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_conselhoAdm_cadastro', compact('unidade','unidades','unidadesMenu','conselhoAdms','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function conselhoAdmValidar($id, $id_item, Request $request)
	{	
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
	    for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id && ($permissao_users[$i]->unidade_id == 1)) {
				$validacao = 'ok';
				break;
			} else {
				$validacao = 'erro';
			}
		}
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);
		$conselhoAdms = ConselhoAdm::find($id_item);
		DB::statement('UPDATE conselho_adms SET validar = 0 WHERE id = '.$id_item.';');
		$conselhoAdms = ConselhoAdm::where('unidade_id', $id)->get();
		$lastUpdated = $conselhoAdms->max('updated_at');
		if($validacao == 'ok') {
			\Session::flash('mensagem', ['msg' => 'Conselho Administrador validado com Sucesso!!','class'=>'green white-text']);		
			$text = true;
			return view('transparencia/membros/membros_conselhoAdm_cadastro', compact('unidade','unidades','unidadesMenu','conselhoAdms','lastUpdated','text','permissao_users'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function conselhoAdmNovo($id, Request $request)
	{	
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
	    for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id && ($permissao_users[$i]->unidade_id == 1)) {
				$validacao = 'ok';
				break;
			} else {
				$validacao = 'erro';
			}
		}
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);
		$conselhoAdms = $this->conselhoAdm->all();
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_conselhoAdm_novo', compact('unidade','unidades','unidadesMenu','conselhoAdms','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function conselhoAdmAlterar($id_unidade, $id_conselhoAdm, Request $request)
	{	
		$permissao_users = PermissaoUsers::where('unidade_id', $id_unidade)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
	    for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id && ($permissao_users[$i]->unidade_id == 1)) {
				$validacao = 'ok';
				break;
			} else {
				$validacao = 'erro';
			}
		}
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id_unidade);
		$conselhoAdm = $this->conselhoAdm->find($id_conselhoAdm);
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_conselhoAdm_alterar', compact('unidade','unidades','unidadesMenu','conselhoAdm','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function conselhoAdmExcluir($id_unidade, $id_conselhoAdm, Request $request)
	{	
		$permissao_users = PermissaoUsers::where('unidade_id', $id_unidade)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
	    for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id && ($permissao_users[$i]->unidade_id == 1)) {
				$validacao = 'ok';
				break;
			} else {
				$validacao = 'erro';
			}
		}
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id_unidade);
		$conselhoAdm = $this->conselhoAdm->find($id_conselhoAdm);
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_conselhoAdm_excluir', compact('unidade','unidades','unidadesMenu','conselhoAdm','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
    public function store($id, Request $request)
    {
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id);
		$conselhoAdms = $this->conselhoAdm->all();
		$input = $request->all(); 
        $v = \Validator::make($request->all(), [
			'name'  => 'required|max:255|unique:conselho_adms',
			'cargo' => 'required'
		]);
		if ($v->fails()) {
			$failed = $v->failed();
			if ( !empty($failed['name']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo nome é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['name']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo nome possui no máximo 255 caracteres!','class'=>'green white-text']);
			} else if ( !empty($failed['name']['Unique']) ) {	
				\Session::flash('mensagem', ['msg' => 'Este nome já foi cadastrado!','class'=>'green white-text']);
			} else if ( !empty($failed['cargo']['Required']) ) {	
				\Session::flash('mensagem', ['msg' => 'O campo cargo é obrigatório!','class'=>'green white-text']);
			}
			$text = true;
			return view('transparencia/membros/membros_conselhoAdm_cadastro', compact('unidades','unidadesMenu','unidade','conselhoAdms','text'));
		} else {
			$conselhoAdm = ConselhoAdm::create($input);
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$conselhoAdms = $this->conselhoAdm->all();
			\Session::flash('mensagem', ['msg' => 'Conselho de Administração cadastrado com sucesso!','class'=>'green white-text']);
			$text = true;
			return view('transparencia/membros/membros_conselhoAdm_cadastro', compact('unidades','unidadesMenu','unidade','conselhoAdms','lastUpdated','text'));
		}
    }

    public function update($id_unidade, $id_conselhoAdm, Request $request)
    {
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$conselhoAdms = $this->conselhoAdm->all();
		$input = $request->all(); 
        $v = \Validator::make($request->all(), [
			'name'  => 'required|max:255',
			'cargo' => 'required'
		]);
		if ($v->fails()) {
			$failed = $v->failed();
			if ( !empty($failed['name']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo nome é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['name']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo nome possui no máximo 255 caracteres!','class'=>'green white-text']);
			} else if ( !empty($failed['cargo']['Required']) ) {	
				\Session::flash('mensagem', ['msg' => 'O campo cargo é obrigatório!','class'=>'green white-text']);
			}
			$text = true;
			return view('transparencia/membros/membros_conselhoAdm_alterar', compact('unidades','unidadesMenu','unidade','conselhoAdms','text'));
		} else {
			$conselhoAdm = ConselhoAdm::find($id_conselhoAdm); 
			$conselhoAdm->update($input);	
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$conselhoAdms = $this->conselhoAdm->all();
			\Session::flash('mensagem', ['msg' => 'Conselho de Administração alterado com sucesso!','class'=>'green white-text']);
			$text = true;
			return view('transparencia/membros/membros_conselhoAdm_cadastro', compact('unidades','unidadesMenu','unidade','lastUpdated','conselhoAdms','text'));
		}
    }

    public function destroy($id_unidade, $id_conselhoAdm, ConselhoAdm $conselhoAdm, Request $request)
    {
        ConselhoAdm::find($id_conselhoAdm)->delete();  
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$unidades = new Unidade();
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$conselhoAdms = $this->conselhoAdm->all();
		$text = true;
		\Session::flash('mensagem', ['msg' => 'Conselho de Administração excluído com sucesso!','class'=>'green white-text']);
		return view('transparencia/membros/membros_conselhoAdm_cadastro', compact('unidades','unidadesMenu','unidade','lastUpdated','conselhoAdms','text'));
    }
}