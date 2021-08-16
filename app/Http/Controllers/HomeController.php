<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Unidade;
use App\Model\ProcessoArquivos;
use App\Model\Processos;
use Auth;
use Validator;

class HomeController extends Controller
{
	protected $unidade;
	
      public function __construct(Unidade $unidade)
      {
		    $this->unidade = $unidade;
      }

      public function index()
      {
        $unidades = $this->unidade->all();
        $text = false;
        if(Auth::user()->id == 24) {
          return view('home_compras', compact('unidades','text'));
        } else {
          return view('home', compact('unidades','text'));
        }
        
      }
	
	    public function trasparenciaHome($id)
      {
        $unidadesMenu = $this->unidade->all();
        $unidades = $unidadesMenu;
        $unidade  = Unidade::where('id', $id)->get(); 
        $lastUpdated  = $unidade->max('updated_at');
        $text = false;
        return view('transparencia.institucional', compact('unidade','unidades','unidadesMenu','lastUpdated','text'));
      }

      public function trasparenciaOrdemCompra($id)
      {
        $unidade      = Unidade::where('id',$id)->get();
        $processos    = Processos::where('unidade_id',$id)->get();
        $processo_arq = ProcessoArquivos::where('unidade_id',$id)->get();
        return view('ordem_compra/ordem_compras_cadastro', compact('unidade','processos','processo_arq'));
      }

      public function trasparenciaOrdemCompraNovo($id)
      {
        $unidade = Unidade::where('id',$id)->get();
        $mes = date('m',strtotime('now')); 
        $processos = Processos::whereMonth('created_at',$mes)->where('unidade_id',$id)->get();
        return view('ordem_compra/ordem_compras_novo', compact('unidade','processos'));
      }

      public function storeOrdemCompra($id, Request $request)
      {
        $input   = $request->all();
        $unidade = Unidade::where('id',$id)->get();
        $validator = Validator::make($request->all(), [
          'numeroSolicitacao'  => 'required|max:255',
          'dataSolicitacao'    => 'required|date',
          'numeroOC'           => 'required|max:255',
          'dataAutorizacao'    => 'required|date',
          'fornecedor'         => 'required|max:255',
          'cnpj'               => 'required|max:14',
          'produto'            => 'required|max:500',
          'qtdOrdemCompra'     => 'required|max:255',
          'totalValorOC'       => 'required|max:255',
          'classificacaoItem'  => 'required|max:255',
          'numeroNotaFiscal'   => 'required|max:255',
          'quantidadeRecebida' => 'required|max:255',
          'valorTotalRecebido' => 'required|max:255',
          'chaveAcesso'        => 'required|max:255',
          'codigoIbge'         => 'required|max:255' 
        ]);
        if ($validator->fails()) {
          $processos = Processos::where('unidade_id',$id)->get();
          return view('ordem_compra/ordem_compras_novo', compact('unidade','processos'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
        } else {
          $processos = Processos::create($input);
          $processos = Processos::all();
          $mes = date('m',strtotime($processos[0]->created_at));
          $now = date('m',strtotime('now')); 
          $processos = Processos::whereMonth('created_at',$mes)->where('unidade_id',$id)->get();
          var_dump($processos); exit();
          return view('ordem_compra/ordem_compras_novo', compact('unidade','processos'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
        }
      }
}