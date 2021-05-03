<?php

namespace App\Http\Controllers;

use App\Model\Organizational;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Model\Unidade;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Support\Facades\Schema;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Auth;
use App\Model\PermissaoUsers;
use Illuminate\Support\Facades\DB;

class OrganizationalController extends Controller
{
	protected $unidade;
	
    public function __construct(Unidade $unidade, Organizational $organizacional, LoggerUsers $logger_users)
    {
		$this->unidade 		  = $unidade;
		$this->organizacional = $organizacional;
		$this->logger_users   = $logger_users;
    }
	
    public function index()
    {
        $unidades = $this->unidade->all();
        return view('transparencia.organizacional', compact('unidades'));
    }
	
	public function organizacionalNovo($id)
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
			return view('transparencia/organizacional/organizacional_novo', compact('unidade','unidades','unidadesMenu','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function organizacionalValidar($id, $id_item)
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
		$estruturaOrganizacional = Organizational::find($id_item);
		DB::statement('UPDATE organizationals SET validar = 0 WHERE id = '.$id_item.';');		
		$estruturaOrganizacional = Organizational::where('unidade_id', $id)->get();
		if($validacao == 'ok') {
			\Session::flash('mensagem', ['msg' => 'Estrutura Organizacional validado com Sucesso!!','class'=>'green white-text']);		
			$text = true;
			return view('transparencia/organizacional/organizacional_cadastro', compact('unidade','unidades','unidadesMenu','text','estruturaOrganizacional'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
    public function store($id, Request $request, LoggerUsers $logger_users, Auth $auth)
    {
		$unidade = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->all();
		$estruturaOrganizacional = Organizational::where('unidade_id', $id)->get();
        if($unidade->id === 1){
            $lastUpdated = '2020-01-01 00:00:00';
        }else{
            $ultimaData = Organizational::where('unidade_id', $id)->where('updated_at','<=', Carbon::now() )->orderBy('updated_at', 'DESC')->first();
            $lastUpdated = '2020-01-01 00:00:00';
        }
		$v = \Validator::make($request->all(), [
				'name'  	 => 'required|min:10',
				'cargo' 	 => 'required|min:3',
				'email' 	 => 'required|email|unique:organizationals',
				'telefone' 	 => 'required|min:8'
		]);
		if ($v->fails()) {
			$failed = $v->failed();
			if ( !empty($failed['name']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo nome é obrigatório!','class'=>'green white-text']);		
			} else if ( !empty($failed['name']['Min']) ) { 
				\Session::flash('mensagem', ['msg' => 'O campo nome possui no mínimo 10 caracteres!','class'=>'green white-text']);		
			} else if ( !empty($failed['cargo']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo cargo é obrigatório!','class'=>'green white-text']);		
			} else if ( !empty($failed['cargo']['Min']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo cargo possui no mínimo 3 caracteres!','class'=>'green white-text']);		
			} else if ( !empty($failed['email']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo email é obrigatório!','class'=>'green white-text']);		
			} else if ( !empty($failed['email']['Email']) ) {
				\Session::flash('mensagem', ['msg' => 'Este E-mail é Inválido!','class'=>'green white-text']);		
			} else if ( !empty($failed['email']['Unique']) ) {
				\Session::flash('mensagem', ['msg' => 'Este E-mail já foi cadastrado!','class'=>'green white-text']);		
			} else if ( !empty($failed['telefone']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo telefone é obrigatório!','class'=>'green white-text']);		
			} else if ( !empty($failed['telefone']['Min']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo telefone possui no mínimo 8 caracteres!','class'=>'green white-text']);		
			} 
			$text = true;
			return view('transparencia/organizacional/organizacional_novo', compact('unidade','unidadesMenu','estruturaOrganizacional','text'));
		}else {
			$input = $request->all(); 
			$organizacional = Organizational::create($input); 			
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			\Session::flash('mensagem', ['msg' => 'Estrutura Organizacional Cadastrado com Sucesso!','class'=>'green white-text']);
			$text = true;
			$estruturaOrganizacional = Organizational::where('unidade_id', $id)->get();
			if($unidade->id === 1){
				$lastUpdated = '2020-01-01 00:00:00';
			}else{
				$ultimaData = Organizational::where('unidade_id', $id)->where('updated_at','<=', Carbon::now() )->orderBy('updated_at', 'DESC')->first();
				$lastUpdated = '2020-01-01 00:00:00';;
			}
			return view('transparencia/organizacional/organizacional_cadastro', compact('unidade','unidadesMenu','lastUpdated','estruturaOrganizacional','text'));
		}
    }

	public function organizacionalCadastro($id, Organizational $organizational)
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
		$estruturaOrganizacional = Organizational::where('unidade_id', $id)->get();
			if($unidade->id == 1 || $unidade->id == 9){
				$lastUpdated = '2020-07-01 00:00:00';
			}else{
				$ultimaData = Organizational::where('unidade_id', $id)->where('updated_at','<=', Carbon::now() )->orderBy('updated_at', 'DESC')->first();
				$lastUpdated = '2020-07-01 00:00:00';
			}
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/organizacional/organizacional_cadastro', compact('unidade','unidades','unidadesMenu','estruturaOrganizacional','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function organizacionalAlterar($id_item, $id_unidade)
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
		$unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id_unidade);				
		$organizacionals = Organizational::where('id', $id_item)->get();
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/organizacional/organizacional_alterar', compact('unidade','unidades','unidadesMenu','organizacionals','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function update($id_item, $id_unidade, Request $request)
    {	
		$unidadesMenu = $this->unidade->all();
		$unidades     = $this->unidade->all();
		$unidade = $unidadesMenu->find($id_unidade);
		$v = \Validator::make($request->all(), [
				'name'  	 => 'required|min:10',
				'cargo' 	 => 'required|min:3',
				'email' 	 => 'required|email',
				'telefone' 	 => 'required|min:8'
		]);		
		if ($v->fails()) {
			$failed = $v->failed();			
			if ( !empty($failed['name']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo nome é obrigatório!','class'=>'green white-text']);		
			} else if ( !empty($failed['name']['Min']) ) { 
				\Session::flash('mensagem', ['msg' => 'O campo nome possui no mínimo 10 caracteres!','class'=>'green white-text']);		
			} else if ( !empty($failed['cargo']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo cargo é obrigatório!','class'=>'green white-text']);		
			} else if ( !empty($failed['cargo']['Min']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo cargo possui no mínimo 3 caracteres!','class'=>'green white-text']);		
			} else if ( !empty($failed['email']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo email é obrigatório!','class'=>'green white-text']);		
			} else if ( !empty($failed['email']['Email']) ) {
				\Session::flash('mensagem', ['msg' => 'Este E-mail é Inválido!','class'=>'green white-text']);		
			} else if ( !empty($failed['telefone']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo telefone é obrigatório!','class'=>'green white-text']);		
			} else if ( !empty($failed['telefone']['Min']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo telefone possui no mínimo 8 caracteres!','class'=>'green white-text']);		
			} 
			$text = true;
			$organizacionals = Organizational::where('id', $id_item)->get();
			return view('transparencia/organizacional/organizacional_novo', compact('unidade','unidadesMenu','organizacionals','text'));
		} else {
			$input = $request->all();
			$organizacional = Organizational::find($id_item);
			$organizacional->update($input);			
			$log = LoggerUsers::create($input);
		    $lastUpdated = $log->max('updated_at');
			$estruturaOrganizacional = Organizational::where('unidade_id', $id_unidade)->get();
			\Session::flash('mensagem', ['msg' => 'Estrutura Organizacional Alterado com Sucesso!','class'=>'green white-text']);		
			$text = true;
			return view('transparencia/organizacional/organizacional_cadastro', compact('unidade','unidades','unidadesMenu','lastUpdated','estruturaOrganizacional','text'));	
		}
    }
	
	public function organograma($id)
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
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id);		
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/organizacional/organograma_cadastro', compact('unidade','unidades','unidadesMenu','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function organogramaNovo($id)
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
			return view('transparencia/organizacional/organograma_novo', compact('unidade','unidades','unidadesMenu','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function storeOrganograma($id, Request $request)
    {
        $unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id);
		$input = $request->all();
		
		if ( $request->file('file_path') === NULL ) {
			\Session::flash('mensagem', ['msg' => 'Informe o arquivo do Organograma!','class'=>'green white-text']);		
			$text = true;
			return view('transparencia/organizacional/organograma_novo', compact('unidades','unidade','unidadesMenu','text'));
		} else {
			if($request->file_path->extension() == 'pdf') {
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
					return view('transparencia/organizacional/organograma_novo', compact('unidades','unidade','unidadesMenu','text'));
				} else {
					$nome = $_FILES['file_path']['name']; 
					$request->file('file_path')->move('../public/storage/', $nome);
					$log = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					\Session::flash('mensagem', ['msg' => 'Organograma cadastrado com sucesso!','class'=>'green white-text']);
					$text = true;
					return view('transparencia/organizacional/organograma_cadastro', compact('unidades','unidade','unidadesMenu','lastUpdated','text'));
				}
			} else {
				\Session::flash('mensagem', ['msg' => 'Só é permitido arquivos: .pdf!','class'=>'green white-text']);		
				$text = true;
				return view('transparencia/organizacional/organograma_novo', compact('unidades','unidade','unidadesMenu','text'));				
			}
		}
    }
	
	public function organogramaExcluir($id)
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
			return view('transparencia/organizacional/organograma_excluir', compact('unidade','unidades','unidadesMenu','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function destroyOrganograma($id, Request $request)
    {
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id);
		$input = $request->all();
		$nome = 'organograma.pdf';
		$pasta = 'public/'.$nome;  
		Storage::delete($pasta);
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		\Session::flash('mensagem', ['msg' => 'Organograma excluído com sucesso!','class'=>'green white-text']);		
		$text = true;
		return view('transparencia/organizacional/organograma_cadastro', compact('unidades','unidade','unidadesMenu','lastUpdated','text'));				
    }

	public function organizacionalExcluir($id_item, $id_unidade)
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
		$unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id_unidade);		
		$organizacionals = new Organizational();
		$organizacionals = Organizational::where('id', $id_item)->get();		
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/organizacional/organizacional_excluir', compact('unidade','unidades','unidadesMenu','organizacionals','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
    public function destroy($id_item, $id_unidade, Organizational $organizational, Request $request)
    {
        Organizational::find($id_item)->delete();
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id_unidade);
		$estruturaOrganizacional = Organizational::where('unidade_id', $id_unidade)->get();
		$text = true;
		\Session::flash('mensagem', ['msg' => 'Estrutura Organizacional Excluído com Sucesso!','class'=>'green white-text']);			
		return view('transparencia/organizacional/organizacional_cadastro', compact('unidade','unidades','unidadesMenu','lastUpdated','estruturaOrganizacional','text'));		
    }
}