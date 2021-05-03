<?php

namespace App\Http\Controllers;

use App\Model\ConselhoFisc;
use Illuminate\Http\Request;
use App\Model\Unidade;
use App\Model\LoggerUsers;
use App\Model\PermissaoUsers;
use Auth;
use Illuminate\Support\Facades\DB;

class ConselhoFiscController extends Controller
{
    public function __construct(Unidade $unidade, Request $request, ConselhoFisc $conselhoFisc, LoggerUsers $logger_users)
    {
        $this->unidade 		= $unidade;
		$this->request 		= $request;
		$this->conselhoFisc = $conselhoFisc;
		$this->logger_users = $logger_users;
    }
	
	public function index()
    {
        $unidades = $this->unidade->all();
		return view ('home', compact('unidades'));
    }

	public function listarConselhoFisc($id, Request $request)
	{	
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
	    for($i = 0; $i < $qtd; $i++) {
			if(($permissao_users[$i]->user_id == Auth::user()->id) && ($permissao_users[$i]->unidade_id == 1)) {
				$validacao = 'ok';
				break;
			} else {
				$validacao = 'erro';
			}
		}
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);
		$conselhoFiscs = $this->conselhoFisc->all();
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_conselhoFisc_cadastro', compact('unidade','unidades','unidadesMenu','conselhoFiscs','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function conselhoFiscNovo($id, Request $request)
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
		$conselhoFiscs = $this->conselhoFisc->all();
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_conselhoFisc_novo', compact('unidade','unidades','unidadesMenu','conselhoFiscs','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function conselhoFiscValidar($id, $id_item, Request $request)
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
		$conselhoFiscs = ConselhoFisc::find($id_item);
		DB::statement('UPDATE conselho_fiscs SET validar = 0 WHERE id = '.$id_item.';');
		$conselhoFiscs = ConselhoFisc::where('unidade_id', $id)->get();
		$lastUpdated = $conselhoFiscs->max('updated_at');
		if($validacao == 'ok') {
			\Session::flash('mensagem', ['msg' => 'Conselho Fiscal validado com Sucesso!!','class'=>'green white-text']);		
			$text = true;
			return view('transparencia/membros/membros_conselhoFisc_cadastro', compact('unidade','unidades','unidadesMenu','conselhoFiscs','text','permissao_users','lastUpdated'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function conselhoFiscAlterar($id_unidade, $id_conselhoFisc, Request $request)
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
		$conselhoFisc = $this->conselhoFisc->find($id_conselhoFisc);
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_conselhoFisc_alterar', compact('unidade','unidades','unidadesMenu','conselhoFisc','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function conselhoFiscExcluir($id_unidade, $id_conselhoFisc, Request $request)
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
		$conselhoFisc = $this->conselhoFisc->find($id_conselhoFisc); 
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_conselhoFisc_excluir', compact('unidade','unidades','unidadesMenu','conselhoFisc','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}

    public function store($id, Request $request)
    {  
		$unidades = new Unidade();
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id);
		$conselhoFiscs = $this->conselhoFisc->all();
		$input = $request->all(); 
		$v = \Validator::make($request->all(), [
			'name'  => 'required|max:255'
		]);
		if ($v->fails()) {
			$failed = $v->failed();
			if ( !empty($failed['name']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo nome é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['name']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo nome possui no máximo 255 caracteres!','class'=>'green white-text']);
			}
			$text = true;
			return view('transparencia/membros/membros_conselhoFisc_novo', compact('unidades','unidadesMenu','unidade','conselhoFiscs','text'));		
		} else {
			$conselhoFisc = conselhoFisc::create($input);
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$conselhoFiscs = $this->conselhoFisc->all();
			$text = true;
			\Session::flash('mensagem', ['msg' => 'Conselho Fiscal cadastrado com sucesso!','class'=>'green white-text']);
			return view('transparencia/membros/membros_conselhoFisc_cadastro', compact('unidades','unidadesMenu','unidade','lastUpdated','conselhoFiscs','text'));
		}
    }

    public function update($id_unidade, $id_conselhoFisc, Request $request)
    {
        $unidades = new Unidade();
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$conselhoFisc = $this->conselhoFisc->find($id_conselhoFisc);
		$input = $request->all(); 
		$v = \Validator::make($request->all(), [
			'name'  => 'required|max:255'
		]);
		if ($v->fails()) {
			$failed = $v->failed();
			if ( !empty($failed['name']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo nome é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['name']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo nome possui no máximo 255 caracteres!','class'=>'green white-text']);
			}
			$text = true;
			return view('transparencia/membros/membros_conselhoFisc_alterar', compact('unidades','unidadesMenu','unidade','conselhoFisc','text'));		
		} else {
			$conselhoFisc = conselhoFisc::find($id_conselhoFisc); 
			$conselhoFisc->update($input);
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$conselhoFiscs = $this->conselhoFisc->all();
			$text = true;
			\Session::flash('mensagem', ['msg' => 'Conselho Fiscal alterado com sucesso!','class'=>'green white-text']);
			return view('transparencia/membros/membros_conselhoFisc_cadastro', compact('unidades','unidadesMenu','unidade','lastUpdated','conselhoFiscs','text'));
		}
    }

    public function destroy($id_unidade, $id_conselhoFisc, ConselhoFisc $conselhoFisc, Request $request)
    {
        ConselhoFisc::find($id_conselhoFisc)->delete();  
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$unidades = new Unidade();
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$conselhoFiscs = $this->conselhoFisc->all();
		$text = true;
		\Session::flash('mensagem', ['msg' => 'Conselho Fiscal excluído com sucesso!','class'=>'green white-text']);
		return view('transparencia/membros/membros_conselhoFisc_cadastro', compact('unidades','unidadesMenu','unidade','lastUpdated','conselhoFiscs','text'));
    }
}