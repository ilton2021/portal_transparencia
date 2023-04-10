<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\RelatorioFinanceiro;
use App\Model\Unidade;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\PermissaoUsersController;
use App\Model\PermissaoUsers;
use Auth;
use Illuminate\Support\Facades\DB;
use Validator;

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
	
	public function cadastroRF($id, Request $request)
	{
		$validacao 	  = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);	
		$relatorioFinanceiro = RelatorioFinanceiro::where('unidade_id',$id)->orderBy('ano','ASC')->get();
        $lastUpdated  = $relatorioFinanceiro->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/relatorioFinanceiro/relatorio_cadastro', compact('unidade','unidades','unidadesMenu','relatorioFinanceiro','lastUpdated'));
		} else {
			$validator = 'Você não tem permissão';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		}
	}
	
	public function novoRF($id, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);	
		if($validacao == 'ok') {
			return view('transparencia/relatorioFinanceiro/relatorio_novo', compact('unidade','unidades','unidadesMenu'));
		} else {
			$validator = 'Você não tem permissão';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}
	
	public function excluirRF($id, $id_rel, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$relatorioFinanceiro = RelatorioFinanceiro::where('unidade_id', $id)->where('id',$id_rel)->get();
		$lastUpdated 		 = $relatorioFinanceiro->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/relatorioFinanceiro/relatorio_excluir', compact('unidade','unidades','unidadesMenu','relatorioFinanceiro','lastUpdated'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		}
	}
	
	public function telaInativarRF($id, $id_rel, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$relatorioFinanceiro = RelatorioFinanceiro::where('unidade_id', $id)->where('id',$id_rel)->get();
		$lastUpdated 		 = $relatorioFinanceiro->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/relatorioFinanceiro/relatorio_inativar', compact('unidade','unidades','unidadesMenu','relatorioFinanceiro','lastUpdated'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		}
	}
	
	public function storeRF($id_unidade, Request $request)
    { 
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$relatorioFinanceiro = RelatorioFinanceiro::where('unidade_id', $id_unidade)->get();
        $lastUpdated = $relatorioFinanceiro->max('updated_at');
		$input 		 = $request->all();
		$nome 		 = $_FILES['file_path']['name']; 
		$extensao 	 = pathinfo($nome, PATHINFO_EXTENSION);
		if($request->file('file_path') === NULL) {	
			$validator = 'Informe o arquivo do Relatório financeiro!';
			return view('transparencia/relatorioFinanceiro/relatorio_novo', compact('unidades','unidade','unidadesMenu','relatorioFinanceiro','lastUpdated'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
		    $extensao = strtolower($extensao);
			if($extensao === 'pdf') {
				$validator = Validator::make($request->all(), [
					'title' => 'required|max:255',
					'ano'   => 'required'
				]);
				if ($input['ano'] < 1800 || $input['ano'] > 2500) {
					$validator = 'O campo ano é inválido';
					return view('transparencia/relatorioFinanceiro/relatorio_novo', compact('unidades','unidade','unidadesMenu','relatorioFinanceiro','lastUpdated'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				}		
				if ($validator->fails()) {
					$failed    = $validator->failed();
					$validator = 'Preencha todos os campos corretamente!';
					return view('transparencia/relatorioFinanceiro/relatorio_novo', compact('unidades','unidade','unidadesMenu','relatorioFinanceiro','lastUpdated'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
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
						$input['nome_arq']  = $nome;
					}
				}				
				$input['status_financeiro'] = 1;
				$relatorioFinanceiro  = RelatorioFinanceiro::create($input);	
				$id_registro 		  = DB::table('relatorio_financeiro')->max('id');
				$input['registro_id'] = $id_registro;
				$log 	 		      = LoggerUsers::create($input);
				$lastUpdated	      = $log->max('updated_at');
				$relatorioFinanceiro  = RelatorioFinanceiro::where('unidade_id',$id_unidade)->get();
				$validator 			  = 'Relatório Financeiro cadastrado com sucesso!';
				return redirect()->route('cadastroRF', [$id_unidade])
					->withErrors($validator);				
			} else {
				$validator 			 = 'Só suporta arquivos do tipo: PDF!';	
				$relatorioFinanceiro = RelatorioFinanceiro::where('unidade_id',$id_unidade)->get();
				$lastUpdated 		 = $relatorioFinanceiro->max('updated_at');
				return view('transparencia/relatorioFinanceiro/relatorio_novo', compact('unidades','unidade','unidadesMenu','relatorioFinanceiro','lastUpdated'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			}
		}
	}
		
	public function destroyRF($id_unidade, $id_item, Request $request)
	{
		$input = $request->all();
		$relatorioFinanceiro = RelatorioFinanceiro::where('id',$id_item)->get();
		$image_path  		 = 'storage/'.$relatorioFinanceiro[0]->file_path;
        unlink($image_path);
		RelatorioFinanceiro::find($id_item)->delete();
		$input['registro_id'] = $id_item;
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);		
		$relatorioFinanceiro = RelatorioFinanceiro::where('unidade_id',$id_unidade)->get();
		$validator = 'Relatório Financeiro excluído com sucesso!';
		return redirect()->route('cadastroRF', [$id_unidade])
				->withErrors($validator);
	}

	public function inativarRF($id, $id_escolha, Request $request)
    {
		$input = $request->all();
		$relatorioFinanceiro = RelatorioFinanceiro::where('id',$id_escolha)->get();
		if($relatorioFinanceiro[0]->status_financeiro == 1) {
			$nomeArq    = explode($relatorioFinanceiro[0]->nome_arq, $relatorioFinanceiro[0]->file_path);
			$nome       = "old_".$relatorioFinanceiro[0]->nome_arq;
			$image_path = $nomeArq[0].$nome;
			DB::statement("UPDATE relatorio_financeiro SET `status_financeiro` = 0, `file_path` = '$image_path', `nome_arq` = '$nome' WHERE `id` = $id_escolha");
			$caminho    = 'storage/'.$relatorioFinanceiro[0]->file_path;
			$image_path = 'storage/'.$nomeArq[0].$nome;
			rename($caminho, $image_path);
		} else {
			$caminho = explode($relatorioFinanceiro[0]->nome_arq, $relatorioFinanceiro[0]->file_path);
			$nome    = explode("old_", $relatorioFinanceiro[0]->nome_arq); 
			$image_path = $caminho[0].$nome[1]; 
			DB::statement("UPDATE relatorio_financeiro SET `status_financeiro` = 1, `file_path` = '$image_path', `nome_arq` = '$nome[1]' WHERE `id` = $id_escolha");
			$caminho    = 'storage/'.$relatorioFinanceiro[0]->file_path;
			$image_path = 'storage/'.$image_path;
			rename($caminho, $image_path);		
		}
		$input['registro_id'] = $relatorioFinanceiro[0]->id;
		$log          = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$relatorioFinanceiro = RelatorioFinanceiro::where('unidade_id',$id)->get();
		$validator    = 'Relatório Financeiro inativado com sucesso!';
		return redirect()->route('cadastroRF', [$id])
				->withErrors($validator);
    }
}