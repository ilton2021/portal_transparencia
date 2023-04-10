<?php

namespace App\Http\Controllers;

use App\Model\Organizational;
use App\Model\Organograma;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Model\Unidade;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Support\Facades\Schema;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Auth;
use App\Model\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Validator;
use DB;
use Storage;

class OrganizationalController extends Controller
{
	protected $unidade;
	
    public function __construct(Unidade $unidade, Organizational $organizacional, LoggerUsers $logger_users)
    {
		$this->unidade 		  = $unidade;
		$this->organizacional = $organizacional;
		$this->logger_users   = $logger_users;
    }
	
    public function index()
    {
        $unidades = $this->unidade->all();
        return view('transparencia.organizacional', compact('unidades'));
    }
	
	public function novoOR($id, Request $request)
	{  
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades', 1)->find($id);		
		if($validacao == 'ok') {
			return view('transparencia/organizacional/organizacional_novo', compact('unidade','unidades','unidadesMenu'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}
    public function storeOR($id, Request $request, LoggerUsers $logger_users, Auth $auth)
    {
		$unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades', 1)->find($id);
		$estruturaOrganizacional = Organizational::where('unidade_id', $id)->get();
        if($unidade->id === 1){
            $lastUpdated = '2020-01-01 00:00:00';
        }else{
            $ultimaData = Organizational::where('unidade_id', $id)->where('updated_at','<=', Carbon::now() )->orderBy('updated_at', 'DESC')->first();
            $lastUpdated = '2020-01-01 00:00:00';
        }
		$validator = Validator::make($request->all(), [
				'name'  	 => 'required|min:10',
				'cargo' 	 => 'required|min:3',
				'email' 	 => 'required|email',
				'telefone' 	 => 'required|min:8'
		]);
		if ($validator->fails()) {
			return view('transparencia/organizacional/organizacional_novo', compact('unidade','unidadesMenu','estruturaOrganizacional'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}else {
			$input = $request->all(); 
			$input['status_organizacional'] = 1;
			$organizacional = Organizational::create($input); 	
			$id_registro    = DB::table('organizationals')->max('id');
			$input['registro_id'] = $id_registro;		
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$estruturaOrganizacional = Organizational::where('unidade_id', $id)->get();
			if($unidade->id === 1){
				$lastUpdated = '2020-01-01 00:00:00';
			}else{
				$ultimaData = Organizational::where('unidade_id', $id)->where('updated_at','<=', Carbon::now() )->orderBy('updated_at', 'DESC')->first();
				$lastUpdated = '2020-01-01 00:00:00';;
			}
			$validator = 'Estrutura organizacional cadastrada com sucesso!';
			return  redirect()->route('cadastroOR', [$id])
				->withErrors($validator)
				->with('unidade', 'unidadesMenu', 'lastUpdated', 'estruturaOrganizacional');
		}
    }

	public function cadastroOR($id, Organizational $organizational, Request $request)
	{ 
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades', 1)->find($id);
		$estruturaOrganizacional = Organizational::where('unidade_id', $id)->get();
		$arqOrgano = Organograma::where('unidade_id', $id)->get();
            if($unidade->id === 1){
                $lastUpdated = '2020-01-01 00:00:00';
            }else{
                $ultimaData = Organizational::where('unidade_id', $id)->where('updated_at','<=', Carbon::now() )->orderBy('updated_at', 'DESC')->first();
                $lastUpdated = '2020-01-01 00:00:00';
            }
		if($validacao == 'ok') {
			return view('transparencia/organizacional/organizacional_cadastro', compact('unidade','unidades','unidadesMenu','estruturaOrganizacional','arqOrgano'));
		} else {
			$validator ='Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}
	
	public function alterarOR($id_item, $id_unidade, Request $request)
	{  
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades', 1)->find($id_unidade);			
		$organizacionals = Organizational::where('id', $id_item)->get();
		if($validacao == 'ok') {
			return view('transparencia/organizacional/organizacional_alterar', compact('unidade','unidades','unidadesMenu','organizacionals'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}
	
	public function updateOR($id_item, $id_unidade, Request $request)
    {	
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$validator = Validator::make($request->all(), [
				'name'  	 => 'required|min:10',
				'cargo' 	 => 'required|min:3',
				'email' 	 => 'required|email',
				'telefone' 	 => 'required|min:8'
		]);		
		if ($validator->fails()) {
			$organizacionals = Organizational::where('id',$id_item)->get();
			return view('transparencia/organizacional/organizacional_novo', compact('unidade','unidadesMenu','organizacionals'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$input = $request->all();
			$organizacional = Organizational::find($id_item);
			$organizacional->update($input);	
			$input['registro_id'] = $id_item;		
			$log   = LoggerUsers::create($input);
		    $lastUpdated = $log->max('updated_at');
			$estruturaOrganizacional = Organizational::where('unidade_id', $id_unidade)->get();
			$validator   = 'Estrutura Organizacional Alterada com Sucesso!';
            return  redirect()->route('cadastroOR', [$id_unidade])
				->withErrors($validator)
				->with('unidade', 'unidades', 'unidadesMenu', 'lastUpdated', 'estruturaOrganizacional');
		}
    }
	
	public function organograma($id, Request $request)
	{  
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades', 1)->find($id);
		$arqOrgano    = Organograma::where('unidade_id', $id)->get();
		if($validacao == 'ok') {
			return view('transparencia/organizacional/organograma_cadastro', compact('unidade','unidades','unidadesMenu','arqOrgano'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}
	
	public function novoOG($id, Request $request)
	{  
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades', 1)->find($id);		
		if($validacao == 'ok') {
			return view('transparencia/organizacional/organograma_novo', compact('unidade','unidades','unidadesMenu'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}
	
	public function storeOG($id, Request $request)
    {
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$undAtual	  = Unidade::where('id', $id)->get();
		$input    	  = $request->all();
		$nome     	  = $_FILES['file_path']['name'];
		$extensao	  = pathinfo($nome, PATHINFO_EXTENSION);
		if ($request->file('file_path') === NULL) {
			$validator = 'Informe o arquivo do Organograma!';
			return view('transparencia/organizacional/organograma_novo', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			if ($extensao === 'pdf') {
				$validator = Validator::make($request->all(), [
					'title'    => 'required|max:255',
				]);
				if ($validator->fails()) {
					return view('transparencia/organizacional/organograma_novo', compact('unidades', 'unidade', 'unidadesMenu'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				} else {
                    /* if ($input['replica'] == 1) {
						$unds = Unidade::all();
						$_FILES['file_path']['name'] = $input['title'] . ".pdf";
						$request->file('file_path')->move('../public/storage/organograma/todas/', $_FILES['file_path']['name']);
						foreach ($unds as $UNDS) {
							$input['file']       = $_FILES['file_path']['name'];
							$input['file_path']  = "organograma/todas/" . $_FILES['file_path']['name'];
							$input['unidade_id'] =  $UNDS->id;
							Organograma::where('unidade_id', $UNDS->id)->delete();
							$input['status_organograma'] = 1;
							$organograma = Organograma::create($input);
							$id_registro = DB::table('organograma')->max('id');
							$input['registro_id'] = $id_registro;	
							$log 		 = LoggerUsers::create($input);
						}
						$arqOrgano = Organograma::where('unidade_id', $id)->get();
						$validator = 'Organograma cadastrado com sucesso!';
						return  redirect()->route('organograma', [$id])
							->withErrors($validator)
							->with('unidades', 'unidade', 'unidadesMenu', 'lastUpdated', 'arqOrgano', 'success', 'validator');
					} else {*/
						$_FILES['file_path']['name'] = $input['title'] . ".pdf";
						$request->file('file_path')->move('../public/storage/organograma/' . $undAtual[0]->sigla . "/", $_FILES['file_path']['name']);
						$input['file']       = $_FILES['file_path']['name'];
						$input['file_path']  = "organograma/" . $undAtual[0]->sigla . "/" . $_FILES['file_path']['name'];
						$input['unidade_id'] =  $undAtual[0]->id;
						Organograma::where('unidade_id', $id)->delete();
						$input['status_organograma'] = 1;
						$organograma = Organograma::create($input);
						$id_registro = DB::table('organograma')->max('id');
						$input['registro_id'] = $id_registro;
						$log 	     = LoggerUsers::create($input);
						$lastUpdated = $log->max('updated_at');
						$arqOrgano   = Organograma::where('unidade_id', $id)->get();
						$validator   = 'Organograma cadastrado com Sucesso!';
						return redirect()->route('organograma', [$id])
							->withErrors($validator)
							->with('unidades', 'unidade', 'unidadesMenu', 'lastUpdated', 'arqOrgano', 'success');
					//}
				}
			} else {
				$validator = 'Só são permitidos arquivos do tipo: PDF!';
				return view('transparencia/organizacional/organograma_novo', compact('unidades', 'unidade', 'unidadesMenu'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			}
		}
	}
	
	public function excluirOG($id, Request $request)
	{  
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades', 1)->find($id);		
		if($validacao == 'ok') {
			return view('transparencia/organizacional/organograma_excluir', compact('unidade','unidades','unidadesMenu'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}

	public function telaInativarOG($id, Request $request)
	{  
		$validacao 	  = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);		
		if($validacao == 'ok') {
			$organograma = Organograma::where('unidade_id',$id)->get();
			return view('transparencia/organizacional/organograma_inativar', compact('unidade','unidades','unidadesMenu','organograma'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}
	
	public function destroyOG($id, Request $request)
	{
		$unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades', 1)->find($id);
		$input = $request->all();
		$organograma = Organograma::where('unidade_id',$id)->get();
		/*if ($input['replica'] == 1) {
			$unds = Unidade::all();
			$image_path = 'storage/'.$organograma[0]->file_path;
        	unlink($image_path);
			foreach ($unds as $UNDS) {
				Organograma::where('unidade_id', $UNDS->id)->delete();
				$input['registro_id'] = $organograma[0]->id;
			}
			$log = LoggerUsers::create($input);
			$arqOrgano = Organograma::where('unidade_id', $id)->get();
			$validator = 'Organograma excluido de todas as unidades com sucesso!';
			return  redirect()->route('organograma', [$id])
				->withErrors($validator)
				->with('unidades', 'unidade', 'unidadesMenu', 'lastUpdated', 'arqOrgano', 'success', 'validator');
		} else {*/
			$image_path = 'storage/'.$organograma[0]->file_path;
        	unlink($image_path);
			Organograma::where('unidade_id', $id)->delete();
			$input['registro_id'] = $organograma[0]->id;
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$undatual  = Unidade::where('id', $id)->get();
			$arqOrgano = Organograma::where('unidade_id', $id)->get();
			$validator = 'Organograma da unidade ' . $undatual[0]->sigla . ' foi excluído com sucesso!';
			return  redirect()->route('organograma', [$id])
				->withErrors($validator)
				->with('unidades', 'unidade', 'unidadesMenu', 'lastUpdated', 'arqOrgano', 'success', 'validator');
		//}
	}

	public function inativarOG($id, Request $request)
    {
		$input = $request->all();
		$arqOrgano = Organograma::where('unidade_id',$id)->get();
		if($arqOrgano[0]->status_organograma == 1) {
			$nome = "old_". $arqOrgano[0]->file;
			DB::statement("UPDATE organograma SET `status_organograma` = 0, `file` = '$nome' WHERE `unidade_id` = $id");
			$nomeArq    = explode($arqOrgano[0]->file, $arqOrgano[0]->file_path);
			$nomeArq    = "storage/".$nomeArq[0].$nome; 
			$image_path = 'storage/'.$arqOrgano[0]->file_path;
			rename($image_path, $nomeArq);
		} else {
			$nomeAntigo = $arqOrgano[0]->file;
			$nome = explode("old_", $arqOrgano[0]->file);
			DB::statement("UPDATE organograma SET `status_organograma` = 1, `file` = '$nome[1]' WHERE `unidade_id` = $id");
			$nomeArq_   = explode($nome[1], $arqOrgano[0]->file_path);
			$nomeArq_   = "storage/".$nomeArq_[0].$nomeAntigo;
			$image_pathNovo = 'storage/'.$arqOrgano[0]->file_path;
			rename($nomeArq_, $image_pathNovo);		
		}
		$input['registro_id'] = $arqOrgano[0]->id;
		$log          = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$arqOrgano    = Organograma::where('unidade_id',$id)->get();
		$validator    = 'Organograma inativado com sucesso!';
		return redirect()->route('organograma', [$id])
				->withErrors($validator);
    }

	public function excluirOR($id_item, $id_unidade, Request $request)
	{  
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades', 1)->find($id_unidade);		
		$organizacionals = Organizational::where('id', $id_item)->get();		
		if($validacao == 'ok') {
			return view('transparencia/organizacional/organizacional_excluir', compact('unidade','unidades','unidadesMenu','organizacionals'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}

	public function telaInativarOR($id_item, $id_unidade, Request $request)
	{  
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades', 1)->find($id_unidade);		
		$organizacionals = Organizational::where('id', $id_item)->get();		
		if($validacao == 'ok') {
			return view('transparencia/organizacional/organizacional_inativar', compact('unidade','unidades','unidadesMenu','organizacionals'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}
	
    public function destroyOR($id_item, $id_unidade, Organizational $organizational, Request $request)
    {
        Organizational::find($id_item)->delete();
		$input = $request->all();
		$input['registro_id'] = $id_item;	
		$log   = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
		$unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades', 1)->find($id_unidade);
		$estruturaOrganizacional = Organizational::where('unidade_id', $id_unidade)->get();
		$validator    = 'Estrutura Organizacional Excluído com Sucesso!';
		return  redirect()->route('cadastroOR', [$id_unidade])
			->withErrors($validator)
			->with('unidade', 'unidades', 'unidadesMenu', 'lastUpdated', 'estruturaOrganizacional');
    }

	public function inativarOR($id_item, $id, Request $request)
    {
		$input = $request->all();
		$estruturaOrganizacional = Organizational::where('id',$id_item)->get();
		if($estruturaOrganizacional[0]->status_organizacional == 1) {
			DB::statement('UPDATE organizationals SET status_organizacional = 0 WHERE id = '.$id_item.';');
		} else {
			DB::statement('UPDATE organizationals SET status_organizacional = 1 WHERE id = '.$id_item.';');
		}
		$input['registro_id'] = $id_item;
		$log          = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$estruturaOrganizacional = Organizational::where('unidade_id',$id)->get();
		$validator = 'Organizacional inativado com sucesso!';
		return redirect()->route('cadastroOR', [$id])
				->withErrors($validator);
    }
}