<?php

namespace App\Http\Controllers;

use App\Model\Estatuto;
use App\Model\Unidade;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Storage;
use App\Model\PermissaoUsers;
use Auth;
use Illuminate\Support\Facades\DB;

class EstatutoController extends Controller
{
	public function __construct(Unidade $unidade, Estatuto $estatuto, LoggerUsers $logger_users)
	{
		$this->unidade  	= $unidade;
		$this->estatuto 	= $estatuto;
		$this->logger_users = $logger_users;
	}

    public function index()
    {
        $unidades = $this->unidade->all();
		return view('transparencia.estatuto', compact('unidades'));
    }

	public function estatutoCadastro($id)
	{
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
		for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id && ($permissao_users[$i]->unidade_id == 1)) {
				$validacao = 'ok';
				break;
			} else {
				$validacao = 'erro';
			}
		}
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);
		$estatutos = $this->estatuto->all();
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/estatuto/estatuto_cadastro', compact('unidade','unidades','unidadesMenu','estatutos','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}

	public function estatutoNovo($id)
	{
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
		for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id && ($permissao_users[$i]->unidade_id == 1)) {
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
			return view('transparencia/estatuto/estatuto_novo', compact('unidade','unidades','unidadesMenu','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function estatutoValidar($id, $id_item, Request $request)
	{
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
		for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id && ($permissao_users[$i]->unidade_id == 1)) {
				$validacao = 'ok';
				break;
			} else {
				$validacao = 'erro';
			}
		}
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);
		$estatuto = Estatuto::find($id_item);
		DB::statement('UPDATE estatutos SET validar = 0 WHERE id = '.$id_item.';');
		$estatutos = Estatuto::all();
		$lastUpdated = $estatutos->max('updated_at');
		if($validacao == 'ok') {
			\Session::flash('mensagem', ['msg' => 'Estatuto validado com Sucesso!!','class'=>'green white-text']);		
			$text = true;
			return view('transparencia/estatuto/estatuto_cadastro', compact('unidade','unidades','unidadesMenu','text','estatutos'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}

	public function estatutoExcluir($id, $id_estatuto)
	{
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
		for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id && ($permissao_users[$i]->unidade_id == 1)) {
				$validacao = 'ok';
				break;
			} else {
				$validacao = 'erro';
			}
		}
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);
		$estatutos = $this->estatuto->find($id_estatuto);
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/estatuto/estatuto_excluir', compact('unidade','unidades','unidadesMenu','estatutos','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}

    public function store($id, Request $request)
    {
        $unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);
		$estatutos = $this->estatuto->all();
		$input = $request->all();
		$nome = $_FILES['path_file']['name']; 
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		$v = \Validator::make($request->all(), [
			'name' => 'required|max:255'		
		]);
		if ($v->fails()) {
			$failed = $v->failed();
			if ( !empty($failed['name']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo título é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['name']['Max']) ) { 
				\Session::flash('mensagem', ['msg' => 'O campo título possui no máximo 255 caracteres!','class'=>'green white-text']);
			}
			$text = true;
			return view('transparencia/estatuto/estatuto_novo', compact('unidade','unidades','unidadesMenu','estatutos','text'));
		} else {
			if($request->file('path_file') === NULL) {
				\Session::flash('mensagem', ['msg' => 'Informe o arquivo do Estatuto/Ata!','class'=>'green white-text']);		
				$text = true;
				return view('transparencia/estatuto/estatuto_novo', compact('unidade','unidades','unidadesMenu','estatutos','text'));
			} else {
				if($extensao === 'pdf') {
					$nome = $_FILES['path_file']['name']; 
					$request->file('path_file')->move('../public/storage/estatuto_ata/', $nome);
					$input['path_file'] = 'estatuto_ata/'.$nome; 
					$input['kind'] = 'ATA';
					$estatuto = Estatuto::create($input);
					$log = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$estatutos = $this->estatuto->all();
					\Session::flash('mensagem', ['msg' => 'Estatuto/Ata cadastrado com sucesso!','class'=>'green white-text']);		
					$text = true;
					return view('transparencia/estatuto/estatuto_cadastro', compact('unidade','unidades','unidadesMenu','lastUpdated','estatutos','text'));
				} else {
					\Session::flash('mensagem', ['msg' => 'Só é permitido arquivos: .pdf!','class'=>'green white-text']);		
					$text = true;
					return view('transparencia/estatuto/estatuto_novo', compact('unidade','unidades','unidadesMenu','estatutos','text'));
				}
			}
		}
    }

    public function destroy($id, $id_estatuto, Estatuto $estatuto, Request $request)
    {
		Estatuto::find($id_estatuto)->delete();
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$nome = $input['path_file'];
		$pasta = 'public/'.$nome; 
		Storage::delete($pasta);
		$lastUpdated = $log->max('updated_at');
        $unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu; 
		$unidade = $this->unidade->find($id);
		$estatutos = $this->estatuto->all();
		\Session::flash('mensagem', ['msg' => 'Estatuto/Ata excluído com sucesso!','class'=>'green white-text']);		
		$text = true;
		return view('transparencia/estatuto/estatuto_cadastro', compact('unidade','unidades','unidadesMenu','lastUpdated','estatutos','text'));
    }
}