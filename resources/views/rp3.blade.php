@extends('layouts.app2')
@section('content')
<?php $hoje = date('Y-m-d'); ?>
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
			<h5 style="font-size: 18px;">Proposta de Contratação: UPAE PALMARES</h5>
		</div>
	</div>
	<div class="row" style="margin-top: 25px;justify-content: center;">
		<table class="table" style="width: 800px;">
			<tr>
				<td>
					<p>A UPAE PALMARES, através do HCP Gestão, está realizando Processo de Contratação de Empresa para prestação de serviços de Laboratório:</p>
					<ul>
					    <li>Prestação de serviço de exames laboratoriais, com fornecimento de insumos e recursos tecnológicos durante as fases Pré-analítica, Analítica e Pós-Analítica e previsão de entrega dos resultados dos exames em até 2H quando da entrada do material no laboratório próprio.</li>
					    <li>Realização de Análise Clínica e Anatomopatologia das amostras.</li>
					    <li>Possuir os Recursos Logísticos necessários para recolhimento e entrega dos resultados.</li>
					</ul>
				</td>

			<tr>
				<td>
					<center>Acesse o arquivo do Processo de Contratação aqui:
						<a href="{{asset('storage/')}}/{{('TERMO DE ESPECIFICAÇÃO 016-2022 LABORATÓRIO.pdf')}}" width="100px" class="btn btn-sm btn-info" target="_blank"> Download</a>
					</center>
				</td>
			</tr>
			<tr>
				<td>
					<center>Acesse a Errata do processo de Contratação aqui:
						<a href="{{asset('storage/')}}/{{'ERRATA 01-UPAE PALMARES - LABORATORIO.pdf'}}" width="100px" class="btn btn-sm btn-info" target="_blank"> Download</a>
					</center>
				</td>
			</tr>
		</table>
	</div><br>
	<center><b>Envie sua proposta para: contratacaodeservicos@hcpgestao.org.br</b></center>
</div>
</div>
@endsection