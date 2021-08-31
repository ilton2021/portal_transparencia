<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ServidoresCedidosRH;
use App\Model\Unidade;
use App\Model\LoggerUsers;
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
	
	public function servidoresCadastro($id_unidade){
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade  = $this->unidade->find($id_unidade);
		$servidores = ServidoresCedidosRH::where('unidade_id', $id_unidade)->orderBy('nome','ASC')->get();
		return view('transparencia/servidores/servidor_cadastro', compact('unidades','unidadesMenu','unidade','servidores'));
	}
	
	public function servidoresNovo($id_unidade){
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade  = $this->unidade->find($id_unidade);
		$text = false;
		$servidores = ServidoresCedidosRH::where('unidade_id', $id_unidade)->get();
		return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade','servidores'));
	}
	
	public function storeServidores($id_unidade, Request $request) {
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade  = $this->unidade->find($id_unidade);
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
			$failed = $validator->failed();
			if ( !empty($failed['nome']['Required']) ) {
				$validator = 'O  campo nome é obrigatório!';
				return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));

			} else if ( !empty($failed['nome']['Max']) ) {
				$validator = 'O  campo nome suporta até 255 caracteres!';
				return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			
			
			} else if ( !empty($failed['cargo']['Required']) ) {	
				$validator = 'O  campo cargo é obrigatório!';
				return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			
			
			} else if ( !empty($failed['cargo']['Max']) ) {
				$validator = 'O  campo cargo suporta até 255 caracteres!';
				return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			
			
			} else if ( !empty($failed['matricula']['Required']) ) {
				$validator = 'O  campo matrícula é obrigatório!';
				return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			
			
			} else if ( !empty($failed['matricula']['Max']) ) {
				$validator = 'O  campo matrícula suporta até 255 caracteres!';
				return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			
			
			} else if ( !empty($failed['email']['Required']) ) {
				$validator = 'O  campo e-mail é obrigatório!';
				return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			
			
			} else if ( !empty($failed['email']['Max']) ) {
				$validator = 'O  campo email suporta até 255 caracteres!';
				return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			
			
			} else if ( !empty($failed['fone']['Required']) ) {
				$validator = 'O  campo Telefone é obrigatório!';
				return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			
			
			} else if ( !empty($failed['fone']['Max']) ) {
				$validator = 'O  campo Telefone suporta até 15 caracteres!';
				return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			
			
			} else if ( !empty($failed['data_inicio']['Required']) ) {
				$validator = 'O  campo Data Início é obrigatório!';
				return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			
			
			} else if ( !empty($failed['data_inicio']['Date']) ) {
				$validator = 'A data inserida no campo Data Início deve ser uma data válida!';
				return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			}
				return view('transparencia/servidores/servidor_alterar', compact('unidades','unidadesMenu','unidade','servidores'));


		}else {
			$servidores = ServidoresCedidosRH::create($input);
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$servidores = ServidoresCedidosRH::all();
			$validator = 'O Servidor Cedido, foi cadastrado com sucesso!';
			return view('transparencia/servidores/servidor_cadastro', compact('unidades','unidadesMenu','unidade','lastUpdated','servidores'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));
		}
	}
	
	public function servidoresAlterar($id_servidor, $id_unidade){
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade  = $this->unidade->find($id_unidade);
		$servidores = ServidoresCedidosRH::where('unidade_id', $id_unidade)->where('id', $id_servidor)->get();
		return view('transparencia/servidores/servidor_alterar', compact('unidades','unidadesMenu','unidade','servidores'));
		
	}
	
	public function updateServidores($id_servidor, $id_unidade, Request $request) {
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade  = $this->unidade->find($id_unidade);
		$input = $request->all();
		$servidores = ServidoresCedidosRH::where('unidade_id',$id_unidade)->where('id',$id_servidor)->get();
		$validator = Validator::make($request->all(), [
			'nome'   	   => 'required|max:255',
			'cargo'  	   => 'required|max:255',
			'matricula'    => 'required|max:255',
			'email'  	   => 'required|max:255',
			'fone'  	   => 'required|max:15',
			'data_inicio'  => 'required|date',
		]);		
		if ($validator->fails()) {
			$failed = $validator->failed();
			if ( !empty($failed['nome']['Required']) ) {
			
				$validator = 'O  campo nome é obrigatório!';
				return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));

			} else if ( !empty($failed['nome']['Max']) ) {
			
				$validator = 'O  campo nome suporta até 255 caracteres!';
				return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
	
	
			} else if ( !empty($failed['cargo']['Required']) ) {	
	
				$validator = 'O  campo cargo é obrigatório!';
				return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
	
	
			} else if ( !empty($failed['cargo']['Max']) ) {
	
				$validator = 'O  campo cargo suporta até 255 caracteres!';
				return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
	
	
			} else if ( !empty($failed['matricula']['Required']) ) {
	
	
				$validator = 'O  campo matrícula é obrigatório!';
				return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
	

			} else if ( !empty($failed['matricula']['Max']) ) {
	
	
				$validator = 'O  campo matrícula suporta até 255 caracteres!';
				return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
	
			} else if ( !empty($failed['email']['Required']) ) {
	
	
				$validator = 'O  campo e-mail é obrigatório!';
				return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
	

			} else if ( !empty($failed['email']['Max']) ) {
	
	
				$validator = 'O  campo email suporta até 255 caracteres!';
				return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
	
			} else if ( !empty($failed['fone']['Required']) ) {
	
				$validator = 'O  campo Telefone é obrigatório!';
				return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
	
	
			} else if ( !empty($failed['fone']['Max']) ) {
	
				$validator = 'O  campo Telefone suporta até 15 caracteres!';
				return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
	
	
			} else if ( !empty($failed['data_inicio']['Required']) ) {
	
				$validator = 'O  campo Data Início é obrigatório!';
				return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
	
	
			} else if ( !empty($failed['data_inicio']['Date']) ) {
	
	
				$validator = 'A data inserida no campo Data Início deve ser uma data válida!';
				return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
	
			}
			return view('transparencia/servidores/servidor_alterar', compact('unidades','unidadesMenu','unidade','servidores'));
		}else {
			$servidores = ServidoresCedidosRH::find($id_servidor); 
			$servidores->update($input);
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$servidores = ServidoresCedidosRH::all();
			$validator = 'O servidor Cedido foi alterado com sucesso!';
			return view('transparencia/servidores/servidor_cadastro', compact('unidades','unidadesMenu','unidade','lastUpdated','servidores'))
			->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}
	
	public function servidoresExcluir($id_servidor, $id_unidade){
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade  = $this->unidade->find($id_unidade);
		$servidores = ServidoresCedidosRH::where('unidade_id', $id_unidade)->where('id', $id_servidor)->get();
		return view('transparencia/servidores/servidor_excluir', compact('unidades','unidadesMenu','unidade','servidores'));
	}
	
	public function destroyServidores($id_servidor, $id_unidade, Request $request) {
		ServidoresCedidosRH::find($id_servidor)->delete();  
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$unidades = new Unidade();
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$servidores = ServidoresCedidosRH::all();
		$validator = 'Servidor Cedido Excluído com sucesso!';
		return view('transparencia/servidores/servidor_cadastro', compact('unidades','unidadesMenu','lastUpdated','unidade','servidores'))
		->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
	}
}
