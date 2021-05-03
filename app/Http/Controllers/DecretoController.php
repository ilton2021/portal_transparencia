<?php

namespace App\Http\Controllers;

use App\Model\Decreto;
use App\Model\Unidade;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Storage;
use App\Model\PermissaoUsers;
use Auth;
use Illuminate\Support\Facades\DB;

class DecretoController extends Controller
{
	public function __construct(Unidade $unidade, Decreto $decreto, LoggerUsers $logger_users)
    {
        $this->unidade 		= $unidade;
		$this->decreto 	    = $decreto;
		$this->logger_users = $logger_users;
    }
	
    public function index()
    {
		$unidades = $this->unidade->all();
		return view ('transparencia', compact('unidades'));
    }

    public function decretoCadastro($id)
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
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id);	
		$decretos = Decreto::all();
        $lastUpdated = $decretos->max('updated_at');
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/decretos/decreto_cadastro', compact('unidade','unidades','unidadesMenu','decretos','lastUpdated','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function decretoNovo($id)
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
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id);
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/decretos/decreto_novo', compact('unidade','unidades','unidadesMenu','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function decretoValidar($id, $id_item)
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
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id);
		$decretos = Decreto::find($id_item);
		DB::statement('UPDATE decretos SET validar = 0 WHERE id = '.$id_item.';');
		$decretos = Decreto::all();
        $lastUpdated = $decretos->max('updated_at');
		if($validacao == 'ok') {
			\Session::flash('mensagem', ['msg' => 'Decreto validado com Sucesso!!','class'=>'green white-text']);		
			$text = true;
			return view('transparencia/decretos/decreto_cadastro', compact('unidade','unidades','unidadesMenu','text','permissao_users','decretos'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function decretoExcluir($id_unidade, $id_item)
	{
		$permissao_users = PermissaoUsers::where('unidade_id', $id_unidade)->get();
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
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id_unidade);
		$decretos = Decreto::where('id',$id_item)->get();
		$lastUpdated = $decretos->max('updated_at');	
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/decretos/decreto_excluir', compact('unidade','unidades','unidadesMenu','decretos','lastUpdated','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
    public function store($id_unidade, Request $request)
    { 
        $unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id_unidade);
		$decretos = Decreto::all();
        $lastUpdated = $decretos->max('updated_at');
		$input = $request->all();
		$nome = $_FILES['path_file']['name']; 
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		if($request->file('path_file') === NULL) {	
			$text = true;
			\Session::flash('mensagem', ['msg' => 'Informe o arquivo do Decreto!','class'=>'green white-text']);		
			return view('transparencia/decretos/decreto_novo', compact('unidades','unidade','unidadesMenu','decretos','lastUpdated','text'));
		} else {
			if($extensao === 'pdf') {
				$v = \Validator::make($request->all(), [
					'title'   => 'required|max:255',
					'decreto' => 'required',
					'kind'	  => 'required'
				]);
				if ($v->fails()) {
					$failed = $v->failed();
					if ( !empty($failed['title']['Required']) ) { var_dump($failed); exit();
						\Session::flash('mensagem', ['msg' => 'O campo título é obrigatório!','class'=>'green white-text']);
					} else if ( !empty($failed['title']['Max']) ) {
						\Session::flash('mensagem', ['msg' => 'O campo título possui no máximo 255 caracteres!','class'=>'green white-text']);
					} else if ( !empty($failed['decreto']['Required']) ) {	
						\Session::flash('mensagem', ['msg' => 'O campo decreto é obrigatório!','class'=>'green white-text']);
					} else if ( !empty($failed['kind']['Required']) ) {	
						\Session::flash('mensagem', ['msg' => 'O campo kind é obrigatório!','class'=>'green white-text']);
					}
					$text = true;
					return view('transparencia/decretos/decreto_novo', compact('unidades','unidade','unidadesMenu','decretos','lastUpdated','text'));
				} else {
					$nome = $_FILES['path_file']['name'];  
					$request->file('path_file')->move('../public/storage/decretos/', $nome);
					$input['path_file'] = 'decretos/' .$nome; 
					$input['decreto'] = 'Nº: '.$input['decreto'];
					$decretos = Decreto::create($input);	
					$log = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$decretos = Decreto::all();
					$text = true;
					\Session::flash('mensagem', ['msg' => 'Decreto cadastrado com sucesso!','class'=>'green white-text']);			
					return view('transparencia/decretos/decreto_cadastro', compact('unidades','unidade','unidadesMenu','decretos','lastUpdated','text'));									
				} 			
				
			} else {	
				\Session::flash('mensagem', ['msg' => 'Só suporta arquivos: .pdf!','class'=>'green white-text']);			
				$text = true;
				$decretos = Decreto::all();
				$lastUpdated = $decretos->max('updated_at');
				return view('transparencia/decretos/decreto_novo', compact('unidades','unidade','decretos','demonstrativoContaveis','lastUpdated','text'));
			}
		}
	}

    public function destroy($id_unidade, $id_item, Decreto $decreto, Request $request)
    {
		Decreto::find($id_item)->delete();		
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$nome = $input['path_file'];
		$pasta = 'public/'.$nome; 
		Storage::delete($pasta);
        $unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id_unidade);		
		$decretos = Decreto::all();
		\Session::flash('mensagem', ['msg' => 'Decreto excluído com sucesso!','class'=>'green white-text']);			
		$text = true;
		return view('transparencia/decretos/decreto_cadastro', compact('unidades','unidade','unidadesMenu','decretos','lastUpdated','text'));
    }
}