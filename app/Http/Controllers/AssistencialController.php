<?php

namespace App\Http\Controllers;

use App\Model\Assistencial;
use App\Model\AssistencialDoc;
use Illuminate\Http\Request;
use App\Model\Unidade;
use App\Model\LoggerUsers;
use App\Http\Controllers\PermissaoUsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AssistencialController extends Controller
{
	public function __construct(Unidade $unidade, Assistencial $assistencial, LoggerUsers $logger_users)
	{
		$this->unidade 		= $unidade;
		$this->assistencial = $assistencial;
		$this->logger_users = $logger_users;
	}

	public function index()
	{
		$unidades = $this->unidade->where('status_unidades', 1)->get();
		return view('transparencia.assistencial', compact('unidades'));
	}

	public function cadastroRA($id, Request $request)
	{
		$validacao     = permissaoUsersController::Permissao($id);
		$unidades      = $unidadesMenu = $this->unidade->where('status_unidades', 1);
		$unidade       = $this->unidade->where('status_unidades',1)->find($id);
		$unidadesMenu  = $this->unidade->where('status_unidades',1)->get();
		$anosRef       = Assistencial::where('unidade_id',$id)->orderBy('ano_ref','ASC')->pluck('ano_ref')->unique();
		$assistencials = Assistencial::where('unidade_id',$id)->get();
		$anosRefDocs   = AssistencialDoc::where('unidade_id',$id)->where('status_ass_doc',1)->orderBy('ano','ASC')->get();
		$assistencial  = Assistencial::where('unidade_id', $id)->where('status_assistencials',1)->get();
		$assistenDocs  = AssistencialDoc::where('unidade_id',$id)->where('status_ass_doc',1)->get();
		//$lastUpdated  = $anosRef->max('updated_at');
        $lastUpdates = array();
        array_push($lastUpdates, 
        $assistencial      ->max('created_at'),
        $assistencial      ->max('updated_at'),
        $assistenDocs      ->max('created_at'),
        $assistenDocs      ->max('updated_at')
        );
        $lastUpdated       = max($lastUpdates);
		if ($validacao == 'ok') {
			return view('transparencia/assistencial/assistencial_cadastro', compact('unidade', 'unidades', 'unidadesMenu', 'assistenDocs', 'anosRef', 'anosRefDocs',  'lastUpdated', 'assistencials'));
		} else {
			$validator = 'Você não tem permissão!!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function alterarRA($id_unidade, $id_item, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidades     = $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$input 		  = $request->all();
		$anosRef	  = Assistencial::where('id', $id_item)->where('status_assistencials', 1)->where('unidade_id', $id_unidade)->get();
		if ($validacao == 'ok') {
			if (sizeof($anosRef) > 0) {
				$ano = $anosRef[0]->ano_ref;
				$lastUpdated = $anosRef->max('updated_at');
				return view('transparencia/assistencial/assistencial_alterar', compact('unidade', 'unidades', 'unidadesMenu', 'anosRef', 'lastUpdated'));
			} else {
				return  redirect()->route('assistencialCadastro', $id_unidade);
			}
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function excluirRA($id_unidade, $id_item, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidades 	  = $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidade 	  = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$anosRef	  = Assistencial::where('ano_ref',$id_item)->where('status_assistencials',1)->where('unidade_id',$id_unidade)->get();
		if ($validacao == 'ok') {
			if (sizeof($anosRef) > 0) {
				$lastUpdated = $anosRef->max('updated_at');
				return view('transparencia/assistencial/assistencial_excluir', compact('unidade', 'unidades', 'unidadesMenu', 'anosRef', 'lastUpdated'));
			} else {
				return  redirect()->route('assistencialCadastro', $id_unidade);
			}
		} else {
			$validator = 'Você não tem permissão!!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function novoRA($id_unidade, Request $request)
	{
		$validacao	  = permissaoUsersController::Permissao($id_unidade);
		$unidades	  = $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidade 	  = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$ano 		  = "";
		if ($validacao == 'ok') {
			if (!empty($_GET['year'])) {
				$ano = $_GET['year'];
				$anosRef = Assistencial::where('ano_ref',$ano)->where('status_assistencials',1)->where('unidade_id',$id_unidade)->get();
				if (sizeof($anosRef) > 0) {
					return view('transparencia/assistencial/assistencial_novo', compact('unidade', 'unidades', 'unidadesMenu', 'anosRef', 'ano'));
				} else {
					return  redirect()->route('assistencialCadastro',$id_unidade);
				}
			} else {
				return view('transparencia/assistencial/assistencial_novo', compact('unidade', 'unidades', 'unidadesMenu', 'ano'));
			}
		} else {
			$validator = 'Você não tem permissão';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function storeRA($id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		if ($validacao == 'ok') {
			$unidade 	  = $this->unidade->where('status_unidades', 1)->find($id);
			$unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
			$anosRef      = Assistencial::where('unidade_id', $id)->orderBy('ano_ref', 'ASC')->pluck('ano_ref')->unique();
			$lastUpdated  = $anosRef->max('updated_at');
			$input		  = $request->all();
			$ano 		  = $input['ano_ref'];
			if (isset($input['meta']) == false) {
				$input['meta'] = "";
			}
			$validator = Validator::make($request->all(), [
				'descricao'	=> 'required|max:800',
				'ano_ref' 	=> 'required',
			]);
			if ($validator->fails()) {
				return view('transparencia/assistencial/assistencial_novo', compact('unidade', 'unidadesMenu', 'anosRef', 'lastUpdated', 'ano'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			} else {
				if ($input['descricao'] == "") { $input['descricao'] = ""; }
				if ($input['meta'] == "")      { $input['meta'] = ""; }
				if ($input['janeiro'] == "")   { $input['janeiro'] = ""; }
				if ($input['fevereiro'] == "") { $input['fevereiro'] = ""; }
				if ($input['marco'] == "") 	   { $input['marco'] = ""; }
				if ($input['abril'] == "") 	   { $input['abril'] = ""; }
				if ($input['maio'] == "") 	   { $input['maio'] = ""; }
				if ($input['junho'] == "")     { $input['junho'] = ""; }
				if ($input['julho'] == "")     { $input['julho'] = ""; }
				if ($input['agosto'] == "")    { $input['agosto'] = ""; }
				if ($input['setembro'] == "")  { $input['setembro'] = ""; }
				if ($input['outubro'] == "")   { $input['outubro'] = ""; }
				if ($input['novembro'] == "")  { $input['novembro'] = ""; }
				if ($input['dezembro'] == "")  { $input['dezembro'] = ""; }
				$input['status_assistencials'] = 1;
				$assistencial = Assistencial::create($input);
				$ano 		  = $input['ano_ref'];
				$anosRef	  = Assistencial::where('unidade_id', $id)->where('status_assistencials', 1)->where('ano_ref', $ano)->get();
				$id_item 	  = DB::table('assistencials')->max('id');
				$input['registro_id'] = $id_item;
				$log 		  = LoggerUsers::create($input);
				$lastUpdated  = $log->max('updated_at');
				$validator 	  = 'Relatório Assistencial cadastrado com Sucesso!!';
				return redirect()->route('cadastroRA', $id);
				/*
			return view('transparencia/assistencial/assistencial_novo', compact('unidade', 'unidadesMenu', 'anosRef', 'lastUpdated', 'ano'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));*/
			}
		} else {
			$validator = 'Você não tem permissão';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}
	
	public function updateRA($id_unidade, $id_item, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		if ($validacao == 'ok') {
			$unidades 	  = $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
			$unidade 	  = $this->unidade->where('status_unidades',1)->find($id_unidade);
			$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
			$anosRef 	  = Assistencial::where('unidade_id',$id_unidade)->get();
			$lastUpdated  = $anosRef->max('updated_at');
			$anosRefs 	  = Assistencial::where('id',$id_item)->where('status_assistencials',1)->get();
			if (sizeof($anosRefs) > 0) {
				$input = $request->all();
				$validator = Validator::make($request->all(), [
					'descricao'	=> 'required|max:800',
					'ano_ref' 	=> 'required',
				]);
				if ($validator->fails()) {
					return view('transparencia/assistencial/assistencial_alterar', compact('unidade', 'unidadesMenu', 'anosRef', 'lastUpdated'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				} else {
					if ($input['descricao'] == "") { $input['descricao'] = ""; }
					if ($input['meta'] == "") 	   { $input['meta'] = ""; }
					if ($input['janeiro'] == "")   { $input['janeiro'] = ""; }
					if ($input['fevereiro'] == "") { $input['fevereiro'] = ""; }
					if ($input['marco'] == "") 	   { $input['marco'] = ""; }
					if ($input['abril'] == "") 	   { $input['abril'] = ""; }
					if ($input['maio'] == "") 	   { $input['maio'] = ""; }
					if ($input['junho'] == "")     { $input['junho'] = ""; }
					if ($input['julho'] == "")     { $input['julho'] = ""; }
					if ($input['agosto'] == "")    { $input['agosto'] = ""; }
					if ($input['setembro'] == "")  { $input['setembro'] = ""; }
					if ($input['outubro'] == "")   { $input['outubro'] = ""; }
					if ($input['novembro'] == "")  { $input['novembro'] = ""; }
					if ($input['dezembro'] == "")  { $input['dezembro'] = ""; }
					$assis = Assistencial::find($id_item);
					$assis->update($input);
					$input['registro_id'] = $id_item;
					$input['acao'] = 'AlterarRelAssistencial';
					$log 		   = LoggerUsers::create($input);
					$lastUpdated   = $log->max('updated_at');
					$ano 		   = $input['ano_ref'];
					$anosRef	   = Assistencial::where('unidade_id',$id_unidade)->where('status_assistencials',1)->where('ano_ref',$ano)->get();
					$validator 	   = 'Relatório Assistencial alterado com sucesso!';
					return view('transparencia/assistencial/assistencial_novo', compact('unidade', 'unidades', 'unidadesMenu', 'anosRef', 'lastUpdated', 'ano'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				}
			} else {
				return redirect()->route('cadastroRA', $id_unidade);
			}
		} else {
			$validator = 'Você não tem permissão';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function destroyRA($id_unidade, $id_item, Assistencial $assistencial, Request $request)
	{
		$ano = $id_item;
		$assistencial = Assistencial::where('unidade_id', $id_unidade)->where('ano_ref', $ano)->get();
		$qtd = sizeof($assistencial);
		$input = $request->all();
		for ($i = 0; $i < $qtd; $i++) {
			$input['status_assistencials'] = 0;
			$assis = Assistencial::find($assistencial[$i]->id);
			$assis->update($input);
			$input['tela'] = 'relAssistencial';
			$input['acao'] = 'ExclusaoRelAssistencial';
			$input['registro_id'] = $assistencial[$i]->id;
			$input['user_id']     = Auth::user()->id;
			$input['unidade_id']  = $id_unidade;
		}
		$input['registro_id'] = $id_item;
		$log   = LoggerUsers::create($input);
		$input = $request->all();
		$validator = 'Relatório Assistencial excluído com sucesso!';
		return  redirect()->route('cadastroRA', $id_unidade)
			->withErrors($validator);
	}

	public function telaInativarRA($id_unidade, $id_item, $tp, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidades 	  = $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidade 	  = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$anosRef	  = Assistencial::where('ano_ref',$id_item)->where('unidade_id',$id_unidade)->get();
		if ($validacao == 'ok') {
			if (sizeof($anosRef) > 0) {
				$lastUpdated = $anosRef->max('updated_at');
				return view('transparencia/assistencial/assistencial_inativar', compact('unidade', 'unidades', 'unidadesMenu', 'anosRef', 'lastUpdated', 'tp'));
			} else {
				return  redirect()->route('assistencialCadastro', $id_unidade);
			}
		} else {
			$validator = 'Você não tem permissão!!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function inativarRA($id_unidade, $id_item, $tp, Assistencial $assistencial, Request $request)
	{
		$ano = $id_item;
		$assistencial = Assistencial::where('unidade_id', $id_unidade)->where('ano_ref', $ano)->get();
		$qtd = sizeof($assistencial);
		$input = $request->all();
		for ($i = 0; $i < $qtd; $i++) {
			if($tp == 0) {
				$input['status_assistencials'] = 0;
				$despesas = DB::statement("UPDATE assistencials SET status_assistencials = 0 WHERE unidade_id = '$id_unidade' and ano_ref = '$ano'");
				$input['acao'] = 'inativarRelAssistencial';
				$validator = 'Relatório Assistencial inativado com sucesso!';
			} else {
				$input['status_assistencials'] = 1;
				$despesas = DB::statement("UPDATE assistencials SET status_assistencials = 1 WHERE unidade_id = '$id_unidade' and ano_ref = '$ano'");
				$input['acao'] = 'ativarRelAssistencial';
				$validator = 'Relatório Assistencial ativado com sucesso!';
			}
		}
		$input['registro_id'] = $id_item;
		$input['tela'] 	      = 'relAssistencial';
		$input['unidade_id']  = $id_unidade;
		$input['user_id'] 	  = Auth::user()->id;
		$log   = LoggerUsers::create($input);
		$input = $request->all();
		return  redirect()->route('cadastroRA', $id_unidade)
			->withErrors($validator);
	}
}
