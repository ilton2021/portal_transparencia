@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
@if(Auth::check())
  @foreach ($permissao_users as $permissao)
	@if(($permissao->permissao_id == 1) && ($permissao->user_id == Auth::user()->id))
	  @if ($permissao->unidade_id == $unidade->id)
		<p align="right"><a class="btn btn-info btn-sm" style="margin-top: 10px;" href="{{route('sicCadastro', $unidade->id)}}"> Alterar <i class="fas fa-edit"></i></a></p>
      @endif
	@endif 
  @endforeach			
@endif
<div class="container-fluid" style="margin-top: 25px;">
	<div class="row" style="margin-bottom: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">SERVIÇO DE INFORMAÇÃO AO CLIENTE - SIC <i class="fas fa-globe"></i></h5>
		</div>
	</div>	<br>
	<div class="row">
		@if($unidade->id == 7 || $unidade->id == 4 || $unidade->id == 3 || $unidade->id == 6)
		<table border="0" class="table table-sm" align="center">
		 <tr>
		  <td align="center"> <img class="card-img-top" style="width: 22rem; background-color: #fafafa;" src="{{asset('img/logoGov.png')}}" alt="Card image cap"> </td>
		 </tr>
		 <tr>
		  <td align="center"> <strong> <a href="http://www.portaisgoverno.pe.gov.br/web/ouvidoria/formularios-lai" target="_blank" style="font-size: 11px;">SERVIÇO DE INFORMAÇÃO AO CIDADÃO - SIC <i class="fas fa-globe"></i> clique aqui <i class="fas fa-globe"></i></a> </strong> </td>
		 </tr>
		</table>
		@elseif($unidade->id == 2 || $unidade->id == 5 || $unidade->id == 8)
		<table border="0" class="table table-sm" align="center">
		 <tr>
		  <td align="center"> <img class="card-img-top" style="width: 22rem; background-color: #fafafa;" src="{{asset('img/logo-prefeitura-recife.png')}}" alt="Card image cap"> </td>
		 </tr>
		 <tr>
		  <td align="center"> <strong><a href="https://ouvidoria.recife.pe.gov.br/" target="_blank" style="font-size: 11px;">SERVIÇO DE INFORMAÇÃO AO CIDADÃO - SIC <i class="fas fa-globe"></i> clique aqui <i class="fas fa-globe"></i></a></strong></td>
		 </tr>
		</table>
		@endif
		
		@if($unidade->id == 1)
		<table border="0" class="table table-sm" align="center">
		 <tr>
		  <td align="center"> <img class="card-img-top" style="width: 22rem; background-color: #fafafa;" src="{{asset('img/logoGov.png')}}" alt="Card image cap"> </td>
		  
		  <td align="center"> <img class="card-img-top" style="width: 22rem; background-color: #fafafa;" src="{{asset('img/logo-prefeitura-recife.png')}}" alt="Card image cap"> </td>
		 </tr>
		 <tr>
		  <td align="center"> <strong><a href="http://www.portaisgoverno.pe.gov.br/web/ouvidoria/formularios-lai" target="_blank" style="font-size: 11px;">SERVIÇO DE INFORMAÇÃO AO CIDADÃO - SIC <i class="fas fa-globe"></i> clique aqui <i class="fas fa-globe"></i></a> </strong> </td>
		  
		  <td align="center"> <strong><a href="https://ouvidoria.recife.pe.gov.br/" target="_blank" style="font-size: 11px;">SERVIÇO DE INFORMAÇÃO AO CIDADÃO - SIC <i class="fas fa-globe"></i> clique aqui <i class="fas fa-globe"></i></a></strong></td>
		 </tr>
		</table>		
		@endif
		
	</div> <br> <br>
	<div class="row" style="margin-bottom: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">OUVIDORIA:</h5> <br>
			<?php $qtd = sizeof($ouvidorias); ?>
			@if($qtd > 0) 
			@foreach($ouvidorias as $sic)
			  <table border="0" class="table table-sm">
			    <tr>
				 <td> Unidade: <strong>
				 @if($sic->unidade_id == 1)
				 {{ 'HCP Gestão' }}
				 @elseif($sic->unidade_id == 2)
				 {{ 'Hospital da Mulher do Recife' }}
				 @elseif($sic->unidade_id == 3)
				 {{ 'UPAE Belo Jardim' }}
				 @elseif($sic->unidade_id == 4)
				 {{ 'UPAE Arcoverde' }}
				 @elseif($sic->unidade_id == 5)
				 {{ 'UPAE Arruda' }}
				 @elseif($sic->unidade_id == 6)
				 {{ 'UPAE Caruaru' }}
				 @elseif($sic->unidade_id == 7)
				 {{ 'Hospital São Sebastião' }}
				 @elseif($sic->unidade_id == 8)
				 {{ 'Hospital Provisório do Recife 1' }}
				 @endif
				 </strong></td>
				</tr>  
				@if($sic->responsavel != "")
		        <tr>
				 <td> Responsável: <strong>{{ $sic->responsavel }}</strong></td>
				</tr>
				@endif
				<tr>
				 <td> Email: <strong>{{ $sic->email }}</strong></td>
				</tr>
				<tr>
				 <td> Telefone: <strong> {{ $sic->telefone }} </strong></td>
				</tr>
		      </table>
			@endforeach
	 		@endif
		</div>
	</div>	
</div>
@endsection