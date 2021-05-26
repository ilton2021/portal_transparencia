<?php

namespace App\Http\Controllers;

use App\Model\Ouvidoria;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use App\Model\Unidade;
use Illuminate\Support\Facades\Storage;
use App\Model\PermissaoUsers;
use Auth;

class OuvidoriaController extends Controller
{
    public function __construct(Unidade $unidade, Ouvidoria $ouvidoria)
    {
        $this->unidade 	 = $unidade;
		$this->ouvidoria = $ouvidoria;
    }
    
    public function sicCadastro($id)
    {
        $permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
	    for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id) {
				$validacao = 'ok';
			} else {
				$validacao = 'erro';
			}
		}
		$unidade = $this->unidade->find($id);
        $unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		if($id == 1){
            $ouvidorias = Ouvidoria::all();
        } else {
            $ouvidorias = Ouvidoria::where('unidade_id', $id)->get();
        }
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/ouvidoria/ouvidoria_cadastro', compact('unidades','unidadesMenu','unidade','text','ouvidorias'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
    }

    public function ouvidoriaNovo($id)
    {
        $permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
		
	    for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id) {
				$validacao = 'ok';
			} else {
				$validacao = 'erro';
			}
		}
		$unidade = $this->unidade->find($id);
        $unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/ouvidoria/ouvidoria_novo', compact('unidades','unidadesMenu','unidade','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
    }

    public function ouvidoriaAlterar($id, $id_ouvidoria)
    {
        $permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
	    for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id) {
				$validacao = 'ok';
			} else {
				$validacao = 'erro';
			}
		}
		$unidade = $this->unidade->find($id);
        $unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
        $ouvidoria = $this->ouvidoria->find($id_ouvidoria);
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/ouvidoria/ouvidoria_alterar', compact('unidades','unidadesMenu','unidade','text','ouvidoria'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
    }

    public function ouvidoriaExcluir($id, $id_ouvidoria)
    {
        $permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
	    for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id) {
				$validacao = 'ok';
			} else {
				$validacao = 'erro';
			}
		}
		$unidade = $this->unidade->find($id);
        $unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
        $ouvidoria = $this->ouvidoria->find($id_ouvidoria);
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/ouvidoria/ouvidoria_excluir', compact('unidades','unidadesMenu','unidade','text','ouvidoria'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
    }

    public function storeOuvidoria($id, Request $request)
    {
        $unidadesMenu = $this->unidade->all();
		$unidades     = $unidadesMenu; 
		$unidade      = $this->unidade->find($id);
		$ouvidorias   = $this->ouvidoria->where('unidade_id',$id);
		$input        = $request->all();
		$v = \Validator::make($request->all(), [
			'responsavel' => 'required|max:255',
            'email'       => 'required|max:255|email',
            'telefone'    => 'required|max:50'		
		]);
		if ($v->fails()) {
			$failed = $v->failed();
			if ( !empty($failed['name']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo título é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['name']['Max']) ) { 
				\Session::flash('mensagem', ['msg' => 'O campo título possui no máximo 255 caracteres!','class'=>'green white-text']);
			} else if ( !empty($failed['email']['Required']) ) { 
				\Session::flash('mensagem', ['msg' => 'O campo e-mail é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['email']['Max']) ) { 
				\Session::flash('mensagem', ['msg' => 'O campo e-mail possui no máximo 255 caracteres!','class'=>'green white-text']);
			} else if ( !empty($failed['email']['Email']) ) { 
				\Session::flash('mensagem', ['msg' => 'O campo e-mail está inválido!','class'=>'green white-text']);
			} else if ( !empty($failed['telefone']['Required']) ) { 
				\Session::flash('mensagem', ['msg' => 'O campo telefone é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['telefone']['Max']) ) { 
				\Session::flash('mensagem', ['msg' => 'O campo telefone possui no máximo 20 caracteres!','class'=>'green white-text']);
			}
			$text = true;
			return view('transparencia/ouvidoria/ouvidoria_novo', compact('unidade','unidades','unidadesMenu','ouvidorias','text'));
		} else {
			$ouvidoria   = Ouvidoria::create($input);
			$log         = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$ouvidorias  = Ouvidoria::where('unidade_id',$id)->get();
			\Session::flash('mensagem', ['msg' => 'Ouvidoria cadastrada com sucesso!','class'=>'green white-text']);		
			$text = true;
			return view('transparencia/ouvidoria/ouvidoria_cadastro', compact('unidade','unidades','unidadesMenu','lastUpdated','ouvidorias','text'));
		}
    }

    public function updateOuvidoria($id, $id_ouvidoria, Request $request)
    {
        $unidadesMenu = $this->unidade->all();
		$unidades     = $unidadesMenu; 
		$unidade      = $this->unidade->find($id);
		$ouvidorias   = $this->ouvidoria->where('unidade_id',$id_ouvidoria);
		$input        = $request->all();
		$v = \Validator::make($request->all(), [
            'email'       => 'required|max:255|email',
            'telefone'    => 'required|max:50'		
		]);
		if ($v->fails()) {
			$failed = $v->failed();
			if ( !empty($failed['email']['Required']) ) { 
				\Session::flash('mensagem', ['msg' => 'O campo e-mail é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['email']['Max']) ) { 
				\Session::flash('mensagem', ['msg' => 'O campo e-mail possui no máximo 255 caracteres!','class'=>'green white-text']);
			} else if ( !empty($failed['email']['Email']) ) { 
				\Session::flash('mensagem', ['msg' => 'O campo e-mail está inválido!','class'=>'green white-text']);
			} else if ( !empty($failed['telefone']['Required']) ) { 
				\Session::flash('mensagem', ['msg' => 'O campo telefone é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['telefone']['Max']) ) { 
				\Session::flash('mensagem', ['msg' => 'O campo telefone possui no máximo 20 caracteres!','class'=>'green white-text']);
			}
			$text = true;
			return view('transparencia/ouvidoria/ouvidoria_alterar', compact('unidade','unidades','unidadesMenu','ouvidorias','text'));
		} else {
			$ouvidoria = $this->ouvidoria->find($id_ouvidoria);
            $ouvidoria->update($input);	
			$log         = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$ouvidorias  = Ouvidoria::where('id',$id_ouvidoria)->get();
			\Session::flash('mensagem', ['msg' => 'Ouvidoria alterada com sucesso!','class'=>'green white-text']);		
			$text = true;
			return view('transparencia/ouvidoria/ouvidoria_cadastro', compact('unidade','unidades','unidadesMenu','lastUpdated','ouvidorias','text'));
		}
    }

    public function destroyOuvidoria($id, $id_ouvidoria, Request $request)
    {
		Ouvidoria::find($id_ouvidoria)->delete();
		$input        = $request->all();
		$log          = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
        $unidadesMenu = $this->unidade->all();
		$unidades     = $unidadesMenu; 
		$unidade      = $this->unidade->find($id);
		$ouvidorias  = Ouvidoria::where('id',$id_ouvidoria)->get();
		\Session::flash('mensagem', ['msg' => 'Ouvidoria excluída com sucesso!','class'=>'green white-text']);		
		$text = true;
		return view('transparencia/ouvidoria/ouvidoria_cadastro', compact('unidade','unidades','unidadesMenu','lastUpdated','ouvidorias','text'));
    }
}
