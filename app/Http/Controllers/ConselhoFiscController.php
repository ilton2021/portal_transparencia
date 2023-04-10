<?php

namespace App\Http\Controllers;

use App\Model\ConselhoFisc;
use Illuminate\Http\Request;
use App\Model\Unidade;
use App\Model\LoggerUsers;
use App\Model\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Auth;
use Illuminate\Support\Facades\Validator;
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
		$unidades = $this->unidade->where('status_unidades', 1)->get();
		return view('home', compact('unidades'));
	}

	public function listarCF($id, Request $request)
	{
		$validacao 	  = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades     = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		if ($validacao == 'ok') {
			$conselhoFiscs = $this->conselhoFisc->get();
			return view('transparencia/membros/membros_conselhoFisc_cadastro', compact('unidade', 'unidades', 'unidadesMenu', 'conselhoFiscs'));
		} else {
			$validator = 'Você não tem Permissão';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function novoCF($id, Request $request)
	{
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades     = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$validacao    = permissaoUsersController::Permissao($id);
		if ($validacao == 'ok') {
			$conselhoFiscs = $this->conselhoFisc->get();
			return view('transparencia/membros/membros_conselhoFisc_novo', compact('unidade', 'unidades', 'unidadesMenu', 'conselhoFiscs'));
		} else {
			$validator = 'Você não tem permissão';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}
	public function alterarCF($id_unidade, $id_conselhoFisc, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades     = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		if ($validacao == 'ok') {
			$conselhoFisc = $this->conselhoFisc->find($id_conselhoFisc);
			if (is_null($conselhoFisc)) {
				return  redirect()->route('listarConselhoFisc', [$id_unidade]);
			} else {
				return view('transparencia/membros/membros_conselhoFisc_alterar', compact('unidade', 'unidades', 'unidadesMenu', 'conselhoFisc'));
			}
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function excluirCF($id_unidade, $id_conselhoFisc, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		if ($validacao == 'ok') {
			$conselhoFisc = $this->conselhoFisc->find($id_conselhoFisc);
			if (is_null($conselhoFisc)) {
				return  redirect()->route('listarConselhoFisc', [$id_unidade]);
			} else {
				return view('transparencia/membros/membros_conselhoFisc_excluir', compact('unidade', 'unidades', 'unidadesMenu', 'conselhoFisc'));
			}
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function telaInativarCF($id_unidade, $id_conselhoFisc, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		if ($validacao == 'ok') {
			$conselhoFisc = $this->conselhoFisc->find($id_conselhoFisc);
			if (is_null($conselhoFisc)) {
				return  redirect()->route('listarConselhoFisc', [$id_unidade]);
			} else {
				return view('transparencia/membros/membros_conselhoFisc_inativar', compact('unidade', 'unidades', 'unidadesMenu', 'conselhoFisc'));
			}
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function storeCF($id, Request $request)
	{
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades     = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$validacao = permissaoUsersController::Permissao($id);
		if ($validacao == 'ok') {
			$conselhoFiscs = $this->conselhoFisc->get();
			$input = $request->all();
			$validator = Validator::make($request->all(), [
				'name' => 'required|max:255',
			]);
			if ($validator->fails()) {
				return view('transparencia/membros/membros_conselhoFisc_novo', compact('unidades', 'unidadesMenu', 'unidade', 'lastUpdated', 'conselhoFiscs'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			} else {
				$input['status_conselho_fiscs'] = 1;
				$input['unidade_id'] = 1;
				$conselhoFisc = conselhoFisc::create($input);
				$id_registro  = DB::table('conselho_fiscs')->max('id');
				$input['registro_id'] = $id_registro;
				$log 		   = LoggerUsers::create($input);
				$lastUpdated   = $log->max('updated_at');
				$conselhoFiscs = $this->conselhoFisc->get();
				$validator     = 'Conselho Fiscal cadastrado com sucesso!';
				return redirect()->route('listarCF', [$id])
					->withErrors($validator);
			}
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function updateCF($id_unidade, $id_conselhoFisc, Request $request)
	{
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades     = $unidadesMenu;
		$unidade 	  = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$validacao	  = permissaoUsersController::Permissao($id_unidade);
		if ($validacao == 'ok') {
			$input = $request->all();
			$conselhoFisc = $this->conselhoFisc->find($id_conselhoFisc);
			$validator = Validator::make($request->all(), [
				'name' => 'required|max:255',
			]);
			if ($validator->fails()) {
				return view('transparencia/membros/membros_conselhoFisc_alterar', compact('unidades', 'unidadesMenu', 'unidade', 'lastUpdated', 'conselhoFiscs'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			} else {
				$input['unidade_id'] = 1;
				$conselhoFisc = conselhoFisc::find($id_conselhoFisc);
				$conselhoFisc->update($input);
				$input['registro_id'] = $id_conselhoFisc;
				$log 		   = LoggerUsers::create($input);
				$lastUpdated   = $log->max('updated_at');
				$conselhoFiscs = $this->conselhoFisc->all();
				$validator     = 'Conselho Fiscal alterado com sucesso';
				return  redirect()->route('listarCF', [$id_unidade])
					->withErrors($validator);
			}
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function destroyCF($id_unidade, $id_conselhoFisc, Request $request)
	{
		$input = $request->all();
		ConselhoFisc::find($id_conselhoFisc)->delete();
		$input['registro_id'] = $id_conselhoFisc;
		$log           = LoggerUsers::create($input);
		$lastUpdated   = $log->max('updated_at');
		$unidadesMenu  = $this->unidade->where('status_unidades',1)->get();
		$unidades 	   = $unidadesMenu;
		$unidade 	   = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$conselhoFiscs  = ConselhoFisc::where('id',$id_conselhoFisc)->get();
		$validator     = 'Conselho Fiscalizador excluído com sucesso!';
		return redirect()->route('listarCF', [$id_unidade])
			->withErrors($validator);
	}

	public function inativarCF($id_unidade, $id_conselhoFisc, Request $request)
	{
		$input         = $request->all();
		$conselhoFiscs = ConselhoFisc::where('id',$id_conselhoFisc)->get();
		if($conselhoFiscs[0]->status_conselho_fiscs == 1) {
			DB::statement('UPDATE conselho_fiscs SET status_conselho_fiscs = 0 WHERE id = '.$id_conselhoFisc.';');
		} else {
			DB::statement('UPDATE conselho_fiscs SET status_conselho_fiscs = 1 WHERE id = '.$id_conselhoFisc.';');
		}
		$input['registro_id'] = $id_conselhoFisc;
		$log          = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$conselhoFiscs  = ConselhoFisc::where('id',$id_conselhoFisc)->get();
		$validator = 'Conselho Fiscalizador inativado com sucesso!';
		return redirect()->route('listarCF', [$id_unidade])
				->withErrors($validator);
	}
}
