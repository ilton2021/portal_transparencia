<?php

namespace App\Http\Controllers;

use App\Model\RelatorioGerencial;
use App\Model\PermissaoUsers;
use Illuminate\Http\Request;
use App\Model\Unidade;
use App\Model\LoggerUsers;
use Auth;
use Illuminate\Support\Facades\DB;

class RelatorioGerencialController extends Controller
{
	public function __construct(Unidade $unidade, RelatorioGerencial $relatorio_gerencial, LoggerUsers $logger_users)
	{
		$this->unidade 		= $unidade;
		$this->relatorio_gerencial  = $relatorio_gerencial;
		$this->logger_users = $logger_users;
	}
	
    public function cadastroRelGerencial($id_unidade)
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
		$demonstrativoContaveis = RelatorioGerencial::where('unidade_id', $id_unidade)->orderBy('mes', 'ASC')->get();
        $lastUpdated = $demonstrativoContaveis->max('updated_at');
		$text = false;	
		if($validacao == 'ok') {
			return view('transparencia/relatorioGerencial/relatorio_gerencial_cadastro', compact('unidade','unidades','unidadesMenu','demonstrativoContaveis','lastUpdated','text','permissao_users'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function relatorioGerencialNovo($id_unidade)
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
		$competenciasMatriz = RelatorioGerencial::where('unidade_id', $id_unidade)->get();
        $lastUpdated = $competenciasMatriz->max('updated_at');
		$text = false;	
		if($validacao == 'ok') {
			return view('transparencia/relatorioGerencial/relatorio_gerencial_novo', compact('unidade','unidades','unidadesMenu','competenciasMatriz','lastUpdated','text','permissao_users'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function storeRelatorioG($id_unidade, Request $request)
	{ 	
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$demonstrativoContaveis = RelatorioGerencial::where('unidade_id',$id_unidade)->get();
        $lastUpdated = $demonstrativoContaveis->max('updated_at');
		$input = $request->all();
		$nome = $_FILES['file_path']['name']; 
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		if($input['ano'] < 1800){
			\Session::flash('mensagem', ['msg' => 'Ano Inválido!','class'=>'green white-text']);		
			$text = true;
			return view('transparencia/relatorioGerencial/relatorio_gerencial_novo', compact('unidades','unidade','unidadesMenu','demonstrativoContaveis','lastUpdated','text'));
		} else if($input['ano'] > 2500){
			\Session::flash('mensagem', ['msg' => 'Ano Inválido!','class'=>'green white-text']);		
			$text = true;
			return view('transparencia/relatorioGerencial/relatorio_gerencial_novo', compact('unidades','unidade','unidadesMenu','demonstrativoContaveis','lastUpdated','text'));
		}
		if($request->file('file_path') === NULL) {	
			\Session::flash('mensagem', ['msg' => 'Informe o arquivo do Relatório Mensal de Execução!','class'=>'green white-text']);		
			$text = true;
			return view('transparencia/relatorioGerencial/relatorio_gerencial_novo', compact('unidades','unidade','unidadesMenu','demonstrativoContaveis','lastUpdated','text'));
		} else {
			if($extensao === 'pdf') {
				$v = \Validator::make($request->all(), [
					'title' => 'required|max:255',
					'ano'   => 'required|max:4'
				]);
				if ($v->fails()) {
					$failed = $v->failed();
					if ( !empty($failed['title']['Required']) ) {
						\Session::flash('mensagem', ['msg' => 'O campo título é obrigatório!','class'=>'green white-text']);
					} else if ( !empty($failed['title']['Max']) ) { 
						\Session::flash('mensagem', ['msg' => 'O campo título possui no máximo 255 caracteres!','class'=>'green white-text']);
					} else if ( !empty($failed['ano']['Required']) ) { 
						\Session::flash('mensagem', ['msg' => 'O campo ano é obrigatório!','class'=>'green white-text']);
					} else if ( !empty($failed['ano']['Max']) ) { 
						\Session::flash('mensagem', ['msg' => 'O campo ano possui no máximo 4 caracteres!','class'=>'green white-text']);
					}
					$text = true;
					return view('transparencia/relatorioGerencial/relatorio_gerencial_novo', compact('unidades','unidade','unidadesMenu','demonstrativoContaveis','lastUpdated','text'));
				} else {
					$nome = $_FILES['file_path']['name']; 					
					$request->file('file_path')->move('../public/storage/relatorio_gerencial/', $nome);
					$input['file_path'] = 'relatorio_gerencial/' .$nome; 
					$demonstrativoContaveis = RelatorioGerencial::create($input);
					$log = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$demonstrativoContaveis = RelatorioGerencial::where('unidade_id',$id_unidade)->get();
					\Session::flash('mensagem', ['msg' => 'Relatório Mensal de Execução cadastrado com sucesso!','class'=>'green white-text']);
					$text = true;
					$permissao_users = PermissaoUsers::where('unidade_id', $id_unidade)->get();
					return view('transparencia/relatorioGerencial/relatorio_gerencial_cadastro', compact('unidades','unidade','unidadesMenu','demonstrativoContaveis','lastUpdated','text','permissao_users'));
				}
			} else {	
				\Session::flash('mensagem', ['msg' => 'Só é suportado arquivos: pdf!','class'=>'green white-text']);		
				$text = true;
				return view('transparencia/relatorioGerencial/relatorio_gerencial_novo', compact('unidades','unidade','unidadesMenu','demonstrativoContaveis','lastUpdated','text'));
			}
		}
	}
	
	public function relatorioGerencialExcluir($id_unidade, $id_rel)
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
		$demonstrativoContaveis = RelatorioGerencial::where('id', $id_rel)->get();
        $lastUpdated = $demonstrativoContaveis->max('updated_at');
		$text = false;	
		if($validacao == 'ok') {
			return view('transparencia/relatorioGerencial/relatorio_gerencial_excluir', compact('unidade','unidades','unidadesMenu','demonstrativoContaveis','lastUpdated','text','permissao_users'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function destroy($id_unidade, $id_rel, Request $request)
	{ 	
		RelatorioGerencial::find($id_rel)->delete();  
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$unidades = new Unidade();
		$unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade = $this->unidade->find($id_unidade);
		$demonstrativoContaveis = RelatorioGerencial::all();
		$text = true;
		\Session::flash('mensagem', ['msg' => 'Relatório Mensal de Execução excluído com sucesso!','class'=>'green white-text']);
		return view('transparencia/relatorioGerencial/relatorio_gerencial_cadastro', compact('unidades','unidadesMenu','lastUpdated','unidade','demonstrativoContaveis','text'));
	}
}
