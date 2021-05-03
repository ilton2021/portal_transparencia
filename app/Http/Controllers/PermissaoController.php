<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Permissao;
use App\Model\PermissaoUsers;
use App\Model\Unidade;
use App\Model\User;
use DB;

class PermissaoController extends Controller
{
    public function __construct(Unidade $unidade, Permissao $permissao, PermissaoUsers $permissao_user)
	{
		$this->unidade   = $unidade;
		$this->permissao = $permissao;
		$this->permissao_user = $permissao_user;
	}
	
	public function index(Unidade $unidade)
	{
		$unidade = $this->unidade->all();
		return view ('transparencia.permissao', compact('unidades'));
	}
	
	public function cadastroPermissao($id)
	{
		$unidade = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		
		$permissoes = DB::table('permissao_user')
		->join('permissao', 'permissao_user.permissao_id', '=', 'permissao.id')
		->join('users', 'permissao_user.user_id', '=', 'users.id')
	    ->select('permissao_user.*','users.name as Nome','permissao.tela','permissao.acao')
		->where('unidade_id', $id)
		->get();
		
		$lastUpdated = $permissoes->max('updated_at');
		
		$text = false;
		return view('transparencia/permissao/permissao_cadastro', compact('unidade','unidades','unidadesMenu','lastUpdated','permissoes','text'));
	}
	
	public function permissaoNovo($id)
	{
		$unidade = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		
		$text = false;
		return view('transparencia/permissao/permissao_novo', compact('unidade','unidades','unidadesMenu','text'));
	}
	
	public function permissaoUsuarioNovo($id)
	{
		$unidade = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$users = User::all();
		$permissoes = Permissao::all();
		$text = false;
		return view('transparencia/permissao/permissao_usuario_novo', compact('unidade','unidades','unidadesMenu','users','permissoes','text'));
	}
	
	public function permissaoAlterar($id, $id_permissao)
	{
		$unidade = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		
		$permissoes = Permissao::where('unidade_id', $id)->where('id', $id_permissao)->get();
		$lastUpdated = $permissoes->max('updated_at');
		$users = User::all();
		
		$text = false;
		return view('transparencia/permissao/permissao_alterar', compact('unidade','unidades','unidadesMenu','lastUpdated','permissoes','users','text'));
	}
	
	public function permissaoExcluir($id, $id_permissao)
	{
		$unidade = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		
		$permissoes = Permissao::where('unidade_id', $id)->where('id', $id_permissao)->get();
		$lastUpdated = $permissoes->max('updated_at');
		$users = User::all();
		
		$text = false;
		return view('transparencia/permissao/permissao_excluir', compact('unidade','unidades','unidadesMenu','lastUpdated','permissoes','users','text'));
	}
	
	public function store($id, Request $request)
	{
		$unidade = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		
		$input = $request->all();
		$input['unidade_id'] = $id;
		
		$permissao = Permissao::create($input);
		$lastUpdated = $permissao->max('updated_at');
		
		$permissoes = DB::table('permissao_user')
		->join('permissao', 'permissao_user.permissao_id', '=', 'permissao.id')
		->join('users', 'permissao_user.user_id', '=', 'users.id')
	    ->select('permissao_user.*','users.name as Nome','permissao.tela','permissao.acao')
		->where('unidade_id', $id)
		->get();
	
		$text = true;
		return view('transparencia/permissao/permissao_cadastro', compact('unidade','unidadesMenu','unidades','permissoes','lastUpdated'));
	}
	
	public function storePermissaoUsuario($id, Request $request)
	{
		$unidade = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		
		$input = $request->all();
		$unidade = $input['unidade'];
	
		if($unidade == 0) {
			for($i = 1; $i <= 8; $i++) {
				$input['unidade_id'] = $i;
				$permissao = PermissaoUsers::create($input);	
			}
		} else {
			$input['unidade_id'] = $unidade;
			$permissao = PermissaoUsers::create($input);
		}
		$lastUpdated = $permissao->max('updated_at');
		
		$permissoes = DB::table('permissao_user')
		->join('permissao', 'permissao_user.permissao_id', '=', 'permissao.id')
		->join('users', 'permissao_user.user_id', '=', 'users.id')
	    ->select('permissao_user.*','users.name as Nome','permissao.tela','permissao.acao')
		->where('unidade_id', $id)
		->get();
		$text = true;
		
		$unidade = $this->unidade->find($id);
		
		return view('transparencia/permissao/permissao_cadastro', compact('unidade','unidadesMenu','unidades','permissoes','lastUpdated'));
	}
	
	public function destroy()
	{
		
	}
	
}
