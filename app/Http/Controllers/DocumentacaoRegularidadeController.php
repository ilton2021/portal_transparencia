<?php

namespace App\Http\Controllers;

use App\Model\DocumentacaoRegularidade;
use App\Model\Unidade;
use App\Model\Type;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Storage;
use App\Model\PermissaoUsers;
use Auth;
use Illuminate\Support\Facades\DB;

class DocumentacaoRegularidadeController extends Controller
{
	public function __construct(Unidade $unidade, DocumentacaoRegularidade $docRegularidade, LoggerUsers $logger_users)
	{
		$this->unidade = $unidade;
		$this->documentacaoRegularidade = $docRegularidade; 
		$this->logger_users = $logger_users;
	}

    public function index()
    {
        $unidade = $this->unidade->all();
		return view('transparencia.documentos', compact('unidade'));
    }

	public function documentosCadastro($id)
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
		$unidades = $this->unidade->all();
		$unidadesMenu = $unidades;
		$unidade = $this->unidade->find($id);
		$documents = DocumentacaoRegularidade::all();
		$lastUpdated = $documents->max('updated_at');
		$types = Type::all();
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/documento/documentos_cadastro', compact('unidade','unidadesMenu','unidades','documents','types','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}

	public function documentosNovo($id)
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
		$unidades = $this->unidade->all();
		$unidadesMenu = $unidades;
		$unidade = $this->unidade->find($id);
		$types = Type::all();
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/documento/documentos_novo', compact('unidade','unidadesMenu','unidades','types','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function documentosValidar($id, $id_item)
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
		$unidades = $this->unidade->all();
		$unidadesMenu = $unidades;
		$unidade = $this->unidade->find($id);
		$types = Type::all();
		$documents = DocumentacaoRegularidade::find($id_item);
		DB::statement('UPDATE documentacao_regularidades SET validar = 0 WHERE id = '.$id_item.';');
		$documents = DocumentacaoRegularidade::where('unidade_id', $id)->get();
        $lastUpdated = $documents->max('updated_at');
		if($validacao == 'ok') {
			\Session::flash('mensagem', ['msg' => 'Documento de Regularidade validado com Sucesso!!','class'=>'green white-text']);		
			$text = true;
			return view('transparencia/documento/documentos_cadastro', compact('unidade','unidadesMenu','unidades','types','text','documents','permissao_users'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}

	public function documentosExcluir($id, $id_escolha)
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
		$unidades = $this->unidade->all();
		$unidadesMenu = $unidades;
		$unidade = $this->unidade->find($id);
		$types = Type::all();
		$documents = DocumentacaoRegularidade::find($id_escolha);
		$lastUpdated = $documents->max('updated_at');
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/documento/documentos_excluir', compact('unidade','unidadesMenu','unidades','documents','types','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}

    public function store($id, Request $request)
    { 
        $unidades = $this->unidade->all();
		$unidadesMenu = $unidades;
		$unidade = $this->unidade->find($id);
		$types = Type::all();
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
			return view('transparencia/documento/documentos_novo', compact('unidade','unidadesMenu','unidades','types','text'));
		} else {
			if($request->file('path_file') === NULL) {	
				\Session::flash('mensagem', ['msg' => 'Informe um arquivo para o Documento de Regularidade!','class'=>'green white-text']);
				$text = true;
				return view('transparencia/documento/documentos_novo', compact('unidade','unidadesMenu','unidades','types','text'));
			} else {
				if($extensao === 'pdf') {
					$nome = $_FILES['path_file']['name'];
					$request->file('path_file')->move('../public/storage/documento_regularidade/', $nome);	
					$input['path_file'] = 'documento_regularidade/'.$nome;
					DocumentacaoRegularidade::create($input);		
					$log = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$documents = DocumentacaoRegularidade::all();	
					\Session::flash('mensagem', ['msg' => 'Documento de Regularidade cadastrado com sucesso!','class'=>'green white-text']);
					$text = true;
					return view('transparencia/documento/documentos_cadastro', compact('unidade','unidadesMenu','unidades','documents','lastUpdated','types','text'));			
				} else {
					\Session::flash('mensagem', ['msg' => 'Só é permitido arquivos: .pdf!','class'=>'green white-text']);
					$text = true;
					return view('transparencia/documento/documentos_novo', compact('unidade','unidadesMenu','unidades','types','text'));			
				}
			}
		}
    }

    public function destroy($id, $id_escolha, DocumentacaoRegularidade $documentacaoRegularidade, Request $request)
    {
		DocumentacaoRegularidade::find($id_escolha)->delete();
		$input = $request->all();
		$nome = $input['path_file'];
		$pasta = 'public/'.$nome; 
		Storage::delete($pasta);
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
        $unidades = $this->unidade->all();
		$unidadesMenu = $unidades;
		$unidade = $this->unidade->find($id);
		$types = Type::all();
		$documents = DocumentacaoRegularidade::all();
		\Session::flash('mensagem', ['msg' => 'Documento de Regularidade excluído com sucesso!','class'=>'green white-text']);
		$text = true;
		return view('transparencia/documento/documentos_cadastro', compact('unidade','unidadesMenu','unidades','documents','lastUpdated','types','text'));			
    }
}