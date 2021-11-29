@extends('layouts.app2')
@section('content')
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
			<h5  style="font-size: 18px;">Termo de Referência <br><br> Proposta de Contratação: {{ $unidades[0]->name }}</h5>
		</div>
	</div>	
	<div class="row" style="margin-top: 25px; margin-left: 300px;">
		<div class="col-md-6 col-sm-6">
		<table class="table" style="width: 800px;">	
			@foreach($unidades as $und)
			 @if($und->id == 3) 	
				<tr>
					<td style="width: 800px;"><p align="justify"> A UPAE BELO JARDIM, através do HCP Gestão, esta realizando Processo de 
					Contratação de Prestação em Serviços Médicos para Consultas, Exames e Procedimentos, nas seguintes 
					Especialidades:</p>
					<ul>
					<li>CARDIOLOGIA</li>
					<li>GASTROENTEROLOGIA</li>
					<li>GINECOLOGIA</li>
					<li>VASCULAR</li>
					<li>ENDOCRINOLOGIA</li>
					<li>NEUROLOGIA</li>
					<li>MASTOLOGIA</li></ul>
					<br>Acesse o Processo de Contratação aqui: 
					<a href="{{asset('img/tr/Belo/Termo de Especificações - Processo de Contratação de Serviços Médicos UPAE BELO JARDIM.pdf')}}" width="100px" class="btn btn-sm btn-info" target="_blank"> Download</a>
					</td>
				</tr>
			@elseif($und->id == 4)
			<tr>
					<td style="width: 800px;"><p align="justify"> A UPAE ARCOVERDE, através do HCP Gestão, esta realizando Processo de 
					Contratação de Prestação em Serviços Médicos para Consultas, Exames e Procedimentos, nas seguintes 
					Especialidades:</p>
					<ul>
					<li>CARDIOLOGIA</li>
					<li>GASTROENTEROLOGIA</li>
					<li>GINECOLOGIA</li>
					<li>VASCULAR</li>
					<li>ENDOCRINOLOGIA</li>
					<li>NEUROLOGIA</li>
					<li>MASTOLOGIA</li></ul>
					<br>Acesse o Processo de Contratação aqui: 
					<a href="{{asset('img/tr/Arco/Termo de Especificações - Processo de Contratação de Serviços Médicos UPAE ARCOVERDE.pdf')}}" width="100px" class="btn btn-sm btn-info" target="_blank"> Download</a>
					</td>
				</tr>
			@endif
			@endforeach
		</table>	
		</div>
	</div><br><br>
	<center><b>Envie sua proposta para: juliana.silva@hcpgestao.org.br , franklin.rodrigues@hcpgestao.org.br</b></center>
</div>
</div>
@endsection