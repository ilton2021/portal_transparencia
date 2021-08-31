@extends('navbar.default-navbar')

<script>
 window.onload = function(){
  <?php if($unidade->id == 8 && $a == 1) { ?>
    <?php if($z == 1) { ?>
	var elemento = document.getElementById('multiCollapseExample5');
	elemento.className=elemento.className.replace('', 'show');
    <?php } else if($z == 2){ ?>
	var elemento = document.getElementById('multiCollapseExample6');
	elemento.className=elemento.className.replace('', 'show');
	<?php } ?>
	var elemento = document.getElementById('multiCollapseExample3');
	elemento.className=elemento.className.replace('', 'show');
	var elemento2 = document.getElementById('multiCollapseExample1');
	elemento2.className=elemento2.className.replace('', 'show');
	var elemento3 = document.getElementById('collapseTwo');
	elemento3.className=elemento3.className.replace('', 'show');
  <?php } ?>
  <?php if($unidade->id != 8 && $a == 1) { ?>
    <?php if($z == 1) { ?>
	var elemento = document.getElementById('multiCollapseExample5');
	elemento.className=elemento.className.replace('', 'show');
    <?php } else if($z == 2){ ?>
	var elemento = document.getElementById('multiCollapseExample6');
	elemento.className=elemento.className.replace('', 'show');
	<?php } ?>
	var elemento = document.getElementById('multiCollapseExample4');
	elemento.className=elemento.className.replace('', 'show');
	var elemento2 = document.getElementById('multiCollapseExample1');
	elemento2.className=elemento2.className.replace('', 'show');
	var elemento3 = document.getElementById('collapseTwo');
	elemento3.className=elemento3.className.replace('', 'show');
  <?php } ?>
 }
</script>
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">CONTRATAÇÕES</h3>
		</div>
	</div>
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 col-sm-12 text-center">
			<div class="accordion" id="accordionExample">
				<!-- REGULAMENTOS -->
				<div class="card">
				  <div class="card-header" id="headingOne">
					<h2 class="mb-0">
					  <a class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						<strong>Regulamentos</strong>
					  </a>
					  @if(Auth::check())
					  <!--a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="" > Alterar <i class="fas fa-edit"></i></a-->
					  @endif
					</h2>
				  </div> 
				  <div id="collapseOne" class="collapse multi-collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
					<div class="card-body"> <?php $a = 2; ?>
						<div class="row">
							<div class="col-6">
								<h6 class="text-success"><strong>Manuais</strong></h6>
								<ul class="list-group">
								<li class="list-group-item border-0" style="font-size: 15px;"><a href="{{asset('../storage/manual_compras_web_setembro_18.pdf')}}" target="_blank">Manual de compras, gestão de materiais e serviços <i style="color: green;  margin-left: 5px;" class="fas fa-download"></i></a></li>
								</ul>
							</div>
							<div class="col-6">
								<h6 class="text-success"><strong>Instruções normativas</strong></h6>
								<ul class="list-group">
									<li class="list-group-item border-0" style="font-size: 15px;"><a href="{{asset('../storage/NormativaCartaoCorporativo.pdf')}}" target="_blank">Normativa Cartão Corporativo<i style="color: green; margin-left: 5px;" class="fas fa-download"></i></a></li>
									<li class="list-group-item border-0" style="font-size: 15px;"><a href="{{asset('../storage/NormativaContratacaoServicos.pdf')}}" target="_blank">Normativa Contratação de Serviços<i style="color: green;  margin-left: 5px;" class="fas fa-download"></i></a></li>
									<li class="list-group-item border-0" style="font-size: 15px;"><a href="{{asset('../storage/NormativaFluxodeCompras.pdf')}}" target="_blank">Normativa Fluxo de Compras<i style="color: green; margin-left: 5px;" class="fas fa-download"></i></a></li>
								</ul>
							</div>
						</div>
					</div>
				  </div>
				</div>
				<!-- COTAÇÕES --> 
				<div class="card">
				  <div class="card-header" id="headingTwo">
					<h2 class="mb-0">
					  <a class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						<strong>Cotações</strong>
					  </a>
					  @if(Auth::check())
					   @foreach ($permissao_users as $permissao)
					    @if(($permissao->permissao_id == 10) && ($permissao->user_id == Auth::user()->id))
					     @if ($permissao->unidade_id == $unidade->id)
						   <a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{route('cadastroCotacoes', $unidade->id)}}" > Alterar <i class="fas fa-edit"></i></a>   
					     @endif
						@endif 
					   @endforeach	
					  @endif
					</h2>
				  </div>
				  
				  @if(($unidade->id > 1) && ($unidade->id < 8))
				  <div id="collapseTwo" class="collapse multi-collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
					<div class="card-body">
						<p>
							<a class="btn btn-success" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Processos de Compra</a>
							<a class="btn btn-success" data-toggle="collapse" href="#multiCollapseExample2" role="button" aria-expanded="false" aria-controls="multiCollapseExample2">Termos de Referência</a>
						</p>
							<div class="collapse border-0" id="multiCollapseExample1">
							<div class="card card-body border-0">
								<div class="container">
								<p>
								<a class="btn btn-success" data-toggle="collapse" href="#multiCollapseExample3" role="button" aria-expanded="false" aria-controls="multiCollapseExample3">Síntese: Mapa do Sistema de Síntese</a> 
								<a class="btn btn-success" data-toggle="collapse" href="#multiCollapseExample4" role="button" aria-expanded="false" aria-controls="multiCollapseExample4">Demais Processos</a> 
								</p>
									<div class="collapse border-0" id="multiCollapseExample3">
									<div class="card card-body border-0">
										<div class="container">
										@foreach ($cotacoes as $cotacaoFiles) 	       
										   @if ($cotacaoFiles->proccess_name == 'MAPA DE COTAÇÕES') 	          
											<table class="table table-sm">
										    <thead>
											 <th scope="col">Título</th>
											 <th scope="col">Arquivo</th>
											</thead>
											<tbody>
											 <th> {{ $cotacaoFiles->proccess_name }} </th>
											 <th> <a target="_blank" href="{{$cotacaoFiles->file_path}}" class="list-group-item list-group-item-action" style="font-size: 12px; padding: 0px; margin-left: 00px">{{$cotacaoFiles->file_name}} <i style="color:#28a745" class="fas fa-download"></i></a> </th>
											</tbody>
											</table>
											@endif 	  
										@endforeach		
										</div>
									</div>
									</div>
									<div class="collapse border-0" id="multiCollapseExample4">
									<div class="card card-body border-0">
										<div class="container">
										 <a class="btn btn-success" data-toggle="collapse" href="#multiCollapseExample5" role="button" aria-expanded="false" aria-controls="multiCollapseExample5">2020</a> 
										 <a class="btn btn-success" data-toggle="collapse" href="#multiCollapseExample6" role="button" aria-expanded="false" aria-controls="multiCollapseExample6">2021</a> 
										</div>
									</div>
									</div>
									<?php if(empty($mes)) { $mes = 0; } else {  } ?>
									<?php $z = 0; ?>
									<div class="collapse border-0" id="multiCollapseExample5">
									<div class="card card-body border-0">
										<div class="container">
										@if($mes <= 9)
											  <table WIDTH="1500px;" border="2">
												 <thead class="bg-success">
													<tr> 	
													  <th scope="col" style="width: 140px"><center>Nº Solicitação</center></th> 	
													  <th scope="col" style="width: 170px"><center>Data Autorização</center></th>
													  <th scope="col" style="width: 120px"><center>Tipo de Pedido</center></th>            
													  <th scope="col" style="width: 200px"><center>Qt. de Itens do Formulário</center></th>
													  <th scope="col" style="width: 850px"><center>Fornecedor</center></th>
													  <th scope="col" style="width: 150px"><center>CNPJ</center></th>
													  <th scope="col" style="width: 100px"><center>Nº O.C.</center></th>
													  <th scope="col" style="width: 200px"><center>Valor Total da O.C.</center></th>            
													  <th scope="col" style="width: 190px"><center>Data da Solicitação</center></th>            
													  <th scope="col" style="width: 170px"><center>Arquivos</center></th>
													</tr>         
												 </thead>
												@if(!empty($processos))
												  @foreach($processos as $processo)
													<div class="collapse border-0" id="{{$mes}}" >
													<tbody> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px" alt="{{$processo->numeroSolicitacao }}"> {{ $processo->numeroSolicitacao }}</td> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><?php if($processo->dataAutorizacao == '1970-01-01'){ echo ""; ?> <?php }else{ ?> {{ date('d/m/Y', strtotime($processo->dataAutorizacao)) }} <?php } ?></td> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px" title="{{ $processo->tipoPedido }}">{{ $processo->tipoPedido }}</td> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center>{{ $processo->qtdItens }}</center></td> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px; width: 50px;"  title="{{ $processo->fornecedor }}">{{ $processo->fornecedor }} </td> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px" title="{{ $processo->cnpj }}">{{ $processo->cnpj }} </td>
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px" title="{{ $processo->numeroOC }}">{{ $processo->numeroOC }}</td>
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px">{{ "R$ ".number_format($processo->totalValorOC, 2,',','.') }}</td>
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><?php if($processo->dataSolicitacao == '1970-01-01'){ echo ""; ?> <?php }else{ ?> {{ date('d/m/Y', strtotime($processo->dataSolicitacao)) }} <?php } ?></td>
													 <td> 
													   <a class="badge badge-pill badge-primary dropdown-toggle" type="button" href="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														Visualizar
														 <div id="div" class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="font-size: 12px;">
														  @foreach($processo_arquivos as $processoA) 
															@if($processoA->processo_id == $processo->id)
															  <a id="div" class="dropdown-item" href="{{asset('../storage/')}}/{{$processoA->file_path}}" target="_blank">{{ $processoA->title }}</a>
															@endif
														  @endforeach
														 </div>	
														</a>
													 </td>
													</tr>	
													</tbody>
													</div>
												  @endforeach
												 @endif
											@elseif($mes > 9)
												<table  WIDTH="2800px;" border="2">
												 <thead class="bg-success" border="2">
												    <tr>
													  <td colspan="2"><center><b>DADOS DA SOLICITAÇÃO</b></center></td>
													  <td colspan="10"><center><b>DADOS DA ORDEM DE COMPRAS</b></center></td>
													  <td colspan="4"><center><b>DADOS DA NOTA FISCAL</b></center></td>
													</tr>
													<tr> 	
													  <th scope="col" style="width: 140px"><center>Nº Solicitação</center></th> 	
													  <th scope="col" style="width: 170px"><center>Data Solicitação</center></th>            
													  <th scope="col" style="width: 100px"><center>Nº O.C.</center></th>
													  <th scope="col" style="width: 170px"><center>Data Autorização</center></th>
													  <th scope="col" style="width: 800px"><center>Fornecedor</center></th>
													  <th scope="col" style="width: 120px"><center>CNPJ</center></th>
													  <th scope="col" style="width: 850px"><center>Produto</center></th>            
													  <th scope="col" style="width: 100px"><center>Qtd O.C.</center></th>            
													  <th scope="col" style="width: 150px"><center>Valor Total O.C</center></th>            
													  <th scope="col" style="width: 680px"><center>Classificação Item</center></th>        
													  <th scope="col" style="width: 150px"><center>Qtd Recebida</center></th>            
													  <th scope="col" style="width: 200px"><center>Valor Tot. Recebido</center></th>            
													  <th scope="col" style="width: 150px"><center>Nº Nota Fiscal</center></th>            
													  <th scope="col" style="width: 150px"><center>Chave Acesso</center></th>            
													  <th scope="col" style="width: 130px"><center>Código IBGE</center></th>            
													  <th scope="col" style="width: 100px"><center>Arquivos</center></th>
													</tr>         
												 </thead>
												@if(!empty($processos))
												  @foreach($processos as $processo)
													<div class="collapse border-0" id="{{$mes}}" >
													<tbody> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px" alt="{{$processo->numeroSolicitacao }}"><center> {{ $processo->numeroSolicitacao }}</center></td> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center><?php if($processo->dataSolicitacao == '1970-01-01'){ echo ""; ?> <?php }else{ ?> {{ date('d/m/Y', strtotime($processo->dataSolicitacao)) }} <?php } ?></center></td>
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px" title="{{ $processo->numeroOC }}"><center>{{ $processo->numeroOC }}</center></td> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center><?php if($processo->dataAutorizacao == '1970-01-01'){ echo ""; ?> <?php }else{ ?> {{ date('d/m/Y', strtotime($processo->dataAutorizacao)) }} <?php } ?></center></td> 		
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px; width: 50px;"  title="{{ $processo->fornecedor }}"><center>{{ $processo->fornecedor }} </center></td> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px" title="{{ $processo->cnpj }}"><center>{{ $processo->cnpj }} </center></td>
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center>{{ $processo->produto }}</center></td> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center>{{ $processo->qtdOrdemCompra }}</center></td> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center>{{ "R$ ".number_format($processo->totalValorOC, 2,',','.') }}</center></td>
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center>{{ $processo->classificacaoItem }}</center></td>
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center>{{ $processo->quantidadeRecebida }}</center></td>
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center>{{ "R$ ".number_format($processo->valorTotalRecebido, 2,',','.') }}</center></td>
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center>{{ $processo->numeroNotaFiscal }}</center></td>
												     <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center>{{ $processo->chaveAcesso }}</center></td>
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center>{{ $processo->codigoIBGE }}</center></td>
													 <td> <center>
													   <a class="badge badge-pill badge-primary dropdown-toggle" type="button" href="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														Visualizar
														 <div id="div" class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="font-size: 12px;">
														  @foreach($processo_arquivos as $processoA) 
															@if($processoA->processo_id == $processo->id)
															  <a id="div" class="dropdown-item" href="{{asset('../storage/')}}/{{$processoA->file_path}}" target="_blank">{{ $processoA->title }}</a>
															@endif
														  @endforeach
														 </div>	
														</a> </center>
													 </td>
													</tr>	
													</tbody>
													</div>
												  @endforeach
												 @endif
											@endif
												 <nav aria-label="Page navigation example">
												  <ul class="pagination justify-content-center">
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,1,2020)) }}">Jan</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,2,2020)) }}">Fev</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,3,2020)) }}">Mar</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,4,2020)) }}">Abr</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,5,2020)) }}">Mai</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,6,2020)) }}">Jun</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,7,2020)) }}">Jul</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,8,2020)) }}">Ago</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,9,2020)) }}">Set</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,10,2020)) }}">Out</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,11,2020)) }}">Nov</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,12,2020)) }}">Dez</a></li>
												  </ul>
												</nav>
											   </table>
										</div>
									</div>
									</div>
									
									<div class="collapse border-0" id="multiCollapseExample6">
									<div class="card card-body border-0">
										<div class="container">
												<table  WIDTH="3000px;" border="2">
												 <thead class="bg-success" border="2">
												    <tr>
													  <td colspan="2"><center><b>DADOS DA SOLICITAÇÃO</b></center></td>
													  <td colspan="10"><center><b>DADOS DA ORDEM DE COMPRAS</b></center></td>
													  <td colspan="4"><center><b>DADOS DA NOTA FISCAL</b></center></td>
													</tr>
													<tr> 	
													  <th scope="col" style="width: 140px"><center>Nº Solicitação</center></th> 	
													  <th scope="col" style="width: 170px"><center>Data Solicitação</center></th>            
													  <th scope="col" style="width: 100px"><center>Nº O.C.</center></th>
													  <th scope="col" style="width: 170px"><center>Data Autorização</center></th>
													  <th scope="col" style="width: 900px"><center>Fornecedor</center></th>
													  <th scope="col" style="width: 120px"><center>CNPJ</center></th>
													  <th scope="col" style="width: 1000px"><center>Produto</center></th>            
													  <th scope="col" style="width: 100px"><center>Qtd O.C.</center></th>            
													  <th scope="col" style="width: 150px"><center>Valor Total O.C</center></th>            
													  <th scope="col" style="width: 600px"><center>Classificação Item</center></th>        
													  <th scope="col" style="width: 150px"><center>Qtd Recebida</center></th>            
													  <th scope="col" style="width: 200px"><center>Valor Tot. Recebido</center></th>            
													  <th scope="col" style="width: 150px"><center>Nº Nota Fiscal</center></th>            
													  <th scope="col" style="width: 650px"><center>Chave Acesso</center></th>            
													  <th scope="col" style="width: 380px"><center>Código IBGE</center></th>            
													  <th scope="col" style="width: 100px"><center>Arquivos</center></th>
													</tr>         
												 </thead>
												@if(!empty($processos))
												  @foreach($processos as $processo)
													<div class="collapse border-0" id="{{$mes}}" >
													<tbody> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px" alt="{{$processo->numeroSolicitacao }}"><center> {{ $processo->numeroSolicitacao }}</center></td> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center><?php if($processo->dataSolicitacao == '1970-01-01'){ echo ""; ?> <?php }else{ ?> {{ date('d/m/Y', strtotime($processo->dataSolicitacao)) }} <?php } ?></center></td>
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px" title="{{ $processo->numeroOC }}"><center>{{ $processo->numeroOC }}</center></td> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center><?php if($processo->dataAutorizacao == '1970-01-01'){ echo ""; ?> <?php }else{ ?> {{ date('d/m/Y', strtotime($processo->dataAutorizacao)) }} <?php } ?></center></td> 		
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px; width: 50px;"  title="{{ $processo->fornecedor }}"><center>{{ $processo->fornecedor }} </center></td> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px" title="{{ $processo->cnpj }}"><center>{{ $processo->cnpj }} </center></td>
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px" title="{{ $processo->produto }}"><center>{{ $processo->produto }}</center></td> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center>{{ $processo->qtdOrdemCompra }}</center></td> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center>{{ "R$ ".number_format($processo->totalValorOC, 2,',','.') }}</center></td>
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px" title="{{ $processo->classificacaoItem }}"><center>{{ $processo->classificacaoItem }}</center></td>
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center>{{ $processo->quantidadeRecebida }}</center></td>
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center>{{ "R$ ".number_format($processo->valorTotalRecebido, 2,',','.') }}</center></td>
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center>{{ $processo->numeroNotaFiscal }}</center></td>
													 <td class="text-truncate" style="max-width: 180px; font-size: 12px" title="{{ $processo->chaveAcesso }}"><center>{{ $processo->chaveAcesso }}</center></td>
													 <td class="text-truncate" style="max-width: 180px; font-size: 12px" title="{{ $processo->codigoIBGE }}"><center>{{ $processo->codigoIBGE }}</center></td>
													 <td> <center>
													   <a class="badge badge-pill badge-primary dropdown-toggle" type="button" href="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														Visualizar
														 <div id="div" class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="font-size: 12px;">
														  @foreach($processo_arquivos as $processoA) 
															@if($processoA->processo_id == $processo->id)
															  <a id="div" class="dropdown-item" href="{{asset('../storage/')}}/{{$processoA->file_path}}" target="_blank">{{ $processoA->title }}</a>
															@endif
														  @endforeach
														 </div>	
														</a> </center>
													 </td>
													</tr>	
													</tbody>
													</div>
												  @endforeach
												 @endif
												 <nav aria-label="Page navigation example">
												  <ul class="pagination justify-content-center">
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,1,2021)) }}">Jan</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,2,2021)) }}">Fev</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,3,2021)) }}">Mar</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,4,2021)) }}">Abr</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,5,2021)) }}">Mai</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,6,2021)) }}">Jun</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,7,2021)) }}">Jul</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,8,2021)) }}">Ago</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,9,2021)) }}">Set</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,10,2021)) }}">Out</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,11,2021)) }}">Nov</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,12,2021)) }}">Dez</a></li>
												  </ul>
												</nav>
											   </table>
										</div>
									</div>
									</div>
								</div>
							</div>
							</div>
							
							<div class="collapse border-0" id="multiCollapseExample2">
							<div class="card card-body border-0">
								<div class="container">	
								  @foreach ($cotacoes->pluck('proccess_name')->unique() as $key => $cotacao)
								    @if ($cotacao !== 'MAPA DE COTAÇÕES')
									<table class="table table-sm" >
									   <thead>
										  <tr>
											<th  style="width: 400px">Título</th>
											<th  style="width: 200px">Download</th>
										  </tr>
									   </thead>
									   <tbody>
											<th> <a style="font-size: 15px; color: #28a745" class="btn" data-toggle="collapse" role="button" aria-expanded="false">
											       <strong>{{$cotacao}}</strong>
												 </a> 
											</th>
											<th>
												@foreach ($cotacoes as $cotacaoFiles)
												 @if ($cotacaoFiles->proccess_name == $cotacao)
													<a target="_blank" href="{{$cotacaoFiles->file_path}}" alt="{{$cotacaoFiles->file_path}}" class="list-group-item list-group-item-action" style="font-size: 10px; position: relative; padding: 5px;">{{$cotacaoFiles->file_name}} <i style="color:#28a745" class="fas fa-download"></i></a>
												 @endif
												@endforeach
											</th>
										</tbody>
									 </table>
									 @endif										
								    @endforeach 
								  </div>
							</div>
							</div>
						</div>
					</div>	
				  @elseif($unidade->id == 8)
				  <div id="collapseTwo" class="collapse multi-collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
					<div class="card-body">
						<p>
							<a class="btn btn-success" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Processos de Compra</a>  
						</p>
							<div class="collapse border-0" id="multiCollapseExample1">
							<div class="card card-body border-0">
							<div class="container">
							<p>
							 <a class="btn btn-success" data-toggle="collapse" href="#multiCollapseExample2" role="button" aria-expanded="false" aria-controls="multiCollapseExample2">Mapa de Síntese</a>
							 <a class="btn btn-success" data-toggle="collapse" href="#multiCollapseExample3" role="button" aria-expanded="false" aria-controls="multiCollapseExample3">Demais Processos</a>
						    </p>
							<div class="collapse border-0" id="multiCollapseExample3">
								<div class="card card-body border-0">
									<div class="container">
									  <a class="btn btn-success" data-toggle="collapse" href="#multiCollapseExample5" role="button" aria-expanded="false" aria-controls="multiCollapseExample5">2020</a> 
									  <a class="btn btn-success" data-toggle="collapse" href="#multiCollapseExample6" role="button" aria-expanded="false" aria-controls="multiCollapseExample6">2021</a> 
									</div>
								</div>
							</div>
									<?php if(empty($mes)) { $mes = 0; } else {  } ?>
									<?php $z = 0; ?>
									<div class="collapse border-0" id="multiCollapseExample5">
									<div class="card card-body border-0">
										<div class="container">
										@if($mes <= 9)
											  <table WIDTH="1500px;" border="2">
												 <thead class="bg-success">
													<tr> 	
													  <th scope="col" style="width: 140px"><center>Nº Solicitação</center></th> 	
													  <th scope="col" style="width: 170px"><center>Data Autorização</center></th>
													  <th scope="col" style="width: 120px"><center>Tipo de Pedido</center></th>            
													  <th scope="col" style="width: 220px"><center>Qt. de Itens do Formulário</center></th>
													  <th scope="col" style="width: 750px"><center>Fornecedor</center></th>
													  <th scope="col" style="width: 170px"><center>CNPJ</center></th>
													  <th scope="col" style="width: 100px"><center>Nº O.C.</center></th>
													  <th scope="col" style="width: 200px"><center>Valor Total da O.C.</center></th>            
													  <th scope="col" style="width: 190px"><center>Data da Solicitação</center></th>            
													  <th scope="col" style="width: 170px"><center>Arquivos</center></th>
													</tr>         
												 </thead>
												@if(!empty($processos))
												  @foreach($processos as $processo)
													<div class="collapse border-0" id="{{$mes}}" >
													<tbody> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px" alt="{{$processo->numeroSolicitacao }}"> {{ $processo->numeroSolicitacao }}</td> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><?php if($processo->dataAutorizacao == '1970-01-01'){ echo ""; ?> <?php }else{ ?> {{ date('d/m/Y', strtotime($processo->dataAutorizacao)) }} <?php } ?></td> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px" title="{{ $processo->tipoPedido }}">{{ $processo->tipoPedido }}</td> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center>{{ $processo->qtdItens }}</center></td> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px; width: 50px;"  title="{{ $processo->fornecedor }}">{{ $processo->fornecedor }} </td> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px" title="{{ $processo->cnpj }}">{{ $processo->cnpj }} </td>
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px" title="{{ $processo->numeroOC }}">{{ $processo->numeroOC }}</td>
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px">{{ "R$ ".number_format($processo->totalValorOC, 2,',','.') }}</td>
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><?php if($processo->dataSolicitacao == '1970-01-01'){ echo ""; ?> <?php }else{ ?> {{ date('d/m/Y', strtotime($processo->dataSolicitacao)) }} <?php } ?></td>
													 <td> 
													   <a class="badge badge-pill badge-primary dropdown-toggle" type="button" href="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														Visualizar
														 <div id="div" class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="font-size: 12px;">
														  @foreach($processo_arquivos as $processoA) 
															@if($processoA->processo_id == $processo->id)
															  <a id="div" class="dropdown-item" href="{{asset('../storage/')}}/{{$processoA->file_path}}" target="_blank">{{ $processoA->title }}</a>
															@endif
														  @endforeach
														 </div>	
														</a>
													 </td>
													</tr>	
													</tbody>
													</div>
												  @endforeach
												 @endif
											@elseif($mes > 9)
												<table  WIDTH="2800px;" border="2">
												 <thead class="bg-success" border="2">
												    <tr>
													  <td colspan="2"><center><b>DADOS DA SOLICITAÇÃO</b></center></td>
													  <td colspan="11"><center><b>DADOS DA ORDEM DE COMPRAS</b></center></td>
													  <td colspan="4"><center><b>DADOS DA NOTA FISCAL</b></center></td>
													</tr>
													<tr> 	
													  <th scope="col" style="width: 140px"><center>Nº Solicitação</center></th> 	
													  <th scope="col" style="width: 170px"><center>Data Solicitação</center></th>            
													  <th scope="col" style="width: 100px"><center>Nº O.C.</center></th>
													  <th scope="col" style="width: 170px"><center>Data Autorização</center></th>
													  <th scope="col" style="width: 950px"><center>Fornecedor</center></th>
													  <th scope="col" style="width: 120px"><center>CNPJ</center></th>
													  <th scope="col" style="width: 850px"><center>Produto</center></th>            
													  <th scope="col" style="width: 100px"><center>Qtd O.C.</center></th>            
													  <th scope="col" style="width: 150px"><center>Valor Total O.C</center></th>            
													  <th scope="col" style="width: 680px"><center>Classificação Item</center></th>        
													  <th scope="col" style="width: 150px"><center>Qtd Recebida</center></th>            
													  <th scope="col" style="width: 200px"><center>Valor Tot. Recebido</center></th>            
													  <th scope="col" style="width: 150px"><center>Nº Nota Fiscal</center></th>            
													  <th scope="col" style="width: 150px"><center>Chave Acesso</center></th>            
													  <th scope="col" style="width: 130px"><center>Código IBGE</center></th>            
													  <th scope="col" style="width: 100px"><center>Arquivos</center></th>
													</tr>         
												 </thead>
												@if(!empty($processos))
												  @foreach($processos as $processo)
													<div class="collapse border-0" id="{{$mes}}" >
													<tbody> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px" alt="{{$processo->numeroSolicitacao }}"><center> {{ $processo->numeroSolicitacao }}</center></td> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center><?php if($processo->dataSolicitacao == '1970-01-01'){ echo ""; ?> <?php }else{ ?> {{ date('d/m/Y', strtotime($processo->dataSolicitacao)) }} <?php } ?></center></td>
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px" title="{{ $processo->numeroOC }}"><center>{{ $processo->numeroOC }}</center></td> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center><?php if($processo->dataAutorizacao == '1970-01-01'){ echo ""; ?> <?php }else{ ?> {{ date('d/m/Y', strtotime($processo->dataAutorizacao)) }} <?php } ?></center></td> 		
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px; width: 50px;"  title="{{ $processo->fornecedor }}"><center>{{ $processo->fornecedor }} </center></td> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px" title="{{ $processo->cnpj }}"><center>{{ $processo->cnpj }} </center></td>
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center>{{ $processo->produto }}</center></td> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center>{{ $processo->qtdOrdemCompra }}</center></td> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center>{{ "R$ ".number_format($processo->totalValorOC, 2,',','.') }}</center></td>
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center>{{ $processo->classificacaoItem }}</center></td>
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center>{{ $processo->quantidadeRecebida }}</center></td>
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center>{{ "R$ ".number_format($processo->valorTotalRecebido, 2,',','.') }}</center></td>
													 <td class="text-truncate" style="max-width: 150px; font-size: 12px"><center>{{ $processo->numeroNotaFiscal }}</center></td>
												     <td class="text-truncate" style="max-width: 150px; font-size: 12px"><center>{{ $processo->chaveAcesso }}</center></td>
													 <td class="text-truncate" style="max-width: 150px; font-size: 12px"><center>{{ $processo->codigoIBGE }}</center></td>
													 <td> <center>
													   <a class="badge badge-pill badge-primary dropdown-toggle" type="button" href="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														Visualizar
														 <div id="div" class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="font-size: 12px;">
														  @foreach($processo_arquivos as $processoA) 
															@if($processoA->processo_id == $processo->id)
															  <a id="div" class="dropdown-item" href="{{asset('../storage/')}}/{{$processoA->file_path}}" target="_blank">{{ $processoA->title }}</a>
															@endif
															
														  @endforeach
														 </div>	
														</a> </center>
													 </td>
													</tr>	
													</tbody>
													</div>
												  @endforeach
												 @endif
												 
											@endif
												 <nav aria-label="Page navigation example">
												  <ul class="pagination justify-content-center">
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,1,2020)) }}">Jan</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,2,2020)) }}">Fev</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,3,2020)) }}">Mar</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,4,2020)) }}">Abr</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,5,2020)) }}">Mai</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,6,2020)) }}">Jun</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,7,2020)) }}">Jul</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,8,2020)) }}">Ago</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,9,2020)) }}">Set</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,10,2020)) }}">Out</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,11,2020)) }}">Nov</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,12,2020)) }}">Dez</a></li>
												  </ul>
												</nav>
											   </table>
										</div>
									</div>
									</div>
									
									<div class="collapse border-0" id="multiCollapseExample6">
									<div class="card card-body border-0">
										<div class="container">
												<table  WIDTH="2800px;" border="2">
												 <thead class="bg-success" border="2">
												    <tr>
													  <td colspan="2"><center><b>DADOS DA SOLICITAÇÃO</b></center></td>
													  <td colspan="10"><center><b>DADOS DA ORDEM DE COMPRAS</b></center></td>
													  <td colspan="4"><center><b>DADOS DA NOTA FISCAL</b></center></td>
													</tr>
													<tr> 	
													  <th scope="col" style="width: 140px"><center>Nº Solicitação</center></th> 	
													  <th scope="col" style="width: 170px"><center>Data Solicitação</center></th>            
													  <th scope="col" style="width: 100px"><center>Nº O.C.</center></th>
													  <th scope="col" style="width: 170px"><center>Data Autorização</center></th>
													  <th scope="col" style="width: 950px"><center>Fornecedor</center></th>
													  <th scope="col" style="width: 120px"><center>CNPJ</center></th>
													  <th scope="col" style="width: 850px"><center>Produto</center></th>            
													  <th scope="col" style="width: 100px"><center>Qtd O.C.</center></th>            
													  <th scope="col" style="width: 150px"><center>Valor Total O.C</center></th>            
													  <th scope="col" style="width: 780px"><center>Classificação Item</center></th>        
													  <th scope="col" style="width: 150px"><center>Qtd Recebida</center></th>            
													  <th scope="col" style="width: 200px"><center>Valor Tot. Recebido</center></th>            
													  <th scope="col" style="width: 150px"><center>Nº Nota Fiscal</center></th>            
													  <th scope="col" style="width: 650px"><center>Chave Acesso</center></th>            
													  <th scope="col" style="width: 430px"><center>Código IBGE</center></th>            
													  <th scope="col" style="width: 100px"><center>Arquivos</center></th>
													</tr>         
												 </thead>
												@if(!empty($processos))
												  @foreach($processos as $processo)
													<div class="collapse border-0" id="{{$mes}}" >
													<tbody> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px" alt="{{$processo->numeroSolicitacao }}"><center> {{ $processo->numeroSolicitacao }}</center></td> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center><?php if($processo->dataSolicitacao == '1970-01-01'){ echo ""; ?> <?php }else{ ?> {{ date('d/m/Y', strtotime($processo->dataSolicitacao)) }} <?php } ?></center></td>
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px" title="{{ $processo->numeroOC }}"><center>{{ $processo->numeroOC }}</center></td> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center><?php if($processo->dataAutorizacao == '1970-01-01'){ echo ""; ?> <?php }else{ ?> {{ date('d/m/Y', strtotime($processo->dataAutorizacao)) }} <?php } ?></center></td> 		
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px; width: 50px;"  title="{{ $processo->fornecedor }}"><center>{{ $processo->fornecedor }} </center></td> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px" title="{{ $processo->cnpj }}"><center>{{ $processo->cnpj }} </center></td>
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center>{{ $processo->produto }}</center></td> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center>{{ $processo->qtdOrdemCompra }}</center></td> 	
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center>{{ "R$ ".number_format($processo->totalValorOC, 2,',','.') }}</center></td>
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center>{{ $processo->classificacaoItem }}</center></td>
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center>{{ $processo->quantidadeRecebida }}</center></td>
													 <td class="text-truncate" style="max-width: 180px; font-size: 12px"><center>{{ "R$ ".number_format($processo->valorTotalRecebido, 2,',','.') }}</center></td>
													 <td class="text-truncate" style="max-width: 100px; font-size: 12px"><center>{{ $processo->numeroNotaFiscal }}</center></td>
													 <td class="text-truncate" style="max-width: 180px; font-size: 12px" title="{{ $processo->chaveAcesso }}"><center>{{ $processo->chaveAcesso }}</center></td>
													 <td class="text-truncate" style="max-width: 180px; font-size: 12px" title="{{ $processo->codigoIBGE }}"><center>{{ $processo->codigoIBGE }}</center></td>
													 <td> <center>
													   <a class="badge badge-pill badge-primary dropdown-toggle" type="button" href="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														Visualizar
														 <div id="div" class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="font-size: 12px;">
														  @foreach($processo_arquivos as $processoA) 
															@if($processoA->processo_id == $processo->id)
															  <a id="div" class="dropdown-item" href="{{asset('../storage/')}}/{{$processoA->file_path}}" target="_blank">{{ $processoA->title }}</a>
															@endif
														  @endforeach
														 </div>	
														</a> </center>
													 </td>
													</tr>	
													</tbody>
													</div>
												  @endforeach
												 @endif
												 <nav aria-label="Page navigation example">
												  <ul class="pagination justify-content-center">
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,1,2021)) }}">Jan</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,2,2021)) }}">Fev</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,3,2021)) }}">Mar</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,4,2021)) }}">Abr</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,5,2021)) }}">Mai</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,6,2021)) }}">Jun</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,7,2021)) }}">Jul</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,8,2021)) }}">Ago</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,9,2021)) }}">Set</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,10,2021)) }}">Out</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,11,2021)) }}">Nov</a></li>
													<li class="page-item"><a class="page-link" href="{{ route('pesquisarMesCotacao', array($unidade->id,12,2021)) }}">Dez</a></li>
												  </ul>
												</nav>
											   </table>   
												
										</div>
							     </div>
							   </div>
							</div>
							</div>
							</div>
						   
							<div class="collapse border-0" id="multiCollapseExample2">
							<div class="card card-body border-0">
								<div class="container">	
								  @foreach ($cotacoes->pluck('proccess_name')->unique() as $key => $cotacao)
								    @if ($cotacao == 'MAPA DE COTAÇÕES')
									<table class="table table-sm" >
									   <thead>
										  <tr>
											<th scope="col" style="width: 400px">Título</th>
											<th scope="col" style="width: 200px">Download</th>
										  </tr>
									   </thead>
									   <tbody>
											<th> <a style="font-size: 15px; color: #28a745" class="btn" data-toggle="collapse" role="button" aria-expanded="false">
											       <strong>{{$cotacao}}</strong>
												 </a> 
											</th>
											<th>
												@foreach ($cotacoes as $cotacaoFiles)
												 @if ($cotacaoFiles->proccess_name == $cotacao)
													<a target="_blank" href="{{$cotacaoFiles->file_path}}" alt="{{$cotacaoFiles->file_path}}" class="list-group-item list-group-item-action" style="font-size: 12px; padding: 0px; margin-left: 00px">{{$cotacaoFiles->file_name}} <i style="color:#28a745" class="fas fa-download"></i></a>
												 @endif
												@endforeach
											</th>
										</tbody>
									 </table>
									 @endif										
								    @endforeach 
								  </div>
							</div>
							</div>
						  </div>	
						 </div>
						@endif
					</div>
					
				<!-- AQUISIÇõES -->
				@if($unidade->id == 8)
				<div class="card">
				  <div class="card-header" id="headingFive">
					<h2 class="mb-0">
					  <a class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
						<strong>Aquisições Operação COVID-19</strong>
					  </a>
					  @if(Auth::check())
					   @foreach ($permissao_users as $permissao)
					    @if(($permissao->permissao_id == 10) && ($permissao->user_id == Auth::user()->id))
					     @if ($permissao->unidade_id == $unidade->id)
						   <a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{route('cadastroCotacoes', $unidade->id)}}" > Alterar <i class="fas fa-edit"></i></a>   
					     @endif
						@endif 
					   @endforeach	
					  @endif
					</h2>
				  </div>
				  <div id="collapseFive" class="collapse multi-collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
					<div class="card-body">
							<p>
							  <a class="btn btn-success" data-toggle="collapse" href="#multiCollapseExample8" role="button" aria-expanded="false" aria-controls="multiCollapseExample8">Aquisições</a>
							</p>
									<div class="collapse border-0" id="multiCollapseExample8">
									<div class="card card-body border-0">
										<div class="container">
										@foreach ($cotacoes->pluck('proccess_name')->unique() as $key => $cotacao)
												@if ($cotacao !== 'MAPA DE COTAÇÕES')
												<table class="table table-sm" >
												   <thead>
													  <tr>
														<th scope="col" style="width: 400px">Título</th>
														<th scope="col" style="width: 200px">Download</th>
													  </tr>
												   </thead>
												   <tbody>
														<th> <a style="font-size: 15px; color: #28a745" class="btn" data-toggle="collapse" role="button" aria-expanded="false">
															   <strong>{{$cotacao}}</strong>
															 </a> 
														</th>
														<th>
															@foreach ($cotacoes as $cotacaoFiles)
															 @if ($cotacaoFiles->proccess_name == $cotacao)
																<a target="_blank" href="{{asset('../storage')}}/{{$cotacaoFiles->file_path}}" class="list-group-item list-group-item-action" style="font-size: 12px; padding: 0px; margin-left: 00px">{{$cotacaoFiles->file_name}} <i style="color:#28a745" class="fas fa-download"></i></a>
															 @endif
															@endforeach
														</th>
													</tbody>
												 </table>
												 @endif										
										@endforeach   
										</div>
									</div>
									</div>
						</div>
					</div>
					</div>
				</div>	
				@endif	
					 
				<!-- CONTRATOS -->
				<div class="card">
				  <div class="card-header" id="headingThree">
					<h2 class="mb-0">
					  <a class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						<strong>Contratos</strong>
					  </a>
					  @if(Auth::check())
					   @foreach ($permissao_users as $permissao)
					    @if(($permissao->permissao_id == 11) && ($permissao->user_id == Auth::user()->id))
					     @if ($permissao->unidade_id == $unidade->id)
						   <a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{route('contratacaoCadastro', $unidade->id)}}" > Alterar <i class="fas fa-edit"></i></a>
					     @endif
						@endif 
					   @endforeach	
					  @endif
					</h2>
				  </div>
				  <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
					<div class="card-body">
						<p>
						<a style="width:200px;" class="btn btn-success" data-toggle="collapse" href="#obras" role="button" aria-expanded="false" aria-controls="collapseExample">
						OBRAS <i class="fas fa-hard-hat"></i>
						</a>
						</p>
						<div class="collapse border-0" id="obras">
						<div class="card card-body border-0">
							<p>
							<a style="width:200px;" class="btn btn-success" data-toggle="collapse" href="#obrasPessoaFisica" role="button" aria-expanded="false" aria-controls="collapseExample">
							PESSOA FÍSICA <i class="fas fa-user-alt"></i>
							</a>							
							<a style="width:200px;" class="btn btn-success" data-toggle="collapse" href="#obrasPessoaJuridica" role="button" aria-expanded="false" aria-controls="collapseExample">
							PESSOA JURÍDICA <i class="fas fa-user-tie"></i>
							</a>
							</p>
							<div class="collapse border-0" id="obrasPessoaFisica">
								<div class="card card-body border-0">
									<div class="container">
										<table class="table table-sm">
											<thead>
											<tr>
											    <th scope="col">CPF</th>
												<th scope="col">Empresa</th>
												<th scope="col">Objeto</th>
												<th scope="col">Opções</th>
											</tr>
											</thead>
											<tbody>
											@foreach ($contratos as $contrato)
											@if ($contrato->tipo_contrato === 'OBRAS' && $contrato->tipo_pessoa === 'PESSOA FÍSICA')
												<tr>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->cnpj_cpf}}">{{$contrato->cnpj_cpf}}</td>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->prestador}}">{{$contrato->prestador}}</td>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->objeto}}">{{$contrato->objeto}}</td>
													<td> 
														<a class="badge badge-pill badge-primary dropdown-toggle" type="button" href="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														Visualizar
														</a> <?php $id = 0; ?>
														<div id="div" class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="font-size: 12px;">
															<a id="div" class="dropdown-item" href="{{$contrato->file_path}}" target="_blank">Contrato</a>
															@foreach($aditivos as $aditivo) 
																@if($aditivo->contrato_id == $contrato->ID)
																	@if($aditivo->opcao == 1)
																		<?php $id += 1; ?>
																		@if($aditivo->ativa == 1)
																		  <strong><a id="div" class="dropdown-item" href="{{$aditivo->file_path}}" target="_blank">{{$id}}º Aditivo</a></strong>
																	    @else
																		  <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">{{$id}}º Aditivo</a></strong>	
																		@endif
																	@elseif($aditivo->opcao == 2)
																	    @if($aditivo->ativa == 1)
																		  <strong><a id="div" class="dropdown-item" href="{{$aditivo->file_path}}" target="_blank">Distrato</a></strong>	
																	    @else
																		  <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">Distrato</a></strong>		
																		@endif
																	@else 
																		@if($aditivo->ativa == 1)
																		  <strong><a id="div" class="dropdown-item" href="{{$aditivo->file_path}}" target="_blank">Contrato</a></strong>	
																	    @else
																		  <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">Contrato</a></strong>		
																		@endif
																	@endif
																@endif
															@endforeach
														</div>
														</td>
												</tr>
											@endif
											@endforeach	
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div class="collapse border-0" id="obrasPessoaJuridica">
								<div class="card card-body border-0">
									<div class="container">
										<table class="table table-sm">
											<thead>
											<tr>
												<th scope="col">CNPJ</th>
												<th scope="col">Empresa</th>
												<th scope="col">Objeto</th>
												<th scope="col">Opções</th>
											</tr>
											</thead>
											<tbody>
											@foreach ($contratos as $contrato)
											@if ($contrato->tipo_contrato == 'OBRAS' && $contrato->tipo_pessoa == 'PESSOA JURÍDICA')
												<tr>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->cnpj_cpf}}">{{$contrato->cnpj_cpf}}</td>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->prestador}}">{{$contrato->prestador}}</td>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->objeto}}">{{$contrato->objeto}}</td>
													<td> 
														<a class="badge badge-pill badge-primary dropdown-toggle" type="button" href="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														Visualizar
														</a> <?php $id = 0; ?>
														<div id="div" class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="font-size: 12px;">
															<a id="div" class="dropdown-item" href="{{$contrato->file_path}}" target="_blank">Contrato</a>
															@foreach($aditivos as $aditivo) 
																@if($aditivo->contrato_id == $contrato->ID)
																	@if($aditivo->opcao == 1)
																		<?php $id += 1; ?>
																		@if($aditivo->ativa == 1)
																		  <strong><a id="div" class="dropdown-item" href="{{$aditivo->file_path}}" target="_blank">{{$id}}º Aditivo</a></strong>
																	    @else
																		  <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">{{$id}}º Aditivo</a></strong>	
																		@endif
																	@elseif($aditivo->opcao == 2)
																	    @if($aditivo->ativa == 1)
																		  <strong><a id="div" class="dropdown-item" href="{{$aditivo->file_path}}" target="_blank">Distrato</a></strong>	
																	    @else
																		  <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">Distrato</a></strong>		
																		@endif	
																	@else 
																		@if($aditivo->ativa == 1)
																		  <strong><a id="div" class="dropdown-item" href="{{$aditivo->file_path}}" target="_blank">Contrato</a></strong>	
																	    @else
																		  <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">Contrato</a></strong>		
																		@endif
																	@endif
																@endif
															@endforeach
														</div>
														</td>
												</tr>
											@endif
											@endforeach	
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						</div>
						<p>			
						<a style="width:200px;" class="btn btn-success" data-toggle="collapse" href="#servicos" role="button" aria-expanded="false" aria-controls="collapseExample">
						SERVIÇOS <i class="fas fa-tools"></i>
						</a>
						</p>
						<div class="collapse border-0" id="servicos">
						<div class="card card-body border-0">
							<p>
							<a style="width:200px;" class="btn btn-success" data-toggle="collapse" href="#servicosPessoaFisica" role="button" aria-expanded="false" aria-controls="collapseExample">
							PESSOA FÍSICA <i class="fas fa-user-alt"></i>
							</a>
							<a style="width:200px;" class="btn btn-success" data-toggle="collapse" href="#servicosPessoaJuridica" role="button" aria-expanded="false" aria-controls="collapseExample">
							PESSOA JURÍDICA <i class="fas fa-user-tie"></i>
							</a>
							</p> 
							<div class="collapse border-0" id="servicosPessoaFisica"> 
								<div class="card card-body border-0">
									<div class="container">
										<table class="table table-sm">
											<thead>
											  <tr>
												<th scope="col">CNPJ:</th>
												<th scope="col">Pessoa</th>
												<th scope="col">Serviço</th>
												<th scope="col">Opções</th>
											  </tr>
											</thead>
											<tbody>
											@foreach ($contratos as $contrato)
											@if ($contrato->tipo_contrato == 'SERVIÇOS' && $contrato->tipo_pessoa == 'PESSOA FÍSICA')
												<tr>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->cnpj_cpf}}">{{$contrato->cnpj_cpf}}</td>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->prestador}}">{{$contrato->prestador}}</td>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->objeto}}">{{$contrato->objeto}}</td>
													<td> 
														<a class="badge badge-pill badge-primary dropdown-toggle" type="button" href="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														Visualizar
														</a> <?php $id = 0; ?>
														<div id="div" class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="font-size: 12px;">
															<a id="div" class="dropdown-item" href="{{$contrato->file_path}}" target="_blank">Contrato</a>
															@foreach($aditivos as $aditivo) 
																@if($aditivo->contrato_id == $contrato->ID)
																	@if($aditivo->opcao == 1)
																		<?php $id += 1; ?>
																		@if($aditivo->ativa == 1)
																		  <strong><a id="div" class="dropdown-item" href="{{$aditivo->file_path}}" target="_blank">{{$id}}º Aditivo</a></strong>
																	    @else
																		  <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">{{$id}}º Aditivo</a></strong>	
																		@endif
																	@elseif($aditivo->opcao == 2)
																	    @if($aditivo->ativa == 1)
																		  <strong><a id="div" class="dropdown-item" href="{{$aditivo->file_path}}" target="_blank">Distrato</a></strong>	
																	    @else
																		  <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">Distrato</a></strong>		
																		@endif
																	@else 
																		@if($aditivo->ativa == 1)
																		  <strong><a id="div" class="dropdown-item" href="{{$aditivo->file_path}}" target="_blank">Contrato</a></strong>	
																	    @else
																		  <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">Contrato</a></strong>		
																		@endif
																	@endif
																@endif
															@endforeach
														</div>
														</td>
												</tr>
											@endif
											@endforeach	
											</tbody>
										</table>
									</div>
								</div>
							</div>
							
							<div class="collapse border-0" id="servicosPessoaJuridica">
								<div class="card card-body border-0">
									<div class="container">
										<table class="table table-hover table-sm">
											<thead>
											  <tr>
												<!-- <th scope="col">ID</th-->
												<th scope="col">CNPJ</th>
												<th scope="col">Empresa</th>
												<th scope="col">Serviço</th>
												<th scope="col">Opções</th>
											  </tr>
											</thead>
											<tbody>
											@foreach ($contratos as $contrato)
											@if ($contrato->tipo_contrato == 'SERVIÇOS' && $contrato->tipo_pessoa == 'PESSOA JURÍDICA')
												<tr>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->cnpj_cpf}}">{{$contrato->cnpj_cpf}}</td>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->prestador}}">{{$contrato->prestador}}</td>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->objeto}}">{{$contrato->objeto}}</td>
													<td> 
														<a class="badge badge-pill badge-primary dropdown-toggle" type="button" href="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														Visualizar
														</a> <?php $id = 0; ?>
														<div id="div" class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="font-size: 12px;">
															<?php if($contrato->cadastro == 0){  ?>
															<a id="div" class="dropdown-item" href="{{$contrato->file_path}}" target="_blank">Contrato</a>
															<?php } else { ?>
															<a id="div" class="dropdown-item" href="{{asset('storage/')}}/{{$contrato->file_path}}" target="_blank">Contrato</a>	
															<?php } ?>
															@foreach($aditivos as $aditivo) 
																@if($aditivo->contrato_id == $contrato->ID)
																	@if($aditivo->opcao == 1)
																		<?php $id += 1; ?>
																		@if($aditivo->ativa == 1)
																		  <strong><a id="div" class="dropdown-item" href="{{$aditivo->file_path}}" target="_blank">{{$id}}º Aditivo</a></strong>
																	    @else
																		  <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">{{$id}}º Aditivo</a></strong>	
																		@endif
																	@elseif($aditivo->opcao == 2)
																	    @if($aditivo->ativa == 1)
																		  <strong><a id="div" class="dropdown-item" href="{{$aditivo->file_path}}" target="_blank">Distrato</a></strong>	
																	    @else
																		  <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">Distrato</a></strong>		
																		@endif
																	@else 
																		@if($aditivo->ativa == 1)
																		  <strong><a id="div" class="dropdown-item" href="{{$aditivo->file_path}}" target="_blank">Contrato</a></strong>	
																	    @else
																		  <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">Contrato</a></strong>		
																		@endif
																	@endif
																@endif
															@endforeach
														</div>
													</td>
												</tr>
											@endif
											@endforeach
									</tbody>
								</table>
									</div>
								</div>
							</div>
						</div>
						</div>
						<p>
						<a style="width:200px;" class="btn btn-success" data-toggle="collapse" href="#aquisicao" role="button" aria-expanded="false" aria-controls="collapseExample">
						AQUISIÇÃO DE BENS <i class="fas fa-people-carry"></i>
						</a>
						</p>
						<div class="collapse border-0" id="aquisicao">
						<div class="card card-body border-0">
							<p>
							<a style="width:200px;" class="btn btn-success" data-toggle="collapse" href="#aquisicaoPessoaFisica" role="button" aria-expanded="false" aria-controls="collapseExample">
							PESSOA FÍSICA <i class="fas fa-user-alt"></i>
							</a>
							<a style="width:200px;" class="btn btn-success" data-toggle="collapse" href="#aquisicaoPessoaJuridica" role="button" aria-expanded="false" aria-controls="collapseExample">
							PESSOA JURÍDICA <i class="fas fa-user-tie"></i>
							</a>
							</p>
							<div class="collapse border-0" id="aquisicaoPessoaFisica">
								<div class="card card-body border-0">
									<div class="container">
										<table class="table table-sm">
											<thead>
											<tr>
												<th scope="col">CPF</th>
												<th scope="col">Empresa</th>
												<th scope="col">Objeto</th>
												<th scope="col">Opções</th>
											</tr>
											</thead>
											<tbody>
											@foreach ($contratos as $contrato)
											@if ($contrato->tipo_contrato == 'AQUISIÇÃO' && $contrato->tipo_pessoa == 'PESSOA FÍSICA')
												<tr>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->cnpj_cpf}}">{{$contrato->cnpj_cpf}}</td>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->prestador}}">{{$contrato->prestador}}</td>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->objeto}}">{{$contrato->objeto}}</td>
													<td> 
														<a class="badge badge-pill badge-primary dropdown-toggle" type="button" href="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														Visualizar
														</a> <?php $id = 0; ?>
														<div id="div" class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="font-size: 12px;">
															<a id="div" class="dropdown-item" href="{{$contrato->file_path}}" target="_blank">Contrato</a>
															@foreach($aditivos as $aditivo) 
																@if($aditivo->contrato_id == $contrato->ID)
																	@if($aditivo->opcao == 1)
																		<?php $id += 1; ?>
																		@if($aditivo->ativa == 1)
																		  <strong><a id="div" class="dropdown-item" href="{{$aditivo->file_path}}" target="_blank">{{$id}}º Aditivo</a></strong>
																	    @else
																		  <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">{{$id}}º Aditivo</a></strong>	
																		@endif
																	@elseif($aditivo->opcao == 2)
																	    @if($aditivo->ativa == 1)
																		  <strong><a id="div" class="dropdown-item" href="{{$aditivo->file_path}}" target="_blank">Distrato</a></strong>	
																	    @else
																		  <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">Distrato</a></strong>		
																		@endif
																	@else 
																		@if($aditivo->ativa == 1)
																		  <strong><a id="div" class="dropdown-item" href="{{$aditivo->file_path}}" target="_blank">Contrato</a></strong>	
																	    @else
																		  <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">Contrato</a></strong>		
																		@endif
																	@endif
																@endif
															@endforeach
														</div>
														</td>
												</tr>
											@endif
											@endforeach	
											</tbody>
										</table>
									</div>						
								</div>
							</div>
							<div class="collapse border-0" id="aquisicaoPessoaJuridica">
								<div class="card card-body border-0">
									<div class="container">
										<table class="table table-sm">
											<thead>
											<tr>
												<th scope="col">CNPJ</th>
												<th scope="col">Empresa</th>
												<th scope="col">Objeto</th>
												<th scope="col">Opções</th>
											</tr>
											</thead>
											<tbody>
											@foreach ($contratos as $contrato)
											@if ($contrato->tipo_contrato == 'AQUISIÇÃO' && $contrato->tipo_pessoa == 'PESSOA JURÍDICA')
												<tr>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->cnpj_cpf}}">{{$contrato->cnpj_cpf}}</td>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->prestador}}">{{$contrato->prestador}}</td>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->objeto}}">{{$contrato->objeto}}</td>
													<td> 
														<a class="badge badge-pill badge-primary dropdown-toggle" type="button" href="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														Visualizar
														</a> <?php $id = 0; ?>
														<div id="div" class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="font-size: 12px;">
															<a id="div" class="dropdown-item" href="{{$contrato->file_path}}" target="_blank">Contrato</a>
															@foreach($aditivos as $aditivo) 
																@if($aditivo->contrato_id == $contrato->ID)
																	@if($aditivo->opcao == 1)
																		<?php $id += 1; ?>
																		@if($aditivo->ativa == 1)
																		  <strong><a id="div" class="dropdown-item" href="{{$aditivo->file_path}}" target="_blank">{{$id}}º Aditivo</a></strong>
																	    @else
																		  <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">{{$id}}º Aditivo</a></strong>	
																		@endif
																	@elseif($aditivo->opcao == 2)
																	    @if($aditivo->ativa == 1)
																		  <strong><a id="div" class="dropdown-item" href="{{$aditivo->file_path}}" target="_blank">Distrato</a></strong>	
																	    @else
																		  <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">Distrato</a></strong>		
																		@endif
																	@else 
																		@if($aditivo->ativa == 1)
																		  <strong><a id="div" class="dropdown-item" href="{{$aditivo->file_path}}" target="_blank">Contrato</a></strong>	
																	    @else
																		  <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">Contrato</a></strong>		
																		@endif
																	@endif
																@endif
															@endforeach
														</div>
														</td>
												</tr>
											@endif
											@endforeach	
											</tbody>
										</table>
									</div>
								</div>
								</div>
							</div>
						</div>
					</div>
				  </div>
				</div>
			  </div> 	
        </div>
		</div>
    </div>
</div>
@endsection