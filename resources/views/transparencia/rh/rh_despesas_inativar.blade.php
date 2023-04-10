@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
		   @if($despesas[0]->status_desp == 0)
			<h3 style="font-size: 18px;">ATIVAR DESPESAS COM PESSOAL:</h3>
		   @else
		 	<h3 style="font-size: 18px;">INATIVAR DESPESAS COM PESSOAL:</h3>
		   @endif
		</div>
	</div>
	@if ($errors->any())
	<div class="alert alert-danger">
		<ul>
			@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
	@endif
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 col-sm-12 text-center">
			<div class="card">
				<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#SELETIVO" aria-expanded="true" aria-controls="SELETIVO">
					DESPESAS COM PESSOAL <i class="fas fa-tasks"></i>
				</a>
				<form action="{{route('inativarDRH', array($unidade->id, $ano, $mes, $tipo, $tp))}}" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="d-flex flex-wrap align-items-center justify-content-center">
						<div class="d-inline-flex flex-wrap align-items-center p-2">
							<div class="p-1">
								<label><strong>Mês:</strong></label>
							</div>
							<div class="p-1">
								<?php if ($mes == 1) {
									echo "<label>Janeiro</label>";
								} elseif ($mes == 2) {
									echo "<label>Fevereiro</label>";
								} elseif ($mes == 3) {
									echo "<label>Março</label>";
								} elseif ($mes == 4) {
									echo "<label>Abril</label>";
								} elseif ($mes == 5) {
									echo "<label>Maio</label>";
								} elseif ($mes == 6) {
									echo "<label>Junho</label>";
								} elseif ($mes == 7) {
									echo "<label>Julho</label>";
								} elseif ($mes == 8) {
									echo "<label>Agosto</label>";
								} elseif ($mes == 9) {
									echo "<label>Setembro</label>";
								} elseif ($mes == 10) {
									echo "<label>Outubro</label>";
								} elseif ($mes == 11) {
									echo "<label>Novembro</label>";
								} else {
									echo "<label>Dezembro</label>";
								}
								?>
							</div>
							<div class="p-1">
								<label><strong>Ano:</strong></label>
							</div>
							<div class="p-1">
								<label>{{ $ano }}</label>
							</div>
							<div class="p-1">
								<label><strong>Tipo:</strong></label>
							</div>
							<div class="p-1">
								<label>{{ $tipo }}</label>
							</div>
						</div>
					</div>
					<div class="d-flex flex-wrap justify-content-around p-2">
						<div class="p-1">
							<b> Deseja Realmente Inativar esta Despesa Pessoal? </b> </td>
						</div>
					</div>
					<div class="d-flex flex-wrap justify-content-around p-2">
						<div class="p-1">
							<a href="{{route('despesasRH', array($unidade->id))}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
						</div>
						<div class="p-1">
						    @if($despesas[0]->status_desp == 0)
							<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Ativar" id="Ativar" name="Ativar" /> 
							@else
							<input type="submit" class="btn btn-primary btn-sm" style="margin-top: 10px;" value="Inativar" id="Inativar" name="Inativar" /> 	
							@endif
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection