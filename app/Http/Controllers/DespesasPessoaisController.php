<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\DespesasPessoais;
use App\Model\Unidade;
use DB;

class DespesasPessoaisController extends Controller
{
	public function __construct(Unidade $unidade)
	{
		$this->unidade = $unidade;
	}
	
    public function cadastroDespesas($id)
	{
		$unidades = $this->unidade->all();
		$unidade = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->all();
		$text = false;
		return view('transparencia/rh/rh_despesasp_cadastro', compact('text','unidades','unidade','unidadesMenu'));
	}
	
	public function storeDespesas($id_unidade, Request $request)
	{
		$unidades = $this->unidade->all();
		$unidade = $this->unidade->find($id_unidade);
		$unidadesMenu = $this->unidade->all();
		$input = $request->all();
		$mes = $input['mes'];
		$ano = $input['ano'];
		
		if($id_unidade == 2){
			$nome = 'hmr';
		} else if ($id_unidade == 3) {
		   $nome = 'belo_jardim';
	    } else if ($id_unidade == 4) {
		   $nome = 'arcoverde';
	    } else if ($id_unidade == 5) {
		   $nome = 'arruda';
	    } else if ($id_unidade == 6) {
		   $nome = 'upaecaruaru';
	    } else if ($id_unidade == 7) {
		   $nome = 'hss';
	    } else if ($id_unidade == 8) {
		   $nome = 'hpr';
	    }	
			
		$validacao = DB::select('SELECT * FROM desp_com_pessoal_' .$nome. ' WHERE Mes = ' .$mes. ' AND Ano = ' .$ano);
		$qtd = sizeof($validacao); var_dump($qtd); exit();
		if($qtd > 30) {
			$text = true;
			session()->flashInput($request->input());
			\Session::flash('mensagem', ['msg' => 'Esta Dispesa Pessoal já foi cadastrada!!','class'=>'green white-text']);		
			return view('transparencia/rh/rh_despesasp_cadastro', compact('text','unidades','unidade','unidadesMenu'));
		} else {
		   for($i = 1; $i < 11; $i++){
			   $nivel = "";
			   $cargo = "";
			   if($i == 1) {
				 $nivel = $input['nivel1'];
				 $cargo = $input['cargo'.$i];
			   } else if($i > 1 && $i < 5) {
				 $nivel = "";
				 $cargo = $input['cargo'.$i];
			   } else if ($i == 5) {
				 $nivel = $input['nivel2'];
				 $cargo = $input['cargo'.$i];
			   } else if ($i > 5 && $i < 8) {
				 $nivel = "";
				 $cargo = $input['cargo'.$i];
			   } else if ($i == 8) {
				 $nivel = $input['nivel3'];
				 $cargo = $input['cargo'.$i];
			   } else if ($i > 8 && $i < 10) {
				 $nivel = "";
				 $cargo = $input['cargo'.$i];
			   } else if ($i == 10){
				 $nivel = $input['nivel4'];
			   }
			   
			   $qtd   = $input['Quant'.$i];
			   $valor = $input['valor'.$i];	
			   $despesas = DB::select("INSERT INTO desp_com_pessoal_" .$nome. " (Nivel,Cargo,Quant,Valor
				,Mes,Ano) VALUES('$nivel','$cargo','$qtd','$valor','$mes','$ano')");
		  }	
	   }
		  $text = true;
		  \Session::flash('mensagem', ['msg' => 'Dispesas com Pessoal cadastrada com sucesso!!','class'=>'green white-text']);		
		  return view('transparencia/rh/rh_despesasp_cadastro', compact('text','unidades','unidade','unidadesMenu'));
	   }
}