<?php

namespace App\Http\Controllers;

use DB;

use App\Model\SelecaoPessoal;
use App\Model\ServidoresCedidosRH;
use App\Model\SelectiveProcess;
use App\Model\Cargo;
use App\Model\DespesasPessoais;
use Illuminate\Http\Request;
use App\Model\Unidade;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\PermissaoUsersController;
use App\Model\PermissaoUsers;
use Auth;
use Validator;

class RHController extends Controller
{
	public function __construct(Unidade $unidade, Request $request, SelecaoPessoal $selecaoP, ServidoresCedidosRH $servidoresC, SelectiveProcess $selectiveP, Cargo $cargo, LoggerUsers $logger_users)
    {
        $this->unidade  	= $unidade;
		$this->request  	= $request;
		$this->selecaoP 	= $selecaoP;
		$this->servidoresC  = $servidoresC;
		$this->selectiveP   = $selectiveP;
		$this->cargo 	    = $cargo;
		$this->logger_users = $logger_users;
    }
	
	public function index()
    {
        $unidades = $this->unidade->all();
		return view ('home', compact('unidades'));
    }
	
	public function cadastroSP($id, Request $request)
	{ 
		$validacao 	  = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);		
		$selecaoPessoal = SelecaoPessoal::where('status_selecao_pessoals',1)->where('unidade_id',$id)->get();
		$data = array();
        $data[] = $selecaoPessoal->max('updated_at');
        $lastUpdated = max($data);		
		if($validacao == 'ok') {
			return view('transparencia/rh/rh_selecaopessoal_cadastro', compact('unidade','unidades','unidadesMenu','selecaoPessoal','lastUpdated'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}
	
	public function novoSP($id, Request $request)
	{
		$validacao 	  = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades', 1)->find($id);		
		$selecaoPessoal = SelecaoPessoal::where('status_selecao_pessoals',1)->where('unidade_id',$id)->get();
		$data = array();
        $data[] = $selecaoPessoal->max('updated_at');
        $lastUpdated = max($data);
		$cargos = Cargo::all()->sortBy("cargo_name");
		if($validacao == 'ok') {
		    return view('transparencia/rh/rh_selecaopessoal_novo', compact('unidade','unidades','unidadesMenu','selecaoPessoal','lastUpdated','cargos'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		}
	}

	public function storeSP($id, Request $request)
	{
		$unidadesMenu   = $this->unidade->where('status_unidades',1)->get();
		$unidades 	    = $unidadesMenu;
		$unidade        = $this->unidade->where('status_unidades',1)->find($id);		
		$selecaoPessoal = SelecaoPessoal::where('status_selecao_pessoals',1)->where('unidade_id', $id)->get();
		$data      		= array();
        $data[]    		= $selecaoPessoal->max('updated_at');
        $lastUpdated 	= max($data);
		$nomeCargo 		= $_POST['cargo_name'];
		$idCargo   		= Cargo::where('status_cargo',1)->where('cargo_name', $nomeCargo)->get();
		$cargos    		= Cargo::where('status_cargo',1)->orderby('cargo_name', 'ASC')->get();
		$input     		= $request->all();		
		$validator = Validator::make($request->all(), [
			'quantidade' => 'required|max:255',
			'ano'   	 => 'required'
		]);
		if ($input['quantidade'] < 0) {
			$validator = 'O campo quantidade não pode ser menor que 0!';
			return view('transparencia/rh/rh_selecaopessoal_novo', compact('unidade','unidades','unidadesMenu','cargos','selecaoPessoal','lastUpdated','cargos'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}  
		if ($validator->fails()) {
			return view('transparencia/rh/rh_selecaopessoal_novo', compact('unidade','unidades','unidadesMenu','cargos','selecaoPessoal','lastUpdated','cargos'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$input['cargo_name_id'] = $idCargo[0]['id'];
			$input['status_selecao_pessoals'] = 1;		
			$selecaoP 		= SelecaoPessoal::create($input);
			$id_registro	= DB::table('selecao_pessoals')->max('id');
			$input['registro_id'] = $id_registro;
			$log            = LoggerUsers::create($input);
			$lastUpdated    = $log->max('updated_at');
			$selecaoPessoal = SelecaoPessoal::where('status_selecao_pessoals',1)->where('unidade_id', $id)->get();
			$validator      = 'Seleção Pessoal cadastrada com sucesso!';
			return redirect()->route('cadastroSP', [$id])
				->withErrors($validator);
		}
	}
	
	public function cargosSP($id, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		if($validacao == 'ok') {
		    return view('transparencia/rh/rh_selecaopessoal_cargos_novo', compact('unidade','unidades','unidadesMenu'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}
	
	public function storeCargosSP($id, Request $request)
	{
		$input = $request->all();
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);	
		$selecaoPessoal = SelecaoPessoal::where('status_selecao_pessoals',1)->where('unidade_id', $id)->get();
		$data	     = array();
        $data[] 	 = $selecaoPessoal->max('updated_at');
        $lastUpdated = max($data);
		$validator   = Validator::make($request->all(), [
			'cargo_name' => 'required|max:255|unique:cargos'
		]);
		if ($validator->fails()) {
			return view('transparencia/rh/rh_selecaopessoal_cargos_novo', compact('unidade','unidades','unidadesMenu','selecaoPessoal','lastUpdated'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$input['status_cargo'] = 1;
			$cargo 			= Cargo::create($input);
			$id_registro	= DB::table('cargos')->max('id');
			$input['registro_id'] = $id_registro;
			$log 		    = LoggerUsers::create($input);
			$lastUpdated 	= $log->max('updated_at');
			$selecaoPessoal = SelecaoPessoal::where('status_selecao_pessoals',1)->where('unidade_id', $id)->get();
			$cargos 	 	= Cargo::where('status_cargo',1)->get();
			$validator 		= 'Cargo cadastrado com sucesso!';
			return redirect()->route('cadastroSP', [$id])
				->withErrors($validator);
		}
	}
	
	public function alterarSP($id, $id_item, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$selecaoPessoal = SelecaoPessoal::where('status_selecao_pessoals',1)->where('id', $id_item)->get();
		$data 		  = array();
        $data[] 	  = $selecaoPessoal->max('updated_at');
        $lastUpdated  = max($data);
		$cargos 	  = Cargo::where('status_cargo',1)->where('id',$selecaoPessoal[0]['cargo_name_id'])->get();
		if($validacao == 'ok') {
		    return view('transparencia/rh/rh_selecaopessoal_alterar', compact('unidade','unidades','unidadesMenu','selecaoPessoal','lastUpdated','cargos'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		}
	}
	
	public function updateSP($id, $id_item, Request $request)
	{ 
		$unidadesMenu 	= $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  	= $unidadesMenu;
		$unidade      	= $this->unidade->where('status_unidades', 1)->find($id);
		$selecaoPessoal = SelecaoPessoal::where('status_selecao_pessoals',1)->where('id', $id_item)->get();
		$data 			= array();
        $data[] 		= $selecaoPessoal->max('updated_at');
        $lastUpdated 	= max($data);
		$cargos 		= Cargo::where('status_cargo',1)->where('id',$selecaoPessoal[0]['cargo_name_id'])->get();		
		$input = $request->all();
		if($input['quantidade'] < 0){
			$validator = 'Quantidade não pode ser menor que 0';
			return view('transparencia/rh/rh_selecaopessoal_alterar', compact('unidade','unidades','unidadesMenu','cargos','selecaoPessoal','lastUpdated'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
		$validator = Validator::make($request->all(), [
			'cargo_name' => 'required|max:255',
			'quantidade' => 'required'
		]);
		if ($validator->fails()) {
			return view('transparencia/rh/rh_selecaopessoal_alterar', compact('unidade','unidades','unidadesMenu','cargos','selecaoPessoal','lastUpdated'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {

			$selecaoP = SelecaoPessoal::find($id_item);
			$selecaoP->update($input);
			$input['registro_id'] = $id_item;
			$log 			= LoggerUsers::create($input);
			$lastUpdated 	= $log->max('updated_at');
			$selecaoPessoal = SelecaoPessoal::where('status_selecao_pessoals',1)->where('unidade_id', $id)->get();
			$validator 		= 'Seleção de Pessoal alterado com sucesso!';
			return redirect()->route('cadastroSP', [$id])
				->withErrors($validator);
		}
	}
	
	public function excluirSP($id, $id_item, Request $request)
	{
		$validacao 		= permissaoUsersController::Permissao($id);
		$unidadesMenu   = $this->unidade->where('status_unidades',1)->get();
		$unidades 	    = $unidadesMenu;
		$unidade        = $this->unidade->where('status_unidades',1)->find($id);		
		$selecaoPessoal = SelecaoPessoal::where('status_selecao_pessoals',1)->where('id',$id_item)->get();
		$data 			= array();
        $data[] 		= $selecaoPessoal->max('updated_at');
        $lastUpdated 	= max($data);
		$cargos 		= Cargo::where('status_cargo',1)->where('id',$selecaoPessoal[0]['cargo_name_id'])->get();
		if($validacao == 'ok') {
		    return view('transparencia/rh/rh_selecaopessoal_excluir', compact('unidade','unidades','unidadesMenu','selecaoPessoal','lastUpdated','cargos'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}
	
	public function destroySP($id, $id_item, Request $request)
	{
		SelecaoPessoal::find($id_item)->delete();
		$input 		    = $request->all();
		$input['registro_id'] = $id_item;
		$log 		    = LoggerUsers::create($input);
		$lastUpdated    = $log->max('updated_at');
		$unidadesMenu   = $this->unidade->where('status_unidades',1)->get();
		$unidades 	    = $unidadesMenu;
		$unidade        = $this->unidade->where('status_unidades',1)->find($id);
		$selecaoPessoal = SelecaoPessoal::where('status_selecao_pessoals',1)->where('unidade_id',$id)->get();
		$validator 		= 'Seleção de Pessoal excluído com sucesso!';
		return redirect()->route('cadastroSP', [$id])
			->withErrors($validator);
	}
	
	public function cadastroPS($id, Request $request)
	{
		$validacao 	  = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades', 1)->find($id);
		$docSelectiveProcess = SelectiveProcess::where('unidade_id', $id)->orderBy('year','ASC')->get();
		$selecaoPessoal 	 = SelecaoPessoal::where('status_selecao_pessoals',1)->where('unidade_id', $id)->get();
        $data = array();
        $data[] = $lastUpdatedRegulamento = '2017-08-31 00:00:00';   
        $data[] = $docSelectiveProcess->max('updated_at');
        $data[] = $selecaoPessoal->max('updated_at');
        $lastUpdated = max($data);
		if($validacao == 'ok') {
		    return view('transparencia/rh/rh_pseletivo_cadastro', compact('unidade','unidades','unidadesMenu','selecaoPessoal','docSelectiveProcess'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}
	
	public function novoPS($id, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades', 1)->find($id);
		$docSelectiveProcess = SelectiveProcess::where('status_processos',1)->where('unidade_id', $id)->orderBy('year', 'ASC')->get();
		$data   = array();
        $data[] = $docSelectiveProcess->max('updated_at');
        $lastUpdated = max($data);
		if($validacao == 'ok') {
		    return view('transparencia/rh/rh_pseletivo_novo', compact('unidade','unidades','unidadesMenu','docSelectiveProcess','lastUpdated'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}
	
	public function storePS($id, Request $request)
	{ 
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$input 		  = $request->all();			
		$nome 		  = $_FILES['file_path']['name']; 		
		$extensao 	  = pathinfo($nome, PATHINFO_EXTENSION);
		$docSelectiveProcess = SelectiveProcess::where('status_processos',1)->where('unidade_id', $id)->orderBy('year','ASC')->get();
		$selecaoPessoal 	 = SelecaoPessoal::where('status_selecao_pessoals',1)->where('unidade_id', $id)->get();
		$data   = array();
		$data[] = $lastUpdatedRegulamento = '2017-08-31 00:00:00';   
		$data[] = $docSelectiveProcess->max('updated_at');
		$data[] = $selecaoPessoal->max('updated_at');
		$lastUpdated = max($data);
		if($request->file('file_path') === NULL) {	
			$validator = 'Informe um arquivo do Processo Seletivo!';
			return view('transparencia/rh/rh_pseletivo_novo', compact('unidades','unidade','unidadesMenu','selecaoPessoal','lastUpdated'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			if($extensao === 'pdf') {
				$validator = Validator::make($request->all(), [
					'title' => 'required|max:255',
					'year' => 'required|digits:4'
				]);
				if ($validator->fails()) {
					return view('transparencia/rh/rh_pseletivo_novo', compact('unidades','unidade','unidadesMenu','selecaoPessoal','lastUpdated'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				} else {
					$ano  = $input['year'];
					$nome = $_FILES['file_path']['name']; 
					$selecaoP = SelectiveProcess::where('year',$ano)->get();
					$qtd = count($selecaoP);
					$input['ordering'] = $qtd + 1;	
					$qtdUnidades = sizeof($unidades);
					for ($i = 1; $i <= $qtdUnidades; $i++) {
						if ($unidade['id'] === $i) {	
							$txt1 = $unidades[$i-1]['path_img'];
							$txt1 = explode(".jpg", $txt1); 
							$txt2 = strtoupper($txt1[0]);
							$upload = $request->file('file_path')->move('../public/storage/processo-seletivo/'.$txt1[0].'/'.$ano.'/PS-0'.$input['ordering'].'_'.$ano.'-'.$txt2.'/', $nome);
							$input['file_path'] = 'processo-seletivo/'.$txt1[0].'/'.$ano.'/PS-0'.$input['ordering'].'_'.$ano.'-'.$txt2.'/'.$nome; 
							$input['name_arq']  = $nome;
						}
					} 		
					$input['status_processos'] = 1;
					$selectiveProcess = SelectiveProcess::create($input);
					$id_registro      = DB::table('selective_processes')->max('id');
					$input['registro_id'] = $id_registro;		
					$log 			  = LoggerUsers::create($input);
					$lastUpdated 	  = $log->max('updated_at');
					$docSelectiveProcess = SelectiveProcess::where('status_processos',1)->where('unidade_id', $id)->orderBy('year','ASC')->get();
					$selecaoPessoal   = SelecaoPessoal::where('status_selecao_pessoals',1)->where('unidade_id', $id)->get();
					$validator = 'Processo Seletivo foi cadastrado com sucesso!';
					return redirect()->route('cadastroPS', [$id])
								->withErrors($validator);
				}
			} else {	
				$validator = 'Só são permitidos arquivos do tipo: PDF!';
				return view('transparencia/rh/rh_pseletivo_novo', compact('unidades','unidade','unidadesMenu','selecaoPessoal','lastUpdated'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			}
		}
	}
	
	public function excluirPS($id, $id_item, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$docSelectiveProcess = SelectiveProcess::where('status_processos',1)->where('id', $id_item)->orderBy('year','ASC')->get();
		$data   = array();
        $data[] = $docSelectiveProcess->max('updated_at');
        $lastUpdated = max($data);
		if($validacao == 'ok') {
		    return view('transparencia/rh/rh_pseletivo_excluir', compact('unidade','unidades','unidadesMenu','docSelectiveProcess','lastUpdated'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}

	public function telaInativarPS($id, $id_item, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$docSelectiveProcess = SelectiveProcess::where('id', $id_item)->orderBy('year','ASC')->get();
		$data   = array();
        $data[] = $docSelectiveProcess->max('updated_at');
        $lastUpdated = max($data);
		if($validacao == 'ok') {
		    return view('transparencia/rh/rh_pseletivo_inativar', compact('unidade','unidades','unidadesMenu','docSelectiveProcess','lastUpdated'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}
	
	public function destroyPS($id, $id_item, Request $request)
	{
		SelectiveProcess::find($id_item)->delete();
		$input        = $request->all();
		$input['registro_id'] = $id_item;
		$log 		  = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
		$nome 		  = $input['file_path'];
		$pasta 		  = 'public/'.$nome; 
		Storage::delete($pasta);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);		
		$docSelectiveProcess = SelectiveProcess::where('unidade_id',$id)->orderBy('year','ASC')->get();
		$validator = 'Processo Seletivo excluído com sucesso!';
		return redirect()->route('cadastroPS', [$id])
			->withErrors($validator);
	}
	
	public function inativarPS($id, $id_item, Request $request)
    {
		$input     = $request->all();
		$docSelectiveProcess = SelectiveProcess::where('id',$id_item)->get();
		if($docSelectiveProcess[0]->status_processos == 1) {
			$nomeArq    = explode($docSelectiveProcess[0]->name_arq, $docSelectiveProcess[0]->file_path);
			$nome       = "old_".$docSelectiveProcess[0]->name_arq;
			$image_path = $nomeArq[0].$nome;
			DB::statement("UPDATE selective_processes SET `status_processos` = 0, `file_path` = '$image_path', `name_arq` = '$nome' WHERE `id` = $id_item");
			$caminho    = 'storage/'.$docSelectiveProcess[0]->file_path;
			$image_path = 'storage/'.$nomeArq[0].$nome;
			rename($caminho, $image_path);
		} else {
			$caminho = explode($docSelectiveProcess[0]->name_arq, $docSelectiveProcess[0]->file_path);
			$nome    = explode("old_", $docSelectiveProcess[0]->name_arq); 
			$image_path = $caminho[0].$nome[1]; 
			DB::statement("UPDATE selective_processes SET `status_processos` = 1, `file_path` = '$image_path', `name_arq` = '$nome[1]' WHERE `id` = $id_item");
			$caminho    = 'storage/'.$docSelectiveProcess[0]->file_path;
			$image_path = 'storage/'.$image_path;
			rename($caminho, $image_path);		
		}
		$input['registro_id'] = $docSelectiveProcess[0]->id;
		$log          = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$docSelectiveProcess = SelectiveProcess::where('unidade_id',$id)->get();
		$validator    = 'Processo Seletivo inativado com sucesso!';
		return redirect()->route('cadastroPS', [$id])
						->withErrors($validator);
    }
	
	public function servidoresPCadastro($id, Request $request)
	{
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);
	}
	
	public function regulamentoCadastro($id, Request $request)
	{
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);
	}

	public function despesasRH($id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades', 1)->find($id);
		$ano = 0; $mes = 0; $tipo = 0; $teste = '';
		if($validacao == 'ok') {
			return view('transparencia/rh/rh_despesas_exibe', compact('unidade','unidades','unidadesMenu','ano','mes','tipo','teste')); 
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}
	
	public function despesasRHProcurar($id, Request $request)
	{
	    $validacao = permissaoUsersController::Permissao($id);
		$input = $request->all();
		$unidade = $this->unidade->find($id);		
		$unidadesMenu = $this->unidade->all();
		$mes  = $input['mes'];
		$ano  = $input['ano'];
		$tipo = $input['tipo'];  
		if($mes == 1) { $teste = 'selected'; } if($mes == 2) { $teste = 'selected'; } if($mes == 3) { $teste = 'selected'; }
        if($mes == 4) { $teste = 'selected'; } if($mes == 5) { $teste = 'selected'; } if($mes == 6) { $teste = 'selected'; }
        if($mes == 7) { $teste = 'selected'; } if($mes == 8) { $teste = 'selected'; } if($mes == 9) { $teste = 'selected'; }
        if($mes == 10) { $teste = 'selected'; } if($mes == 11) { $teste = 'selected'; } if($mes == 12) { $teste = 'selected'; }
		if($tipo == NULL){ $tipo = ""; }
		if ($id == 2){
			$despesas = DB::table('desp_com_pessoal_hmr')->where('mes',$mes)->where('ano',$ano)->where('tipo',$tipo)->where('status_desp',1)->get();	
		} else if ($id == 3){
			$despesas = DB::table('desp_com_pessoal_belo_jardim')->where('mes',$mes)->where('ano',$ano)->where('tipo',$tipo)->where('status_desp',1)->get();	
		} else if($id == 4){
			$despesas = DB::table('desp_com_pessoal_arcoverde')->where('mes',$mes)->where('ano',$ano)->where('tipo',$tipo)->where('status_desp',1)->get();	
		} else if($id == 5){
			$despesas = DB::table('desp_com_pessoal_arruda')->where('mes',$mes)->where('ano',$ano)->where('tipo',$tipo)->where('status_desp',1)->get();	
		} else if($id == 6){
			$despesas = DB::table('desp_com_pessoal_upaecaruaru')->where('mes',$mes)->where('ano',$ano)->where('tipo',$tipo)->where('status_desp',1)->get();	
		} else if($id == 7){
			$despesas = DB::table('desp_com_pessoal_hss')->where('mes',$mes)->where('ano',$ano)->where('tipo',$tipo)->where('status_desp',1)->get();	
		} else if($id == 8){
			$despesas = DB::table('desp_com_pessoal_hpr')->where('mes',$mes)->where('ano',$ano)->where('tipo',$tipo)->where('status_desp',1)->get();	
		} else if($id == 9){
		    $despesas = DB::table('desp_com_pessoal_igarassu')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->where('status_desp',1)->get();
		} else if($id == 10){
		    $despesas = DB::table('desp_com_pessoal_palmares')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->where('status_desp',1)->get();
		}
		$qtdDesp = sizeof($despesas);
		if($validacao == 'ok') {
			if($qtdDesp == 0) {
				$validator = 'Nenhuma Despesa foi encontrada!!';
				return view('transparencia/rh/rh_despesas_exibe	', compact('unidade','despesas','unidadesMenu','ano','mes','tipo','teste','qtdDesp'))
			 		->withErrors($validator);
			} 
			return view('transparencia/rh/rh_despesas_exibe	', compact('unidade','despesas','unidadesMenu','ano','mes','tipo','teste','qtdDesp'));
 		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function alterarRH($id, $ano, $mes, $tipo, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades', 1)->find($id);
		if ($id == 2){
			$despesas = DB::table('desp_com_pessoal_hmr')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();	
		} else if ($id == 3){
			$despesas = DB::table('desp_com_pessoal_belo_jardim')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();	
		} else if($id == 4){
			$despesas = DB::table('desp_com_pessoal_arcoverde')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();	
		} else if($id == 5){
			$despesas = DB::table('desp_com_pessoal_arruda')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();	
		} else if($id == 6){
			$despesas = DB::table('desp_com_pessoal_upaecaruaru')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();	
		} else if($id == 7){
			$despesas = DB::table('desp_com_pessoal_hss')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();	
		} else if($id == 8){
			$despesas = DB::table('desp_com_pessoal_hpr')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();	
		} else if($id == 9){
		    $despesas = DB::table('desp_com_pessoal_igarassu')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();
		} else if($id == 10){
		    $despesas = DB::table('desp_com_pessoal_palmares')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();
		}
		if($validacao == 'ok') {
			return view('transparencia/rh/rh_despesas_alterar', compact('unidade','unidades','unidadesMenu','despesas','ano','mes','tipo')); 
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function alterarDRH($id, $ano, $mes, $tipo, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades', 1)->find($id);
		if ($id == 2){
			$despesas = DB::table('desp_com_pessoal_hmr')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();	
		} else if ($id == 3){
			$despesas = DB::table('desp_com_pessoal_belo_jardim')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();	
		} else if($id == 4){
			$despesas = DB::table('desp_com_pessoal_arcoverde')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();	
		} else if($id == 5){
			$despesas = DB::table('desp_com_pessoal_arruda')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();	
		} else if($id == 6){
			$despesas = DB::table('desp_com_pessoal_upaecaruaru')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();	
		} else if($id == 7){
			$despesas = DB::table('desp_com_pessoal_hss')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();	
		} else if($id == 8){
			$despesas = DB::table('desp_com_pessoal_hpr')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();	
		} else if($id == 9){
		    $despesas = DB::table('desp_com_pessoal_igarassu')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();
		} else if($id == 10){
		    $despesas = DB::table('desp_com_pessoal_palmares')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();
		}
		if($validacao == 'ok') {
			return view('transparencia/rh/rh_despesas_alterar', compact('unidade','unidades','unidadesMenu','despesas','ano','mes','tipo')); 
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function updateDRH($id, Request $request)
	{
		$unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades', 1)->find($id);
		$input = $request->all();
		$mes   = $input['mes'];
		$ano   = $input['ano'];
		$tipo  = $input['tipo'];
		$teste = "";
		if ($id == 2){
			$despesas = DB::table('desp_com_pessoal_hmr')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();	
			$nome = 'desp_com_pessoal_hmr';
		} else if ($id == 3){
			$despesas = DB::table('desp_com_pessoal_belo_jardim')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();	
			$nome = 'desp_com_pessoal_belo_jardim';
		} else if($id == 4){
			$despesas = DB::table('desp_com_pessoal_arcoverde')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();	
			$nome = 'desp_com_pessoal_arcoverde';
		} else if($id == 5){
			$despesas = DB::table('desp_com_pessoal_arruda')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();	
			$nome = 'desp_com_pessoal_arruda';
		} else if($id == 6){
			$despesas = DB::table('desp_com_pessoal_upaecaruaru')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();	
			$nome = 'desp_com_pessoal_upaecaruaru';
		} else if($id == 7){
			$despesas = DB::table('desp_com_pessoal_hss')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();	
			$nome = 'desp_com_pessoal_hss';
		} else if($id == 8){
			$despesas = DB::table('desp_com_pessoal_hpr')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();	
			$nome = 'desp_com_pessoal_hpr';
		} else if($id == 9){
		    $despesas = DB::table('desp_com_pessoal_igarassu')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();	
			$nome = 'desp_com_pessoal_igarassu';
		} else if($id == 10){
		    $despesas = DB::table('desp_com_pessoal_palmares')->where('mes',$mes)->where('ano', $ano)->where('tipo', $tipo)->get();	
			$nome = 'desp_com_pessoal_palmares';
		}
		for($a = 1; $a <= 10; $a++){
			$idl   = $input['id_'.$a];
			$quant = $input['quant_'.$a];
			$valor = $input['valor_'.$a]; 
			$despesas = DB::statement("UPDATE `$nome` SET `Quant` = '$quant', `Valor` = '$valor', `tipo` = '$tipo' WHERE `id` = $idl");	
		}
		$despesas  = DB::table($nome)->where('mes',$mes)->where('ano',$ano)->where('tipo',$tipo)->get();
		$qtdDesp   = sizeof($despesas);
		$validator = 'Despesas de Pessoal alterado com sucesso!';
		return view('transparencia/rh/rh_despesas_exibe', compact('unidade','unidades','unidadesMenu','despesas','mes','ano','tipo','teste','qtdDesp'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));		
	}

	public function excluirDespesasRH($id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades', 1)->find($id);
		$teste = "";
		if($validacao == 'ok') {
			return view('transparencia/rh/rh_despesas_excluir', compact('unidade','unidades','unidadesMenu','teste')); 
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function destroyDespesasRH($id, Request $request)
	{
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade  = $this->unidade->find($id);
		$input = $request->all();
		$mes   = $input['mes'];
		$ano   = $input['ano'];
		$tipo  = $input['tipo'];
		$teste = "";
		if ($id == 2) {
			$nome = 'desp_com_pessoal_hmr';
		} else if ($id == 3) {
			$nome = 'desp_com_pessoal_belo_jardim';
		} else if ($id == 4) {
			$nome = 'desp_com_pessoal_arcoverde';
		} else if ($id == 5) {
			$nome = 'desp_com_pessoal_arruda';
		} else if ($id == 6) {
			$nome = 'desp_com_pessoal_upaecaruaru';
		} else if ($id == 7) {
			$nome = 'desp_com_pessoal_hss';
		} else if ($id == 8) {
			$nome = 'desp_com_pessoal_hpr';
		} else if ($id == 9) {
			$nome = 'desp_com_pessoal_igarassu';
		} else if ($id == 10) {
			$nome = 'desp_com_pessoal_palmares';
		}
		for ($i = 1; $i <= 10; $i++) {
			if (isset($input['id_' . $i])) {
				$id = $input['id_' . $i];
				$despesas = DB::statement('DELETE FROM ' . $nome . ' where `id` = ' . $id);
			}
		}
		$validator = 'Despesas de Pessoal Excluída com sucesso!';
		$despesas = DB::table($nome)->where('mes', $mes)->where('ano', $ano)->where('tipo', $tipo)->get();
		return view('transparencia/rh/rh_despesas_exibe', compact('unidade', 'unidades', 'unidadesMenu', 'despesas', 'ano', 'mes', 'tipo', 'teste'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));
	}

	public function telaInativarDRH($id, $ano, $mes, $tipo, $tp, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades', 1)->find($id);
		if ($id == 2) {
			$nome = 'desp_com_pessoal_hmr';
		} else if ($id == 3) {
			$nome = 'desp_com_pessoal_belo_jardim';
		} else if ($id == 4) {
			$nome = 'desp_com_pessoal_arcoverde';
		} else if ($id == 5) {
			$nome = 'desp_com_pessoal_arruda';
		} else if ($id == 6) {
			$nome = 'desp_com_pessoal_upaecaruaru';
		} else if ($id == 7) {
			$nome = 'desp_com_pessoal_hss';
		} else if ($id == 8) {
			$nome = 'desp_com_pessoal_hpr';
		} else if ($id == 9) {
			$nome = 'desp_com_pessoal_igarassu';
		} else if ($id == 10) {
			$nome = 'desp_com_pessoal_palmares';
		}
		$despesas = DB::table($nome)->where('mes', $mes)->where('ano', $ano)->where('tipo', $tipo)->get();
		$teste = "";
		if($validacao == 'ok') {
			return view('transparencia/rh/rh_despesas_inativar', compact('unidade','unidades','unidadesMenu','teste','ano','mes','tipo','despesas','tp')); 
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function inativarDRH($id, $ano, $mes, $tipo, $tp, Request $request)
	{
		$unidadesMenu = $this->unidade->all();
		$unidades 	  = $unidadesMenu;
		$unidade 	  = $this->unidade->find($id);
		$input = $request->all();
		$teste = "";
		if ($id == 2) {
			$nome = 'desp_com_pessoal_hmr';
		} else if ($id == 3) {
			$nome = 'desp_com_pessoal_belo_jardim';
		} else if ($id == 4) {
			$nome = 'desp_com_pessoal_arcoverde';
		} else if ($id == 5) {
			$nome = 'desp_com_pessoal_arruda';
		} else if ($id == 6) {
			$nome = 'desp_com_pessoal_upaecaruaru';
		} else if ($id == 7) {
			$nome = 'desp_com_pessoal_hss';
		} else if ($id == 8) {
			$nome = 'desp_com_pessoal_hpr';
		} else if ($id == 9) {
			$nome = 'desp_com_pessoal_igarassu';
		} else if ($id == 10) {
			$nome = 'desp_com_pessoal_palmares';
		}
		for ($i = 1; $i <= 10; $i++) {
			if($tp == 0) {
				$despesas = DB::statement("UPDATE $nome SET status_desp = 1 WHERE mes = '$mes' and ano = '$ano' and tipo = '$tipo'");
				$validator = 'Despesas de Pessoal Inativada com sucesso!';
			} else {
				$despesas = DB::statement("UPDATE $nome SET status_desp = 0 WHERE mes = '$mes' and ano = '$ano' and tipo = '$tipo'");
				$validator = 'Despesas de Pessoal Ativada com sucesso!';
			}
		}
		$despesas  = DB::table($nome)->where('mes',0)->get();
		$qtdDesp   = sizeof($despesas);
		return view('transparencia/rh/rh_despesas_exibe', compact('unidade','unidades','unidadesMenu','ano','mes','tipo','teste','despesas','qtdDesp'))
				   ->withErrors($validator); 
	}
}
?>