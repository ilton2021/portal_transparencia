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
					<p>A UPAE PALMARES, através do HCP Gestão, está realizando Processo de Contratação de Prestação em Serviços Médicos para Consultas Ambulatoriais e Exames.</p>
					<ul>
					    <li>Angiologia</li>
					    <!--li>Alergologia</li-->
					    <li>Cardiologia</li>
					    <li>Clínica Médica</li>
					    <!--li>Dermatologia</li-->
					    <li>Endocrinologia</li>
					    <li>Infectologia</li>
					    <!--li>Mastologia</li-->
					    <li>Neurologia</li>
					    <li>Oftalmologia</li>
					    <!--li>Otorrinolaringologia</li-->
					    <li>Pediatria</li>
					    <li>Pneumologia</li>
					    <li>Proctologia</li>
					    <li>Reumatologia</li>
					    <!--li>Urologia</li-->
					    <li>Radiologia</li>
					</ul>
				</td>

            <tr>
				<td>
					<center>Acesse o arquivo da errata:
						<a href="{{asset('storage/')}}/{{('ERRATA 01 - UPAE PALMARES- PROCESSO MÉDICO (1).pdf')}}" width="100px" class="btn btn-sm btn-info" target="_blank"> Download</a>
					</center>
				</td>
			</tr>
			<tr>
				<td>
					<center>Acesse o arquivo do Processo de Contratação aqui:
						<a href="{{asset('storage/')}}/{{('001.2022 Termo de Especificações - Processo de Contratação Médico UPAE PALMARES.CORRIGIDO.pdf')}}" width="100px" class="btn btn-sm btn-info" target="_blank"> Download</a>
					</center>
				</td>
			</tr>
			
		</table>
	</div><br>
	<center><b>Envie sua proposta para: contratacaodeservicos@hcpgestao.org.br</b></center>
</div>
</div>
@endsection