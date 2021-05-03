<?php

namespace App\Http\Controllers;

use App\Model\SelecaoPessoal;
use App\Model\ServidoresCedidosRH;
use App\Model\SelectiveProcess;
use App\Model\Cargo;
use Illuminate\Http\Request;
use App\Model\Unidade;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Storage;
use App\Model\PermissaoUsers;
use Auth;
use Illuminate\Support\Facades\DB;

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
	
	public function selecaoPCadastro($id, Request $request)
	{ 
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
	    for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id) {
				$validacao = 'ok';
				break;
			} else {
				$validacao = 'erro';
			}
		}
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);		
		$selecaoPessoal = SelecaoPessoal::where('unidade_id', $id)->get();
		$data = array();
        $data[] = $selecaoPessoal->max('updated_at');
        $lastUpdated = max($data);		
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/rh/rh_selecaopessoal_cadastro', compact('unidade','unidades','unidadesMenu','selecaoPessoal','lastUpdated','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function selecaoPNovo($id, Request $request)
	{
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
	    for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id) {
				$validacao = 'ok';
				break;
			} else {
				$validacao = 'erro';
			}
		}
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);		
		$selecaoPessoal = SelecaoPessoal::where('unidade_id', $id)->get();
		$data = array();
        $data[] = $selecaoPessoal->max('updated_at');
        $lastUpdated = max($data);
		$cargos = Cargo::all()->sortBy("cargo_name");
		$text = false;
		if($validacao == 'ok') {
		    return view('transparencia/rh/rh_selecaopessoal_novo', compact('unidade','unidades','unidadesMenu','selecaoPessoal','lastUpdated','cargos','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function selecaoPValidar($id, $id_item, Request $request)
	{
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
	    for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id) {
				$validacao = 'ok';
				break;
			} else {
				$validacao = 'erro';
			}
		}
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);		
		$selecaoPessoal = SelecaoPessoal::find($id_item);
		DB::statement('UPDATE selecao_pessoals SET validar = 0 WHERE id = '.$id_item.';');
		$selecaoPessoal = SelecaoPessoal::where('unidade_id', $id)->get();
		$data = array();
        $data[] = $selecaoPessoal->max('updated_at');
        $lastUpdated = max($data);
		$cargos = Cargo::all()->sortBy("cargo_name");
		if($validacao == 'ok') {
			\Session::flash('mensagem', ['msg' => 'Seleção de Pessoal validado com Sucesso!!','class'=>'green white-text']);		
			$text = true;
		    return view('transparencia/rh/rh_selecaopessoal_cadastro', compact('unidade','unidades','unidadesMenu','selecaoPessoal','lastUpdated','cargos','text','permissao_users'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function processoSValidar($id, $id_item, Request $request)
	{
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
	    for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id) {
				$validacao = 'ok';
				break;
			} else {
				$validacao = 'erro';
			}
		}
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);		
		$docSelectiveProcess = SelectiveProcess::find($id_item);
        DB::statement('UPDATE selective_processes SET validar = 0 WHERE id = '.$id_item.';');
		$docSelectiveProcess = SelectiveProcess::where('unidade_id', $id)->orderBy('year', 'ASC')->get();
		$data = array();
        $data[] = $lastUpdatedRegulamento = '2020-05-31 00:00:00';   
        $lastUpdated = max($data);
		$cargos = Cargo::all()->sortBy("cargo_name");
		if($validacao == 'ok') {
			\Session::flash('mensagem', ['msg' => 'Processo Seletivo validado com Sucesso!!','class'=>'green white-text']);		
			$text = true;
		    return view('transparencia/rh/rh_pseletivo_cadastro', compact('unidade','unidades','unidadesMenu','docSelectiveProcess','lastUpdated','cargos','text','permissao_users'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}

	public function storeSelecao($id, Request $request)
	{
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);		
		$selecaoPessoal = SelecaoPessoal::where('unidade_id', $id)->get();
		$data = array();
        $data[] = $selecaoPessoal->max('updated_at');
        $lastUpdated = max($data);
		$nomeCargo = $_POST['cargo_name'];
		$idCargo = Cargo::where('cargo_name', $nomeCargo)->get();
		$cargos = Cargo::all()->sortBy("cargo_name");
		$input = $request->all();		
		$v = \Validator::make($request->all(), [
			'quantidade' => 'required|max:255',
			'ano'   	 => 'required'
		]);
		if ($input['quantidade'] < 0) {
			\Session::flash('mensagem', ['msg' => 'O campo quantidade não pode ser menor que 0!','class'=>'green white-text']);
			$text = true;
			return view('transparencia/rh/rh_selecaopessoal_novo', compact('unidade','unidades','unidadesMenu','cargos','selecaoPessoal','lastUpdated','cargos','text'));
		} else if ($input['ano'] < 1800 || $input['ano'] > 2500) {
			\Session::flash('mensagem', ['msg' => 'O campo ano é inválido!','class'=>'green white-text']);
			$text = true;
			return view('transparencia/rh/rh_selecaopessoal_novo', compact('unidade','unidades','unidadesMenu','cargos','selecaoPessoal','lastUpdated','cargos','text'));
		}  
		if ($v->fails()) {
			$failed = $v->failed();
			if ( !empty($failed['quantidade']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo quantidade é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['quantidade']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo quantidade possui no máximo 255 caracteres!','class'=>'green white-text']);
			} else if ( !empty($failed['ano']['Required']) ) {	
				\Session::flash('mensagem', ['msg' => 'O campo ano é obrigatório!','class'=>'green white-text']);
			}
			$text = true;
			return view('transparencia/rh/rh_selecaopessoal_novo', compact('unidade','unidades','unidadesMenu','cargos','selecaoPessoal','lastUpdated','cargos','text'));
		} else {
			$input['cargo_name_id'] = $idCargo[0]['id'];		
			$selecaoP = SelecaoPessoal::create($input);
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$selecaoPessoal = SelecaoPessoal::where('unidade_id', $id)->get();
			$text = true;
			\Session::flash('mensagem', ['msg' => 'Seleção de Pessoal cadastrada com sucesso!','class'=>'green white-text']);
			return view('transparencia/rh/rh_selecaopessoal_cadastro', compact('unidade','unidades','unidadesMenu','selecaoPessoal','lastUpdated','text'));
		}
	}
	
	public function selecaoPCargos($id, Request $request)
	{
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
	    for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id) {
				$validacao = 'ok';
				break;
			} else {
				$validacao = 'erro';
			}
		}
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);
		$text = false;
		if($validacao == 'ok') {
		    return view('transparencia/rh/rh_selecaopessoal_cargos_novo', compact('unidade','unidades','unidadesMenu','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function storeCargos($id, Request $request)
	{
		$input = $request->all();
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);	
		$selecaoPessoal = SelecaoPessoal::where('unidade_id', $id)->get();
		$data = array();
        $data[] = $selecaoPessoal->max('updated_at');
        $lastUpdated = max($data);
		$v = \Validator::make($request->all(), [
			'cargo_name' => 'required|max:255|unique:cargos'
		]);
		if ($v->fails()) {
			$failed = $v->failed();
			if ( !empty($failed['cargo_name']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo nome é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['cargo_name']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo nome possui no máximo 255 caracteres!','class'=>'green white-text']);
			} else if ( !empty($failed['cargo_name']['Unique']) ) {	
				\Session::flash('mensagem', ['msg' => 'Este cargo já foi cadastrado!','class'=>'green white-text']);
			}
			$text = true;
			return view('transparencia/rh/rh_selecaopessoal_cargos_novo', compact('unidade','unidades','unidadesMenu','selecaoPessoal','lastUpdated','text'));
		} else {
			$cargo = Cargo::create($input);
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$selecaoPessoal = SelecaoPessoal::where('unidade_id', $id)->get();
			$cargos = Cargo::all()->sortBy("cargo_name");
			$text = true;
			\Session::flash('cargo_name', ['msg' => 'Cargo cadastrado com sucesso!','class'=>'green white-text']);
			return view('transparencia/rh/rh_selecaopessoal_cadastro', compact('unidade','unidades','unidadesMenu','cargos','selecaoPessoal','lastUpdated','text'));
		}
	}
	
	public function selecaoPAlterar($id, $id_item, Request $request)
	{
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
	    for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id) {
				$validacao = 'ok';
				break;
			} else {
				$validacao = 'erro';
			}
		}
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);
		$selecaoPessoal = SelecaoPessoal::where('id', $id_item)->get();
		$data = array();
        $data[] = $selecaoPessoal->max('updated_at');
        $lastUpdated = max($data);
		$cargos = Cargo::where('id', $selecaoPessoal[0]['cargo_name_id'])->get();
		$text = false;
		if($validacao == 'ok') {
		    return view('transparencia/rh/rh_selecaopessoal_alterar', compact('unidade','unidades','unidadesMenu','selecaoPessoal','lastUpdated','cargos','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function updateSelecao($id, $id_item, Request $request)
	{ 
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);
		$selecaoPessoal = SelecaoPessoal::where('id', $id_item)->get();
		$data = array();
        $data[] = $selecaoPessoal->max('updated_at');
        $lastUpdated = max($data);
		$cargos = Cargo::where('id', $selecaoPessoal[0]['cargo_name_id'])->get();		
		$input = $request->all();
		$v = \Validator::make($request->all(), [
			'cargo_name' => 'required|max:255'
		]);
		if ($v->fails()) {
			$failed = $v->failed();
			if ( !empty($failed['cargo_name']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo nome é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['cargo_name']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo nome possui no máximo 255 caracteres!','class'=>'green white-text']);
			} 
			$text = true;
			return view('transparencia/rh/rh_selecaopessoal_alterar', compact('unidade','unidades','unidadesMenu','cargos','selecaoPessoal','lastUpdated','text'));
		} else {
			$selecaoP = SelecaoPessoal::find($id_item);
			$selecaoP->update($input);
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$selecaoPessoal = SelecaoPessoal::where('unidade_id', $id)->get();
			$text = true;
			\Session::flash('mensagem', ['msg' => 'Seleção de Pessoal alterado com sucesso!','class'=>'green white-text']);
			return view('transparencia/rh/rh_selecaopessoal_cadastro', compact('unidade','unidades','unidadesMenu','selecaoPessoal','lastUpdated','text'));
		}
	}
	
	public function selecaoPExcluir($id, $id_item, Request $request)
	{
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
	    for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id) {
				$validacao = 'ok';
				break;
			} else {
				$validacao = 'erro';
			}
		}
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);		
		$selecaoPessoal = SelecaoPessoal::where('id', $id_item)->get();
		$data = array();
        $data[] = $selecaoPessoal->max('updated_at');
        $lastUpdated = max($data);
		$text = false;
		$cargos = Cargo::where('id', $selecaoPessoal[0]['cargo_name_id'])->get();
		if($validacao == 'ok') {
		    return view('transparencia/rh/rh_selecaopessoal_excluir', compact('unidade','unidades','unidadesMenu','selecaoPessoal','lastUpdated','cargos','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function destroySelecao($id, $id_item, Request $request)
	{
		SelecaoPessoal::find($id_item)->delete();
		
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);
		$selecaoPessoal = SelecaoPessoal::where('unidade_id', $id)->get();
		$text = true;
		\Session::flash('mensagem', ['msg' => 'Seleção de Pessoal excluído com sucesso!','class'=>'green white-text']);
		return view('transparencia/rh/rh_selecaopessoal_cadastro', compact('unidade','unidades','unidadesMenu','selecaoPessoal','lastUpdated','text'));
	}
	
	public function processoSCadastro($id, Request $request)
	{
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
	    for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id) {
				$validacao = 'ok';
				break;
			} else {
				$validacao = 'erro';
			}
		}
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);
		$docSelectiveProcess = SelectiveProcess::where('unidade_id', $id)->orderBy('year', 'ASC')->get();
		$selecaoPessoal = SelecaoPessoal::where('unidade_id', $id)->get();
        $data = array();
        $data[] = $lastUpdatedRegulamento = '2020-05-31 00:00:00';   
        $data[] = $docSelectiveProcess->max('updated_at');
        $data[] = $selecaoPessoal->max('updated_at');
        $lastUpdated = max($data);
		$text = false;
		if($validacao == 'ok') {
		    return view('transparencia/rh/rh_pseletivo_cadastro', compact('unidade','unidades','unidadesMenu','selecaoPessoal','docSelectiveProcess','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function processoSNovo($id, Request $request)
	{
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
	    for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id) {
				$validacao = 'ok';
				break;
			} else {
				$validacao = 'erro';
			}
		}
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);
		$docSelectiveProcess = SelectiveProcess::where('unidade_id', $id)->orderBy('year', 'ASC')->get();
		$data = array();
        $data[] = $docSelectiveProcess->max('updated_at');
        $lastUpdated = max($data);
		$text = false;
		if($validacao == 'ok') {
		    return view('transparencia/rh/rh_pseletivo_novo', compact('unidade','unidades','unidadesMenu','docSelectiveProcess','lastUpdated','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function storeSeletivo($id, Request $request)
	{ 
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);
		$input = $request->all();			$nome = $_FILES['file_path']['name']; 		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		$docSelectiveProcess = SelectiveProcess::where('unidade_id', $id)->orderBy('year', 'ASC')->get();
		$selecaoPessoal = SelecaoPessoal::where('unidade_id', $id)->get();
		$data = array();
		$data[] = $lastUpdatedRegulamento = '2017-08-31 00:00:00';   
		$data[] = $docSelectiveProcess->max('updated_at');
		$data[] = $selecaoPessoal->max('updated_at');
		$lastUpdated = max($data);
		if($request->file('file_path') === NULL) {	
			$text = true;
			\Session::flash('mensagem', ['msg' => 'Informe um arquivo do Processo Seletivo!','class'=>'green white-text']);
			return view('transparencia/rh/rh_pseletivo_novo', compact('unidades','unidade','unidadesMenu','selecaoPessoal','lastUpdated','text'));
		} else {
			if($extensao === 'pdf') {
				$v = \Validator::make($request->all(), [
					'title' => 'required|max:255',
					'year' => 'required|digits:4'
				]);
				if ( $input['year'] < 1800 && $input['year'] > 2500 ) {
					$text = true;
					\Session::flash('mensagem', ['msg' => 'O campo ano é inválido!','class'=>'green white-text']);
					return view('transparencia/rh/rh_pseletivo_novo', compact('unidades','unidade','unidadesMenu','selecaoPessoal','lastUpdated','text'));
				}
				if ($v->fails()) {
					$failed = $v->failed();
					if ( !empty($failed['title']['Required']) ) {
						\Session::flash('mensagem', ['msg' => 'O campo título é obrigatório!','class'=>'green white-text']);
					} else if ( !empty($failed['title']['Max']) ) {
						\Session::flash('mensagem', ['msg' => 'O campo título possui no máximo 255 caracteres!','class'=>'green white-text']);
					} else if ( !empty($failed['year']['Required']) ) {
						\Session::flash('mensagem', ['msg' => 'O campo ano é obrigatório!','class'=>'green white-text']);
					} else if ( !empty($failed['year']['Digits']) ) {
						\Session::flash('mensagem', ['msg' => 'O campo ano é inválido!','class'=>'green white-text']);
					}
					$text = true;
					return view('transparencia/rh/rh_pseletivo_novo', compact('unidades','unidade','unidadesMenu','selecaoPessoal','lastUpdated','text'));
				} else {
					$ano  = $input['year'];
					$nome = $_FILES['file_path']['name']; 
					$selecaoP = SelectiveProcess::where('year', $ano)->get();
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
						}
					} 
					
					$selectiveProcess = SelectiveProcess::create($input);		
					$log = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$docSelectiveProcess = SelectiveProcess::where('unidade_id', $id)->orderBy('year', 'ASC')->get();
					$selecaoPessoal = SelecaoPessoal::where('unidade_id', $id)->get();
					$text = true;
					\Session::flash('mensagem', ['msg' => 'Processo Seletivo foi cadastrado com sucesso!','class'=>'green white-text']);
					return view('transparencia/rh/rh_pseletivo_cadastro', compact('unidades','unidade','unidadesMenu','selecaoPessoal','docSelectiveProcess','lastUpdated','text'));
				}
			} else {	
				$text = true;
				\Session::flash('mensagem', ['msg' => 'Só é permitido arquivos: .pdf!','class'=>'green white-text']);
				return view('transparencia/rh/rh_pseletivo_novo', compact('unidades','unidade','unidadesMenu','selecaoPessoal','lastUpdated','text'));
			}
		}
		return view('transparencia/rh/rh_pseletivo_novo', compact('unidade','unidades','unidadesMenu','selecaoPessoal','lastUpdated'));		
	}
	
	public function processoSExcluir($id, $id_item, Request $request)
	{
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
	    for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id) {
				$validacao = 'ok';
				break;
			} else {
				$validacao = 'erro';
			}
		}
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);
		$docSelectiveProcess = SelectiveProcess::where('id', $id_item)->orderBy('year', 'ASC')->get();
		$data = array();
        $data[] = $docSelectiveProcess->max('updated_at');
        $lastUpdated = max($data);
		$text = false;
		if($validacao == 'ok') {
		    return view('transparencia/rh/rh_pseletivo_excluir', compact('unidade','unidades','unidadesMenu','docSelectiveProcess','lastUpdated','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function destroySeletivo($id, $id_item, Request $request)
	{
		SelectiveProcess::find($id_item)->delete();
		
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$nome = $input['file_path'];
		$pasta = 'public/'.$nome; 
		Storage::delete($pasta);
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);		
		$docSelectiveProcess = SelectiveProcess::where('unidade_id', $id)->orderBy('year', 'ASC')->get();
		$text = true;
		\Session::flash('mensagem', ['msg' => 'Processo Seletivo excluído com sucesso!','class'=>'green white-text']);
		return view('transparencia/rh/rh_pseletivo_cadastro', compact('unidade','unidades','unidadesMenu','docSelectiveProcess','lastUpdated','text'));
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
}
?>