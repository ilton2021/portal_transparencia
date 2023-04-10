<?php

namespace App\Http\Controllers;

use App\Model\Superintendente;
use App\Model\Unidade;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use App\Http\Controllers\PermissaoUsersController;
use App\Model\PermissaoUsers;
use Auth;
use Illuminate\Support\Facades\Validator;
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
		$unidades = $this->unidade->where('status_unidades', 1)->get();
		return view('home', compact('unidades'));
	}

	public function listarSP($id, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades     = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		if ($validacao == 'ok') {
			$superintendentes = $this->superintendente->get();
			return view('transparencia/membros/membros_super_cadastro', compact('unidade', 'unidades', 'unidadesMenu', 'superintendentes'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function novoSP($id, Request $request)
	{
		$validacao 	  = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade 	  = $this->unidade->where('status_unidades',1)->find($id);
		if ($validacao == 'ok') {
			$superintendentes = $this->superintendente->all();
			return view('transparencia/membros/membros_super_novo', compact('unidade', 'unidades', 'unidadesMenu', 'superintendentes'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function alterarSP($id_unidade, $id_super, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade 	  = $this->unidade->where('status_unidades',1)->find($id_unidade);
		if ($validacao == 'ok') {
			$superintendentes = $this->superintendente->find($id_super);
			if (is_null($superintendentes)) {
				return  redirect()->route('listarSuper', [$id_unidade]);
			} else {
				return view('transparencia/membros/membros_super_alterar', compact('unidade', 'unidades', 'unidadesMenu', 'superintendentes'));
			}
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function excluirSP($id_unidade, $id_super, Request $request)
	{
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade 	  = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$validacao 	  = permissaoUsersController::Permissao($id_unidade);
		if ($validacao == 'ok') {
			$superintendentes = $this->superintendente->find($id_super);
			if (is_null($superintendentes)) {
				return  redirect()->route('listarSuper', [$id_unidade]);
			} else {
				return view('transparencia/membros/membros_super_excluir', compact('unidade', 'unidades', 'unidadesMenu', 'superintendentes'));
			}
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function telaInativarSP($id_unidade, $id_super, Request $request)
	{
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade 	  = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$validacao 	  = permissaoUsersController::Permissao($id_unidade);
		if ($validacao == 'ok') {
			$superintendentes = $this->superintendente->find($id_super);
			if (is_null($superintendentes)) {
				return  redirect()->route('listarSuper', [$id_unidade]);
			} else {
				return view('transparencia/membros/membros_super_inativar', compact('unidade', 'unidades', 'unidadesMenu', 'superintendentes'));
			}
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function storeSP($id, Request $request)
	{
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade 	  = $this->unidade->where('status_unidades',1)->find($id);
		$validacao 	  = permissaoUsersController::Permissao($id);
		if ($validacao == 'ok') {
			$input = $request->all();
			$superintendentes = $this->superintendente->all();
			$validator = Validator::make($request->all(), [
				'name'  => 'required|max:255',
				'cargo' => 'required'
			]);
			if ($validator->fails()) {
				$failed = $validator->failed();
				$validator = 'Algo de errado aconteceu, verifique os campos e preencha novamente!';
				return view('transparencia/membros/membros_super_novo', compact('unidades', 'unidadesMenu', 'unidade', 'superintendentes'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			} else {
				$input['status_superintendentes'] = 1;
				$input['unidade_id']  = 1;
				$superintendente 	  = Superintendente::create($input);
				$id_registro 		  = DB::table('superintendentes')->max('id');
				$input['registro_id'] = $id_registro;
				$log 				  = LoggerUsers::create($input);
				$lastUpdated 		  = $log->max('updated_at');
				$superintendentes 	  = $this->superintendente->all();
				$validator 			  = 'Superintendente cadastrado com sucesso!';
				return  redirect()->route('listarSP', [$id])
					->withErrors($validator);
			}
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function updateSP($id_unidade, $id_super, Request $request, Superintendente $superintendente)
	{
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade 	  = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$validacao 	  = permissaoUsersController::Permissao($id_unidade);
		if ($validacao == 'ok') {
			$superintendentes = $this->superintendente->where('status_superintendentes', 1);
			if (is_null($superintendentes)) {
				return  redirect()->route('listarSuper', [$id_unidade]);
			} else {
				$input = $request->all();
				$validator = Validator::make($request->all(), [
					'name'  => 'required|max:255',
					'cargo' => 'required'
				]);
				if ($validator->fails()) {
					return view('transparencia/membros/membros_super_alterar', compact('unidades', 'unidadesMenu', 'unidade', 'superintendentes'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				} else {
					$input['unidade_id'] = 1;
					$superintendentes = Superintendente::find($id_super);
					$superintendentes->update($input);
					$input['registro_id'] = $id_super;
					LoggerUsers::create($input);
					$validator = 'Superintendente alterado com sucesso!';
					return  redirect()->route('listarSP', [$id_unidade])
						->withErrors($validator);
				}
			}
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function destroySP($id_unidade, $id_super, Request $request)
	{
		$input = $request->all();
		Superintendente::find($id_super)->delete();
		$input['registro_id'] = $id_super;
		$log           = LoggerUsers::create($input);
		$lastUpdated   = $log->max('updated_at');
		$unidadesMenu  = $this->unidade->where('status_unidades',1)->get();
		$unidades 	   = $unidadesMenu;
		$unidade 	   = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$superintendentes = Superintendente::where('id',$id_super)->get();
		$validator     = 'Superintendente excluído com sucesso!';
		return redirect()->route('listarSP', [$id_unidade])
			->withErrors($validator);
	}

	public function inativarSP($id_unidade, $id_super, Request $request)
	{
		$input         = $request->all();
		$superintendentes = Superintendente::where('id',$id_super)->get();
		if($superintendentes[0]->status_superintendentes == 1) {
			DB::statement('UPDATE superintendentes SET status_superintendentes = 0 WHERE id = '.$id_super.';');
		} else {
			DB::statement('UPDATE superintendentes SET status_superintendentes = 1 WHERE id = '.$id_super.';');
		}
		$input['registro_id'] = $id_super;
		$log          = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$superintendentes = Superintendente::where('id',$id_super)->get();
		$validator = 'Superintendente inativado com sucesso!';
		return redirect()->route('listarSP', [$id_unidade])
				->withErrors($validator);
	}
}
