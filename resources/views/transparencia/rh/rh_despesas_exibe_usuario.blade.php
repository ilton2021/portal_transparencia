@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">Despesas Com Pessoal</h3>
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
		<div class="col-md-12 col-sm-12 text-center">
			<div class="card">
				<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#SELETIVO" aria-expanded="true" aria-controls="SELETIVO">
					DESPESAS COM PESSOAL <i class="fas fa-tasks"></i>
				</a>
				<form action="{{route('despesasUsuarioRHProcurar', $unidade->id)}}" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="d-flex flex-wrap align-items-center justify-content-center">

						<div class="p-2">
							<label>Mês</label>
							<select style="width: 120px; margin-left: 3px;" class="form-control" id="mes" name="mes" placeholder="Mês">
								<option <?php if ($mes == 1) {
											echo $teste;
										}  ?> value="1" id="mes" name="mes">Janeiro</option>
								<option <?php if ($mes == 2) {
											echo $teste;
										}  ?> value="2" id="mes" name="mes">Fevereiro</option>
								<option <?php if ($mes == 3) {
											echo $teste;
										}  ?> value="3" id="mes" name="mes">Março</option>
								<option <?php if ($mes == 4) {
											echo $teste;
										}  ?> value="4" id="mes" name="mes">Abril</option>
								<option <?php if ($mes == 5) {
											echo $teste;
										}  ?> value="5" id="mes" name="mes">Maio</option>
								<option <?php if ($mes == 6) {
											echo $teste;
										}  ?> value="6" id="mes" name="mes">Junho</option>
								<option <?php if ($mes == 7) {
											echo $teste;
										}  ?> value="7" id="mes" name="mes">Julho</option>
								<option <?php if ($mes == 8) {
											echo $teste;
										}  ?> value="8" id="mes" name="mes">Agosto</option>
								<option <?php if ($mes == 9) {
											echo $teste;
										}  ?> value="9" id="mes" name="mes">Setembro</option>
								<option <?php if ($mes == 10) {
											echo $teste;
										}  ?> value="10" id="mes" name="mes">Outubro</option>
								<option <?php if ($mes == 11) {
											echo $teste;
										}  ?> value="11" id="mes" name="mes">Novembro</option>
								<option <?php if ($mes == 12) {
											echo $teste;
										}  ?> value="12" id="mes" name="mes">Dezembro</option>
							</select>
						</div>
						<div class="p-2">
							<label>Ano</label>
							<select style="width: 90px; padding: 5px;" class="form-control" id="ano" name="ano">
								<?php for ($anoP = 2017; $anoP <= 2025; $anoP++) { ?>
									@if($ano == $anoP)
									<option selected value="<?php echo $anoP; ?>" id="ano" name="ano">{{ $anoP }}</option>
									@else
									<option value="<?php echo $anoP; ?>" id="ano" name="ano">{{ $anoP }}</option>
									@endif
								<?php } ?>
							</select>
						</div>
						<div class="p-2">
							<label>Tipo</label>
							<select style="width: 200px; padding: 5px; margin-right:px;" class="form-control" id="tipo" name="tipo" style=>
								<option <?php if ($tipo == 'base') {
											echo $teste;
										}  ?> value="base" id="tipo" name="tipo">Salário Base</option>
								<option <?php if ($tipo == 'complemento') {
											echo $teste;
										}  ?> value="complemento" id="tipo" name="tipo">Complemento</option>
								<option <?php if ($tipo == '13') {
											echo $teste;
										}  ?> value="13" id="tipo" name="tipo">13° Salário</option>
								<option <?php if ($tipo == 'covid') {
											echo $teste;
										}  ?> value="covid" id="tipo" name="tipo">Covid</option>
							</select>
						</div>
						<div class="p-2">
							<input type="submit" class="btn btn-info btn-sm" style="margin-top:;" value="Pesquisar" id="Pesquisar" name="Pesquisar" />
						</div>
					</div>
				</form>
				<div style="overflow:auto;">
					<table class="table">
						<thead>
							<th style="width:170px">Nível</th>
							<th style="width:250px">Cargo</th>
							<th style="width:90px">Qtd</th>
							<th style="width:110px">Valor</th>
							<th style="width:80px">Tipo</th>
						</thead>
						<tbody>
							@if(!empty($despesas))
							@foreach($despesas as $despesa)
							<tr>
								<td style="font-size: 11px; width:170px" align="center"><input style="width:170px" type="text" id="" name="" readonly="true" class="form-control" value="<?php echo $despesa->Nivel ?>" /> </td>
								<td style="font-size: 11px; width:250px" align="center"><input style="width:250px" type="text" id="" name="" readonly="true" class="form-control" value="<?php echo $despesa->Cargo ?>" /> </td>
								<td style="font-size: 11px; width:90px" align="center"><input style="width:90px" type="text" id="" name="" readonly="true" class="form-control" value="<?php echo $despesa->Quant ?>" /></td>
								<td style="font-size: 11px; width:150px" align="center"><input style="width:150px" type="text" id="" name="" readonly="true" class="form-control" value="<?php echo $despesa->Valor ?>" /></td>
								<td style="font-size: 11px; width:80px" align="center"><input style="width:80px" type="text" id="" name="" readonly="true" class="form-control" value="<?php echo $despesa->tipo ?>" /></td>
							</tr>
							@endforeach
							@endif
						</tbody>
					</table>
				</div>
				<table>
					<tr>
						<td>
							<a href="{{route('transparenciaRecursosHumanos', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
							@if($ano != null)
							@endif
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection