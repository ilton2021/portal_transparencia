<?php

namespace App\Http\Controllers;

use App\Model\Associado;
use App\Model\ConselhoAdm;
use Illuminate\Http\Request;
use App\Model\Unidade;
use App\Model\LoggerUsers;
use App\Model\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AssociadoController extends Controller
{
	public function __construct(Unidade $unidade, Associado $associado, Request $request, LoggerUsers $logger_users)
	{
		$this->unidade 		= $unidade;
		$this->associado 	= $associado;
		$this->request 		= $request;
		$this->logger_users = $logger_users;
	}

	public function index()
	{
		$unidades = $this->associado->all();
		return view('home', compact('unidades'));
	}

	public function listarAS($id, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades     = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$associados   = $this->associado->all();
		$lastUpdated  = $associados->max('last_updated');
		if ($validacao == 'ok') {
			return view('transparencia/membros/membros_cadastro', compact('unidades', 'unidadesMenu', 'lastUpdated', 'unidade', 'associados'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function alterarAS($id_unidade, $id_associado, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades     = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$associado    = $this->associado->where('status_associados',1)->find($id_associado);
		if ($validacao == 'ok') {
			if (is_null($associado)) {
				return  redirect()->route('listarAssociado', [$id_unidade]);
			} else {
				return view('transparencia/membros/membros_alterar', compact('unidades', 'unidadesMenu', 'unidade', 'associado'));
			}
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function novoAS($id, Request $request)
	{
		$validacao 	  = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade 	  = $this->unidade->where('status_unidades',1)->find($id);
		$associados   = $this->associado->all();
		if ($validacao == 'ok') {
			return view('transparencia/membros/membros_novo', compact('unidades', 'unidadesMenu', 'unidade', 'associados'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function excluirAS($id_unidade, $id_associado, Request $request)
	{
		$validacao 	  = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade 	  = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$associados   = $this->associado->find($id_associado);
		if ($validacao == 'ok') {
			if (is_null($associados)) {
				return  redirect()->route('listarAssociado', [$id_unidade]);
			} else {
				return view('transparencia/membros/membros_excluir', compact('unidades', 'unidadesMenu', 'unidade', 'associados'));
			}
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function telaInativarAS($id_unidade, $id_associado, Request $request)
	{
		$validacao 	  = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade 	  = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$associados   = $this->associado->find($id_associado);
		if ($validacao == 'ok') {
			if (is_null($associados)) {
				return  redirect()->route('listarAssociado', [$id_unidade]);
			} else {
				return view('transparencia/membros/membros_inativar', compact('unidades', 'unidadesMenu', 'unidade', 'associados'));
			}
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function storeAS($id, Request $request)
	{
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade 	  = $this->unidade->where('status_unidades',1)->find($id);
		$associados   = $this->associado->all();
		$input        = $request->all();
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:255',
		]);
		if ($validator->fails()) {
			return view('transparencia/membros/membros_novo', compact('unidades', 'unidadesMenu', 'unidade', 'associados'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$input['status_associados'] = 1;
			$input['unidade_id'] = 1;
			$input['cpf'] = '';
			$associado    = Associado::create($input);
			$id_registro  = DB::table('associados')->max('id');
			$input['registro_id'] = $id_registro;
			$log 		  = LoggerUsers::create($input);
			$lastUpdated  = $log->max('updated_at');
			$associados   = $this->associado->all();
			$validator    = 'Membro Associado, cadastrado com sucesso';
			return  redirect()->route('listarAS', [$id])
				->withErrors($validator);
		}
	}

	public function updateAS($id_unidade, $id_associado, Request $request)
	{
		$unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade 	  = $this->unidade->where('status_unidades', 1)->find($id_unidade);
		$associado 	  = $this->associado->find($id_associado);
		$input 		  = $request->all();
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:255',
		]);
		if ($validator->fails()) {
			return view('transparencia/membros/membros_alterar', compact('unidades', 'unidadesMenu', 'unidade', 'associados'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$input['unidade_id'] = 1;
			$associado = Associado::find($id_associado);
			$associado->update($input);
			$input['registro_id'] = $id_associado;
			$log         = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$associados  = $this->associado->all();
			$validator   = 'Membro associado alterado com sucesso!';
			return  redirect()->route('listarAS', [1])
				->withErrors($validator);
		}
	}

	public function destroyAS($id_unidade, $id_associado, Associado $associado, Request $request)
	{
		$input = $request->all();
		Associado::find($id_associado)->delete();
		$input['registro_id'] = $id_associado;
		$log          = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
		$unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade 	  = $this->unidade->where('status_unidades', 1)->find($id_unidade);
		$associados   = $this->associado->all();
		$validator    = 'Membro Associado excluído com sucesso!';
		return redirect()->route('listarAS', [$id_unidade])
			->withErrors($validator);
	}

	public function inativarAS($id, $id_associado, Request $request)
    {
		$input     = $request->all();
		$associado = Associado::where('id',$id_associado)->get();
		if($associado[0]->status_associados == 1) {
			DB::statement('UPDATE associados SET status_associados = 0 WHERE id = '.$id_associado.';');
		} else {
			DB::statement('UPDATE associados SET status_associados = 1 WHERE id = '.$id_associado.';');
		}
		$input['registro_id'] = $id_associado;
		$log          = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$associado  = Associado::where('status_associados',1)->where('id',$id_associado)->get();
		$validator = 'Associado inativado com sucesso!';
		return redirect()->route('listarAS', [$id])
				->withErrors($validator);
    }
}
