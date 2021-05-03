<?php

namespace App\Http\Controllers;

use App\Model\Competencia;
use App\Model\PermissaoUsers;
use Illuminate\Http\Request;
use App\Model\Unidade;
use App\Model\LoggerUsers;
use Auth;
use Illuminate\Support\Facades\DB;

class CompetenciaController extends Controller
{
	public function __construct(Unidade $unidade, Competencia $competencia, LoggerUsers $logger_users)
	{
		$this->unidade 		= $unidade;
		$this->competencia  = $competencia;
		$this->logger_users = $logger_users;
	}
	
    public function index()
    {
        $unidades = $this->unidade->all();
		return view('transparencia.competencia', compact('unidades')); 		
    }
	
	public function competenciaListar($id_unidade)
	{ 	
		$permissao_users = PermissaoUsers::where('unidade_id', $id_unidade)->get();
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
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$competenciasMatriz = Competencia::where('unidade_id', $id_unidade)->get();
        $lastUpdated = $competenciasMatriz->max('updated_at');
		$text = false;	
		if($validacao == 'ok') {
			return view('transparencia/competencia/competencia_listar', compact('unidade','unidades','unidadesMenu','competenciasMatriz','lastUpdated','text','permissao_users'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function competenciaCadastro($id_unidade, $id_tem)
	{ 	
		$permissao_users = PermissaoUsers::where('unidade_id', $id_unidade)->get();
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
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$competenciasMatriz = Competencia::where('id', $id_tem)->get();
        $lastUpdated = $competenciasMatriz->max('updated_at');
		$text = false;	
		if($validacao == 'ok') {
			return view('transparencia/competencia/competencia_cadastro', compact('unidade','unidades','unidadesMenu','competenciasMatriz','lastUpdated','text','permissao_users'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function competenciaValidar($id_unidade, $id_tem)
	{ 	
		$permissao_users = PermissaoUsers::where('unidade_id', $id_unidade)->get();
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
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$competenciasMatriz = Competencia::find($id_item);
		DB::statement('UPDATE competencias SET validar = 0 WHERE id = '.$id_item.';');
		$competenciasMatriz = Competencia::where('unidade_id', $id_unidade)->get();
        $lastUpdated = $competenciasMatriz->max('updated_at');
		if($validacao == 'ok') {
			\Session::flash('mensagem', ['msg' => 'Competência validado com Sucesso!!','class'=>'green white-text']);		
			$text = true;
			return view('transparencia/competencia/competencia_cadastro', compact('unidade','unidades','unidadesMenu','competenciasMatriz','lastUpdated','text','permissao_users'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function competenciaAlterar($id_unidade, $id_item)
	{ 	
		$permissao_users = PermissaoUsers::where('unidade_id', $id_unidade)->get();
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
		$unidade = $this->unidade->find($id_unidade);
		$competenciasMatriz = Competencia::where('id', $id_item)->get();
        $lastUpdated = $competenciasMatriz->max('updated_at');
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/competencia/competencia_alterar', compact('unidade','unidades','unidadesMenu','competenciasMatriz','lastUpdated','text','permissao_users'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function competenciaExcluir($id_unidade, $id_item)
	{ 	
		$permissao_users = PermissaoUsers::where('unidade_id', $id_unidade)->get();
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
		$unidade = $this->unidade->find($id_unidade);
		$competenciasMatriz = Competencia::where('id', $id_item)->get();
        $lastUpdated = $competenciasMatriz->max('updated_at');
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/competencia/competencia_excluir', compact('unidade','unidades','unidadesMenu','competenciasMatriz','lastUpdated','text','permissao_users'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function competenciaNovo($id_unidade, Request $request)
	{
		$permissao_users = PermissaoUsers::where('unidade_id', $id_unidade)->get();
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
		$unidade = $this->unidade->find($id_unidade);
		$competenciasMatriz = Competencia::where('id', $id_unidade)->get();
		$lastUpdated = $competenciasMatriz->max('updated_at');
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/competencia/competencia_novo', compact('unidade','unidades','unidadesMenu','competenciasMatriz','lastUpdated','text','permissao_users'));	
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}

    public function store($id, Request $request)
    {
        $unidade = $this->unidade->find($id);
		$unidades = $this->unidade->all();
		$unidadesMenu = $this->unidade->all();
		$input = $request->all();			
		$competenciasMatriz = Competencia::where('unidade_id', $id)->get();
     	$v = \Validator::make($request->all(), [
				'setor' => 'required|max:255',
				'cargo' => 'required|max:255',
				'descricao' => 'required|max:5000'
		]);
		if ($v->fails()) {
			$failed = $v->failed();
			
			if ( !empty($failed['setor']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo setor é obrigatório!','class'=>'green white-text']);		
			} else if ( !empty($failed['setor']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo setor possui no máximo 255 caracteres!','class'=>'green white-text']);		
			} else if ( !empty($failed['cargo']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo cargo é obrigatório!','class'=>'green white-text']);		
			} else if ( !empty($failed['cargo']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo cargo possui no máximo 5000 caracteres!','class'=>'green white-text']);		
			} else if ( !empty($failed['descricao']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo descrição é obrigatório!','class'=>'green white-text']);		
			} else if ( !empty($failed['descricao']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo descrição possui no máximo 255 caracteres!','class'=>'green white-text']);		
			} 
			$text = true;
			return view('transparencia/competencia/competencia_novo', compact('unidade','unidades','unidadesMenu','competenciasMatriz','lastUpdated','text'));
		} else {
			$competencia = Competencia::create($input); 
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$competenciasMatriz = Competencia::where('unidade_id', $id)->get();
			$text = true;
			$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
			\Session::flash('mensagem', ['msg' => 'Matriz de Competência cadastrado com sucesso!','class'=>'green white-text']);		
			return view('transparencia/competencia/competencia_listar', compact('unidade','unidades','unidadesMenu','competenciasMatriz','lastUpdated','text','permissao_users'));
		}
    }

    public function update($id_unidade, $id_item, Request $request)
    { 
		$unidadesMenu = $this->unidade->all();
		$unidades 	  = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$competenciasMatriz = Competencia::where('id', $id_item)->get();
        $v = \Validator::make($request->all(), [
				'setor' => 'required|max:255',
				'cargo' => 'required|max:255',
				'descricao' => 'required|max:5000'
		]);
		if ($v->fails()) {
			$failed = $v->failed();
			
			if ( !empty($failed['setor']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo setor é obrigatório!','class'=>'green white-text']);		
			} else if ( !empty($failed['setor']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo setor possui no máximo 255 caracteres!','class'=>'green white-text']);		
			} else if ( !empty($failed['cargo']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo cargo é obrigatório!','class'=>'green white-text']);		
			} else if ( !empty($failed['cargo']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo cargo possui no máximo 5000 caracteres!','class'=>'green white-text']);		
			} else if ( !empty($failed['descricao']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo descrição é obrigatório!','class'=>'green white-text']);		
			} else if ( !empty($failed['descricao']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo descrição possui no máximo 255 caracteres!','class'=>'green white-text']);		
			} 
			$text = true;
			return view('transparencia/competencia/competencia_novo', compact('unidade','unidades','unidadesMenu','competenciasMatriz','lastUpdated','text'));
		} else {
			$input = $request->all(); 
			$competencia = Competencia::find($id_item);
			$competencia->update($input);
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$competenciasMatriz = Competencia::where('unidade_id', $id_unidade)->get();
			$lastUpdated = $competenciasMatriz->max('updated_at'); 
			$text = true;
			\Session::flash('mensagem', ['msg' => 'Matriz de Competência alterado com sucesso!','class'=>'green white-text']);		
			$permissao_users = PermissaoUsers::where('unidade_id', $id_unidade)->get();
			return view('transparencia/competencia/competencia_listar', compact('unidade','unidades','unidadesMenu','competenciasMatriz','lastUpdated','text','permissao_users'));
		}
    }

    public function destroy($id_unidade, $id_item, Request $request)
    { 
		Competencia::find($id_item)->delete();
		$input = $request->all();	
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$unidadesMenu = $this->unidade->all(); 
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$competenciasMatriz = Competencia::where('unidade_id', $id_unidade)->get();
    	$text = true;
		\Session::flash('mensagem', ['msg' => 'Matriz de Competência excluído com sucesso!','class'=>'green white-text']);		
		$permissao_users = PermissaoUsers::where('unidade_id', $id_unidade)->get();
		return view('transparencia/competencia/competencia_listar', compact('unidade','unidades','unidadesMenu', 'competenciasMatriz','lastUpdated','text','permissao_users'));		
    }
}