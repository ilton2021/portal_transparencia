<?php

namespace App\Http\Controllers;

use App\Model\Manual;
use App\Model\Unidade;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Storage;
use App\Model\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Auth;
use Validator;
use DB;

class RegulamentoController extends Controller
{
	public function __construct(Unidade $unidade, Manual $manual, LoggerUsers $logger_users)
    {
        $this->unidade 		= $unidade;
		$this->manual  		= $manual;
		$this->logger_users = $logger_users;
    }
	
    public function index()
    {
		$unidades = $this->unidade->all();
		return view ('transparencia', compact('unidades'));
    }

    public function cadastroRG($id)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidade      = $this->unidade->find($id);
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;	
		$manuais      = Manual::all();
        $lastUpdated  = $manuais->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/regulamentos/regulamento_cadastro', compact('unidade','unidades','unidadesMenu','manuais','lastUpdated'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator);
		}
	}
	
	public function novoRG($id)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidade      = $this->unidade->find($id);
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;	
		if($validacao == 'ok') {
			return view('transparencia/regulamentos/regulamento_novo', compact('unidade','unidades','unidadesMenu'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}
	
	public function excluirRG($id_unidade, $id_item)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidade      = $this->unidade->find($id_unidade);
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;	
		$manuais 	  = Manual::where('status_manuais',1)->where('id',$id_item)->get();
		$lastUpdated  = $manuais->max('updated_at');	
		if($validacao == 'ok') {
			return view('transparencia/regulamentos/regulamento_excluir', compact('unidade','unidades','unidadesMenu','manuais','lastUpdated'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}

	public function telaInativarRG($id_unidade, $id_item)
	{
		$validacao 	  = permissaoUsersController::Permissao($id_unidade);
		$unidade      = $this->unidade->find($id_unidade);
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;	
		$manuais 	  = Manual::where('id',$id_item)->get();
		$lastUpdated  = $manuais->max('updated_at');	
		if($validacao == 'ok') {
			return view('transparencia/regulamentos/regulamento_inativar', compact('unidade','unidades','unidadesMenu','manuais','lastUpdated'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}
	
    public function storeRG($id_unidade, Request $request)
    { 
        $unidade      = $this->unidade->find($id_unidade);
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
        $lastUpdated  = date('d-m-Y', strtotime('now'));
		$input 		  = $request->all();
		$nome 		  = $_FILES['path_file']['name']; 
		$extensao     = pathinfo($nome, PATHINFO_EXTENSION);
		$nomeImg      = $_FILES['path_img']['name'];
		$extensaoI    = pathinfo($nomeImg, PATHINFO_EXTENSION);
		if($request->file('path_file') === NULL || $request->file('path_img') === NULL) {	
			$validator = 'Informe o arquivo e a imagem do Regulamento!';
			return view('transparencia/regulamentos/regulamento_novo', compact('unidades','unidade','unidadesMenu','lastUpdated'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		} else {
			if($extensao == 'pdf') {
				if($extensaoI == 'png' || $extensaoI == 'jpg') {
					$validator  = Validator::make($request->all(), [
						'title' => 'required|max:255'
					]);
					if ($validator->fails()) {
						return view('transparencia/regulamentos/regulamento_novo', compact('unidades','unidade','unidadesMenu','lastUpdated'))
							->withErrors($validator)
							->withInput(session()->flashInput($request->input()));	
					} else {  
						$nomeA = $_FILES['path_file']['name'];   
						$request->file('path_file')->move('../public/storage/manual', $nomeA);
						$nomeF = $_FILES['path_img']['name'];
						$request->file('path_img')->move('../public/img', $nome);
						$input['path_file'] = 'manual/' .$nomeA;
						$input['path_img'] = $nomeF;				
						$input['status_manuais'] = 1;	
						$manuais     = Manual::create($input);	
						$id_registro = DB::table('manuals')->max('id');
						$input['registro_id'] = $id_registro;
						$log         = LoggerUsers::create($input);
						$lastUpdated = $log->max('updated_at');
						$manuais     = Manual::where('status_manuais',1)->get();
						$validator   = 'Regulamento cadastrado com sucesso!';
						return redirect()->route('cadastroRG',[$id_unidade])->withErrors($validator);									
					} 
				} else {
					$validator = 'Só suporta Imagens do tipo: PNG e JPG!';
					$manuais = Manual::where('unidade_id',$id_unidade)->get();
					$lastUpdated = $manuais->max('updated_at');
					return view('transparencia/regulamentos/regulamento_novo', compact('unidades','unidade','unidadesMenu','lastUpdated'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));		
				}
			} else {	
				$validator = 'Só suporta arquivos do tipo: PDF!';
				$manuais = Manual::where('unidade_id',$id_unidade)->get();
				$lastUpdated = $manuais->max('updated_at');
				return view('transparencia/regulamentos/regulamento_novo', compact('unidades','unidade','unidadesMenu','lastUpdated'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));	
			}
		}
	}

    public function destroyRG($id_unidade, $id_item, Manual $manuais, Request $request)
    {
		$input   	  = $request->all();
		$manuais 	  = Manual::where('id',$id_item)->get();
		$image_path   = 'storage/'.$manuais[0]->path_file;
        unlink($image_path);
		Manual::find($id_item)->delete();		
		$input['registro_id'] = $id_item;
		$log   		  = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
        $unidade      = $this->unidade->find($id_unidade);
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;	
		$manuais      = Manual::where('status_manuais',1)->get();
		$validator 	  = 'Regulamento Excluído com sucesso!';
		return redirect()->route('cadastroRG', [$id_unidade])
			->withErrors($validator);
    }

	public function inativarRG($id, $id_item, Request $request)
    {
		$input = $request->all();
		$manuais = Manual::where('id',$id_item)->get();
		if($manuais[0]->status_manuais == 1) {
			$nomeArq    = explode("manual/", $manuais[0]->path_file); 
			$nome       = "old_". $nomeArq[1]; 
			$image_path = 'manual/'.$nome;  
			DB::statement("UPDATE manuals SET `status_manuais` = 0, `path_file` = '$image_path' WHERE `id` = $id_item");
			$image_path = 'storage/manual/'.$nome; 
			$caminho    = 'storage/'.$manuais[0]->path_file;  
			rename($caminho, $image_path);
		} else {
			$nomeArq    = explode("manual/old_", $manuais[0]->path_file);
			$image_path = 'manual/'.$nomeArq[1];
			DB::statement("UPDATE manuals SET `status_manuais` = 1, `path_file` = '$image_path' WHERE `id` = $id_item");
			$image_path = 'storage/manual/'.$nomeArq[1];
			$caminho    = 'storage/'.$manuais[0]->path_file;
			rename($caminho, $image_path);		
		}
		$input['registro_id'] = $manuais[0]->id;
		$log          = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$regimento    = Manual::where('id',$id_item)->get();
		$validator    = 'Regulamento Próprio inativado com sucesso!';
		return redirect()->route('cadastroRG', [$id])
				->withErrors($validator);
    }
}