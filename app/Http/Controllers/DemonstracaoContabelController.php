<?php

namespace App\Http\Controllers;

use App\Model\DemonstracaoContabel;
use App\Model\Unidade;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\PermissaoUsersController;
use App\Model\PermissaoUsers;
use Auth;
use Validator;
use DB;

class DemonstracaoContabelController extends Controller
{
	public function __construct(Unidade $unidade, DemonstracaoContabel $demonstracaoContabel, LoggerUsers $logger_users)
    {
        $this->unidade 				= $unidade;
		$this->demonstracaoContabel = $demonstracaoContabel;
		$this->logger_users 		= $logger_users;
    }
	
    public function index()
    {
		$unidades = $this->unidade->all();
		return view ('transparencia', compact('unidades'));
    }

    public function cadastroDC($id, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);	
		$demonstrativoContaveis = DemonstracaoContabel::where('unidade_id', $id)->get();
        $lastUpdated  = $demonstrativoContaveis->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/demonstrativo-contabel/accountable_cadastro', compact('unidade','unidades','unidadesMenu','demonstrativoContaveis','lastUpdated'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
    			->withErrors($validator)
    			->withInput(session()->flashInput($request->input()));
		}
	}
	
	public function novoDC($id, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$contabilReports = DemonstracaoContabel::where('unidade_id', $id)->get();
        $lastUpdated  = $contabilReports->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/demonstrativo-contabel/accountable_novo', compact('unidade','unidades','unidadesMenu','contabilReports','lastUpdated'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
    			->withErrors($validator)
    			->withInput(session()->flashInput($request->input()));
		}
	}
	
	public function telaInativarDC($id_unidade, $id_item, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$contabilReports = DemonstracaoContabel::where('id', $id_item)->get(); 
        $lastUpdated  = $contabilReports->max('updated_at');
		if($validacao == 'ok') {
		    return view('transparencia/demonstrativo-contabel/accountable_inativar', compact('unidade','unidades','unidadesMenu','contabilReports','lastUpdated'));	
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
    			->withErrors($validator)
    			->withInput(session()->flashInput($request->input()));
		}
	}
	
	public function excluirDC($id_unidade, $id_item, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$demonstrativoContaveis = DemonstracaoContabel::where('id',$id_item)->get();
		$lastUpdated  = $demonstrativoContaveis->max('updated_at');	
		if($validacao == 'ok') {
		    return view('transparencia/demonstrativo-contabel/accountable_excluir', compact('unidade','unidades','unidadesMenu','demonstrativoContaveis','lastUpdated'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
    			->withErrors($validator)
    			->withInput(session()->flashInput($request->input()));
		}
	}
	
    public function storeDC($id_unidade, Request $request)
    { 
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$contabilReports = DemonstracaoContabel::where('unidade_id', $id_unidade)->get();
        $lastUpdated  = $contabilReports->max('updated_at');
		$input 		  = $request->all();
		$nome		  = $_FILES['file_path']['name']; 
		$extensao     = pathinfo($nome, PATHINFO_EXTENSION);
		if($request->file('file_path') === NULL) {	
			$validator = 'Informe o arquivo do Demonstrativo';
			return view('transparencia/demonstrativo-contabel/accountable_novo', compact('unidades','unidade','unidadesMenu','contabilReports','lastUpdated'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		} else {
			if($extensao === 'pdf') {
				$validator = Validator::make($request->all(), [
					'title' => 'required|max:255',
					'ano'   => 'required'
				]);
				if ($input['ano'] < 1800 || $input['ano'] > 2500) {
					return view('transparencia/demonstrativo-contabel/accountable_novo', compact('unidades','unidade','unidadesMenu','contabilReports','lastUpdated'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));	
				}		
				if ($validator->fails()) {
					return view('transparencia/demonstrativo-contabel/accountable_novo', compact('unidades','unidade','unidadesMenu','contabilReports','lastUpdated'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));	
				}
				$ano  		 = $_POST['ano'];
				$qtdUnidades = sizeof($unidades);
				$randomCode = rand(11111, 99999) . "-";
				$nome = $randomCode . $_FILES['file_path']['name']; 				
				for ( $i = 1; $i <= $qtdUnidades; $i++ ) {
					if ( $unidade['id'] === $i ) {
						$txt1 = $unidades[$i-1]['path_img'];
						$txt1 = explode(".jpg", $txt1);		
						$request->file('file_path')->move('../public/storage/demonstrativo-contabel/'.$txt1[0].'/'.$ano.'/', $nome);
						$input['file_path'] = 'demonstrativo-contabel/'.$txt1[0].'/'.$ano.'/'.$nome; 	
						$input['name_arq']  = $nome;
					}
				}				
				$input['status_contabel'] = 1;
				$demonstrativo = DemonstracaoContabel::create($input);
				$id_registro   = DB::table('demonstracao_contabels')->max('id');
				$input['registro_id'] = $id_registro;	
				$logger 	   = LoggerUsers::create($input);
				$lastUpdated   = $logger->max('updated_at');
				$demonstrativoContaveis = DemonstracaoContabel::where('unidade_id',$id_unidade)->get();
				$validator 	   = 'Demosntrativo Contábiel cadastrado com sucesso!';
				return redirect()->route('cadastroDC', $id_unidade)
			        ->withErrors($validator);
					
			} else {	
				$validator   = 'Só suporta arquivos do tipo: PDF!';
				$demonstrativoContaveis = DemonstracaoContabel::where('unidade_id',$id_unidade)->get();
				$lastUpdated = $demonstrativoContaveis->max('updated_at');
				return view('transparencia/demonstrativo-contabel/accountable_novo', compact('unidades','unidade','unidadesMenu','demonstrativoContaveis','lastUpdated'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));				
			}
		}
    }
	
    public function inativarDC($id_unidade, $id_item, Request $request)
    {
        $input = $request->all();
		$demonstrativoContaveis = DemonstracaoContabel::where('id',$id_item)->get();
		if($demonstrativoContaveis[0]->status_contabel == 1) {
			$nomeArq    = explode($demonstrativoContaveis[0]->name_arq, $demonstrativoContaveis[0]->file_path);
			$nome       = "old_".$demonstrativoContaveis[0]->name_arq;
			$image_path = $nomeArq[0].$nome; 
			DB::statement("UPDATE demonstracao_contabels SET `status_contabel` = 0, `file_path` = '$image_path', `name_arq` = '$nome' WHERE `id` = $id_item");
			$image_path = 'storage/'.$image_path;
			$caminho    = 'storage/'.$demonstrativoContaveis[0]->file_path;
			rename($caminho, $image_path);
		} else {
			$nomeArq    = explode($demonstrativoContaveis[0]->name_arq, $demonstrativoContaveis[0]->file_path);
			$nome       = explode("old_", $demonstrativoContaveis[0]->name_arq); 
			$image_path = $nomeArq[0].$nome[1]; 
			DB::statement("UPDATE demonstracao_contabels SET `status_contabel` = 1, `file_path` = '$image_path', `name_arq` = '$nome[1]' WHERE `id` = $id_item");
			$image_path = 'storage/'.$image_path; 
			$caminho    = 'storage/'.$demonstrativoContaveis[0]->file_path; 
			rename($caminho, $image_path);		
		}
		$input['registro_id'] = $id_item;
		$logger       = LoggerUsers::create($input);
		$lastUpdated  = $logger->max('updated_at');
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$demonstrativoContaveis = DemonstracaoContabel::where('unidade_id',$id_unidade)->get();
		$validator    = 'Demonstrativo Contábel inativado com sucesso!';
		return redirect()->route('cadastroDC', [$id_unidade])
				->withErrors($validator);
    }

    public function destroyDC($id_unidade, $id_item, Request $request)
    {
		$input = $request->all();
		$demonstrativoContaveis = DemonstracaoContabel::where('id',$id_item)->get();
		$image_path 		    = 'storage/'.$demonstrativoContaveis[0]->file_path;
        unlink($image_path);
		DemonstracaoContabel::find($id_item)->delete();		
		$input['registro_id'] = $id_item;
		$log          = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);	
		$demonstrativoContaveis = DemonstracaoContabel::where('unidade_id',$id_unidade)->get();
		$validator = 'Demonstrativo Contábil excluído com sucesso!';
		return  redirect()->route('cadastroDC', $id_unidade)
			->withErrors($validator);			
	}
}