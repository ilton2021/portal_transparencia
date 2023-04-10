@extends('layouts.app2')
@section('content')
<?php $hoje = date('Y-m-d'); ?>
@if((($contratacao_servicos[0]->prazoInicial <= $hoje && ($contratacao_servicos[0]->prazoFinal >= $hoje || $contratacao_servicos[0]->prazoProrroga >= $hoje) && $contratacao_servicos[0]->status == 1)||($contratacao_servicos[0]->prazoFinal == "" && $contratacao_servicos[0]->prazoProrroga >= "")) == true)

<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('js/utils.js') }}" rel="stylesheet">
	<link href="{{ asset('js/bootstrap.js') }}" rel="stylesheet">
</head>
<div class="container text-center" style="color: #28a745"></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5 style="font-size: 18px;">Proposta de Contratação: {{ $unidades[0]->name }}</h5>
		</div>
	</div>
	<div class="row" style="margin-top: 25px;justify-content: center;">
		<table class="table" style="width: 800px;">
			@foreach($contratacao_servicos as $CS)
			<tr>
				<td>
					<p>{!!$CS->texto!!}</p>
					<ul>
					   	 @foreach($especialidades as $especialidade)
						  @foreach($especialidade_contratacao as $Especialidade_contratacao)
						   @if($especialidade->id == $Especialidade_contratacao->especialidades_id)
						     <?php if($especialidade->id !== "40"){ ?>
						     <li>{{$especialidade->nome}}</li>
						     <?php } ?>
						   @endif
						  @endforeach
						 @endforeach
					</ul>
				</td>

			<tr>
				<td>
					<center>Acesse o arquivo do Processo de Contratação aqui:
						<a href="{{asset('storage/')}}/{{$CS->arquivo}}" width="100px" class="btn btn-sm btn-info" target="_blank"> Download</a>
					</center>
				</td>
			</tr>
			<tr>
			    @if($CS->id == 13)
				<td>
					<center>Acesse o 2º arquivo do Processo de Contratação aqui:
						<a href="{{asset('storage/')}}/contratacao_servicos/TR 002_2022- POSTO C.pdf" width="100px" class="btn btn-sm btn-info" target="_blank"> Download</a>
					</center>
				</td>
				@endif
			</tr>
			@if($CS->arquivo_errat != "")
			<tr>
				<td>
					<center>Acesse a 1º Errata do processo de Contratação aqui:
						<a href="{{asset('storage/')}}/{{$CS->arquivo_errat}}" width="100px" class="btn btn-sm btn-info" target="_blank"> Download</a>
					</center>
				</td>
			</tr>
			@endif
			@if($CS->arquivo_errat_2 != "")
			<tr>
				<td>
					<center>Acesse a 2º Errata do processo de Contratação aqui:
						<a href="{{asset('storage/')}}/{{$CS->arquivo_errat_2}}" width="100px" class="btn btn-sm btn-info" target="_blank"> Download</a>
					</center>
				</td>
			</tr>
			@endif
			@if($CS->arquivo_errat_3 != "")
			<tr>
				<td>
					<center>Acesse a 3º Errata do processo de Contratação aqui:
						<a href="{{asset('storage/')}}/{{$CS->arquivo_errat_3}}" width="100px" class="btn btn-sm btn-info" target="_blank"> Download</a>
					</center>
				</td>
			</tr>
			@endif
			@endforeach
		</table>
	</div><br>
	<center><b>Envie sua proposta para: contratacaodeservicos@hcpgestao.org.br</b></center>
</div>
</div>
@elseif(Auth::check())
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('js/utils.js') }}" rel="stylesheet">
	<link href="{{ asset('js/bootstrap.js') }}" rel="stylesheet">
</head>
<div class="container text-center" style="color: #28a745"></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5 style="font-size: 18px;">Proposta de Contratação: {{ $unidades[0]->name }}</h5>
		</div>
	</div>
	<div class="row" style="margin-top: 25px;justify-content: center;">
		<table class="table" style="width: 800px;">
			@foreach($contratacao_servicos as $CS)
			<tr>
				<td>
					{!! $CS->texto !!}
					<ul>
						@foreach($especialidades as $especialidade)
						 @foreach($especialidade_contratacao as $Especialidade_contratacao)
						  @if($especialidade->id == $Especialidade_contratacao->especialidades_id)
						   <li>{{$especialidade->nome}}</li>
					  	  @endif
						 @endforeach
						@endforeach
					</ul>
				</td>

			<tr>
				<td>
					<center>Acesse o arquivo do Processo de Contratação aqui:
						<a href="{{asset('storage/')}}/{{$CS->arquivo}}" width="100px" class="btn btn-sm btn-info" target="_blank"> Download</a>
					</center>
				</td>
			</tr>
			<tr>
			    @if($CS->id == 13)
				<td>
					<center>Acesse o 2º arquivo do Processo de Contratação aqui:
						<a href="{{asset('storage/')}}/contratacao_servicos/TR 002_2022- POSTO C.pdf" width="100px" class="btn btn-sm btn-info" target="_blank"> Download</a>
					</center>
				</td>
				@endif
			</tr>
			@if($CS->arquivo_errat != "")
			<tr>
				<td>
					<center>Acesse a 1º Errata do processo de Contratação aqui:
						<a href="{{asset('storage/')}}/{{$CS->arquivo_errat}}" width="100px" class="btn btn-sm btn-info" target="_blank"> Download</a>
					</center>
				</td>
			</tr>
			@endif
			@if($CS->arquivo_errat_2 != "")
			<tr>
				<td>
					<center>Acesse a 2º Errata do processo de Contratação aqui:
						<a href="{{asset('storage/')}}/{{$CS->arquivo_errat_2}}" width="100px" class="btn btn-sm btn-info" target="_blank"> Download</a>
					</center>
				</td>
			</tr>
			@endif
			@if($CS->arquivo_errat_3 != "")
			<tr>
				<td>
					<center>Acesse a 3º Errata do processo de Contratação aqui:
						<a href="{{asset('storage/')}}/{{$CS->arquivo_errat_3}}" width="100px" class="btn btn-sm btn-info" target="_blank"> Download</a>
					</center>
				</td>
			</tr>
			@endif
			@endforeach
		</table>
	</div><br>
	<center><b>Envie sua proposta para: contratacaodeservicos@hcpgestao.org.br</b></center>
</div>
</div>
@endif
@endsection