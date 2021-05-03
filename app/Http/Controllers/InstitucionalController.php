<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Unidade;
use App\Model\Institucional;
use App\Model\LoggerUsers;
use App\Model\PermissaoUsers;
use Auth;

class InstitucionalController extends Controller
{
	protected $unidade;
	
    public function __construct(Unidade $unidade, LoggerUsers $logger_users)
    {
		$this->unidade 		= $unidade;
		$this->logger_users = $logger_users;
    }

    public function index()
    {
		$unidades = $this->unidade->all();
        return view('home', compact('unidades'));
    }
	
	public function institucionalCadastro($id, Request $request)
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
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id);
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/institucional/institucional_cadastro', compact('unidade','unidades','unidadesMenu','text','permissao_users'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}

	public function institucionalNovo($id, Request $request)
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
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id);
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/institucional/institucional_novo', compact('unidade','unidades','unidadesMenu','text','permissao_users'));
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
		$unidade = $unidadesMenu->find($id);
		$input = $request->all();		
		$nome = $_FILES['path_img']['name']; 		
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);		
		$nomeI = $_FILES['icon_img']['name']; 		
		$extensaoI = pathinfo($nomeI, PATHINFO_EXTENSION);
		if(($request->file('path_img') === NULL) || ($request->file('icon_img') === NULL)) {	
			\Session::flash('mensagem', ['msg' => 'Insira um arquivo e um ícone!','class'=>'green white-text']);
			$text = true;
			return view('transparencia/institucional/institucional_novo', compact('unidade','unidades','unidadesMenu','true'));
		} else {
			if(($extensao == 'png' || $extensao == 'jpg') && ($extensaoI == 'png' || $extensaoI == 'jpg')) {
				$v = \Validator::make($request->all(), [
					'owner'       => 'required|max:255',
					'cnpj'        => 'required|max:18',
					'telefone'    => 'required|max:13',
					'cep' 	   	  => 'required|max:11',
					'google_maps' => 'required'
				]);
				if ($v->fails()) {
					$failed = $v->failed();
					if ( !empty($failed['owner']['Required']) ) {
						\Session::flash('mensagem', ['msg' => 'O campo perfil é obrigatório!','class'=>'green white-text']);
					} else if ( !empty($failed['owner']['Max']) ) { 
						\Session::flash('mensagem', ['msg' => 'O campo perfil possui no máximo 255 caracteres!','class'=>'green white-text']);
					} else if ( !empty($failed['cnpj']['Required']) ) {
						\Session::flash('mensagem', ['msg' => 'O campo cnpj é obrigatório!','class'=>'green white-text']);
					} else if ( !empty($failed['cnpj']['Max']) ) {
						\Session::flash('mensagem', ['msg' => 'Este CNPJ é inválido!','class'=>'green white-text']);
					} else if ( !empty($failed['telefone']['Required']) ) {
						\Session::flash('mensagem', ['msg' => 'O campo telefone é obrigatório!','class'=>'green white-text']);
					} else if ( !empty($failed['telefone']['Digits']) ) {
						\Session::flash('mensagem', ['msg' => 'O campo telefone possui no máximo 11 caracteres!','class'=>'green white-text']);
					} else if ( !empty($failed['cep']['Required']) ) {
						\Session::flash('mensagem', ['msg' => 'O campo cep é obrigatório!','class'=>'green white-text']);
					} else if ( !empty($failed['cep']['Max'] ) ) {
						\Session::flash('mensagem', ['msg' => 'O campo cep possui no máximo 11 caracteres!','class'=>'green white-text']);
					} else if ( !empty($failed['google_maps']['Required'] ) ) {
						\Session::flash('mensagem', ['msg' => 'O campo google maps é obrigatório!','class'=>'green white-text']);
					} 
					$text = true;
					return view('transparencia/institucional/institucional_novo', compact('unidade','unidades','unidadesMenu','text'));
				} else {
					$nome = $_FILES['path_img']['name']; 
					$input['path_img'] = $nome; 
					$nomeI = $_FILES['icon_img']['name'];
					$input['icon_img'] = $nomeI;
					$request->file('path_img')->move('../public/img', $nome);	
					$request->file('icon_img')->move('../public/img', $nomeI);		
					$unidade = Unidade::create($input);
					$log = LoggerUsers::create($input);	
					$lastUpdated = $log->max('updated_at');	
					\Session::flash('mensagem', ['msg' => 'Instituição Cadastrado com Sucesso!','class'=>'green white-text']);
					$text = true;
					return view('transparencia/institucional/institucional_cadastro', compact('unidade','unidades','unidadesMenu','lastUpdated','text'));
				}
			} else  {	
				\Session::flash('mensagem', ['msg' => 'Só é suportado arquivos: jpg ou png!','class'=>'green white-text']);
				$text = true;
				return view('transparencia/institucional/institucional_novo', compact('unidade','unidades','unidadesMenu','text'));
			}
		}		
	}

	public function institucionalAlterar($id, Request $request)
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
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id);
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/institucional/institucional_alterar', compact('unidade','unidades','unidadesMenu','text','permissao_users'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}

	public function update($id, Request $request)
	{
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $unidadesMenu->find($id);
		$input = $request->all();
		if(($request->file('path_img') === NULL) || ($request->file('icon_img') === NULL)) {
			$v = \Validator::make($request->all(), [
					'owner'    => 'required|max:255',
					'cnpj'     => 'required|max:18',
					'telefone' => 'required|max:13',
					'cep' 	   => 'required|max:10'
			]);
			if ($v->fails()) {
				$failed = $v->failed(); 
				if ( !empty($failed['owner']['Max']) ) { 
					\Session::flash('mensagem', ['msg' => 'O campo perfil possui no máximo 255 caracteres!','class'=>'green white-text']);
				} else if ( !empty($failed['cnpj']['Max']) ) {
					\Session::flash('mensagem', ['msg' => 'CNPJ inválido!','class'=>'green white-text']);
				} else if ( !empty($failed['telefone']['Digits']) ) {
					\Session::flash('mensagem', ['msg' => 'O campo telefone possui no máximo 11 caracteres!','class'=>'green white-text']);
				} else if ( !empty($failed['cep']['Max'] ) ) {
					\Session::flash('mensagem', ['msg' => 'O campo cep possui no máximo 9 caracteres!','class'=>'green white-text']);
				}
				$text = true;
				return view('transparencia/institucional/institucional_alterar', compact('unidade','unidades','unidadesMenu','text'));
			}
			if(!empty($input['path_img']) && !empty($input['icon_img'])){
				$unidade = Unidade::find($id);
				$unidade->update($input);
				$log = LoggerUsers::create($input);
				$lastUpdated = $log->max('updated_at');	
				\Session::flash('mensagem', ['msg' => 'Instituição Alterado com Sucesso!','class'=>'green white-text']);
				$permissao_users = PermissaoUsers::where('id', $id)->get();
				$text = true;
				return view('transparencia/institucional/institucional_cadastro', compact('unidade','unidades','lastUpdated','unidadesMenu','text','permissao_users'));
			} 
		} else {
			$unidade = Unidade::find($id);
			$unidade->update($input);
			$lastUpdated = $unidade->max('updated_at');	
			LoggerUsers::create($input);
			\Session::flash('mensagem', ['msg' => 'Instituição Alterado com Sucesso!','class'=>'green white-text']);
			$text = true;
			return view('transparencia/institucional/institucional_cadastro', compact('unidade','unidades','lastUpdated','unidadesMenu','text'));
		}
	}

	public function institucionalExcluir($id, Request $request)
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
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id);
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/institucional/institucional_excluir', compact('unidade','unidades','unidadesMenu','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}

	public function destroy($id, Unidade $unidade, Request $request)
	{ 
		$input = $request->all();
		$logers = LoggerUsers::where('unidade_id', $input['unidade_id'])->get();
		$qtdLog = sizeof($logers);
		if($qtdLog > 0) {
			for ( $i = 0; $i <= $qtdLog; $i++ ) {
				LoggerUsers::find($logers[$i]['id'])->delete();	
			}
		}		
		Unidade::find($id)->delete();		
		$unidadesMenu = $this->unidade->all();
		$unidades = $this->unidade->all();
		$lastUpdated = $unidades->max('updated_at');	
		$unidade = $unidadesMenu->find(1);		
		\Session::flash('mensagem', ['msg' => 'Instituição Excluído com Sucesso!','class'=>'green white-text']);
		$text = true;
		return view('transparencia/institucional/institucional_cadastro', compact('unidade','unidades','unidadesMenu','lastUpdated','text'));
	}
}