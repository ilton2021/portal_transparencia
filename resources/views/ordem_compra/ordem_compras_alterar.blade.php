@extends('layouts.app')
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{asset('img/favico.png')}}">
        <title>Portal da Transparencia - HCP</title>
        <script src="https://kit.fontawesome.com/7656d93ed3.js" crossorigin="anonymous"></script>
        <style>
        .navbar .dropdown-menu .form-control {
            width: 300px;
        }
        </style>
</head>
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade[0]->name}}</strong></div><div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;"> ALTERAR ORDEM DE COMPRA:</h3>
		</div>
	</div>
	@if ($errors->any())
      <div class="alert alert-success">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div>
	@endif 
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-0 col-sm-0"></div>
		<div class="col-md-12 col-sm-12 text-center">
            <div class="accordion" id="accordionExample">
                <div class="card">
                <a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
                    Ordem de Compra <i class="fas fa-check-circle"></i>
                </a>
                </div>
				    <form method="post" action="{{ route('updateOrdemCompra', array($unidade[0]->id,$processos[0]->id)) }}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<table class="table">
                	  <thead>
						<tr> 
							<td> Nº Solicitação </td>
							<td> <input type="text" id="numeroSolicitacao" name="numeroSolicitacao" class="form-control" value="<?php echo $processos[0]->numeroSolicitacao; ?>" required /> </td>
							<td> Data da Solicitação </td>
							<td> <input type="date" id="dataSolicitacao" name="dataSolicitacao" class="form-control" value="<?php echo $processos[0]->dataSolicitacao; ?>" required /> </td>
							<td> Nº O.C </td>
							<td> <input type="text" id="numeroOC" name="numeroOC" class="form-control" value="<?php echo $processos[0]->numeroOC; ?>" required /> </td>
						</tr>
						<tr> 	
							<td> Data de Autorização O.C. </td>
							<td> <input type="date" id="dataAutorizacao" name="dataAutorizacao" class="form-control" value="<?php echo $processos[0]->dataAutorizacao; ?>" required /> </td>
							<td> Fornecedor </td>
							<td> <input type="text" id="fornecedor" name="fornecedor" class="form-control" value="<?php echo $processos[0]->fornecedor; ?>" required /> </td>
							<td> CNPJ </td>
							<td> <input type="text" id="cnpj" name="cnpj" class="form-control" value="<?php echo $processos[0]->cnpj; ?>" required /> </td>
						</tr>
						<tr> 	
						    <td> Quantidade da O.C. </td>
							<td> <input type="text" id="qtdOrdemCompra" name="qtdOrdemCompra" class="form-control" value="<?php echo $processos[0]->qtdOrdemCompra; ?>" required /> </td>
							<td> Valor Total da O.C. </td>
							<td> <input type="text" id="totalValorOC" name="totalValorOC" class="form-control" value="<?php echo $processos[0]->totalValorOC; ?>" required /> </td>
							<td> Produto </td>
							<td> <input type="text" id="produto" name="produto" class="form-control" value="<?php echo $processos[0]->produto; ?>" required /> </td>
						</tr>
						<tr> 		
							<td> Classificação do Item </td>
							<td> <input type="text" id="classificacaoItem" name="classificacaoItem" class="form-control" value="<?php echo $processos[0]->classificacaoItem; ?>" required /></td>
							<td> Quantidade Recebida </td>
							<td> <input type="text" id="quantidadeRecebida" name="quantidadeRecebida" class="form-control" value="<?php echo $processos[0]->quantidadeRecebida; ?>" required /> </td>
							<td> Valor Total Recebido </td>
							<td> <input type="text" id="valorTotalRecebido" name="valorTotalRecebido" class="form-control" value="<?php echo $processos[0]->valorTotalRecebido; ?>" required /> </td>
						</tr>
						<tr> 	
							<td> Nº Nota Fiscal </td>
							<td> <input type="text" id="numeroNotaFiscal" name="numeroNotaFiscal" class="form-control" value="<?php echo $processos[0]->numeroNotaFiscal; ?>" required /> </td>
							<td> Chave de Acesso </td>
							<td> <input type="text" id="chaveAcesso" name="chaveAcesso" class="form-control" value="<?php echo $processos[0]->chaveAcesso; ?>" required /> </td>
							<td> Código Ibge </td>
							<td> <input type="text" id="codigoIBGE" name="codigoIBGE" class="form-control" value="<?php echo $processos[0]->codigoIBGE; ?>" required /> </td>
						</tr>
						</thead>
					</table>					
					<table>
						 <tr>
						   <td> <input hidden type="text" class="form-control" id="validar" name="validar" value="1"> </td>
						   <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade[0]->id; ?>" /></td>
		        		   <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
						 </tr>
					</table>			
					<br/>
					<table>
					 <tr>
					   <td align="left">
					     <a href="{{route('transparenciaOrdemCompra', $unidade[0]->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
					     <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" /> 
					   </td>
					 </tr>
					</table>
                  </div>
            </div>
        </div>
		<div class="col-md-0 col-sm-0"></div>
    </div>
</div> 
</section >    
@endsection
