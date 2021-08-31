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
			<h3 style="font-size: 18px;"> CADASTRAR ORDEM DE COMPRA:</h3>
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
				    <table class="table">
					<tr>
					  <td> NÚMERO SOLICITAÇÃO </td>
					  <td> DATA SOLICITAÇÃO </td>
					  <td> Nº ORDEM COMPRA </td>
					  <td> DATA AUTORIZAÇÃO O.C. </td>
					</tr>
					<tr>  
					@foreach($processos as $prc)
					  <td> {{ $prc->numeroSolicitacao }} </td>
					  <td> {{ date('d-m-Y', strtotime($prc->dataSolicitacao)) }} </td>
					  <td> {{ $prc->numeroOC }} </td>
					  <td> {{ date('d-m-Y', strtotime($prc->dataAutorizacao)) }} </td>
					@endforeach
					</tr>
					</table> <BR><BR>
                    <form method="post" action="{{route('storeOrdemCompra', array($unidade[0]->id)) }}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<table class="table">
                	  <thead>
						<tr> 
							<td> Nº SOLICITAÇÃO </td>
							<td> <input type="text" id="numeroSolicitacao" name="numeroSolicitacao" class="form-control" /> </td>
						</tr>
						<tr>
							<td> DATA DA SOLICITAÇÃO </td>
							<td> <input type="date" id="dataSolicitacao" name="dataSolicitacao" class="form-control" /> </td>
						</tr>
						<tr> 	
							<td> Nº O.C </td>
							<td> <input type="text" id="numeroOC" name="numeroOC" class="form-control" /> </td>
						</tr>
						<tr> 	
							<td> DATA DE AUTORIZAÇÃO O.C. </td>
							<td> <input type="date" id="dataAutorizacao" name="dataAutorizacao" class="form-control" /> </td>
						</tr>
						<tr> 	
							<td> FORNECEDOR </td>
							<td> <input type="text" id="fornecedor" name="fornecedor" class="form-control" /> </td>
						</tr>
						<tr> 	
							<td> CNPJ </td>
							<td> <input type="text" id="cnpj" name="cnpj" class="form-control" /> </td>
						</tr>
						<tr> 	
						    <td> QUANTIDADE DA O.C. </td>
							<td> <input type="text" id="qtdOrdemCompra" name="qtdOrdemCompra" class="form-control" /> </td>
						</tr>
						<tr> 		
							<td> VALOR TOTAL DA O.C. </td>
							<td> <input type="text" id="totalValorOC" name="totalValorOC" class="form-control" /> </td>
						</tr>
						<tr> 	
							<td> PRODUTO </td>
							<td> <input type="text" id="produto" name="produto" class="form-control" /> </td>
						</tr>
						<tr> 		
							<td> CLASSIFICAÇÃO DO ITEM </td>
							<td> <input type="text" id="classificacaoItem" name="classificacaoItem" class="form-control" /> </td>
						</tr>
						<tr> 	
							<td> QUANTIDADE RECEBIDA </td>
							<td> <input type="text" id="quantidadeRecebida" name="quantidadeRecebida" class="form-control" /> </td>
						</tr>
						<tr> 	
							<td> VALOR TOTAL RECEBIDO </td>
							<td> <input type="text" id="valorTotalRecebido" name="valorTotalRecebido" class="form-control" /> </td>
						</tr>
						<tr> 	
							<td> Nº NOTA FISCAL </td>
							<td> <input type="text" id="numeroNotaFiscal" name="numeroNotaFiscal" class="form-control" /> </td>
						</tr>
						<tr> 	
							<td> CHAVE DE ACESSO </td>
							<td> <input type="text" id="chaveAcesso" name="chaveAcesso" class="form-control" /> </td>
						</tr>
						<tr> 	
							<td> CÓDIGO IBGE </td>
							<td> <input type="text" id="codigoIbge" name="codigoIbge" class="form-control" /> </td>
						</tr>
						</thead>
					</table>					
					<table>
						 <tr>
						   <td> <input hidden type="text" class="form-control" id="validar" name="validar" value="1"> </td>
						   <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade[0]->id; ?>" /></td>
						  </tr>
					</table>			
					<br/>
					<table>
					 <tr>
					   <td align="left">
						 <a href="{{route('trasparenciaOrdemCompraNovo', $unidade[0]->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
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