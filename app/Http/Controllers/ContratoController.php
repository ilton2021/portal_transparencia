<?php

namespace App\Http\Controllers;

use App\Model\ContratoGestao;
use App\Model\Unidade;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Model\PermissaoUsers;
use Illuminate\Support\Facades\DB;

class ContratoController extends Controller
{
    public function __construct(Unidade $unidade, ContratoGestao $contratoGestao, LoggerUsers $logger_users)
    {
        $this->unidade 		  = $unidade;
		$this->contratoGestao = $contratoGestao;
		$this->logger_users   = $logger_users;
    }
	
	public function index(Unidade $unidade)
    {
        $unidades = $this->unidade->all();
		return view('transparencia.contratoGestao', compact('unidades'));
    }
	
	public function contratoNovo($id_unidade)
	{
		$permissao_users = PermissaoUsers::where('unidade_id', $id_unidade)->get();
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
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/contratosGestao/contratoGestao_novo', compact('unidades','unidade','unidadesMenu','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function contratoValidar($id_unidade, $id_item)
	{
		$permissao_users = PermissaoUsers::where('unidade_id', $id_unidade)->get();
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
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$contratos = ContratoGestao::find($id_item);
		DB::statement('UPDATE contrato_gestaos SET validar = 0 WHERE id = '.$id_item.';');
		$contratos = ContratoGestao::where('unidade_id', $id_unidade)->get();
		if($validacao == 'ok') {
			\Session::flash('mensagem', ['msg' => 'Contrato de Gestão validado com Sucesso!!','class'=>'green white-text']);		
			$text = true;
			return view('transparencia/contratosGestao/contratoGestao_cadastro', compact('unidades','unidade','unidadesMenu','text','contratos','permissao_users'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function contratoCadastro($id_unidade, ContratoGestao $contrato)
	{
		$permissao_users = PermissaoUsers::where('unidade_id', $id_unidade)->get();
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
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$text = false;
			if($id_unidade === 1){
				$contratos = ContratoGestao::all();
				$lastUpdated = $contratos->max('updated_at');
			}else{
				$contratos = ContratoGestao::where('unidade_id',$id_unidade)->get();
				$lastUpdated = $contratos->max('updated_at');
			}
    	if($validacao == 'ok') {
			return view('transparencia/contratosGestao/contratoGestao_cadastro', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function contratoExcluir($id_unidade, $escolha)
	{
		$permissao_users = PermissaoUsers::where('unidade_id', $id_unidade)->get();
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
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$contratos = ContratoGestao::where('id',$escolha)->get();
        $lastUpdated = $contratos->max('updated_at');        
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/contratosGestao/contratoGestao_excluir', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
    public function store($id_unidade, Request $request)
    { 
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$contratos = ContratoGestao::where('unidade_id',$id_unidade)->get();
        $lastUpdated = $contratos->max('updated_at');
		$input = $request->all();
		$nome = $_FILES['path_file']['name']; 
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		if($request->file('path_file') === NULL) {	
			\Session::flash('mensagem', ['msg' => 'Informe o arquivo do Contrato!','class'=>'green white-text']);		
			$text = true;
			return view('transparencia/contratosGestao/contratoGestao_novo', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated','text'));
		} else {
			if($extensao === 'pdf') {
				$v = \Validator::make($request->all(), [
					'title'    => 'required|max:255',
				]);
				if ($v->fails()) {
					$failed = $v->failed();
					if ( !empty($failed['title']['Required']) ) {
						\Session::flash('mensagem', ['msg' => 'O campo título é obrigatório!','class'=>'green white-text']);
					} else if ( !empty($failed['title']['Max']) ) { 
						\Session::flash('mensagem', ['msg' => 'O campo título possui no máximo 255 caracteres!','class'=>'green white-text']);
					}
					$text = true;
					return view('transparencia.contratoGestao', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated','text'));
				} else {
					$nome = $_FILES['path_file']['name']; 					
					$request->file('path_file')->move('../public/storage/contrato_gestao/', $nome);
					$input['path_file'] = 'contrato_gestao/' .$nome; 
					$contrato_gestao = ContratoGestao::create($input);
					$log = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$contratos = ContratoGestao::where('unidade_id',$id_unidade)->get();
					\Session::flash('mensagem', ['msg' => 'Contrato de Gestão/Aditivo cadastrado com sucesso!','class'=>'green white-text']);
					$text = true;
					$permissao_users = PermissaoUsers::where('unidade_id', $id_unidade)->get();
					return view('transparencia/contratosGestao/contratoGestao_cadastro', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated','text','permissao_users'));
				}
			} else {	
				\Session::flash('mensagem', ['msg' => 'Só é suportado arquivos: pdf!','class'=>'green white-text']);		
				$text = true;
				return view('transparencia/contratosGestao/contratoGestao_novo', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated','text'));
			}
		}
    }
	
    public function destroy($id_unidade, $id_escolha, ContratoGestao $contrato, Request $request)
    {
        ContratoGestao::find($id_escolha)->delete();
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$nome = $input['path_file'];
		$pasta = 'public/'.$nome; 
		Storage::delete($pasta);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$contratos = ContratoGestao::where('unidade_id',$id_unidade)->get();
        \Session::flash('mensagem', ['msg' => 'Contrato de Gestão/Aditivo excluído com sucesso!','class'=>'green white-text']);
		$text = true;
		return view('transparencia/contratosGestao/contratoGestao_cadastro', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated','text'));
    }
}