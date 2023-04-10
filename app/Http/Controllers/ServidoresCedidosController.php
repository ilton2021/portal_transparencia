<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ServidoresCedidosRH;
use App\Model\Unidade;
use App\Model\LoggerUsers;
use App\Http\Controllers\PermissaoUsersController;
use App\Model\PermissaoUsers;
use Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class ServidoresCedidosController extends Controller
{
    public function __construct(Unidade $unidade, ServidoresCedidosRH $servidores, Request $request, LoggerUsers $logger_users){
		$this->unidade 	  = $unidade;
		$this->servidores = $servidores;
		$this->request 		= $request;
		$this->logger_users = $logger_users;
	}
	
	public function index()
    {
        $unidades = $this->associado->all();
		return view('home', compact('unidades')); 		
    }
	
	public function cadastroSE($id_unidade, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$servidores = ServidoresCedidosRH::where('unidade_id', $id_unidade)->orderBy('nome','ASC')->get();
		if($validacao == 'ok') {
			return view('transparencia/servidores/servidor_cadastro', compact('unidades','unidadesMenu','unidade','servidores'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}
	
	public function novoSE($id_unidade, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		if($validacao == 'ok') {
			return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}
	
	public function storeSE($id_unidade, Request $request) 
	{
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$input = $request->all();
		$validator = Validator::make($request->all(), [
			'nome'   	   => 'required|max:255',
			'cargo'  	   => 'required|max:255',
			'matricula'    => 'required|max:255',
			'email'  	   => 'required|max:255',
			'fone'  	   => 'required|max:15',
			'data_inicio'  => 'required|date',
		]);		
		if ($validator->fails()) {
			return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}else {
			$input['status_servidores'] = 1;
			$servidores  = ServidoresCedidosRH::create($input);
			$id_registro = DB::table('servidores_cedidos')->max('id');
			$input['registro_id'] = $id_registro;
			$log 		 = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$servidores  = ServidoresCedidosRH::where('status_servidores',1)->where('unidade_id',$id_unidade)->orderby('nome','ASC')->get();
			$validator   = 'O Servidor Cedido, foi cadastrado com sucesso!';
			return redirect()->route('cadastroSE', [$id_unidade])
				->withErrors($validator);
		}
	}
	
	public function alterarSE($id_servidor, $id_unidade, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$servidores = ServidoresCedidosRH::where('unidade_id',$id_unidade)->where('id',$id_servidor)->get();
		if($validacao == 'ok') {
			return view('transparencia/servidores/servidor_alterar', compact('unidades','unidadesMenu','unidade','servidores'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}
	
	public function updateSE($id_servidor, $id_unidade, Request $request) 
	{
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$input 		  = $request->all();
		$servidores   = ServidoresCedidosRH::where('unidade_id',$id_unidade)->where('id',$id_servidor)->get();
		$validator = Validator::make($request->all(), [
			'nome'   	   => 'required|max:255',
			'cargo'  	   => 'required|max:255',
			'matricula'    => 'required|max:255',
			'email'  	   => 'required|max:255',
			'fone'  	   => 'required|max:15',
			'data_inicio'  => 'required|date',
		]);		
		if ($validator->fails()) {
			return view('transparencia/servidores/servidor_alterar', compact('unidades','unidadesMenu','unidade','servidores'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}else {
			$servidores  = ServidoresCedidosRH::find($id_servidor); 
			$servidores->update($input);
			$input['registro_id'] = $id_servidor;
			$log 		 = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$servidores  = ServidoresCedidosRH::where('unidade_id',$id_unidade)->orderby('nome','ASC')->get();
			$validator   = 'O servidor Cedido foi alterado com sucesso!';
			return redirect()->route('cadastroSE', [$id_unidade])
				->withErrors($validator);
		}
	}
	
	public function excluirSE($id_servidor, $id_unidade, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$servidores = ServidoresCedidosRH::where('unidade_id', $id_unidade)->where('id', $id_servidor)->get();
		if($validacao == 'ok') {
			return view('transparencia/servidores/servidor_excluir', compact('unidades','unidadesMenu','unidade','servidores'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function telaInativarSE($id_servidor, $id_unidade, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$servidores = ServidoresCedidosRH::where('unidade_id', $id_unidade)->where('id', $id_servidor)->get();
		if($validacao == 'ok') {
			return view('transparencia/servidores/servidor_inativar', compact('unidades','unidadesMenu','unidade','servidores'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}
	
	public function destroySE($id_servidor, $id_unidade, Request $request) {
		ServidoresCedidosRH::find($id_servidor)->delete();  
		$input 		  = $request->all();
		$input['registro_id'] = $id_servidor;
		$log 		  = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$servidores   = ServidoresCedidosRH::where('unidade_id',$id_unidade)->orderby('nome','ASC')->get();
		$validator    = 'Servidor Cedido Excluído com sucesso!';
		return redirect()->route('cadastroSE', [$id_unidade])
				->withErrors($validator);
	}

	public function inativarSE($id_servidor, $id_unidade, Request $request) {
		$input     = $request->all();
		$servidores = ServidoresCedidosRH::where('id',$id_servidor)->get();
		if($servidores[0]->status_servidores == 1) {
			DB::statement('UPDATE servidores_cedidos SET status_servidores = 0 WHERE id = '.$id_servidor.';');
		} else {
			DB::statement('UPDATE servidores_cedidos SET status_servidores = 1 WHERE id = '.$id_servidor.';');
		}
		$input['registro_id'] = $id_servidor;
		$log          = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$servidores   = ServidoresCedidosRH::where('id',$id_servidor)->get();
		$validator    = 'Servidores inativado com sucesso!';
		return redirect()->route('cadastroSE', [$id_unidade])
				->withErrors($validator);
	}
}