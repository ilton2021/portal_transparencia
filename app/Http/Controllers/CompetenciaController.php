<?php

namespace App\Http\Controllers;

use App\Model\Competencia;
use Illuminate\Http\Request;
use App\Model\Unidade;
use App\Model\LoggerUsers;
use App\Model\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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
		$unidades = $this->unidade->where('status_unidades', 1)->get();
		return view('transparencia.competencia', compact('unidades'));
	}
	public function cadastroCP($id_unidade, $id_tem, Request $request)
	{
		$unidades     = $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$validacao 	  = permissaoUsersController::Permissao($id_unidade);
		if ($validacao == 'ok') {
			$competenciasMatriz = Competencia::where('id',$id_tem)->get();
			if (sizeof($competenciasMatriz) == 0) {
				return  redirect()->route('transparenciaCompetencia', [$id_unidade]);
			} else {
				$lastUpdated = $competenciasMatriz->max('updated_at');
				return view('transparencia/competencia/competencia_cadastro', compact('unidade', 'unidades', 'unidadesMenu', 'competenciasMatriz', 'lastUpdated'));
			}
		} else {
			$validator = "Você não permissão para acessar a página !";
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function alterarCP($id_unidade, $id_item, Request $request)
	{
		$validacao 	  = permissaoUsersController::Permissao($id_unidade);
		$unidades  	  = $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		if ($validacao == 'ok') {
			$competenciasMatriz = Competencia::where('id',$id_item)->get();
			if (sizeof($competenciasMatriz) == 0) {
				return  redirect()->route('transparenciaCompetencia', [$id_unidade]);
			} else {
				$lastUpdated = $competenciasMatriz->max('updated_at');
				return view('transparencia/competencia/competencia_alterar', compact('unidade', 'unidades', 'unidadesMenu', 'competenciasMatriz', 'lastUpdated'));
			}
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function excluirCP($id_unidade, $id_item, Request $request)
	{
		$validacao 	  = permissaoUsersController::Permissao($id_unidade);
		$unidades 	  = $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidade 	  = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		if ($validacao == 'ok') {
			$competenciasMatriz = Competencia::where('id',$id_item)->get();
			if (sizeof($competenciasMatriz) == 0) {
				return  redirect()->route('transparenciaCompetencia', [$id_unidade]);
			} else {
				$lastUpdated = $competenciasMatriz->max('updated_at');
				return view('transparencia/competencia/competencia_excluir', compact('unidade', 'unidades', 'unidadesMenu', 'competenciasMatriz', 'lastUpdated'));
			}
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function telaInativarCP($id_unidade, $id_item, Request $request)
	{
		$validacao 	  = permissaoUsersController::Permissao($id_unidade);
		$unidades 	  = $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidade 	  = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		if ($validacao == 'ok') {
			$competenciasMatriz = Competencia::where('id',$id_item)->get();
			if (sizeof($competenciasMatriz) == 0) {
				return  redirect()->route('transparenciaCompetencia', [$id_unidade]);
			} else {
				$lastUpdated = $competenciasMatriz->max('updated_at');
				return view('transparencia/competencia/competencia_inativar', compact('unidade', 'unidades', 'unidadesMenu', 'competenciasMatriz', 'lastUpdated'));
			}
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function novoCP($id_unidade, Request $request)
	{
		$validacao 	  = permissaoUsersController::Permissao($id_unidade);
		$unidades 	  = $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidade 	  = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		if ($validacao == 'ok') {
			$competenciasMatriz = Competencia::where('id',$id_unidade)->get();
			$lastUpdated = $competenciasMatriz->max('updated_at');
			$setores = DB::table('competencias')
				->select('setor')
				->distinct()
				->get();
			$cargos = DB::table('competencias')
				->select('cargo')
				->distinct()
				->get();
			return view('transparencia/competencia/competencia_novo', compact('unidade', 'unidades', 'unidadesMenu', 'competenciasMatriz', 'lastUpdated', 'setores', 'cargos'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function storeCP($id, Request $request)
	{
		$unidades 	  = $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidade 	  = $this->unidade->where('status_unidades',1)->find($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$validacao 	  = permissaoUsersController::Permissao($id);
		if ($validacao == 'ok') {
			$input = $request->all();
			$competenciasMatriz = Competencia::where('unidade_id', $id)->get();
			$validator = Validator::make($request->all(), [
				'setor' => 'required|max:255',
				'cargo' => 'required|max:255',
				'descricao' => 'required|max:5000'
			]);
			if ($validator->fails()) {
				return view('transparencia/competencia/competencia_novo', compact('unidade', 'unidades', 'unidadesMenu', 'competenciasMatriz', 'lastUpdated'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			} else {
				$input['status_competencias'] = 1;
				$competencia = Competencia::create($input);
				$id_registro = DB::table('competencias')->max('id');
				$input['registro_id'] = $id_registro;
				$log 		 = LoggerUsers::create($input);
				$lastUpdated = $log->max('updated_at');
				$validator 	 = 'Matriz de Competência cadastrada com sucesso!';
				return  redirect()->route('transparenciaCompetencia', [$id])
					->withErrors($validator);
			}
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function updateCP($id_unidade, $id_item, Request $request)
	{
		$unidades 	  = $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidade 	  = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		if ($validacao == 'ok') {
			$competenciasMatriz = Competencia::where('id',$id_item)->get();
			if (sizeof($competenciasMatriz) == 0) {
				return  redirect()->route('transparenciaCompetencia', [$id_unidade]);
			} else {
				$validator = Validator::make($request->all(), [
					'setor' => 'required|max:255',
					'cargo' => 'required|max:255',
					'descricao' => 'required|max:5000'
				]);
				if ($validator->fails()) {
					return view('transparencia/competencia/competencia_alterar', compact('processos'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				} else {
					$input 		 = $request->all();
					$competencia = Competencia::find($id_item);
					$competencia->update($input);
					$input['registro_id'] = $id_item;
					$log 				  = LoggerUsers::create($input);
					$lastUpdated 		  = $log->max('updated_at');
					$competenciasMatriz   = Competencia::where('id', $id_item)->get();
					$lastUpdated 		  = $competenciasMatriz->max('updated_at');
					$validator 			  = 'Matriz de Competência alterada com sucesso!';
					return  redirect()->route('cadastroCP', [$id_unidade, $id_item])
						->withErrors($validator);
				}
			}
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function destroyCP($id_unidade, $id_item, Request $request)
	{
		$input = $request->all();
		Competencia::find($id_item)->delete();
		$input['registro_id'] = $id_item;
		$log           = LoggerUsers::create($input);
		$lastUpdated   = $log->max('updated_at');
		$unidadesMenu  = $this->unidade->where('status_unidades',1)->get();
		$unidades 	   = $unidadesMenu;
		$unidade 	   = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$competenciasMatriz = Competencia::where('id',$id_item)->get();
		$validator     = 'Competência excluída com sucesso!';
		return redirect()->route('cadastroCP', [$id_unidade, $id_item])
			->withErrors($validator);
	}

	public function inativarCP($id_unidade, $id_item, Request $request)
	{
		$input         	    = $request->all();
		$competenciasMatriz = Competencia::where('id',$id_item)->get();
		if($competenciasMatriz[0]->status_competencias == 1) {
			DB::statement('UPDATE competencias SET status_competencias = 0 WHERE id = '.$id_item.';');
		} else {
			DB::statement('UPDATE competencias SET status_competencias = 1 WHERE id = '.$id_item.';');
		}
		$input['registro_id'] = $id_item;
		$log          = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$competenciasMatriz = Competencia::where('id',$id_item)->get();
		$validator = 'Competência inativada com sucesso!';
		return redirect()->route('cadastroCP', [$id_unidade, $id_item])
				->withErrors($validator);
	}
}