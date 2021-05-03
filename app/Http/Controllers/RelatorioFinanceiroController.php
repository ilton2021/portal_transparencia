<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\RelatorioFinanceiro;
use App\Model\Unidade;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Storage;
use App\Model\PermissaoUsers;
use Auth;
use Illuminate\Support\Facades\DB;

class RelatorioFinanceiroController extends Controller
{
    public function __construct(Unidade $unidade, RelatorioFinanceiro $relatorioFinanceiro, LoggerUsers $logger_users)
    {
        $this->unidade 			   = $unidade;
		$this->relatorioFinanceiro = $relatorioFinanceiro;
		$this->logger_users 	   = $logger_users;
    }
	
	public function index()
    {
		$unidades = $this->unidade->all();
		return view ('transparencia', compact('unidades'));
    }
	
	public function cadastroRelatorio($id)
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
		$relatorioFinanceiro = RelatorioFinanceiro::where('unidade_id', $id)->orderBy('ano','ASC')->get();
        $lastUpdated = $relatorioFinanceiro->max('updated_at');
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/relatorioFinanceiro/relatorio_cadastro', compact('unidade','unidades','unidadesMenu','relatorioFinanceiro','lastUpdated','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function relatorioNovo($id)
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
			return view('transparencia/relatorioFinanceiro/relatorio_novo', compact('unidade','unidades','unidadesMenu','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function relatorioExcluir($id, $id_rel)
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
		$relatorioFinanceiro = RelatorioFinanceiro::where('unidade_id', $id)->where('id',$id_rel)->get();
		$lastUpdated = $relatorioFinanceiro->max('updated_at');
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/relatorioFinanceiro/relatorio_excluir', compact('unidade','unidades','unidadesMenu','relatorioFinanceiro','lastUpdated','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function storeRelatorio($id_unidade, Request $request)
    { 
        $unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id_unidade);
		$relatorioFinanceiro = RelatorioFinanceiro::where('unidade_id', $id_unidade)->get();
        $lastUpdated = $relatorioFinanceiro->max('updated_at');
		$input = $request->all();
		$nome = $_FILES['file_path']['name']; 
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		if($request->file('file_path') === NULL) {	
			$text = true;
			\Session::flash('mensagem', ['msg' => 'Informe o arquivo do Relatório Financeiro!','class'=>'green white-text']);		
			return view('transparencia/relatorioFinanceiro/relatorio_novo', compact('unidades','unidade','unidadesMenu','relatorioFinanceiro','lastUpdated'));
		} else {
			if($extensao === 'pdf') {
				$v = \Validator::make($request->all(), [
					'title' => 'required|max:255',
					'ano'   => 'required'
				]);
				if ($input['ano'] < 1800 || $input['ano'] > 2500) {
					\Session::flash('mensagem', ['msg' => 'O campo ano é inválido!','class'=>'green white-text']);
					$text = true;
					return view('transparencia/relatorioFinanceiro/relatorio_novo', compact('unidades','unidade','unidadesMenu','relatorioFinanceiro','lastUpdated','text'));
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
					return view('transparencia/relatorioFinanceiro/relatorio_novo', compact('unidades','unidade','unidadesMenu','relatorioFinanceiro','lastUpdated','text'));
				}
				$ano  = $_POST['ano'];
				$qtdUnidades = sizeof($unidades);
				$nome = $_FILES['file_path']['name']; 				
				for ( $i = 1; $i <= $qtdUnidades; $i++ ) {
					if ( $unidade['id'] === $i ) {
						$txt1 = $unidades[$i-1]['path_img'];
						$txt1 = explode(".jpg", $txt1);		
						$request->file('file_path')->move('../public/storage/relatorioFinanceiro/'.$txt1[0].'/'.$ano.'/', $nome);
						$input['file_path'] = 'relatorioFinanceiro/'.$txt1[0].'/'.$ano.'/'.$nome; 	
					}
				}				
				$text = true;
				$relatorioFinanceiro = RelatorioFinanceiro::create($input);	
				$log = LoggerUsers::create($input);
				$lastUpdated = $log->max('updated_at');
				$relatorioFinanceiro = RelatorioFinanceiro::where('unidade_id',$id_unidade)->get();
				\Session::flash('mensagem', ['msg' => 'Relatório Financeiro cadastrado com sucesso!','class'=>'green white-text']);			
				return view('transparencia/relatorioFinanceiro/relatorio_cadastro', compact('unidades','unidade','unidadesMenu','relatorioFinanceiro','lastUpdated','text'));				
			} else {	
				\Session::flash('mensagem', ['msg' => 'Só suporta arquivos: pdf!','class'=>'green white-text']);			
				$text = true;
				$relatorioFinanceiro = RelatorioFinanceiro::where('unidade_id',$id_unidade)->get();
				$lastUpdated = $relatorioFinanceiro->max('updated_at');
				return view('transparencia/relatorioFinanceiro/relatorio_novo', compact('unidades','unidade','unidadesMenu','relatorioFinanceiro','lastUpdated','text'));
			}
		}
	}
		
		public function destroyRelatorio($id_unidade, $id_item, RelatorioFinanceiro $relatorioFinanceiro, Request $request)
		{
			RelatorioFinanceiro::find($id_item)->delete();		
			$input = $request->all();
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$nome = $input['file_path'];
			$pasta = 'public/'.$nome; 
			Storage::delete($pasta);
			$unidadesMenu = $this->unidade->all(); 
			$unidades = $this->unidade->all();
			$unidade = $unidadesMenu->find($id_unidade);		
			$relatorioFinanceiro = RelatorioFinanceiro::where('unidade_id',$id_unidade)->get();
			\Session::flash('mensagem', ['msg' => 'Relatório Financeiro excluído com sucesso!','class'=>'green white-text']);			
			$text = true;
			return view('transparencia/relatorioFinanceiro/relatorio_cadastro', compact('unidades','unidade','unidadesMenu','relatorioFinanceiro','lastUpdated','text'));
		}
}
