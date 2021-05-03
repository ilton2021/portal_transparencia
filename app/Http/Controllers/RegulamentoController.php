<?php

namespace App\Http\Controllers;

use App\Model\Manual;
use App\Model\Unidade;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Storage;
use App\Model\PermissaoUsers;
use Auth;
use Illuminate\Support\Facades\DB;

class RegulamentoController extends Controller
{
	public function __construct(Unidade $unidade, Manual $manual, LoggerUsers $logger_users)
    {
        $this->unidade 		= $unidade;
		$this->manual  		= $manual;
		$this->logger_users = $logger_users;
    }
	
    public function index()
    {
		$unidades = $this->unidade->all();
		return view ('transparencia', compact('unidades'));
    }

    public function regulamentoCadastro($id)
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
		$manuais = Manual::all();
        $lastUpdated = $manuais->max('updated_at');
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/regulamentos/regulamento_cadastro', compact('unidade','unidades','unidadesMenu','manuais','lastUpdated','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function regulamentoValidar($id, $id_item, Request $request)
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
		$manuais = Manual::find($id_item);
		DB::statement('UPDATE manuals SET validar = 0 WHERE id = '.$id_item.';');		
		$manuais = Manual::where('unidade_id', $id)->get();
		$lastUpdated = $manuais->max('updated_at');
		$text = false;
		if($validacao == 'ok') {
			\Session::flash('mensagem', ['msg' => 'Regulamento Próprio validado com Sucesso!!','class'=>'green white-text']);		
			$text = true;
			return view('transparencia/regulamentos/regulamento_cadastro', compact('unidade','unidades','unidadesMenu','manuais','lastUpdated','text','permissao_users'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function regulamentoNovo($id)
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
			return view('transparencia/regulamentos/regulamento_novo', compact('unidade','unidades','unidadesMenu','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function regulamentoExcluir($id_unidade, $id_item)
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
		$manuais = Manual::where('id',$id_item)->get();
		$lastUpdated = $manuais->max('updated_at');	
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/regulamentos/regulamento_excluir', compact('unidade','unidades','unidadesMenu','manuais','lastUpdated','text'));
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
		$manuais = Manual::all();
        $lastUpdated = $manuais->max('updated_at');
		$input = $request->all();
		$nome = $_FILES['path_file']['name']; 
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		$nomeImg = $_FILES['path_img']['name'];
		$extensaoI = pathinfo($nomeImg, PATHINFO_EXTENSION);
		if($request->file('path_file') === NULL || $request->file('path_img') === NULL) {	
			$text = true;
			\Session::flash('mensagem', ['msg' => 'Informe o arquivo e a imagem do Regulamento!','class'=>'green white-text']);		
			return view('transparencia/regulamentos/regulamento_novo', compact('unidades','unidade','unidadesMenu','manuais','lastUpdated','text'));
		} else {
			if($extensao == 'pdf') {
				if($extensaoI == 'png' || $extensaoI == 'jpg') {
					$v = \Validator::make($request->all(), [
						'title' => 'required|max:255'
					]);
					if ($v->fails()) {
						$failed = $v->failed();
						if ( !empty($failed['title']['Required']) ) { 
							\Session::flash('mensagem', ['msg' => 'O campo título é obrigatório!','class'=>'green white-text']);
						} else if ( !empty($failed['title']['Max']) ) {
							\Session::flash('mensagem', ['msg' => 'O campo título possui no máximo 255 caracteres!','class'=>'green white-text']);
						} 
						$text = true; 
						return view('transparencia/regulamentos/regulamento_novo', compact('unidades','unidade','unidadesMenu','manuais','lastUpdated','text'));
					} else {  
						$nomeA = $_FILES['path_file']['name'];   
						$request->file('path_file')->move('../public/storage/manual', $nomeA);
						$nomeF = $_FILES['path_img']['name'];
						$request->file('path_img')->move('../public/img', $nome);
						$input['path_file'] = 'manual/' .$nomeA;
						$input['path_img'] = $nomeF;					
						$manuais = Manual::create($input);	
						$log = LoggerUsers::create($input);
						$lastUpdated = $log->max('updated_at');
						$manuais = Manual::all();
						$text = true;
						\Session::flash('mensagem', ['msg' => 'Regulamento cadastrado com sucesso!','class'=>'green white-text']);			
						return view('transparencia/regulamentos/regulamento_cadastro', compact('unidades','unidade','unidadesMenu','manuais','lastUpdated','text'));									
					} 
				} else {
					\Session::flash('mensagem', ['msg' => 'Só suporta imagens: .png e .jpg!','class'=>'green white-text']);			
					$text = true;
					$manuais = Manual::where('unidade_id',$id_unidade)->get();
					$lastUpdated = $manuais->max('updated_at');
					return view('transparencia/regulamentos/regulamento_novo', compact('unidades','unidade','unidadesMenu','manuais','lastUpdated','text'));
				}
			} else {	
				\Session::flash('mensagem', ['msg' => 'Só suporta arquivos: .pdf!','class'=>'green white-text']);			
				$text = true;
				$manuais = Manual::where('unidade_id',$id_unidade)->get();
				$lastUpdated = $manuais->max('updated_at');
				return view('transparencia/regulamentos/regulamento_novo', compact('unidades','unidade','unidadesMenu','manuais','lastUpdated','text'));
			}
		}
	}

    public function destroy($id_unidade, $id_item, Manual $manuais, Request $request)
    {
		Manual::find($id_item)->delete();		
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$nome = $input['path_file'];
		$pasta = 'public/'.$nome; 
		Storage::delete($pasta);
		$nome = $input['path_img'];
		$pasta = 'public/img/'.$nome; 
		Storage::delete($pasta);
        $unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id_unidade);		
		$manuais = Manual::all();
		\Session::flash('mensagem', ['msg' => 'Regulamento excluído com sucesso!','class'=>'green white-text']);			
		$text = true;
		return view('transparencia/regulamentos/regulamento_cadastro', compact('unidades','unidade','unidadesMenu','manuais','lastUpdated','text'));
    }
}