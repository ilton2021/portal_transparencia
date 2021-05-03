<?php

namespace App\Http\Controllers;

use App\Model\Associado;
use App\Model\ConselhoAdm;
use Illuminate\Http\Request;
use App\Model\Unidade;
use App\Model\LoggerUsers;
use App\Model\PermissaoUsers;
use Auth;
use Illuminate\Support\Facades\DB;

class AssociadoController extends Controller
{
	//Método Construtor, Instanciar as classes.
	public function __construct(Unidade $unidade, Associado $associado, Request $request, LoggerUsers $logger_users)
	{
		$this->unidade 		= $unidade;
		$this->associado 	= $associado;
		$this->request 		= $request;
		$this->logger_users = $logger_users;
	}
	
	//Usado quando o usuário clica no Menu: Membros Dirigentes - Associados.
    public function index()
    {
        $unidades = $this->associado->all();
		return view('home', compact('unidades')); 		
    }
	
	//Usado quando o usuário clica no botão Alterar em Associados - Membros Dirigentes. 
	public function listarAssociado($id, Request $request)
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
		$associados = new Associado();
		$unidades = new Unidade();
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id);
		$associados = $this->associado->all();
		$lastUpdated = $associados->max('last_updated');
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_cadastro', compact('unidades','unidadesMenu','lastUpdated','unidade','associados','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	//Usado quando o usuário clica no botão Alterar para Alterar um Associado.
	public function associadoAlterar($id_unidade, $id_associado, Request $request)
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
		$associados = new Associado();
		$unidades = new Unidade();
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$associado = $this->associado->find($id_associado);
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_alterar', compact('unidades','unidadesMenu','unidade','associado','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function associadoValidar($id_unidade, $id_associado, Request $request)
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
		$associados = new Associado();
		$unidades = new Unidade();
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$associado = Associado::find($id_associado);
		DB::statement('UPDATE associados SET validar = 0 WHERE id = '.$id_associado.';');
		$associados = Associado::where('unidade_id', $id_unidade)->get();
		$lastUpdated = $associado->max('updated_at');
		if($validacao == 'ok') {
			\Session::flash('mensagem', ['msg' => 'Associado validado com Sucesso!!','class'=>'green white-text']);		
			$text = true;
			return view('transparencia/membros/membros_cadastro', compact('unidades','unidadesMenu','unidade','associados','text','permissao_users'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	//Usado quando o usuário clica no botão Novo para cadastrar um novo Associado.
	public function associadoNovo($id, Request $request)
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
		$associados = new Associado();
		$unidades = new Unidade();
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id);
		$associados = $this->associado->all();
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_novo', compact('unidades','unidadesMenu','unidade','associados','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	//Usado quando o usuário clica no botão Excluir para excluir um Associado.
	public function associadoExcluir($id_unidade, $id_associado , Request $request)
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
		$associados = new Associado();
		$unidades = new Unidade();
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$associados = $this->associado->find($id_associado);
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/membros/membros_excluir', compact('unidades','unidadesMenu','unidade','associados','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}

	//Método para Salvar um novo Associado.
    public function store($id, Request $request)
    {
		$unidadesMenu = $this->unidade->all();
		$unidades 	  = $unidadesMenu;
		$unidade 	  = $this->unidade->find($id);
		$associados = $this->associado->all();
		$input = $request->all(); 	
		$v = \Validator::make($request->all(), [
			'name' => 'required|max:255',
			'cpf'  => 'required|max:14|min:11'
		]);		
		if ($v->fails()) {
			$failed = $v->failed();
			if ( !empty($failed['name']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo nome é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['name']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo nome possui no máximo 255 caracteres!','class'=>'green white-text']);
			} else if ( !empty($failed['cpf']['Required']) ) {	
				\Session::flash('mensagem', ['msg' => 'O campo cpf é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['cpf']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo cpf é inválido!','class'=>'green white-text']);
			} else if ( !empty($failed['cpf']['Min']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo cpf é inválido!','class'=>'green white-text']);
			} 
			$text = true;
			return view('transparencia/membros/membros_novo', compact('unidades','unidadesMenu','unidade','associados','text'));
		} else {
			$associado = Associado::create($input);
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$associados = $this->associado->all();
			$text = true;
			\Session::flash('mensagem', ['msg' => 'Membro Associado cadastrado com sucesso!','class'=>'green white-text']);
			return view('transparencia/membros/membros_cadastro', compact('unidades','unidadesMenu','unidade','lastUpdated','associados','text'));
		}
    }

	//Método para Alterar um Associado.
    public function update($id_unidade, $id_associado, Request $request)
    {	
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$associado = $this->associado->find($id_associado);
		$input = $request->all();
		$v = \Validator::make($request->all(), [
			'name' => 'required|max:255',
			'cpf'  => 'required|max:14|min:11'
		]);
		if ($v->fails()) {
			$failed = $v->failed();
			if ( !empty($failed['name']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo nome é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['name']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo nome possui no máximo 255 caracteres!','class'=>'green white-text']);
			} else if ( !empty($failed['cpf']['Required']) ) {	
				\Session::flash('mensagem', ['msg' => 'O campo cpf é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['cpf']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo cpf é inválido!','class'=>'green white-text']);
			} else if ( !empty($failed['cpf']['Min']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo cpf é inválido!','class'=>'green white-text']);
			}  
			$text = true;
			return view('transparencia/membros/membros_alterar', compact('unidades','unidadesMenu','unidade','associado','text'));
		} else {
			$associado = Associado::find($id_associado); 
			$associado->update($input);
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$associados = $this->associado->all();
			$text = true;
			\Session::flash('mensagem', ['msg' => 'Membro Associado alterado com sucesso!','class'=>'green white-text']);
			return view('transparencia/membros/membros_cadastro', compact('unidades','unidadesMenu','lastUpdated','unidade','associados','text'));
		}
    }

	//Método para Excluir um Associado.
    public function destroy($id_unidade, $id_associado, Associado $associado, Request $request)
    { 
        Associado::find($id_associado)->delete();  
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$unidades = new Unidade();
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$associados = $this->associado->all();
		$text = true;
		\Session::flash('mensagem', ['msg' => 'Membro Associado excluído com sucesso!','class'=>'green white-text']);
		return view('transparencia/membros/membros_cadastro', compact('unidades','unidadesMenu','lastUpdated','unidade','associados','text'));
    }
}