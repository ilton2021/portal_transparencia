<?php

namespace App\Http\Controllers;

use App\Model\Estatuto;
use App\Model\Unidade;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Storage;
use App\Model\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Auth;
use Validator;
use DB;

class EstatutoController extends Controller
{
	public function __construct(Unidade $unidade, Estatuto $estatuto, LoggerUsers $logger_users)
	{
		$this->unidade  	= $unidade;
		$this->estatuto 	= $estatuto;
		$this->logger_users = $logger_users;
	}

	public function index()
	{
		$unidades = $this->unidade->all();
		return view('transparencia.estatuto', compact('unidades'));
	}

	public function cadastroES($id, Request $request)
	{
		$validacao 	  = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);	
		$estatutos    = $this->estatuto->all();
		if ($validacao == 'ok') {
			return view('transparencia/estatuto/estatuto_cadastro', compact('unidade', 'unidades', 'unidadesMenu', 'estatutos'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function novoES($id, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);	
		if ($validacao == 'ok') {
			return view('transparencia/estatuto/estatuto_novo', compact('unidade', 'unidades', 'unidadesMenu'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function excluirES($id, $id_estatuto, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);	
		$estatutos    = $this->estatuto->find($id_estatuto);
		if ($validacao == 'ok') {
			return view('transparencia/estatuto/estatuto_excluir', compact('unidade', 'unidades', 'unidadesMenu', 'estatutos'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function telaInativarES($id, $id_estatuto, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);	
		$estatutos    = $this->estatuto->find($id_estatuto);
		if ($validacao == 'ok') {
			return view('transparencia/estatuto/estatuto_inativar', compact('unidade', 'unidades', 'unidadesMenu', 'estatutos'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function storeES($id, Request $request)
	{
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);	
		$estatutos    = $this->estatuto->all();
		$input        = $request->all();
		$nome         = $_FILES['path_file']['name'];
		$extensao     = pathinfo($nome, PATHINFO_EXTENSION);
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:255'
		]);
		if ($validator->fails()) {
			return view('transparencia/estatuto/estatuto_novo', compact('unidade', 'unidades', 'unidadesMenu', 'estatutos'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			if ($request->file('path_file') === NULL) {
				$validator = 'Informe o arquivo do Estatuto / Ata!';
				return view('transparencia/estatuto/estatuto_novo', compact('unidade', 'unidades', 'unidadesMenu', 'estatutos'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			} else {
				if ($extensao === 'pdf') {
					$nome = $_FILES['path_file']['name'];
					$request->file('path_file')->move('../public/storage/estatuto_ata/', $nome);
					$input['path_file'] = 'estatuto_ata/' . $nome;
					$input['kind'] 		= 'ATA';
					$input['status_estatuto'] = 1;	
					$estatuto    = Estatuto::create($input);
					$id_registro = DB::table('estatutos')->max('id');
					$input['registro_id'] = $id_registro;
					$log 				  = LoggerUsers::create($input);
					$lastUpdated	      = $log->max('updated_at');
					$estatutos 		      = $this->estatuto->all();
					$validator 			  = 'Estatuto / Ata cadastrado com sucesso!';
					return  redirect()->route('cadastroES', [$id])
						->withErrors($validator);
				} else {
					$validator = 'Só são permitidos arquivos do tipo: PDF!';
					return view('transparencia/estatuto/estatuto_novo', compact('unidade', 'unidades', 'unidadesMenu', 'estatutos'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				}
			}
		}
	}

	public function destroyES($id, $id_estatuto, Request $request)
	{
		$input 		  = $request->all();
		$estatuto     = Estatuto::where('id',$id_estatuto)->get();
		$image_path   = 'storage/'.$estatuto[0]->path_file;
        unlink($image_path);
		Estatuto::find($id_estatuto)->delete();
		$input['registro_id'] = $id_estatuto;
		$log   		  = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);	
		$estatutos    = $this->estatuto->all();
		$validator    = 'Estatuto/Ata Excluído com sucesso!';
		return  redirect()->route('cadastroES', [$id])
			->withErrors($validator);
	}

	public function inativarES($id, $id_estatuto, Request $request)
	{
		$input    = $request->all();
		$estatuto = Estatuto::where('id',$id_estatuto)->get();
		if($estatuto[0]->status_estatuto == 1) {
			$nomeArq    = explode("estatuto_ata/", $estatuto[0]->path_file);
			$nome       = "old_". $nomeArq[1];
			$image_path = 'estatuto_ata/'.$nome;
			DB::statement("UPDATE estatutos SET `status_estatuto` = 0, `path_file` = '$image_path' WHERE `id` = $id_estatuto");
			$image_path = 'storage/estatuto_ata/'.$nome;
			$caminho    = 'storage/'.$estatuto[0]->path_file;
			rename($caminho, $image_path);
		} else {
			$nomeArq    = explode("estatuto_ata/old_", $estatuto[0]->path_file);
			$image_path = 'estatuto_ata/'.$nomeArq[1];
			DB::statement("UPDATE estatutos SET `status_estatuto` = 1, `path_file` = '$image_path' WHERE `id` = $id_estatuto");
			$image_path = 'storage/estatuto_ata/'.$nomeArq[1];
			$caminho    = 'storage/'.$estatuto[0]->path_file;
			rename($caminho, $image_path);		
		}
		$input['registro_id'] = $estatuto[0]->id;
		$log          = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$estatuto     = Estatuto::where('unidade_id',$id)->get();
		$validator    = 'Estatuto inativado com sucesso!';
		return redirect()->route('cadastroES', [$id])
				->withErrors($validator);
	}
}