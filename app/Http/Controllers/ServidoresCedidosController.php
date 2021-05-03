<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ServidoresCedidosRH;
use App\Model\Unidade;
use App\Model\LoggerUsers;
use App\Model\PermissaoUsers;
use Auth;
use Illuminate\Support\Facades\DB;

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
		$text = false;
		return view('transparencia/servidores/servidor_cadastro', compact('unidades','unidadesMenu','unidade','servidores','text'));
	}
	
	public function servidoresNovo($id_unidade){
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade  = $this->unidade->find($id_unidade);
		$text = false;
		$servidores = ServidoresCedidosRH::where('unidade_id', $id_unidade)->get();
		return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade','servidores','text'));
	}
	
	public function storeServidores($id_unidade, Request $request) {
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade  = $this->unidade->find($id_unidade);
		$input = $request->all();
		$v = \Validator::make($request->all(), [
			'nome'   	   => 'required|max:255',
			'cargo'  	   => 'required|max:255',
			'matricula'    => 'required|max:255',
			'email'  	   => 'required|max:255',
			'fone'  	   => 'required|max:15',
			'data_inicio'  => 'required|date',
		]);		
		if ($v->fails()) {
			$failed = $v->failed();
			if ( !empty($failed['nome']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo nome é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['nome']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo nome possui no máximo 255 caracteres!','class'=>'green white-text']);
			} else if ( !empty($failed['cargo']['Required']) ) {	
				\Session::flash('mensagem', ['msg' => 'O campo matrícula é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['cargo']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo matrícula possui no máximo 255 caracteres!','class'=>'green white-text']);
			} else if ( !empty($failed['matricula']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo matrícula é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['matricula']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo matrícula possui no máximo 255 caracteres!','class'=>'green white-text']);
			} else if ( !empty($failed['email']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo email é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['email']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo email possui no máximo 255 caracteres!','class'=>'green white-text']);
			} else if ( !empty($failed['fone']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo telefone é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['fone']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo telefone possui no máximo 15 caracteres!','class'=>'green white-text']);
			} else if ( !empty($failed['data_inicio']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo data início é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['data_inicio']['Date']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo data início tem que ser uma data válida!','class'=>'green white-text']);
			}
			$text = true; 
			return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade','text'));
		}else {
			$servidores = ServidoresCedidosRH::create($input);
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$servidores = ServidoresCedidosRH::all();
			$text = true;
			\Session::flash('mensagem', ['msg' => 'O Servidor Cedido foi cadastrado com sucesso!','class'=>'green white-text']);
			return view('transparencia/servidores/servidor_cadastro', compact('unidades','unidadesMenu','unidade','lastUpdated','servidores','text'));
		}
	}
	
	public function servidoresAlterar($id_servidor, $id_unidade){
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade  = $this->unidade->find($id_unidade);
		$servidores = ServidoresCedidosRH::where('unidade_id', $id_unidade)->where('id', $id_servidor)->get();
		$text = false;
		return view('transparencia/servidores/servidor_alterar', compact('unidades','unidadesMenu','unidade','servidores','text'));
	}
	
	public function updateServidores($id_servidor, $id_unidade, Request $request) {
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade  = $this->unidade->find($id_unidade);
		$input = $request->all();
		$servidores = ServidoresCedidosRH::where('unidade_id',$id_unidade)->where('id',$id_servidor)->get();
		$v = \Validator::make($request->all(), [
			'nome'   	   => 'required|max:255',
			'cargo'  	   => 'required|max:255',
			'matricula'    => 'required|max:255',
			'email'  	   => 'required|max:255',
			'fone'  	   => 'required|max:15',
			'data_inicio'  => 'required|date',
		]);		
		if ($v->fails()) {
			$failed = $v->failed();
			if ( !empty($failed['nome']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo nome é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['nome']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo nome possui no máximo 255 caracteres!','class'=>'green white-text']);
			} else if ( !empty($failed['cargo']['Required']) ) {	
				\Session::flash('mensagem', ['msg' => 'O campo matrícula é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['cargo']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo matrícula possui no máximo 255 caracteres!','class'=>'green white-text']);
			} else if ( !empty($failed['matricula']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo matrícula é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['matricula']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo matrícula possui no máximo 255 caracteres!','class'=>'green white-text']);
			} else if ( !empty($failed['email']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo email é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['email']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo email possui no máximo 255 caracteres!','class'=>'green white-text']);
			} else if ( !empty($failed['fone']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo telefone é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['fone']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo telefone possui no máximo 15 caracteres!','class'=>'green white-text']);
			} else if ( !empty($failed['data_inicio']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo data início é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['data_inicio']['Date']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo data início tem que ser uma data válida!','class'=>'green white-text']);
			}
			$text = true; 
			return view('transparencia/servidores/servidor_alterar', compact('unidades','unidadesMenu','unidade','servidores','text'));
		}else {
			$servidores = ServidoresCedidosRH::find($id_servidor); 
			$servidores->update($input);
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$servidores = ServidoresCedidosRH::all();
			$text = true;
			\Session::flash('mensagem', ['msg' => 'O Servidor Cedido foi alterado com sucesso!','class'=>'green white-text']);
			return view('transparencia/servidores/servidor_cadastro', compact('unidades','unidadesMenu','unidade','lastUpdated','servidores','text'));
		}
	}
	
	public function servidoresExcluir($id_servidor, $id_unidade){
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade  = $this->unidade->find($id_unidade);
		$servidores = ServidoresCedidosRH::where('unidade_id', $id_unidade)->where('id', $id_servidor)->get();
		$text = false;
		return view('transparencia/servidores/servidor_excluir', compact('unidades','unidadesMenu','unidade','servidores','text'));
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
		$text = true;
		\Session::flash('mensagem', ['msg' => 'Servidor Cedido excluído com sucesso!','class'=>'green white-text']);
		return view('transparencia/servidores/servidor_cadastro', compact('unidades','unidadesMenu','lastUpdated','unidade','servidores','text'));
	}
}
