<?php

namespace App\Http\Controllers;

use App\Model\DocumentacaoRegularidade;
use App\Model\Unidade;
use App\Model\Type;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\PermissaoUsersController;
use App\Model\PermissaoUsers;
use Auth;
use Validator;
use DB;

class DocumentacaoRegularidadeController extends Controller
{
	public function __construct(Unidade $unidade, DocumentacaoRegularidade $docRegularidade, LoggerUsers $logger_users)
	{
		$this->unidade = $unidade;
		$this->documentacaoRegularidade = $docRegularidade; 
		$this->logger_users = $logger_users;
	}

    public function index()
    {
        $unidade = $this->unidade->all();
		return view('transparencia.documentos', compact('unidade'));
    }

	public function cadastroDR($id, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$documents    = DocumentacaoRegularidade::where('unidade_id',$id)->orwhere('unidade_id',1)->get();
		$lastUpdated  = $documents->max('updated_at');
		$types 		  = Type::all();
		if($validacao == 'ok') {
			return view('transparencia/documento/documentos_cadastro', compact('unidade','unidadesMenu','unidades','lastUpdated','documents','types'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))	
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		}
	}

	public function novoDR($id, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$types		  = Type::all();
		if($validacao == 'ok') {
			return view('transparencia/documento/documentos_novo', compact('unidade','unidadesMenu','unidades','types'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			
		}
	}

	public function excluirDR($id, $id_escolha, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$types        = Type::all();
		$documents    = DocumentacaoRegularidade::find($id_escolha);
		$lastUpdated  = $documents->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/documento/documentos_excluir', compact('unidade','unidadesMenu','unidades','documents','types'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		}
	}

	public function telaInativarDR($id, $id_escolha, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$types        = Type::all();
		$documents    = DocumentacaoRegularidade::find($id_escolha);
		$lastUpdated  = $documents->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/documento/documentos_inativar', compact('unidade','unidadesMenu','unidades','documents','types'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		}
	}

    public function storeDR($id, Request $request)
    { 
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$types 		  = Type::all();
		$input 		  = $request->all();
		$nome 		  = $_FILES['path_file']['name']; 
		$extensao	  = pathinfo($nome, PATHINFO_EXTENSION);	
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:255'
		]);
		if ($validator->fails()) {			
			return view('transparencia/documento/documentos_novo', compact('unidade','unidadesMenu','unidades','types'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		} else {
			if($request->file('path_file') === NULL) {	
				$validator = 'Informe um arquivo para o Documento de Regularidade!';
				return view('transparencia/documento/documentos_novo', compact('unidade','unidadesMenu','unidades','types'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));	
			} else {
				if($extensao === 'pdf') {
				    $random = rand(1, 99999);
				    $random = substr($random, 0, 5);
					$nome =  $random ."-" . $_FILES['path_file']['name'];
					$request->file('path_file')->move('../public/storage/documento_regularidade/', $nome);	
					$input['path_file'] = 'documento_regularidade/'.$nome;
					$input['status_documentos'] = 1;
					DocumentacaoRegularidade::create($input);
					$id_registro = DB::table('regimento_interno')->max('id');
					$input['registro_id'] = $id_registro;		
					$log 		 = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$documents   = DocumentacaoRegularidade::where('unidade_id',$id)->orwhere('unidade_id',1)->get();	
					$validator   = 'Documento de Regularidade cadastrado com sucesso!';
					return  redirect()->route('cadastroDR', [$id])
						->withErrors($validator);				
				} else {
					$validator = 'Só são permitidos os arquivos do tipo: PDF';
					return view('transparencia/documento/documentos_novo', compact('unidade','unidadesMenu','unidades','types'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));				
				}
			}
		}
    }

    public function destroyDR($id, $id_escolha, Request $request)
    {
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$input        = $request->all();
		$documents    = DocumentacaoRegularidade::where('id',$id_escolha)->get();
		$image_path   = 'storage/'.$documents[0]->path_file;
        unlink($image_path);
        DocumentacaoRegularidade::find($id_escolha)->delete();
		$input['registro_id'] = $id_escolha;
		$log         = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$documents  = DocumentacaoRegularidade::where('status_documentos',1)->where('unidade_id',$id)->get();
		$validator   = 'Documento de Regularidade Excluído com sucesso!';
		return  redirect()->route('cadastroDR', [$id])
			->withErrors($validator);	
    }

	public function inativarDR($id, $id_escolha, Request $request)
    {
		$input     = $request->all();
		$documents = DocumentacaoRegularidade::where('id',$id_escolha)->get();
		if($documents[0]->status_documentos == 1) {
			$nomeArq    = explode("documento_regularidade/", $documents[0]->path_file);
			$nome       = "old_". $nomeArq[1];
			$image_path = 'documento_regularidade/'.$nome;
			DB::statement("UPDATE documentacao_regularidades SET `status_documentos` = 0, `path_file` = '$image_path' WHERE `id` = $id_escolha");
			$image_path = 'storage/documento_regularidade/'.$nome;
			$caminho    = 'storage/'.$documents[0]->path_file;
			rename($caminho, $image_path);
		} else {
			$nomeArq    = explode("documento_regularidade/old_", $documents[0]->path_file);
			$image_path = 'documento_regularidade/'.$nomeArq[1];
			DB::statement("UPDATE documentacao_regularidades SET `status_documentos` = 1, `path_file` = '$image_path' WHERE `id` = $id_escolha");
			$image_path = 'storage/documento_regularidade/'.$nomeArq[1];
			$caminho    = 'storage/'.$documents[0]->path_file;
			rename($caminho, $image_path);		
		}
		$input['registro_id'] = $documents[0]->id;
		$log          = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$documents    = DocumentacaoRegularidade::where('unidade_id',$id)->get();
		$validator    = 'Documento de Regularidade inativado com sucesso!';
		return redirect()->route('cadastroDR', [$id])
				->withErrors($validator);		
    }
}