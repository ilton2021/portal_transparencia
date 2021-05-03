<?php

namespace App\Http\Controllers;

use App\Model\DemonstrativoFinanceiro;
use App\Model\Unidade;
use App\Model\LoggerUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Model\PermissaoUsers;
use Auth;
use Illuminate\Support\Facades\DB;

class DemonstrativoFinanceiroController extends Controller
{
	public function __construct(Unidade $unidade, DemonstrativoFinanceiro $demonstrativoFinanceiro, LoggerUsers $logger_users)
    {
        $this->unidade 				   = $unidade;
		$this->demonstrativoFinanceiro = $demonstrativoFinanceiro;
		$this->logger_users 		   = $logger_users;
    }
	
    public function index()
    {
		$unidades = $this->unidade->all();
		return view ('demonstrativoFinanceiro', compact('unidades'));
    }

    public function demonstrativoFinanCadastro($id)
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
		$financialReports = DemonstrativoFinanceiro::where('unidade_id', $id)->get();
        $lastUpdated = $financialReports->max('updated_at');	
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/demonstrativo-financeiro/demonstrativo_cadastro', compact('unidade','unidades','unidadesMenu', 'financialReports','lastUpdated','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function demonstrativoFinanNovo($id)
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
		$financialReports = DemonstrativoFinanceiro::where('unidade_id', $id)->get();
        $lastUpdated = $financialReports->max('updated_at');
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/demonstrativo-financeiro/demonstrativo_novo', compact('unidade','unidades','unidadesMenu', 'financialReports','lastUpdated','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function demonstrativoFinanValidar($id, $id_item)
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
		$financialReports = DemonstrativoFinanceiro::find($id_item);
		DB::statement('UPDATE financial_reports SET validar = 0 WHERE id = '.$id_item.';');
		$financialReports = DemonstrativoFinanceiro::where('unidade_id', $id)->get();
        $lastUpdated = $financialReports->max('updated_at');
		if($validacao == 'ok') {
			\Session::flash('mensagem', ['msg' => 'Demonstrativo Financeiro validado com Sucesso!!','class'=>'green white-text']);		
			$text = true;
			return view('transparencia/demonstrativo-financeiro/demonstrativo_cadastro', compact('unidade','unidades','unidadesMenu', 'financialReports','lastUpdated','text','permissao_users'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function demonstrativoFinanAlterar($id_unidade, $id_item)
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
		$financialReports = DemonstrativoFinanceiro::where('id', $id_item)->get(); 
        $lastUpdated = $financialReports->max('updated_at');
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/demonstrativo-financeiro/demonstrativo_alterar', compact('unidade','unidades','unidadesMenu', 'financialReports','lastUpdated','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function demonstrativoFinanExcluir($id_unidade, $id_item)
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
		$financialReports = DemonstrativoFinanceiro::where('id', $id_item)->get();
        $lastUpdated = $financialReports->max('updated_at');
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/demonstrativo-financeiro/demonstrativo_excluir', compact('unidade','unidades','unidadesMenu', 'financialReports','lastUpdated','text'));
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
		$financialReports = DemonstrativoFinanceiro::where('unidade_id', $id_unidade)->get();
        $input = $request->all();
		$nome = $_FILES['file_path']['name']; 
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		$mes = $input['mes'];
		$ano = $input['ano'];
		$financialR = DemonstrativoFinanceiro::where('unidade_id', $id_unidade)->where('mes', $mes)->where('ano',$ano)->get();
		$qtd = sizeof($financialR);
		if ($qtd > 0) {
			$text = true;
			\Session::flash('mensagem', ['msg' => 'O Relatório correspondente a este mês e ano já foi cadastrado!','class'=>'green white-text']);		
			return view('transparencia/demonstrativo-financeiro/demonstrativo_novo', compact('unidades','unidade','unidadesMenu','financialReports','lastUpdated','text'));
		}
		if($request->file('file_path') === NULL) {	
			$text = true;
			\Session::flash('mensagem', ['msg' => 'Informe o arquivo do Demonstrativo!','class'=>'green white-text']);		
			return view('transparencia/demonstrativo-financeiro/demonstrativo_novo', compact('unidades','unidade','unidadesMenu','financialReports','lastUpdated','text'));
		} else {
			if($extensao === 'pdf') {
				$v = \Validator::make($request->all(), [
					'title' => 'required',
					'mes' => 'required|numeric',
					'ano' => 'required|numeric'
				]);
				if ($input['ano'] < 1800 || $input['ano'] > 2500) {
					\Session::flash('mensagem', ['msg' => 'O campo ano é inválido!','class'=>'green white-text']);
					$text = true;
					return view('transparencia/demonstrativo-financeiro/demonstrativo_novo', compact('unidades','unidade','unidadesMenu','financialReports','lastUpdated','text'));
				}
				if ($v->fails()) {
					$failed = $v->failed();
					if ( !empty($failed['title']['Required']) ) {
						\Session::flash('mensagem', ['msg' => 'O campo título é obrigatório!','class'=>'green white-text']);
					} else if ( !empty($failed['mes']['Required']) ) {
						\Session::flash('mensagem', ['msg' => 'O campo mês é obrigatório!','class'=>'green white-text']);
					} else if ( !empty($failed['mes']['Numeric']) ) {
						\Session::flash('mensagem', ['msg' => 'O campo mês é numérico!','class'=>'green white-text']);
					} else if ( !empty($failed['ano']['Required']) ) {	
						\Session::flash('mensagem', ['msg' => 'O campo ano é obrigatório!','class'=>'green white-text']);
					} else if ( !empty($failed['ano']['Numeric']) ) {
						\Session::flash('mensagem', ['msg' => 'O campo ano é numérico!','class'=>'green white-text']);
					}
					$text = true;
					return view('transparencia/demonstrativo-financeiro/demonstrativo_novo', compact('unidades','unidade','unidadesMenu','financialReports','lastUpdated','text'));
				}
				$ano  = $_POST['ano'];
				$mes  = $_POST['mes'];
				$qtdUnidades = sizeof($unidades); 
				for ( $i = 1; $i <= $qtdUnidades; $i++ ) { 				
					if ($unidade['id'] === $i) { 
						$txt1 = $unidades[$i-1]['path_img'];
						$txt1 = explode(".jpg", $txt1); 
						$txt2 = strtoupper($txt1[0]);								
						$nome = $mes .'.relat-mensal-finan-' .$ano. '-'.$txt2.'.pdf';
						$upload = $request->file('file_path')->move('../public/storage/relatorio-mensal-financeiro/'.$txt1[0].'/'.$ano.'/', $nome);
						$input['file_path'] = 'relatorio-mensal-financeiro/'.$txt1[0].'/'.$ano.'/'.$nome; 
					}
				}
				$demonstrativo = DemonstrativoFinanceiro::create($input);	
				$log = LoggerUsers::create($input);
				$lastUpdated = $log->max('updated_at');						
				$financialReports = DemonstrativoFinanceiro::where('unidade_id', $id_unidade)->orderBy('ano', 'ASC')->get();
				$text = true;
			    \Session::flash('mensagem', ['msg' => 'Demonstrativo Financeiro cadastrado com sucesso!','class'=>'green white-text']);			
				return view('transparencia/demonstrativo-financeiro/demonstrativo_cadastro', compact('unidades','unidade','unidadesMenu','financialReports','lastUpdated','text'));	
			} else {	
				\Session::flash('mensagem', ['msg' => 'Só suporta arquivos: pdf!','class'=>'green white-text']);			
				$text = true;
				return view('transparencia/demonstrativo-financeiro/demonstrativo_novo', compact('unidades','unidade','unidadesMenu','financialReports','lastUpdated','text'));
			}
		}
    }
	
    public function update($id_unidade, $id_item, Request $request, DemonstrativoFinanceiro $demonstrativoFinanceiro)
    {
        $unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $unidadesMenu->find($id_unidade);	
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$financialReports = DemonstrativoFinanceiro::where('unidade_id', $id_unidade)->get();
		$text = true;
		\Session::flash('mensagem', ['msg' => 'Demonstrativo Financeiro alterado com sucesso!','class'=>'green white-text']);			
		return view('transparencia/demonstrativo-financeiro/demonstrativo_cadastro', compact('unidades','unidade','unidadesMenu','financialReports','lastUpdated','text'));
    }

    public function destroy($id_unidade, $id_item, Request $request)
    {
		DemonstrativoFinanceiro::find($id_item)->delete();
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$nome = $input['file_path'];
		$pasta = 'public/'.$nome; 
		Storage::delete($pasta);
        $unidadesMenu = $this->unidade->all(); 
		$unidades = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);	
		$financialReports = DemonstrativoFinanceiro::where('unidade_id', $id_unidade)->orderBy('ano', 'ASC')->get();
		$text = true;
		\Session::flash('mensagem', ['msg' => 'Demonstrativo Financeiro excluído com sucesso!','class'=>'green white-text']);			
		return view('transparencia/demonstrativo-financeiro/demonstrativo_cadastro', compact('unidades','unidade','unidadesMenu','financialReports','lastUpdated','text'));
    }
}