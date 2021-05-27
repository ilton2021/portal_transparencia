<?php

namespace App\Http\Controllers;

use App\Model\Contrato;
use App\Model\Aditivo;
use App\Model\Cotacao;
use App\Model\Unidade;
use App\Model\Prestador;
use App\Model\Processos;
use App\Model\ProcessoArquivos;
use App\Model\Gestor;
use App\Model\GestorContrato;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use Illuminate\Support\Facades\Storage;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;
use App\Imports\processoImport;
use App\Model\PermissaoUsers;
use Auth;

class ContratacaoController extends Controller
{
    public function __construct(Unidade $unidade, Contrato $contrato, Prestador $prestador, Cotacao $cotacao, LoggerUsers $loggerUsers, Aditivo $aditivo, Processos $processos, ProcessoArquivos $processo_arquivos)
    {
        $this->unidade     = $unidade;
		$this->contrato    = $contrato;
		$this->prestador   = $prestador;
		$this->cotacao     = $cotacao;
		$this->loggerUsers = $loggerUsers;
		$this->aditivo 	   = $aditivo;
		$this->processos   = $processos;
		$this->processo_arquivos = $processo_arquivos;
    }

	public function index(Unidade $unidade)
    {
        $unidades = $this->unidade->all();
		return view('transparencia.contrato', compact('unidades'));
    }

	public function contratacaoCadastro($id)
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
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->all();
		$contratos = DB::table('contratos')
        ->join('prestadors', 'contratos.prestador_id', '=', 'prestadors.id')
		->select('contratos.id as ID', 'contratos.*', 'prestadors.prestador as nome', 'prestadors.*')
		->where('contratos.unidade_id', $id)
		->orderBy('nome', 'ASC')
        ->get()->toArray();
		$aditivos = Aditivo::where('unidade_id', $id)->get();
		$lastUpdated = $aditivos->max('updated_at');
		$processos = Processos::where('unidade_id', $id)->get();
		$processo_arquivos = ProcessoArquivos::where('unidade_id', $id)->get();
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_cadastro', compact('unidades','unidade','unidadesMenu','contratos','aditivos','lastUpdated','text','processos','processo_arquivos'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function addCotacao($id)
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
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->all();
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/contratacao/cotacao_excel', compact('unidades','unidade','unidadesMenu','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function arquivosCotacoes($id, $id_processo, Request $request)
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
		$unidade  = $this->unidade->find($id);
		$unidadesMenu = $unidades;
		$processo = Processos::where('unidade_id', $id)->where('id', $id_processo)->get();
		$processo_arquivos = ProcessoArquivos::where('unidade_id',$id)->get();
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/contratacao/cotacao_arquivos_novo', compact('unidades','unidade','unidadesMenu','text','processo','processo_arquivos'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function validarCotacoes($id, $id_processo, Request $request)
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
		$unidade  = $this->unidade->find($id);
		$unidadesMenu = $unidades;
		$cotacoes = Cotacao::find($id_processo);
		DB::statement('UPDATE cotacaos SET validar = 0 WHERE id = '.$id_processo.';');
		$cotacoes = Cotacao::where('unidade_id', $id)->get();
		if($validacao == 'ok') {
			\Session::flash('mensagem', ['msg' => 'Cotação validado com Sucesso!!','class'=>'green white-text']);		
			$text = true;
			return view('transparencia/contratacao/contratacao_cotacoes_cadastro', compact('unidades','unidade','unidadesMenu','text','cotacoes','permissao_users'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function storeArquivoCotacao($id, $id_processo, Request $request)
	{
		$unidades = $this->unidade->all();
		$unidade  = $this->unidade->find($id);
		$unidadesMenu = $unidades;
		$processo = Processos::where('unidade_id', $id)->where('id', $id_processo)->get();
		$input = $request->all();
		$v = \Validator::make($request->all(), [
			'title' 	=> 'required|max:255',
			'file_path' => 'required|file',
		]);
		if ($v->fails()) {
			$failed = $v->failed(); 
			if ( !empty($failed['title']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo título é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['title']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo título possui no máximo 255 caracteres!','class'=>'green white-text']);
			} else if ( !empty($failed['file_path']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo arquivo é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['file_path']['File']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo arquivo tem que ser um documento!','class'=>'green white-text']);
			}
 			$text = true; 
			return view('transparencia/contratacao/cotacao_arquivos_novo', compact('unidades','unidade','unidadesMenu','text'));
		} else {
			$solicitacao = $input['numeroSolicitacao'];
			$nome = $_FILES['file_path']['name'];  
			$request->file('file_path')->move('../public/storage/cotacoes/arquivos/'. $solicitacao. '/',$nome);	
			$input['file_path'] = 'cotacoes/arquivos/'.$solicitacao.'/'.$nome;
			$input['processo_id'] = $id_processo;
			ProcessoArquivos::create($input);	
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$processo_arquivos = ProcessoArquivos::where('unidade_id',$id)->get();
			$text = true;
			$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
			\Session::flash('mensagem', ['msg' => 'Arquivo da Cotação cadastrado com sucesso!','class'=>'green white-text']);
			$a = 0;
			return view('transparencia/contratacao/cotacao_arquivos_novo', compact('unidade','unidades','unidadesMenu','lastUpdated','text','processo_arquivos','processo','permissao_users','a'));
		}
	}
	
	public function storeExcelCotacao($id, Request $request)
	{
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade  = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->all();
		$processos = Processos::where('unidade_id', $id)->get();
		$nome = $_FILES['file_path']['name']; 
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		if($request->file('file_path') === NULL) {	
			\Session::flash('mensagem', ['msg' => 'Informe o arquivo do Contrato!','class'=>'green white-text']);		
			$text = true;
			return view('transparencia/contratacao/cotacao_excel', compact('unidades','unidade','unidadesMenu','processos','text'));
		} else {	
		    if(($extensao === 'csv') || ($extensao === 'xls') || ($extensao === 'xlsx')) {
				$v = \Validator::make($request->all(), [
					'file_path' => 'required'
				]);
				if ($v->fails()) {
					$failed = $v->failed(); 
					if ( !empty($failed['file_path']['Required']) ) {
						\Session::flash('mensagem', ['msg' => 'O campo arquivo é obrigatório!','class'=>'green white-text']);
					} else {
						$text = true;
						return view('transparencia/contratacao/cotacao_excel', compact('unidades','unidade','unidadesMenu','text','processos'));	
					}
				}else {
					$processosA = Processos::where('unidade_id', $id)->get();
					$qtdA = sizeof($processosA);
					\Excel::import(new processoImport($id), $request->file('file_path'));
					$processosD = Processos::where('unidade_id', $id)->get();
					$qtdD = sizeof($processosD);
					if($qtdA == $qtdD) {
						$text = true;
						\Session::flash('mensagem', ['msg' => 'Erro ao Salvar Processo! Número do Processo já Existe!!!','class'=>'green white-text']);		
						return view('transparencia/contratacao/cotacao_excel', compact('unidades','unidade','unidadesMenu','text','processos'));
					}
					$cotacoes = Cotacao::where('unidade_id', $id)->get();
					$contratos = Contrato::where('unidade_id', $id)->get();
					$processos = Processos::where('unidade_id', $id)->get();
					$lastUpdated = $contratos->max('updated_at');
					$aditivos = Aditivo::where('unidade_id', $id)->get();
					$text = false;
					$a = 0;
					return view('transparencia.contratacao', compact('unidades','unidade','unidadesMenu','contratos','aditivos','lastUpdated','cotacoes','text','processos','a'));		
				}
			} else {
				\Session::flash('mensagem', ['msg' => 'Só é suportado arquivos: .csv, .xls, .xlsx!','class'=>'green white-text']);		
				$text = true;
				return view('transparencia/contratacao/cotacao_excel', compact('unidades','unidade','unidadesMenu','processos','text'));
			}
		}
	}

	public function prestadorCadastro($id_unidade)
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
		$contratos = Contrato::where('unidade_id', $id_unidade)->get();
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_prestador_cadastro', compact('unidades','unidade','unidadesMenu','contratos','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function cadastroContratos($id_unidade, Contrato $contrato)
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
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_novo', compact('unidades','unidade','unidadesMenu','text'));	
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function alterarContratos($id_unidade, $id_prestador, $id_contrato)
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
		$text = false;
		$contratos = Contrato::where('unidade_id', $id_unidade)->where('prestador_id', $id_prestador)->get();
		$prestadores = Prestador::where('id', $id_prestador)->get();
		if($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_alterar', compact('unidades','unidade','unidadesMenu','text','contratos','prestadores'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}

	public function cadastroCotacoes($id_unidade)
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
		$cotacoes = Cotacao::where('unidade_id', $id_unidade)->get();
		$processos = Processos::where('unidade_id', $id_unidade)->get();
		$processo_arquivos = ProcessoArquivos::where('unidade_id', $id_unidade)->get();
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_cotacoes_cadastro', compact('unidades','unidade','unidadesMenu','cotacoes','text','processos','processo_arquivos'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}

	public function cotacoesNovo($id_unidade)
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
		$cotacoes = Cotacao::where('unidade_id', $id_unidade)->get();
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_cotacoes_novo', compact('unidades','unidade','unidadesMenu','cotacoes','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}

	public function pesquisarPrestador($id_unidade)
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
		$prestadores = Prestador::all(); 
		$lastUpdated = $prestadores->max('updated_at');
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_pesquisar_prestador', compact('unidades','unidade','unidadesMenu','lastUpdated','prestadores','text'));	
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function responsavelCadastro($id_unidade, $id_contrato)
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
		$gestores = Gestor::all(); 
		$contrato = Contrato::where('id', $id_contrato)->get();
		$gestorContratos = DB::table('gestor_contrato')
		->join('gestor', 'gestor_contrato.gestor_id', '=', 'gestor.id')
		->join('unidades','unidades.id','=','gestor_contrato.unidade_id')
		->select('gestor.nome as Nome', 'gestor_contrato.*')
		->where('gestor_contrato.contrato_id', $id_contrato)
		->where('unidade_id',$id_unidade)
		->get()->toArray();
		$lastUpdated = $gestores->max('updated_at');
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_responsavel_cadastro', compact('unidades','unidade','unidadesMenu','lastUpdated','gestores','text','contrato','gestorContratos'));	
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function responsavelNovo($id_unidade, $id_contrato)
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
		$prestadores = Prestador::all(); 
		$lastUpdated = $prestadores->max('updated_at');
		$contrato = Contrato::where('id', $id_contrato)->get();
		$id = $contrato[0]->id;
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_gestor_cadastro', compact('unidades','unidade','unidadesMenu','lastUpdated','prestadores','text','id'));	
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}

	public function pesqPresdator($id_unidade, $id_prestador, Contrato $contrato)
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
		if($id_prestador == "procurarPrestador") {
		 $prestadores = null;	
		 $text = false;
		 return view('transparencia/contratacao/contratacao_novo', compact('unidades','unidade','unidadesMenu','prestadores','text'));	
	    } else { 
		 $prestadores = Prestador::where('id', $id_prestador)->get(); 
		 $lastUpdated = $prestadores->max('updated_at');
		 $text = false;
		 if($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_novo', compact('unidades','unidade','unidadesMenu','lastUpdated','prestadores','text'));	
		 } else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		 } 
		}
	}
	
	public function procurarPrestador($id_unidade, Request $request, Contrato $contrato)
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
		$input = $request->all();
		$funcao = $input['funcao'];
		$pesq = $input['pesq'];
		if($funcao == 0){
		  if(!$pesq == ""){
		   $prestadores = DB::table('prestadors')->where('prestadors.prestador', 'like', '%' . $pesq . '%')->get();
		   $lastUpdated = $prestadores->max('updated_at');
	      } else {
		   $prestadores = Prestador::all(); 		  
		   $lastUpdated = $prestadores->max('updated_at');
		  }
		} else if($funcao == 1){
		  $prestadores = DB::table('prestadors')->where('prestadors.cnpj_cpf', 'like', '%' . $pesq . '%')->get();		  
		  $lastUpdated = $prestadores->max('updated_at');
		} else if($funcao == 2){
		  $prestadores = DB::table('prestadors')->where('prestadors.tipo_contrato', 'like', '%' . $pesq . '%')->get();
		  $lastUpdated = $prestadores->max('updated_at');
		} else if($funcao == 3){
		  $prestadores = DB::table('prestadors')->where('prestadors.tipo_pessoa', 'like', '%' . $pesq . '%')->get();
		  $lastUpdated = $prestadores->max('updated_at');
		} else {
			$prestadores = Prestador::all();
			$lastUpdated = $prestadores->max('updated_at');
		}
		
		$text = false;
		if($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_pesquisar_prestador', compact('unidades','unidade','unidadesMenu','lastUpdated','prestadores','text'));	
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}

	public function excluirAditivos($id_unidade, $id_aditivo, Request $request)
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
		Aditivo::find($id_aditivo)->delete();
		$input = $request->all();
		$input['tela'] = 'contratacao';
		$input['acao'] = 'excluirContratacao';
		$input['user_id'] = Auth::user()->id;
		$input['unidade_id'] = $id_unidade;
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$contratos = DB::table('contratos')
        ->join('prestadors', 'contratos.prestador_id', '=', 'prestadors.id')
		->select('contratos.id as ID', 'contratos.*', 'prestadors.prestador as nome', 'prestadors.*')
		->where('contratos.unidade_id', $id_unidade)
		->orderBy('nome', 'ASC')
        ->get()->toArray();
		$aditivos = Aditivo::where('unidade_id', $id_unidade)->get();
		$processo_arquivos = ProcessoArquivos::where('unidade_id', $id_unidade)->get();
		$text = true;
		\Session::flash('mensagem', ['msg' => 'Contrato excluído com sucesso!','class'=>'green white-text']);
		
		if($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_cadastro', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated','text','permissao_users','aditivos'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	}
	
	public function excluirContratos($id_unidade, $id_contrato, $id_prestador)
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
		$contratos = Contrato::where('id',$id_contrato)->get();
		$aditivos = Aditivo::where('unidade_id', $id_unidade)->where('contrato_id', $id_contrato)->get();
		$lastUpdated = $contratos->max('updated_at');
        $prestador = Prestador::where('id', $id_prestador)->get();
        $text = false;
		if($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_excluir', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated','prestador','text','aditivos'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	} 

	public function excluirCotacoes($id_unidade, $id_cotacao)
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
		$cotacoes = Cotacao::where('id',$id_cotacao)->get();
		$lastUpdated = $cotacoes->max('updated_at');
        $text = false;
		if($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_cotacoes_excluir', compact('unidades','unidade','unidadesMenu','lastUpdated','cotacoes','text'));
		} else {
			\Session::flash('mensagem', ['msg' => 'Você não tem Permissão!!','class'=>'green white-text']);		
			$text = true;
			return view('home', compact('unidades','unidade','unidadesMenu','text')); 		
		}
	} 
	
	public function storePrestador($id_unidade, Request $request)
    {
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$input = $request->all();
		$v = \Validator::make($request->all(), [
			'prestador' 	=> 'required|max:255',
			'cnpj_cpf' 		=> 'required|min:14|max:18',
		]);
		if ($v->fails()) {
			$failed = $v->failed(); 
			if ( !empty($failed['prestador']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo prestador é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['prestador']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo prestador possui no máximo 255 caracteres!','class'=>'green white-text']);
			} else if ( !empty($failed['cnpj_cpf']['Required']) ) {	
				\Session::flash('mensagem', ['msg' => 'O campo cnpj_cpf é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['cnpj_cpf']['Min']) ) {	
				\Session::flash('mensagem', ['msg' => 'O campo cnpj_cpf possui no mínimo 14 caracteres!','class'=>'green white-text']);
			} else if ( !empty($failed['cnpj_cpf']['Max']) ) {	
				\Session::flash('mensagem', ['msg' => 'O campo cnpj_cpf possui no máxima 18 caracteres!','class'=>'green white-text']);
			}
			$text = true; 
			return view('transparencia/contratacao/contratacao_prestador_cadastro', compact('unidades','unidade','unidadesMenu','text'));
		} else {
			$prestador = Prestador::create($input);
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$contratos = Contrato::where('unidade_id',$id_unidade)->get();
			$text = true;
			\Session::flash('mensagem', ['msg' => 'Prestador cadastrado com sucesso!','class'=>'green white-text']);
			return view('transparencia/contratacao/contratacao_novo', compact('unidade','unidades','unidadesMenu','lastUpdated','text'));
		}	
    }
	
	public function storeGestor($id_unidade, $id_contrato, Request $request)
    {
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$input = $request->all();
		$v = \Validator::make($request->all(), [
			'nome' 	=> 'required|max:255',
			'email' => 'required|email'
		]);
		if ($v->fails()) {
			$failed = $v->failed(); 
			if ( !empty($failed['nome']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo nome é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['nome']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo nome possui no máximo 255 caracteres!','class'=>'green white-text']);
			} else if ( !empty($failed['email']['Required']) ) {	
				\Session::flash('mensagem', ['msg' => 'O campo email é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['email']['Email']) ) {	
				\Session::flash('mensagem', ['msg' => 'O campo email é inválido!','class'=>'green white-text']);
			} 
			$text = true; 
			return view('transparencia/contratacao/contratacao_gestor_cadastro', compact('unidades','unidade','unidadesMenu','text'));
		} else {
			$gestor = Gestor::create($input);
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$gestores = Gestor::all();
			$contrato = Contrato::where('id',$id_contrato)->get();
			$text = true;
			\Session::flash('mensagem', ['msg' => 'Gestor cadastrado com sucesso!','class'=>'green white-text']);
			return view('transparencia/contratacao/contratacao_responsavel_cadastro', compact('unidade','unidades','unidadesMenu','lastUpdated','text','gestores','contrato'));
		}	
    }
	
	public function validarGestorContrato($id_unidade, $id_gestor, $id_contrato, Request $request)
    {
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$hoje = date('Y-m-d',(strtotime('now')));
		$input = $request->all();
		$input['contrato_id'] = $id_contrato;
		$input['gestor_id'] = $id_gestor;
		$gestorContrato = GestorContrato::where('contrato_id',$id_contrato)->where('gestor_id',$id_gestor)->get();
		$qtd = sizeof($gestorContrato);
		if($qtd > 0){
			$gestores = Gestor::all();
			$contrato = Contrato::where('id',$id_contrato)->get();
			$gestorContratos = DB::table('gestor_contrato')
			->join('gestor', 'gestor_contrato.gestor_id', '=', 'gestor.id')
			->join('unidades','unidades.id','=','gestor_contrato.unidade_id')
			->select('gestor.nome as Nome', 'gestor_contrato.*')
			->where('gestor_contrato.contrato_id', $id_contrato)
			->where('unidade_id',$id_unidade)
			->get()->toArray();
			$lastUpdated = $gestores->max('updated_at');
			$text = true;
			\Session::flash('mensagem', ['msg' => 'Gestor já vinculado para este Contrato!','class'=>'green white-text']);
			return view('transparencia/contratacao/contratacao_responsavel_cadastro', compact('unidade','unidades','unidadesMenu','lastUpdated','text','gestores','contrato','gestorContratos'));
		} else {
			$input['unidade_id'] = $id_unidade;
			$gestorContrato = GestorContrato::create($input);	
			$lastUpdated = $gestorContrato->max('updated_at');
			$gestores = Gestor::all();
			$contrato = Contrato::where('id',$id_contrato)->get();
			$gestorContratos = DB::table('gestor_contrato')
			->join('gestor', 'gestor_contrato.gestor_id', '=', 'gestor.id')
			->select('gestor.nome as Nome', 'gestor_contrato.*')
			->where('gestor_contrato.contrato_id', $id_contrato)
			->get()->toArray();
			$text = true;
			\Session::flash('mensagem', ['msg' => 'Gestor vinculado ao Contrato com sucesso!','class'=>'green white-text']);
			return view('transparencia/contratacao/contratacao_responsavel_cadastro', compact('unidade','unidades','unidadesMenu','lastUpdated','text','gestores','contrato','gestorContratos'));
		}
    }
	
	public function updateContratos($id_unidade, $id_prestador, $id_contrato, Request $request)
	{
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$contratos = Contrato::where('unidade_id',$id_unidade)->where('prestador_id', $id_prestador)->get();
	    $prestadores = Prestador::where('id', $id_prestador)->get();
		$input = $request->all();
		if($input['file_path_'] !== "") {
			$extensao = 'pdf';
		}
		$data1 = $input['inicio'];
		$data2 = $input['fim'];
		if(strtotime($data1) > strtotime($data2)){
			\Session::flash('mensagem', ['msg' => 'O campo data fim não pode ser maior que o campo data início!','class'=>'green white-text']);
			$text = true;
			return view('transparencia/contratacao/contratacao_alterar', compact('unidades','unidade','unidadesMenu','contratos','prestadores','text'));
		}
		$input['yellow_alert'] = 90;
		$input['red_alert']    = 60;
		if ($input['valor'] < 0) {
			\Session::flash('mensagem', ['msg' => 'O campo valor é inválido!','class'=>'green white-text']);
			$text = true;
			return view('transparencia/contratacao/contratacao_alterar', compact('unidades','unidade','unidadesMenu','contratos','prestadores','text'));
		}
		$v = \Validator::make($request->all(), [
			'objeto' 	=> 'required|max:255',
			'valor' 	=> 'required'
		]);
		if ($v->fails()) {
			$failed = $v->failed(); 
			if ( !empty($failed['objeto']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo título é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['objeto']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo título possui no máximo 255 caracteres!','class'=>'green white-text']);
			} else if ( !empty($failed['valor']['Required']) ) {	
				\Session::flash('mensagem', ['msg' => 'O campo valor é obrigatório!','class'=>'green white-text']);
			}
			$text = true;
			return view('transparencia/contratacao/contratacao_alterar', compact('unidades','unidade','unidadesMenu','contratos','prestadores','text'));
		} else {
			if($request->file('file_path') === NULL && $input['file_path_'] == "") {	
				$text = true;
				\Session::flash('mensagem', ['msg' => 'Informe o arquivo da Contratação!','class'=>'green white-text']);			
				return view('transparencia/contratacao/contratacao_alterar', compact('unidades','unidade','unidadesMenu','contratos','prestadores','text'));
			} else {
				if($extensao == 'pdf') {
					$input['ativa'] = 1;
					$qtdUnidades = sizeof($unidades);
					for ($i = 1; $i <= $qtdUnidades; $i++) {						
						if ($unidade['id'] === $i) {							
							$txt1 = $unidades[$i-1]['path_img'];
							$txt1 = explode(".jpg", $txt1);
							$nome = $_FILES['file_path']['name'];
							if($request->file('file_path') !== NULL) {
								$request->file('file_path')->move('../public/storage/contratos/'.$txt1[0].'/', $nome);
								$input['file_path'] = 'contratos/'.$txt1[0].'/'.$nome;
							}
							$input['prestador_id'] = $id_prestador;
							$contrato = Contrato::find($id_contrato);
							$contrato->update($input);
							$log = LoggerUsers::create($input);
							$lastUpdated = $log->max('updated_at');
						}
					}
					$contratos = DB::table('contratos')
					->join('prestadors', 'contratos.prestador_id', '=', 'prestadors.id')
					->select('contratos.id as ID', 'contratos.*', 'prestadors.prestador as nome', 'prestadors.*')
					->where('contratos.unidade_id', $id_unidade)
					->orderBy('nome', 'ASC')
					->get()->toArray();
					$aditivos = Aditivo::where('unidade_id', $id_unidade)->get();
					$text = true;
					\Session::flash('mensagem', ['msg' => 'Contratação cadastrada com sucesso!','class'=>'green white-text']);			
					return view('transparencia/contratacao/contratacao_cadastro', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated','aditivos','text'));
				} else {	
					$text = true;
					\Session::flash('mensagem', ['msg' => 'Só é suportado arquivos: .pdf!','class'=>'green white-text']);			
					return view('transparencia/contratacao/contratacao_novo', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated','text'));
				}
			
			}
		}
	}
	
    public function storeContratos($id_unidade, Request $request)
    { 
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$contratos = Contrato::where('unidade_id',$id_unidade)->get();
		$aditivos = Aditivo::where('unidade_id', $id_unidade)->get();
	    $cotacoes = Cotacao::where('unidade_id', $id_unidade)->get();
		$input = $request->all();
		$nome = $_FILES['file_path']['name']; 
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		if ( empty($input['prestador']) ) {
			$text = true;
			\Session::flash('mensagem', ['msg' => 'Informe o Prestador!','class'=>'green white-text']);			
			return view('transparencia/contratacao/contratacao_novo', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated','text'));
		}
		$data1 = $input['inicio'];
		$data2 = $input['fim'];
		if(strtotime($data1) > strtotime($data2)){
			\Session::flash('mensagem', ['msg' => 'O campo data fim não pode ser maior que o campo data início!','class'=>'green white-text']);
			$text = true;
			return view('transparencia/contratacao/contratacao_novo', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated','text'));
		}
		$input['yellow_alert'] = 90;
		$input['red_alert']    = 60;
		$input['prestador_id'] = $input['id'];
		$v = \Validator::make($request->all(), [
			'objeto' 	=> 'required|max:255',
			'valor' 	=> 'required'
		]);
		if ($input['valor'] < 0) {
			\Session::flash('mensagem', ['msg' => 'O campo valor é inválido!','class'=>'green white-text']);
			$text = true;
			return view('transparencia/contratacao/contratacao_novo', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated','text'));
		}
		if ($v->fails()) {
			$failed = $v->failed(); 
			if ( !empty($failed['objeto']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo título é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['objeto']['Max']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo título possui no máximo 255 caracteres!','class'=>'green white-text']);
			} else if ( !empty($failed['valor']['Required']) ) {	
				\Session::flash('mensagem', ['msg' => 'O campo valor é obrigatório!','class'=>'green white-text']);
			}
			$text = true;
			return view('transparencia/contratacao/contratacao_novo', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated','text'));
		}
		if($request->file('file_path') === NULL) {	
			$text = true;
			\Session::flash('mensagem', ['msg' => 'Informe o arquivo da Contratação!','class'=>'green white-text']);			
			return view('transparencia/contratacao/contratacao_novo', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated','text'));
		} else {
			if($extensao == 'pdf') {
					$input['ativa'] = 1;
					$qtdUnidades = sizeof($unidades);
					$nome = $_FILES['file_path']['name']; 	
					$input['cadastro'] = 1;	
					for ($i = 1; $i <= $qtdUnidades; $i++) {						
						if ($unidade['id'] === $i) {							
							$txt1 = $unidades[$i-1]['path_img'];
							$txt1 = explode(".jpg", $txt1);
					
							$prestador = $input['prestador_id'];
							$contratosN = Contrato::where('unidade_id', $id_unidade)->where('prestador_id', $prestador)->get();
							$qtd = sizeof($contratosN);
							
							if($input['aditivos'] === '0') {
								
								if($qtd > 0){
									$request->file('file_path')->move('../public/storage/contratos/'.$txt1[0].'/aditivos/', '0-'.$nome);		
									$input['file_path'] = 'contratos/'.$txt1[0].'/'.$nome;
									$input['opcao'] = 0;
									$input['ativa'] = 0;
									$input['contrato_id'] = $contratosN[0]->id;
									$aditivo = Aditivo::create($input);
									$log 	 = LoggerUsers::create($input);
									$lastUpdated = $log->max('updated_at');
								} else {
									$request->file('file_path')->move('../public/storage/contratos/'.$txt1[0].'/', $nome);		
									$input['file_path'] = 'contratos/'.$txt1[0].'/'.$nome;
									$contrato = Contrato::create($input);
									$log 	  = LoggerUsers::create($input);
									$lastUpdated = $log->max('updated_at');
								}
								
							} else {	
								$request->file('file_path')->move('../public/storage/contratos/'.$txt1[0].'/aditivos/', '1-'.$nome);		
								$input['file_path'] = 'contratos/'.$txt1[0].'/aditivos/1-'.$nome; 
								$input['opcao'] = 1;	
								$input['ativa'] = 0;
								$input['contrato_id'] = $contratosN[0]->id;
								$aditivo = Aditivo::create($input);	
								$log 	 = LoggerUsers::create($input);
								$lastUpdated = $log->max('updated_at');
							}	
						}
					}
					
					$contratos = Contrato::where('unidade_id',$id_unidade)->get();
					$aditivos = Aditivo::where('unidade_id', $id_unidade)->get();
					$permissao_users = PermissaoUsers::where('unidade_id', $id_unidade)->get();
					$text = true;
					$a = 0;
					\Session::flash('mensagem', ['msg' => 'Contratação cadastrada com sucesso!','class'=>'green white-text']);			
					return view('transparencia/contratacao', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated','cotacoes','text','aditivos','permissao_users','a'));
				} else {	
					$text = true;
					\Session::flash('mensagem', ['msg' => 'Só é suportado arquivos: .pdf!','class'=>'green white-text']);			
					return view('transparencia/contratacao/contratacao_novo', compact('unidades','unidade','unidadesMenu','contratos','lastUpdated','text'));
				}
			} 
    }

	public function storeCotacoes($id_unidade, Request $request)
    {   
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$input = $request->all();		
		$cotacoes = Cotacao::where('unidade_id',$id_unidade)->get();		
		$nome = $_FILES['file_path']['name']; 
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		if($request->file('file_path') === NULL) {	
			$text = true;
			\Session::flash('mensagem', ['msg' => 'Informe o arquivo da Cotação!','class'=>'green white-text']);
			return view('transparencia/contratacao/contratacao_cotacoes_novo', compact('unidades','unidade','unidadesMenu','cotacoes','lastUpdated','text'));
		} else {
			if($extensao == 'pdf' || $extensao == 'xlsx') {	
				if(!empty($input['proccess_name2'])){
					$ord = Cotacao::where('unidade_id',$id_unidade)->max('ordering');
					$ord = $ord + 1;
					$qtdUnidades = sizeof($unidades);
					$input['ordering'] = $ord;
					$input['proccess_name'] = $input['proccess_name2'];
					$input['file_name'] = $input['proccess_name'];
					$nomeCotacao = $input['proccess_name'];
					$input['validar'] = 0;
					for ($i = 1; $i <= $qtdUnidades; $i++) { 
						if ($unidade['id'] === $i) {		
							$request->file('file_path')->move('../public/storage/cotacoes/hpr/',$nomeCotacao.'.xlsx');
							$input['file_path'] = 'cotacoes/hpr/'.$nomeCotacao.'.xlsx';
						}			
					}
					$cotacao = Cotacao::create($input);
					$log = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$processos = Processos::where('unidade_id', $id)->get();
					$cotacoes = Cotacao::where('unidade_id',$id_unidade)->get();
					\Session::flash('mensagem', ['msg' => 'Cotação cadastrada com sucesso!','class'=>'green white-text']);			
					$text = true;
					return view('transparencia/contratacao/contratacao_cotacoes_cadastro', compact('unidades','unidade','unidadesMenu','cotacoes','lastUpdated','text','processos'));
 				} else {
					$qtds = sizeof($cotacoes);
					$input['ordering'] = $qtds + 1;				
					$qtdUnidades = sizeof($unidades);
					$nome = $_FILES['file_path']['name']; 
					$nomeCotacao = $input['proccess_name'];
					$input['file_name'] = $nome;	 
					for ($i = 1; $i <= $qtdUnidades; $i++) { 
						if ($unidade['id'] === $i) {
							$txt1 = $unidades[$i-1]['path_img'];
							$txt1 = explode(".jpg", $txt1);					
							$request->file('file_path')->storeAs('public/cotacoes/'.$txt1[0].'/'.$nomeCotacao.'/',$nome);
							$input['file_path'] = 'cotacoes/'.$txt1[0].'/'.$nome;
						}			
					}
					$cotacao = Cotacao::create($input);
					$log = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$cotacoes = Cotacao::where('unidade_id',$id_unidade)->get();
					$processos = Processos::where('unidade_id', $id)->get();
					\Session::flash('mensagem', ['msg' => 'Cotação cadastrada com sucesso!','class'=>'green white-text']);			
					$text = true;
					return view('transparencia/contratacao/contratacao_cotacoes_cadastro', compact('unidades','unidade','unidadesMenu','cotacoes','lastUpdated','text','processos'));
				}	
			} else {	
				$text = true;
				\Session::flash('mensagem', ['msg' => 'Só suporta arquivos: .pdf!','class'=>'green white-text']);			
				return view('transparencia/contratacao/contratacao_cotacoes_novo', compact('unidades','unidade','unidadesMenu','cotacoes','lastUpdated','text'));
			}	
		}
    }

	public function destroy($id_unidade, $id_contrato, Contrato $contrato, Request $request)
    {
		$aditivos = Aditivo::where('unidade_id', $id_unidade)->where('contrato_id', $id_contrato)->get();
		$qtd = sizeof($aditivos);
		for($i = 0; $i < $qtd; $i++) {
		   Aditivo::find($aditivos[$i]->id)->delete();	
		}
        Contrato::find($id_contrato)->delete();
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$nome = $input['file_path'];
		$pasta = 'public/'.$nome; 
		Storage::delete($pasta);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$contratos = DB::table('contratos')
        ->join('prestadors', 'contratos.prestador_id', '=', 'prestadors.id')
		->select('contratos.id as ID', 'contratos.*', 'prestadors.prestador as nome', 'prestadors.*')
		->where('contratos.unidade_id', $id_unidade)
		->orderBy('nome', 'ASC')
        ->get()->toArray();
		$aditivos = Aditivo::where('unidade_id', $id_unidade)->get();
		$text = true;
		\Session::flash('mensagem', ['msg' => 'Contrato excluído com sucesso!','class'=>'green white-text']);
		return view('transparencia/contratacao/contratacao_cadastro', compact('unidades','unidade','unidadesMenu','contratos','aditivos','lastUpdated','text'));
    }
	
	public function destroyCotacao($id_unidade, $id_cotacao, Cotacao $cotacao, Request $request)
    {
        Cotacao::find($id_cotacao)->delete();
		$input = $request->all();
		$log = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$nome = $input['file_path'];
		$pasta = 'public/'.$nome;
		$pasta = 'public/'.$nome;
		Storage::delete($pasta);
		$unidades = $unidadesMenu = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$cotacoes = Cotacao::where('unidade_id', $id_unidade)->get();
		$lastUpdated = $cotacoes->max('updated_at');
		$text = true;
		\Session::flash('mensagem', ['msg' => 'Cotação excluído com sucesso!','class'=>'green white-text']);			
		return view('transparencia/contratacao/contratacao_cotacoes_cadastro', compact('unidades','unidade','unidadesMenu','lastUpdated','cotacoes','text'));
    }
}