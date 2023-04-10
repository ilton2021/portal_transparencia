<?php

namespace App\Http\Controllers;

use App\Model\Decreto;
use App\Model\Unidade;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Storage;
use App\Model\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Auth;
use Validator;
use DB;

class DecretoController extends Controller
{
	public function __construct(Unidade $unidade, Decreto $decreto, LoggerUsers $logger_users)
    {
        $this->unidade 		= $unidade;
		$this->decreto 	    = $decreto;
		$this->logger_users = $logger_users;
    }
	
    public function index()
    {
		$unidades = $this->unidade->all();
		return view ('transparencia', compact('unidades'));
    }

    public function cadastroDE($id, Request $request)
	{
		$validacao 	  = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$decretos 	  = Decreto::all();
        $lastUpdated  = $decretos->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/decretos/decreto_cadastro', compact('unidade','unidades','unidadesMenu','decretos','lastUpdated'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}
	
	public function novoDE($id, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		if($validacao == 'ok') {
			return view('transparencia/decretos/decreto_novo', compact('unidade','unidades','unidadesMenu'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}
	
	public function excluirDE($id_unidade, $id_item, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$decretos 	  = Decreto::where('id',$id_item)->get();
		$lastUpdated  = $decretos->max('updated_at');	
		if($validacao == 'ok') {
			return view('transparencia/decretos/decreto_excluir', compact('unidade','unidades','unidadesMenu','decretos','lastUpdated'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			
		}
	}

	public function telaInativarDE($id_unidade, $id_item, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$decretos 	  = Decreto::where('id',$id_item)->get();
		$lastUpdated  = $decretos->max('updated_at');	
		if($validacao == 'ok') {
			return view('transparencia/decretos/decreto_inativar', compact('unidade','unidades','unidadesMenu','decretos','lastUpdated'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			
		}
	}
	
    public function storeDE($id_unidade, Request $request)
    { 
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$decretos     = Decreto::all();
        $lastUpdated  = $decretos->max('updated_at');
		$input 		  = $request->all();
		$nome 		  = $_FILES['path_file']['name']; 
		$extensao     = pathinfo($nome, PATHINFO_EXTENSION); 
		if($request->file('path_file') === NULL) {	
			$validator = 'Informe o arquivo do Decreto';
			return view('transparencia/decretos/decreto_novo', compact('unidades','unidade','unidadesMenu','decretos','lastUpdated'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		} else {  
			if($extensao == 'pdf') {
				$validator = Validator::make($request->all(), [
					'title'   => 'required|max:255',
					'decreto' => 'required',
					'kind'	  => 'required'
				]); 
				if ($validator->fails()) {
					return view('transparencia/decretos/decreto_novo', compact('unidades','unidade','unidadesMenu','decretos'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));	
				} else {
					$nome = $_FILES['path_file']['name'];  
					$request->file('path_file')->move('../public/storage/decretos/', $nome);
					$input['path_file'] = 'decretos/' .$nome; 
					$input['decreto']   = 'Nº: '.$input['decreto'];
					$input['status_decreto'] = 1;
					$decretos    = Decreto::create($input);	
					$id_registro = DB::table('decretos')->max('id');
					$input['registro_id'] = $id_registro;
					$log         = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$decretos    = Decreto::all();
					$validator   = 'Decreto cadastrado com Sucesso!!';
					return redirect()->route('cadastroDE', $id_unidade)
						->withErrors($validator);
				} 			
			} else {	
				$validator = 'São suportados somente arquivos do tipo: PDF!';
				$decretos = Decreto::all();
				$lastUpdated = $decretos->max('updated_at');
				return view('transparencia/decretos/decreto_novo', compact('unidades','unidade','unidadesMenu','decretos','lastUpdated'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));	
			}
		}
	}

    public function destroyDE($id_unidade, $id_item, Request $request)
    {
		$input 		= $request->all();
		$decretos   = Decreto::where('id',$id_item)->get();
		$image_path = 'storage/'.$decretos[0]->path_file;
        unlink($image_path);
		Decreto::find($id_item)->delete();
		$input['registro_id'] = $id_item;
		$log 		  = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);		
		$decretos 	  = Decreto::all();
		$validator = 'Decreto excluido com sucesso!';
		return  redirect()->route('cadastroDE', $id_unidade)
						->withErrors($validator);
    }

	public function inativarDE($id, $id_escolha, Request $request)
    {
		$input = $request->all();
		$decretos = Decreto::where('id',$id_escolha)->get();
		if($decretos[0]->status_decreto == 1) {
			$nomeArq    = explode("decretos/", $decretos[0]->path_file);
			$nome       = "old_". $nomeArq[1];
			$image_path = 'decretos/'.$nome;
			DB::statement("UPDATE decretos SET `status_decreto` = 0, `path_file` = '$image_path' WHERE `id` = $id_escolha");
			$image_path = 'storage/decretos/'.$nome;
			$caminho    = 'storage/'.$decretos[0]->path_file;
			rename($caminho, $image_path);
		} else {
			$nomeArq    = explode("decretos/old_", $decretos[0]->path_file);
			$image_path = 'decretos/'.$nomeArq[1];
			DB::statement("UPDATE decretos SET `status_decreto` = 1, `path_file` = '$image_path' WHERE `id` = $id_escolha");
			$image_path = 'storage/decretos/'.$nomeArq[1];
			$caminho    = 'storage/'.$decretos[0]->path_file;
			rename($caminho, $image_path);		
		}
		$input['registro_id'] = $decretos[0]->id;
		$log          = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$decretos     = Decreto::where('id',$id_escolha)->get();
		$validator    = 'Decreto inativado com sucesso!';
		return redirect()->route('cadastroDE', [$id])
				->withErrors($validator);
    }
}