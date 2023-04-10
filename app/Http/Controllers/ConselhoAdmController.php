<?php

namespace App\Http\Controllers;

use App\Model\ConselhoAdm;
use App\Model\Unidade;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use App\Model\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Auth;
use Illuminate\Support\Facades\Validator;
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
		$unidades = $this->unidade->where('status_unidades',1)->get();
		return view('home', compact('unidades'));
	}

	public function listarCA($id, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades     = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$conselhoAdms = $this->conselhoAdm->get();
		if ($validacao == 'ok') {
			return view('transparencia/membros/membros_conselhoAdm_cadastro', compact('unidade', 'unidades', 'unidadesMenu', 'conselhoAdms'));
		} else {
			$validator = 'Você não tem permissao!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function novoCA($id, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades     = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$conselhoAdms = $this->conselhoAdm->all();
		if ($validacao == 'ok') {
			return view('transparencia/membros/membros_conselhoAdm_novo', compact('unidade', 'unidades', 'unidadesMenu', 'conselhoAdms'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function alterarCA($id_unidade, $id_conselhoAdm, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades     = $unidadesMenu;
		$unidade 	  = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$conselhoAdm  = $this->conselhoAdm->find($id_conselhoAdm);
		if ($validacao == 'ok') {
			if (is_null($conselhoAdm)) {
				return  redirect()->route('listarConselhoAdm', [$id_unidade]);
			} else {
				return view('transparencia/membros/membros_conselhoAdm_alterar', compact('unidade', 'unidades', 'unidadesMenu', 'conselhoAdm'));
			}
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function excluirCA($id_unidade, $id_conselhoAdm, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades     = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$conselhoAdm  = $this->conselhoAdm->find($id_conselhoAdm);
		if ($validacao == 'ok') {
			if (is_null($conselhoAdm)) {
				return  redirect()->route('listarConselhoAdm', [$id_unidade]);
			} else {
				return view('transparencia/membros/membros_conselhoAdm_excluir', compact('unidade', 'unidades', 'unidadesMenu', 'conselhoAdm'));
			}
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function telaInativarCA($id_unidade, $id_conselhoAdm, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades     = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$conselhoAdm  = $this->conselhoAdm->find($id_conselhoAdm);
		if ($validacao == 'ok') {
			if (is_null($conselhoAdm)) {
				return  redirect()->route('listarConselhoAdm', [$id_unidade]);
			} else {
				return view('transparencia/membros/membros_conselhoAdm_inativar', compact('unidade', 'unidades', 'unidadesMenu', 'conselhoAdm'));
			}
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function storeCA($id, Request $request)
	{
		$input 		  = $request->all();
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade 	  = $this->unidade->where('status_unidades',1)->find($id);
		$conselhoAdms = $this->conselhoAdm->all();
		$validator = Validator::make($request->all(), [
			'name'  => 'required|max:255',
			'cargo' => 'required'
		]);
		if ($validator->fails()) {
			$validator = 'Algo de errado aconteceu, verifique os campos!';
			return view('transparencia/membros/membros_conselhoAdm_novo', compact('unidades', 'unidadesMenu', 'unidade', 'conselhoAdms'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$input['status_conselho_adms'] = 1;
			$input['unidade_id'] = 1;
			$conselhoAdm = ConselhoAdm::create($input);
			$id_registro = DB::table('conselho_adms')->max('id');
			$input['registro_id'] = $id_registro;
			$log 		  = LoggerUsers::create($input);
			$lastUpdated  = $log->max('updated_at');
			$conselhoAdms = $this->conselhoAdm->all();
			$validator 	  = 'Conselho de Administração cadastrado com sucesso!';
			return  redirect()->route('listarCA', [$id])
				->withErrors($validator);
		}
	}
	public function updateCA($id_unidade, $id_conselhoAdm, Request $request)
	{
		$input 		  = $request->all();
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade 	  = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$conselhoAdms = $this->conselhoAdm->all();
		$conselhoAdm  = $this->conselhoAdm->find($id_conselhoAdm);
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:255',
			'cargo'  => 'required'
		]);
		if ($validator->fails()) {
			return view('transparencia/membros/membros_conselhoAdm_alterar', compact('unidade', 'unidades', 'unidadesMenu', 'conselhoAdm'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$input['unidade_id'] = 1;
			$conselhoAdm = ConselhoAdm::find($id_conselhoAdm);
			$conselhoAdm->update($input);
			$input['registro_id'] = $id_conselhoAdm;
			$log 		  = LoggerUsers::create($input);
			$lastUpdated  = $log->max('updated_at');
			$conselhoAdms = $this->conselhoAdm->all();
			$validator    = 'Conselho de Adminstração alterado com sucesso!';
			return  redirect()->route('listarCA', [$id_unidade])
				->withErrors($validator);
		}
	}

	public function destroyCA($id_unidade, $id_conselhoAdm, Request $request)
	{
		$input = $request->all();
		ConselhoAdm::find($id_conselhoAdm)->delete();
		$input['registro_id'] = $id_conselhoAdm;
		$log          = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade 	  = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$conselhoAdms   = $this->conselhoAdm->all();
		$validator    = 'Conselho Admistrativo excluído com sucesso!';
		return redirect()->route('listarCA', [$id_unidade])
			->withErrors($validator);
	}

	public function inativarCA($id, $id_conselhoAdm, Request $request)
    {
		$input        = $request->all();
		$conselhoAdms = ConselhoAdm::where('id',$id_conselhoAdm)->get();
		if($conselhoAdms[0]->status_conselho_adms == 1) {
			DB::statement('UPDATE conselho_adms SET status_conselho_adms = 0 WHERE id = '.$id_conselhoAdm.';');
		} else {
			DB::statement('UPDATE conselho_adms SET status_conselho_adms = 1 WHERE id = '.$id_conselhoAdm.';');
		}
		$input['registro_id'] = $id_conselhoAdm;
		$log          = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$conselhoAdms = ConselhoAdm::where('id',$id_conselhoAdm)->get();
		$validator = 'Conselho Administrador inativado com sucesso!';
		return redirect()->route('listarCA', [$id])
				->withErrors($validator);
    }
}
