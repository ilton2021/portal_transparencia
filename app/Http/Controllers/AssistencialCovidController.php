<?php

namespace App\Http\Controllers;

use App\Model\AssistencialCovid;
use Illuminate\Http\Request;
use App\Model\Unidade;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Storage;
use App\Model\PermissaoUsers;
use Auth;
use Illuminate\Support\Facades\DB;

class AssistencialCovidController extends Controller
{
    public function __construct(Unidade $unidade, AssistencialCovid $assistencialCovid, LoggerUsers $logger_users)
	{
		$this->unidade  	     = $unidade;
		$this->assistencialCovid = $assistencialCovid;
		$this->logger_users      = $logger_users;
	}

    public function index()
    {
        $unidades = $this->unidade->all();
		return view('transparencia.assistencialCovid', compact('unidades'));
    }

    public function assistencialCovidCadastro($id)
	{
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
		for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id && ($permissao_users[$i]->unidade_id == 8)) {
				$validacao = 'ok';
				break;
			} else {
				$validacao = 'erro';
			}
		}
		$unidadesMenu = $this->unidade->all();
		$unidades     = $unidadesMenu; 
		$unidade      = $this->unidade->find($id);
		$assistencialCovid = $this->assistencialCovid->all();
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/assistencialCovid/covid_cadastro', compact('unidade','unidades','unidadesMenu','assistencialCovid','text','permissao_users'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}

    public function assistencialCovidNovo($id)
	{
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
		for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id && ($permissao_users[$i]->unidade_id == 8)) {
				$validacao = 'ok';
				break;
			} else {
				$validacao = 'erro';
			}
		}
		$unidadesMenu = $this->unidade->all();
		$unidades     = $unidadesMenu; 
		$unidade      = $this->unidade->find($id);
		$text         = false;
		if($validacao == 'ok') {
			return view('transparencia/assistencialCovid/covid_novo', compact('unidade','unidades','unidadesMenu','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}

    public function assistencialCovidExcluir($id, $id_covid)
	{
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$qtd = sizeof($permissao_users);
		$validacao = '';
		for($i = 0; $i < $qtd; $i++) {
			if($permissao_users[$i]->user_id == Auth::user()->id && ($permissao_users[$i]->unidade_id == 8)) {
				$validacao = 'ok';
				break;
			} else {
				$validacao = 'erro';
			}
		}
		$unidadesMenu = $this->unidade->all();
		$unidades     = $unidadesMenu; 
		$unidade      = $this->unidade->find($id);
		$assistencialCovid = $this->assistencialCovid->find($id_covid);
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/assistencialCovid/covid_excluir', compact('unidade','unidades','unidadesMenu','assistencialCovid','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}

    public function store($id, Request $request)
    {
        $unidadesMenu = $this->unidade->all();
		$unidades     = $unidadesMenu; 
		$unidade      = $this->unidade->find($id);
		$assistencialCovid = $this->assistencialCovid->all();
		$input = $request->all();
		$nome  = $_FILES['file_path']['name']; 
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
			return view('transparencia/assistencialCovid/covid_novo', compact('unidade','unidades','unidadesMenu','assistencialCovid','text'));
		} else {
			if($request->file('file_path') === NULL) {
				\Session::flash('mensagem', ['msg' => 'Informe o arquivo do Assistencial Covid!','class'=>'green white-text']);		
				$text = true;
				return view('transparencia/assistencialCovid/covid_novo', compact('unidade','unidades','unidadesMenu','assistencialCovid','text'));
			} else {
				if($extensao === 'pdf') {
					$nome = $_FILES['file_path']['name']; 
                    $mes  = $input['mes'];
					$request->file('file_path')->move('../public/storage/assistencialCovid/'.$mes.'/', $nome);
					$input['file_path'] = 'assistencialCovid/'.$nome; 
				    $input['file_name'] = $nome;
                    $input['titulo']    = $input['name'];
					$assistencialCovid  = AssistencialCovid::create($input);
					$log = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$assistencialCovid = $this->assistencialCovid->all();
                    $permissao_users   = PermissaoUsers::where('unidade_id', $id)->get();
					\Session::flash('mensagem', ['msg' => 'Assistencial Covid cadastrado com sucesso!','class'=>'green white-text']);		
					$text = true;
					return view('transparencia/assistencialCovid/covid_cadastro', compact('unidade','unidades','unidadesMenu','lastUpdated','assistencialCovid','text','permissao_users'));
				} else {
					\Session::flash('mensagem', ['msg' => 'Só é permitido arquivos: .pdf!','class'=>'green white-text']);		
					$text = true;
					return view('transparencia/assistencialCovid/covid_novo', compact('unidade','unidades','unidadesMenu','assistencialCovid','text'));
				}
			}
		}
    }

    public function destroy($id, $id_covid, AssistencialCovid $assistencialCovid, Request $request)
    {
        AssistencialCovid::find($id_covid)->delete();
        $input = $request->all();
        $log   = LoggerUsers::create($input);
        $nome  = $input['path_file'];
        $pasta = 'public/'.$nome; 
        Storage::delete($pasta);
        $lastUpdated  = $log->max('updated_at');
        $unidadesMenu = $this->unidade->all();
        $unidades     = $unidadesMenu; 
        $unidade      = $this->unidade->find($id);
        $assistencialCovid = $this->assistencialCovid->all();
        \Session::flash('mensagem', ['msg' => 'Assistencial Covid excluído com sucesso!','class'=>'green white-text']);		
        $text = true;
        return view('transparencia/assistencialCovid/covid_cadastro', compact('unidade','unidades','unidadesMenu','lastUpdated','assistencialCovid','text'));
    }
}
