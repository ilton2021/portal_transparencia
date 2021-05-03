<?php

namespace App\Http\Controllers;

use App\Model\Superintendente;
use App\Model\Unidade;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use App\Model\PermissaoUsers;
use Auth;
use Illuminate\Support\Facades\DB;

class SuperintendentesController extends Controller
{
    public function __construct(Unidade $unidade, Request $request, Superintendente $superintendente, LoggerUsers $logger_users)
    {
        $this->unidade 		   = $unidade;
		$this->request 		   = $request;
		$this->superintendente = $superintendente;
		$this->logger_users    = $logger_users;
    }
	
	public function index()
	{
		$unidades = $this->unidade->all();
		return view('home', compact('unidades'));
	}
	
	public function listarSuper($id, Request $request)
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
		$superintendentes = $this->superintendente->all();
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_super_cadastro', compact('unidade','unidades','unidadesMenu','superintendentes','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function superNovo($id, Request $request)
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
		$superintendentes = $this->superintendente->all();
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_super_novo', compact('unidade','unidades','unidadesMenu','superintendentes','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function superValidar($id, $id_item, Request $request)
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
		$superintendentes = Superintendente::find($id_item);
		DB::statement('UPDATE superintendentes SET validar = 0 WHERE id = '.$id_item.';');
		$superintendentes = Superintendente::where('unidade_id', $id)->get();
        $lastUpdated = $superintendentes->max('updated_at');
		if($validacao == 'ok') {
			\Session::flash('mensagem', ['msg' => 'Superintendente validado com Sucesso!!','class'=>'green white-text']);		
			$text = true;
			return view('transparencia/membros/membros_super_cadastro', compact('unidade','unidades','unidadesMenu','superintendentes','text','permissao_users'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function superAlterar($id_unidade, $id_super, Request $request)
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
		$superintendentes = $this->superintendente->find($id_super);
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_super_alterar', compact('unidade','unidades','unidadesMenu','superintendentes','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function superExcluir($id_unidade, $id_super, Request $request)
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
		$superintendentes = $this->superintendente->find($id_super);
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_super_excluir', compact('unidade','unidades','unidadesMenu','superintendentes','text'));
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
		$superintendentes = $this->superintendente->all();
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
			return view('transparencia/membros/membros_super_novo', compact('unidades','unidadesMenu','unidade','superintendentes','text'));
		} else {
			$superintendente = Superintendente::create($input);
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$superintendentes = $this->superintendente->all();
			\Session::flash('mensagem', ['msg' => 'Superintendente cadastrado com sucesso!','class'=>'green white-text']);
			$text = true;
			return view('transparencia/membros/membros_super_cadastro', compact('unidades','unidadesMenu','unidade','lastUpdated','superintendentes','text'));
		}
    }

    public function update($id_unidade, $id_super, Request $request, Superintendente $superintendente)
    {
        $unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$superintendentes = $this->superintendente->all();
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
			return view('transparencia/membros/membros_super_alterar', compact('unidades','unidadesMenu','unidade','superintendentes','text'));
		} else {
			$superintendente = Superintendente::find($id_super); 
			$superintendente->update($input);
			LoggerUsers::create($input);
			$superintendentes = $this->superintendente->all();
			\Session::flash('mensagem', ['msg' => 'Superintendente alterado com sucesso!','class'=>'green white-text']);
			$text = true;
			return view('transparencia/membros/membros_super_cadastro', compact('unidades','unidadesMenu','unidade','superintendentes','text'));
		}	
    }

    public function destroy($id_unidade, $id_super, Superintendente $superintendente, Request $request)
    {
        Superintendente::find($id_super)->delete();  
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$unidades = new Unidade();
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$superintendentes = $this->superintendente->all();
		\Session::flash('mensagem', ['msg' => 'Superintendente excluído com sucesso!','class'=>'green white-text']);
		$text = true;
		return view('transparencia/membros/membros_super_cadastro', compact('unidades','unidadesMenu','unidade','lastUpdated','superintendentes','text'));
    }
}