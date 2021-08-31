@extends('layouts.app')
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{asset('img/favico.png')}}">
        <title>Portal da Transparencia - HCP</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!-- BOOTSTRAP -->
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
        <!-- OWN STYLE -->
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
		<!-- Font Awesome KIT -->
        <script src="https://kit.fontawesome.com/7656d93ed3.js" crossorigin="anonymous"></script>
        <style>
        .navbar .dropdown-menu .form-control {
            width: 300px;
        }
        </style>
    </head>
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade[0]->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;"> EXCLUIR ORDENS DE COMPRA:</h3>
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
                        Ordens de Compra <i class="fas fa-check-circle"></i>
                    </a>
                    <form method="post" action="{{ route('destroyOrdemCompra', array($unidade[0]->id,$processos[0]->id)) }}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<table border="0" class="table-sm" style="line-height: 1.5;" WIDTH="1020">
				<tr> 
							<td> Nº SOLICITAÇÃO </td>
							<td> <input type="text" id="numeroSolicitacao" readonly = "true" name="numeroSolicitacao" class="form-control" value =" <?php echo $processos[0]->numeroSolicitacao ?>"/> </td>
						</tr>
						<tr>
							<td> DATA DA SOLICITAÇÃO </td>
							<td> <input type="date" id="dataSolicitacao" readonly = "true" name="dataSolicitacao" class="form-control" value ="<?php echo $processos[0]->dataSolicitacao?>" /> </td>
						</tr>
						<tr> 	
							<td> Nº O.C </td>
							<td> <input type="text" id="numeroOC" readonly = "true" name="numeroOC" class="form-control"value =" <?php echo $processos[0]->numeroOC ?>"/> </td>
						</tr>
						<tr> 	
							<td> DATA DE AUTORIZAÇÃO O.C. </td>
							<td> <input type="date" id="dataAutorizacao" readonly = "true" name="dataAutorizacao" class="form-control" value ="<?php echo $processos[0]->dataAutorizacao?> "/> </td>
						</tr>
						<tr> 	
							<td> FORNECEDOR </td>
							<td> <input type="text" id="fornecedor" readonly = "true" name="fornecedor" class="form-control"value ="<?php echo $processos[0]->forncedor?> "/> </td>
						</tr>
						<tr> 	
							<td> CNPJ </td>
							<td> <input type="text" id="cnpj" readonly = "true" name="cnpj" class="form-control"value =" <?php echo $processos[0]->cnpj?>" /> </td>
						</tr>
						<tr> 	
						    <td> QUANTIDADE DA O.C. </td>
							<td> <input type="text" id="qtdOrdemCompra" readonly = "true" name="qtdOrdemCompra" class="form-control"value =" <?php echo $processos[0]->qtdOrdemCompra ?>" /> </td>
						</tr>
						<tr> 		
							<td> VALOR TOTAL DA O.C. </td>
							<td> <input type="text" id="totalValorOC" readonly = "true" name="totalValorOC" class="form-control" value ="<?php echo $processos[0]->totalValorOC?>" /> </td>
						</tr>
						<tr> 	
							<td> PRODUTO </td>
							<td> <input type="text" id="produto" readonly = "true" name="produto" class="form-control" value ="<?php echo $processos[0]->produto?>" /> </td>
						</tr>
						<tr> 		
							<td> CLASSIFICAÇÃO DO ITEM </td>
							<td> <input type="text" id="classificacaoItem" readonly = "true" name="classificacaoItem" class="form-control" value ="<?php echo $processos[0]->cassificacaoItem?> "/> </td>
						</tr>
						<tr> 	
							<td> QUANTIDADE RECEBIDA </td>
							<td> <input type="text" id="quantidadeRecebida" readonly = "true"name="quantidadeRecebida" class="form-control"value ="<?php echo $processos[0]->quantidadeRecebida?>" /> </td>
						</tr>
						<tr> 	
							<td> VALOR TOTAL RECEBIDO </td>
							<td> <input type="text" id="valorTotalRecebido" readonly = "true" name="valorTotalRecebido" class="form-control"value ="<?php echo $processos[0]->valorTotalRecebido?> "/> </td>
						</tr>
						<tr> 	
							<td> Nº NOTA FISCAL </td>
							<td> <input type="text" id="numeroNotaFiscal" readonly = "true" name="numeroNotaFiscal" class="form-control"value ="<?php echo $processos[0]->numeroNotaFiscal?> "/> </td>
						</tr>
						<tr> 	
							<td> CHAVE DE ACESSO </td>
							<td> <input type="text" id="chaveAcesso"readonly = "true" name="chaveAcesso" class="form-control"value ="<?php echo $processos[0]->chaveAcesso?> "/> </td>
						</tr>
						<tr> 	
							<td> CÓDIGO IBGE </td>
							<td> <input type="text" id="codigoIbge" readonly = "true" name="codigoIbge" class="form-control"value ="<?php echo $processos[0]->codigoIbge?> "/> </td>
						</tr>
					</table>
					
					<table>
					   <tr>
						 <t<d> <input hidden type="text" class="form-control" id="unidade_id" name="unidade_id" value="<?php echo $unidade[0]->id; ?>" /> </td>
					   </tr>
					</table>
					
					<br/><br/>
					<p><h6 align="left"> Deseja realmente Excluir esta Ordem de Compra? </h6></p>
					<table>
					 <tr>
					   <td align="left">
						 <a href="{{route('ordemCompraExcluir', array($unidade[0]->id, $processos[0]->id))}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
					     <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Excluir" id="Excluir" name="Excluir" /> 
					   </td>
					 </tr>
					</table>
                  </div>
				</form>
            </div>
        </div>
		<div class="col-md-0 col-sm-0"></div>
    </div>
</div>
@endsection