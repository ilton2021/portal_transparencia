<?php

namespace App\Http\Controllers;

use App\Model\ContratoGestao;
use App\Model\Unidade;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Model\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Validator;
use DB;

class ContratoController extends Controller
{
    public function __construct(Unidade $unidade, ContratoGestao $contratoGestao, LoggerUsers $logger_users)
    {
        $this->unidade 		  = $unidade;
		$this->contratoGestao = $contratoGestao;
		$this->logger_users   = $logger_users;
    }
	
	public function index(Unidade $unidade)
    {
        $unidades = $this->unidade->all();
		return view('transparencia.contratoGestao', compact('unidades'));
    }
	
	public function novoCG($id_unidade, Request $request)
	{
		$validacao 	  = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		if($validacao == 'ok') {
			return view('transparencia/contratosGestao/contratoGestao_novo', compact('unidades','unidade','unidadesMenu'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			
		}
	}
	
    public function cadastroCG($id_unidade, ContratoGestao $contrato, Request $request)
	{
		$validacao 	  = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		if ($id_unidade === 1) {
			$contratos = ContratoGestao::all();
		} else {
			$contratos = ContratoGestao::where('unidade_id', $id_unidade)->get();
		}
		$lastUpdated = $contratos->max('updated_at');
		if ($validacao == 'ok') {
			return view('transparencia/contratosGestao/contratoGestao_cadastro', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'lastUpdated'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}
	
		public function alterarCG($id_unidade, $escolha, Request $request)
	{
		$validacao	  = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$contratos	  = ContratoGestao::where('id', $escolha)->get();
		$lastUpdated  = $contratos->max('updated_at');
		if ($validacao == 'ok') {
			return view('transparencia/contratosGestao/contratoGestao_alterar', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'lastUpdated'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}
	
	public function excluirCG($id_unidade, $escolha, Request $request)
	{
		$validacao 	  = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$contratos    = ContratoGestao::where('id',$escolha)->get();
        $lastUpdated  = $contratos->max('updated_at');        
		if($validacao == 'ok') {
			return view('transparencia/contratosGestao/contratoGestao_excluir', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			
		}
	}

	public function telaInativarCG($id_unidade, $escolha, Request $request)
	{
		$validacao 	  = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$contratos    = ContratoGestao::where('id',$escolha)->get();
        $lastUpdated  = $contratos->max('updated_at');        
		if($validacao == 'ok') {
			return view('transparencia/contratosGestao/contratoGestao_inativar', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			
		}
	}
	
    public function storeCG($id_unidade, Request $request)
    { 
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$contratos    = ContratoGestao::where('unidade_id',$id_unidade)->get();
        $lastUpdated  = $contratos->max('updated_at');
		$input 		  = $request->all();
		$nome 		  = $_FILES['path_file']['name']; 
		$extensao 	  = pathinfo($nome, PATHINFO_EXTENSION);
		if($request->file('path_file') === NULL) {	
			$validator = 'Informe o arquivo do contrato';
			return view('transparencia/contratosGestao/contratoGestao_novo', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
		    $extensao = strtolower($extensao);
			if($extensao === 'pdf') {
				$validator = Validator::make($request->all(), [
					'title' => 'required|max:255',
					]);
				if ($validator->fails()) {
					return view('transparencia.contratoGestao', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				} else {
					$nome = $_FILES['path_file']['name']; 					
					$request->file('path_file')->move('../public/storage/contrato_gestao/', $nome);
					$input['path_file'] 	   = 'contrato_gestao/' .$nome; 
					$input['status_contratos'] = 1;
					$contrato_gestao = ContratoGestao::create($input);
					$id_registro = DB::table('contrato_gestaos')->max('id');
					$input['registro_id'] = $id_registro;
					$log 		 = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$contratos   = ContratoGestao::where('unidade_id',$id_unidade)->get();
					$validator   = 'Contrato de Gestão/Aditivo cadastrado com sucesso!';
					return redirect()->route('cadastroCG', [$id_unidade])
						->withErrors($validator);			
				}
			} else {	
				$validator = 'Só suporta arquivos do tipo: PDF';
				return view('transparencia/contratosGestao/contratoGestao_novo', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			}
		}
	
    }
	
	public function updateCG($id_unidade, $id_escolha, Request $request)
	{
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$contratos	  = ContratoGestao::where('unidade_id', $id_unidade)->get();
		$lastUpdated  = $contratos->max('updated_at');
		$input		  = $request->all();
		$arq 		  = isset($input['path_file']);
		if ($arq) {
			$nome 	  = $_FILES['path_file']['name'];
			$extensao = pathinfo($nome, PATHINFO_EXTENSION);
			$ext 	  = strtolower($extensao);
			if ($ext === 'pdf') {
				$validator = Validator::make($request->all(), [
					'title' => 'required|max:255',
				]);
				if ($validator->fails()) {
					return view('transparencia/contratosGestao/contratoGestao_alterar', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'lastUpdated'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				} else {
					$nome = $_FILES['path_file']['name'];
					$request->file('path_file')->move('../public/storage/contrato_gestao/', $nome);
					$input['path_file']   = 'contrato_gestao/' . $nome;
					$contrato_gestao      = ContratoGestao::find($id_escolha);
					$contrato_gestao->update($input);
					$input['registro_id'] = $id_escolha;
					$log		 = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$contratos   = ContratoGestao::where('unidade_id', $id_unidade)->get();
					$validator   = 'Contrato de Gestão/Aditivo cadastrado com sucesso!';
					return redirect()->route('cadastroCG', [$id_unidade])
						->withErrors($validator);
				}
			} else {
				$validator = 'Só suporta arquivos do tipo: PDF';
				return view('transparencia/contratosGestao/contratoGestao_alterar', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'lastUpdated'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			}
		} else {
			$validator = Validator::make($request->all(), [
				'title' => 'required|max:255',
			]);
			if ($validator->fails()) {
				return view('transparencia/contratosGestao/contratoGestao_alterar', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'lastUpdated'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			} else {
				$input['path_file'] = $input['arquivo'];
				$contrato_gestao    = ContratoGestao::find($id_escolha);
				$contrato_gestao->update($input);
				$input['registro_id'] = $id_escolha;
				$log 		 = LoggerUsers::create($input);
				$lastUpdated = $log->max('updated_at');
				$contratos   = ContratoGestao::where('unidade_id', $id_unidade)->get();
				$validator   = 'Contrato de Gestão/Aditivo alterado com sucesso!';
				return redirect()->route('cadastroCG', [$id_unidade, $id_escolha])
					->withErrors($validator);
			}
		}
	}
	
    public function destroyCG($id_unidade, $id_escolha, Request $request)
    {
		$input 		  = $request->all();
		$contratos    = ContratoGestao::where('id',$id_escolha)->get();
		$image_path   = 'storage/'.$contratos[0]->path_file;
        unlink($image_path);
        ContratoGestao::find($id_escolha)->delete();
		$input['registro_id'] = $id_escolha;
		$log 		 = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$contratos = ContratoGestao::where('unidade_id',$id_unidade)->get();
		$validator = 'Contrato de Gestão/Aditivo excluído com sucesso!';
   		return redirect()->route('cadastroCG', [$id_unidade])
			->withErrors($validator);
    }

	public function inativarCG($id, $id_escolha, Request $request)
    {
		$input = $request->all();
		$contratos = ContratoGestao::where('id',$id_escolha)->get();
		if($contratos[0]->status_contratos == 1) {
			$nomeArq    = explode("contrato_gestao/", $contratos[0]->path_file);
			$nome       = "old_". $nomeArq[1];
			$image_path = 'contrato_gestao/'.$nome;
			DB::statement("UPDATE contrato_gestaos SET `status_contratos` = 0, `path_file` = '$image_path' WHERE `id` = $id_escolha");
			$image_path = 'storage/contrato_gestao/'.$nome;
			$caminho    = 'storage/'.$contratos[0]->path_file;
			rename($caminho, $image_path);
		} else {
			$nomeArq    = explode("contrato_gestao/old_", $contratos[0]->path_file);
			$image_path = 'contrato_gestao/'.$nomeArq[1];
			DB::statement("UPDATE contrato_gestaos SET `status_contratos` = 1, `path_file` = '$image_path' WHERE `id` = $id_escolha");
			$image_path = 'storage/contrato_gestao/'.$nomeArq[1];
			$caminho    = 'storage/'.$contratos[0]->path_file;
			rename($caminho, $image_path);		
		}
		$input['registro_id'] = $contratos[0]->id;
		$log          = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$contratos    = ContratoGestao::where('unidade_id',$id)->get();
		$validator    = 'Contrato de Gestão inativado com sucesso!';
		return redirect()->route('cadastroCG', [$id])
				->withErrors($validator);
    }
}