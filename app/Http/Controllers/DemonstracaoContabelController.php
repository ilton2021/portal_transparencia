<?php

namespace App\Http\Controllers;

use App\Model\DemonstracaoContabel;
use App\Model\Unidade;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Storage;
use App\Model\PermissaoUsers;
use Auth;
use Illuminate\Support\Facades\DB;

class DemonstracaoContabelController extends Controller
{
	public function __construct(Unidade $unidade, DemonstracaoContabel $demonstracaoContabel, LoggerUsers $logger_users)
    {
        $this->unidade 				= $unidade;
		$this->demonstracaoContabel = $demonstracaoContabel;
		$this->logger_users 		= $logger_users;
    }
	
    public function index()
    {
		$unidades = $this->unidade->all();
		return view ('transparencia', compact('unidades'));
    }

    public function demonstrativoContCadastro($id)
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
		$demonstrativoContaveis = DemonstracaoContabel::where('unidade_id', $id)->get();
        $lastUpdated = $demonstrativoContaveis->max('updated_at');
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/demonstrativo-contabel/accountable_cadastro', compact('unidade','unidades','unidadesMenu','demonstrativoContaveis','lastUpdated','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function demonstrativoContNovo($id)
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
		$contabilReports = DemonstracaoContabel::where('unidade_id', $id)->get();
        $lastUpdated = $contabilReports->max('updated_at');
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/demonstrativo-contabel/accountable_novo', compact('unidade','unidades','unidadesMenu','contabilReports','lastUpdated','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function demonstrativoContAlterar($id_unidade, $id_item)
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
		$unidade = $unidadesMenu->find($id_unidade);
		$contabilReports = DemonstracaoContabel::where('id', $id_item)->get(); 
        $lastUpdated = $contabilReports->max('updated_at');
		$text = false;
		if($validacao == 'ok') {
		    return view('transparencia/demonstrativo-contabel/accountable_alterar', compact('unidade','unidades','unidadesMenu','contabilReports','lastUpdated','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function demonstrativoContValidar($id_unidade, $id_item)
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
		$contabilReports = DemonstracaoContabel::find($id_item);
		DB::statement('UPDATE demonstracao_contabels SET validar = 0 WHERE id = '.$id_item.';');
		$demonstrativoContaveis = DemonstracaoContabel::where('unidade_id', $id_unidade)->get();
        $lastUpdated = $demonstrativoContaveis->max('updated_at');
		if($validacao == 'ok') {
			\Session::flash('mensagem', ['msg' => 'Demonstração Contábel validado com Sucesso!!','class'=>'green white-text']);		
			$text = true;
		    return view('transparencia/demonstrativo-contabel/accountable_cadastro', compact('unidade','unidades','unidadesMenu','contabilReports','lastUpdated','text','demonstrativoContaveis'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function demonstrativoContExcluir($id_unidade, $id_item)
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
		$demonstrativoContaveis = DemonstracaoContabel::where('id',$id_item)->get();
		$lastUpdated = $demonstrativoContaveis->max('updated_at');	
		$text = false;
		if($validacao == 'ok') {
		    return view('transparencia/demonstrativo-contabel/accountable_excluir', compact('unidade','unidades','unidadesMenu','demonstrativoContaveis','lastUpdated','text'));
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
		$contabilReports = DemonstracaoContabel::where('unidade_id', $id_unidade)->get();
        $lastUpdated = $contabilReports->max('updated_at');
		$input = $request->all();
		$nome = $_FILES['file_path']['name']; 
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		if($request->file('file_path') === NULL) {	
			$text = true;
			\Session::flash('mensagem', ['msg' => 'Informe o arquivo do Demonstrativo!','class'=>'green white-text']);		
			return view('transparencia/demonstrativo-contabel/accountable_novo', compact('unidades','unidade','unidadesMenu','contabilReports','lastUpdated'));
		} else {
			if($extensao === 'pdf') {
				$v = \Validator::make($request->all(), [
					'title' => 'required|max:255',
					'ano'   => 'required'
				]);
				if ($input['ano'] < 1800 || $input['ano'] > 2500) {
					\Session::flash('mensagem', ['msg' => 'O campo ano é inválido!','class'=>'green white-text']);
					$text = true;
					return view('transparencia/demonstrativo-contabel/accountable_novo', compact('unidades','unidade','unidadesMenu','contabilReports','lastUpdated','text'));
				}		
				if ($v->fails()) {
					$failed = $v->failed();
					if ( !empty($failed['title']['Required']) ) {
						\Session::flash('mensagem', ['msg' => 'O campo título é obrigatório!','class'=>'green white-text']);
					} else if ( !empty($failed['title']['Max']) ) {
						\Session::flash('mensagem', ['msg' => 'O campo título possui no máximo 255 caracteres!','class'=>'green white-text']);
					} else if ( !empty($failed['ano']['Required']) ) {	
						\Session::flash('mensagem', ['msg' => 'O campo ano é obrigatório!','class'=>'green white-text']);
					}
					$text = true;
					return view('transparencia/demonstrativo-contabel/accountable_novo', compact('unidades','unidade','unidadesMenu','contabilReports','lastUpdated','text'));
				}
				$ano  = $_POST['ano'];
				$qtdUnidades = sizeof($unidades);
				$nome = $_FILES['file_path']['name']; 				
				for ( $i = 1; $i <= $qtdUnidades; $i++ ) {
					if ( $unidade['id'] === $i ) {
						$txt1 = $unidades[$i-1]['path_img'];
						$txt1 = explode(".jpg", $txt1);		
						$request->file('file_path')->move('../public/storage/demonstrativo-contabel/'.$txt1[0].'/'.$ano.'/', $nome);
						$input['file_path'] = 'demonstrativo-contabel/'.$txt1[0].'/'.$ano.'/'.$nome; 	
					}
				}				
				$text = true;
				$demonstrativo = DemonstracaoContabel::create($input);	
				$log = LoggerUsers::create($input);
				$lastUpdated = $log->max('updated_at');
				$demonstrativoContaveis = DemonstracaoContabel::where('unidade_id',$id_unidade)->get();
				\Session::flash('mensagem', ['msg' => 'Demonstrativo Contábil cadastrado com sucesso!','class'=>'green white-text']);			
				return view('transparencia/demonstrativo-contabel/accountable_cadastro', compact('unidades','unidade','unidadesMenu','demonstrativoContaveis','lastUpdated','text'));				
			} else {	
				\Session::flash('mensagem', ['msg' => 'Só suporta arquivos: pdf!','class'=>'green white-text']);			
				$text = true;
				$demonstrativoContaveis = DemonstracaoContabel::where('unidade_id',$id_unidade)->get();
				$lastUpdated = $demonstrativoContaveis->max('updated_at');
				return view('transparencia/demonstrativo-contabel/accountable_novo', compact('unidades','unidade','unidadesMenu','demonstrativoContaveis','lastUpdated','text'));
			}
		}
    }
	
    public function update($id_unidade, $id_item, Request $request, DemonstracaoContabel $demonstracaoContabel)
    {
        $unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id_unidade);		
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$demonstrativoContaveis = DemonstracaoContabel::where('unidade_id',$id_unidade)->get();
		$text = true;
		return view('transparencia/demonstrativo-contabel/accountable_cadastro', compact('unidades','unidade','unidadesMenu','demonstrativoContaveis','lastUpdated','text'));
    }

    public function destroy($id_unidade, $id_item, DemonstracaoContabel $demonstracaoContabel, Request $request)
    {
		DemonstracaoContabel::find($id_item)->delete();		
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$nome = $input['file_path'];
		$pasta = 'public/'.$nome; 
		Storage::delete($pasta);
        $unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id_unidade);		
		$demonstrativoContaveis = DemonstracaoContabel::where('unidade_id',$id_unidade)->get();
		\Session::flash('mensagem', ['msg' => 'Demonstrativo Contábil excluído com sucesso!','class'=>'green white-text']);			
		$text = true;
		return view('transparencia/demonstrativo-contabel/accountable_cadastro', compact('unidades','unidade','unidadesMenu','demonstrativoContaveis','lastUpdated','text'));
    }
}