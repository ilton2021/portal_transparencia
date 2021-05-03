<?php

namespace App\Http\Controllers;

use App\Model\LoggerUsers;
use App\Model\Unidade;
use App\Model\RegimentoInterno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Model\PermissaoUsers;
use Auth;

class RegimentoInternoController extends Controller
{
	public function __construct(Unidade $unidade, LoggerUsers $logger_users, RegimentoInterno $regimentoInterno)
	{
		$this->unidade 			= $unidade;
		$this->logger_users     = $logger_users;
		$this->regimentoInterno = $regimentoInterno;
	}
	
    public function index()
    {
        $unidades = $this->unidade->all();
		return view('transparencia.regimento_interno', compact('unidades'));
    }

	public function regimentoCadastro($id)
	{
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
		
	    for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id) {
				$validacao = 'ok';
			} else {
				$validacao = 'erro';
			}
		}
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id);
		$regimentos = RegimentoInterno::where('unidade_id', $id)->get();
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/organizacional/regimento_cadastro', compact('unidades','unidadesMenu','unidade','text','regimentos'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function regimentoNovo($id)
	{
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
	    for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id) {
				$validacao = 'ok';
			} else {
				$validacao = 'erro';
			}
		}
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id);
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/organizacional/regimento_novo', compact('unidades','unidadesMenu','unidade','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function regimentoExcluir($id, $id_escolha)
	{
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
	    for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id) {
				$validacao = 'ok';
			} else {
				$validacao = 'erro';
			}
		}
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade  = $this->unidade->find($id);
		$regimentos = RegimentoInterno::where('unidade_id', $id)->where('id',$id_escolha)->get();
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/organizacional/regimento_excluir', compact('unidades','unidadesMenu','unidade','text','regimentos'));
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
		$input = $request->all();
		$nome = $_FILES['file_path']['name']; 
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);

		if ( $request->file('file_path') === NULL ) {
			\Session::flash('mensagem', ['msg' => 'Informe o arquivo do Regimento Interno!','class'=>'green white-text']);		
			$text = true;
			return view('transparencia/organizacional/regimento_novo', compact('unidades','unidade','unidadesMenu','text'));
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
					return view('transparencia/organizacional/regimento_novo', compact('unidades','unidade','unidadesMenu','text'));
				} else {
					$nome = $_FILES['file_path']['name']; 
					$request->file('file_path')->move('../public/storage/regimento_interno/', $nome);		
					$input['file_path'] = 'regimento_interno/' .$nome;
					RegimentoInterno::create($input);
					$log = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$regimentos = RegimentoInterno::where('unidade_id', $id)->get();
					\Session::flash('mensagem', ['msg' => 'Regimento Interno cadastrado com sucesso!','class'=>'green white-text']);
					$text = true;
					return view('transparencia/organizacional/regimento_cadastro', compact('unidades','unidade','unidadesMenu','regimentos','lastUpdated','text'));
				}
			} else {
				\Session::flash('mensagem', ['msg' => 'Só é permitido arquivos: .pdf!','class'=>'green white-text']);		
				$text = true;
				return view('transparencia/organizacional/regimento_novo', compact('unidades','unidade','unidadesMenu','text'));				
			}
		}
    }

    public function destroy($id, $id_escolha, Request $request)
    {
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id);
		$input = $request->all();
		$nome = $input['file_path'];
		$pasta = 'public/'.$nome; 
		Storage::delete($pasta);
        RegimentoInterno::find($id_escolha)->delete();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$regimentos = RegimentoInterno::where('unidade_id', $id)->get();
		\Session::flash('mensagem', ['msg' => 'Regimento Interno excluído com sucesso!','class'=>'green white-text']);		
		$text = true;
		return view('transparencia/organizacional/regimento_cadastro', compact('unidades','unidade','unidadesMenu','regimentos','lastUpdated','text'));				
    }
}