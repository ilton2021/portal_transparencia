<?php

namespace App\Http\Controllers;

use App\Model\LoggerUsers;
use App\Model\Unidade;
use App\Model\RegimentoInterno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\PermissaoUsersController;
use Validator;
use DB;

class RegimentoInternoController extends Controller
{
	public function __construct(Unidade $unidade, LoggerUsers $logger_users, RegimentoInterno $regimentoInterno)
	{
		$this->unidade 			= $unidade;
		$this->logger_users     = $logger_users;
		$this->regimentoInterno = $regimentoInterno;
	}
	
    public function index()
    {
        $unidades = $this->unidade->all();
		return view('transparencia.regimento_interno', compact('unidades'));
    }

	public function cadastroRE($id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$regimentos   = RegimentoInterno::where('unidade_id', $id)->get();
		if($validacao == 'ok') {
			return view('transparencia/organizacional/regimento_cadastro', compact('unidades','unidadesMenu','unidade','regimentos'));
		} else {
			$validator = 'Você não tem Permissão!!';		
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}
	
	public function novoRE($id, Request $request)
	{
		$validacao 	  = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		if($validacao == 'ok') {
			return view('transparencia/organizacional/regimento_novo', compact('unidades','unidadesMenu','unidade'));
		} else {
			$validator = 'Você não tem Permissão!!';		
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}
	
	public function alterarRE($id, $id_escolha, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$regimentos   = RegimentoInterno::where('unidade_id',$id)->where('id',$id_escolha)->get();
		if ($validacao == 'ok') {
			return view('transparencia/organizacional/regimento_alterar', compact('unidades', 'unidadesMenu', 'unidade', 'regimentos'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}
	
	public function excluirRE($id, $id_escolha, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$regimentos   = RegimentoInterno::where('unidade_id',$id)->where('id',$id_escolha)->get();
		if($validacao == 'ok') {
			return view('transparencia/organizacional/regimento_excluir', compact('unidades','unidadesMenu','unidade','regimentos'));
		} else {
			$validator = 'Você não tem Permissão!!';		
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}

	public function telaInativarRE($id_escolha, $id, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$regimentos   = RegimentoInterno::where('unidade_id', $id)->where('id',$id_escolha)->get();
		if($validacao == 'ok') {
			return view('transparencia/organizacional/regimento_inativar', compact('unidades','unidadesMenu','unidade','regimentos'));
		} else {
			$validator = 'Você não tem Permissão!!';		
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}

	public function storeRE($id, Request $request)
	{
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$input 		  = $request->all();
		$nome 		  = $_FILES['file_path']['name'];
		$extensao 	  = pathinfo($nome, PATHINFO_EXTENSION);
		if ($request->file('file_path') === NULL) {
			$validator = 'Informe o arquivo do Regimento Interno!';
			return view('transparencia/organizacional/regimento_novo', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			if ($extensao === 'pdf') {
				$validator = Validator::make($request->all(), [
					'title'    => 'required|max:255',
				]);
				if ($validator->fails()) {
					return view('transparencia/organizacional/regimento_novo', compact('unidades', 'unidade', 'unidadesMenu'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				} else {
					$nome = $_FILES['file_path']['name'];
					$request->file('file_path')->move('../public/storage/regimento_interno/', $nome);
					$input['file_path'] = 'regimento_interno/' . $nome;
					$input['status_regimento'] = 1;
					RegimentoInterno::create($input);
					$id_registro = DB::table('regimento_interno')->max('id');
					$input['registro_id'] = $id_registro;
					$log 		 = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$regimentos  = RegimentoInterno::where('status_regimento',1)->where('unidade_id', $id)->get();
					$validator   = 'Regimento interno cadastrado com sucesso!';
					return  redirect()->route('cadastroRE', [$id])
						->withErrors($validator)
						->with('unidades', 'unidade', 'unidadesMenu', 'regimentos', 'lastUpdated');
				}
			} else {
				$validator = 'Só são permitidos arquivos do tipo: PDF!';
				return view('transparencia/organizacional/regimento_novo', compact('unidades', 'unidade', 'unidadesMenu'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			}
		}
	}
	
	public function updateRE($id, $id_escolha, Request $request)
	{
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$input = $request->all();
		$regimentos = RegimentoInterno::where('unidade_id', $id)->where('id', $id_escolha)->get();
		if ($request->file('file_path') !== NULL) {
			$nome = $_FILES['file_path']['name'];
			$extensao = pathinfo($nome, PATHINFO_EXTENSION);
			if ($extensao !== 'pdf') {
				$validator = 'Só são permitidos arquivos do tipo: PDF!';
				return view('transparencia/organizacional/regimento_Alterar', compact('unidades', 'unidade', 'unidadesMenu', 'regimentos'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			} else {
				$validator = Validator::make($request->all(), [
					'title'    => 'required|max:255',
				]);
				if ($validator->fails()) {
					return view('transparencia/organizacional/regimento_Alterar', compact('unidades', 'unidadesMenu', 'unidade', 'regimentos'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				} else {
					$nome = $_FILES['file_path']['name'];
					$request->file('file_path')->move('../public/storage/regimento_interno/', $nome);
					$input['file_path'] = 'regimento_interno/' . $nome;
					$regimentosInterno  = RegimentoInterno::find($id_escolha);
					$regimentosInterno->update($input);
					$input['registro_id'] = $id_escolha;
					$log = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$regimentos  = RegimentoInterno::where('status_regimento',1)->where('unidade_id', $id)->get();
					$validator   = 'Regimento Interno Alterado com sucesso!';
					return  redirect()->route('alterarRE', [$id, $id_escolha])
						->withErrors($validator)
						->with('unidades', 'unidadesMenu', 'unidade', 'regimentos');
				}
			}
		} else {
			$validator = Validator::make($request->all(), [
				'title'    => 'required|max:255',
			]);
			if ($validator->fails()) {
				return view('transparencia/organizacional/regimento_Alterar', compact('unidades', 'unidadesMenu', 'unidade', 'regimentos'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			} else {
				$regimentosInterno = RegimentoInterno::find($id_escolha);
				$regimentosInterno->update($input);
				$input['registro_id'] = $id_escolha;
				$log = LoggerUsers::create($input);
				$lastUpdated = $log->max('updated_at');
				$regimentos = RegimentoInterno::where('unidade_id', $id)->get();
				$validator = 'Regimento Interno Alterado com sucesso!';
				return  redirect()->route('alterarRE', [$id, $id_escolha])
					->withErrors($validator)
					->with('unidades', 'unidadesMenu', 'unidade', 'regimentos');
			}
		}
	}

    public function destroyRE($id, $id_escolha, Request $request)
    {
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$input        = $request->all();
		$regimento    = RegimentoInterno::where('id',$id_escolha)->get();
		$image_path   = 'storage/'.$regimento[0]->file_path;
        unlink($image_path);
        RegimentoInterno::find($id_escolha)->delete();
		$input['registro_id'] = $id_escolha;
		$log         = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$regimentos  = RegimentoInterno::where('status_regimento',1)->where('unidade_id',$id)->get();
		$validator   = 'Regimento Interno Excluído com sucesso!';
		return  redirect()->route('cadastroRE', [$id])
			->withErrors($validator)
			->with('unidades', 'unidade', 'unidadesMenu', 'regimentos', 'lastUpdated');			
    }

	public function inativarRE($id, $id_escolha, Request $request)
    {
		$input = $request->all();
		$regimento = RegimentoInterno::where('id',$id)->get();
		if($regimento[0]->status_regimento == 1) {
			$nomeArq    = explode("regimento_interno/", $regimento[0]->file_path);
			$nome       = "old_". $nomeArq[1];
			$image_path = 'regimento_interno/'.$nome;
			DB::statement("UPDATE regimento_interno SET `status_regimento` = 0, `file_path` = '$image_path' WHERE `id` = $id");
			$image_path = 'storage/regimento_interno/'.$nome;
			$caminho    = 'storage/'.$regimento[0]->file_path;
			rename($caminho, $image_path);
		} else {
			$nomeArq    = explode("regimento_interno/old_", $regimento[0]->file_path);
			$image_path = 'regimento_interno/'.$nomeArq[1];
			DB::statement("UPDATE regimento_interno SET `status_regimento` = 1, `file_path` = '$image_path' WHERE `id` = $id");
			$image_path = 'storage/regimento_interno/'.$nomeArq[1];
			$caminho    = 'storage/'.$regimento[0]->file_path;
			rename($caminho, $image_path);		
		}
		$input['registro_id'] = $regimento[0]->id;
		$log          = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_escolha);
		$regimento    = RegimentoInterno::where('unidade_id',$id_escolha)->get();
		$validator    = 'Regimento Interno inativado com sucesso!';
		return redirect()->route('cadastroRE', [$id_escolha])
				->withErrors($validator);
    }
}