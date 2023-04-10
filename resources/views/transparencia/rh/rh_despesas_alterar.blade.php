@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">ALTERAR DESPESAS COM PESSOAL:</h3>
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
				<form action="{{route('updateDRH', array($unidade->id, $ano, $mes, $tipo))}}" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">

					<div class="d-flex flex-wrap align-items-center justify-content-center">
						<div class="d-inline-flex flex-wrap align-items-center p-2">
							<div class="p-1">
								<label>Mês:</label>
							</div>
							<div class="p-1">
								<select class="form-control" id="mes" name="mes">
									<option <?php if ($mes == 1) {
												echo "selected";
											}  ?> value="1" id="mes" name="mes">Janeiro</option>
									<option <?php if ($mes == 2) {
												echo "selected";
											}  ?> value="2" id="mes" name="mes">Fevereiro</option>
									<option <?php if ($mes == 3) {
												echo "selected";
											}  ?> value="3" id="mes" name="mes">Março</option>
									<option <?php if ($mes == 4) {
												echo "selected";
											}  ?> value="4" id="mes" name="mes">Abril</option>
									<option <?php if ($mes == 5) {
												echo "selected";
											}  ?> value="5" id="mes" name="mes">Maio</option>
									<option <?php if ($mes == 6) {
												echo "selected";
											}  ?> value="6" id="mes" name="mes">Junho</option>
									<option <?php if ($mes == 7) {
												echo "selected";
											}  ?> value="7" id="mes" name="mes">Julho</option>
									<option <?php if ($mes == 8) {
												echo "selected";
											}  ?> value="8" id="mes" name="mes">Agosto</option>
									<option <?php if ($mes == 9) {
												echo "selected";
											}  ?> value="9" id="mes" name="mes">Setembro</option>
									<option <?php if ($mes == 10) {
												echo "selected";
											}  ?> value="10" id="mes" name="mes">Outubro</option>
									<option <?php if ($mes == 11) {
												echo "selected";
											}  ?> value="11" id="mes" name="mes">Novembro</option>
									<option <?php if ($mes == 12) {
												echo "selected";
											}  ?> value="12" id="mes" name="mes">Dezembro</option>
								</select>
							</div>
							<div class="p-1">
								<label>Ano:</label>
							</div>
							<div class="p-1">
								<select style="width:100px;" class="form-control" id="ano" name="ano">
									<option value="<?php echo $ano ?>" id="ano" name="ano">{{ $ano }}</option>
								</select>
							</div>
							<div class="p-1">
								<label>Tipo:</label>
							</div>
							<div class="p-1">
								<select style="width:160px;" class="form-control" id="tipo" name="tipo">
									<option value="<?php echo $tipo ?>" id="tipo" name="tipo">{{ $tipo }}</option>
								</select>
							</div>
						</div>
					</div>
					<div style="overflow:auto;">
						<table class="table">
							<thead style="margin-right: 90px;">
								<th style="width: 190px;"> Nível: </th>
								<th style="width: 250px;"> Cargos: </th>
								<th style="width: 100px;"> Qtd: </th>
								<th style="width: 150px;"> Valores (R$): </th>
							</thead>
							<?php $a = 0; ?>
							<tbody>
								@if(!empty($despesas))
								@foreach($despesas as $despesa)
								<tr> <?php $a += 1; ?>
									<td hidden style="font-size: 11px; width:190px"><input type="text" id="id_<?php echo $a; ?>" name="id_<?php echo $a; ?>" readonly="true" class="form-control" value="<?php echo $despesa->id ?>" /> </td>
									<td align="center" style="font-size: 11px; width: 250px;"><input style="width: 190px;" type="text" id="nivel" name="nivel" readonly="true" class="form-control" value="<?php echo $despesa->Nivel ?>" /> </td>
									<td align="center" style="font-size: 11px; width:250px"><input style="width: 250px;" type="text" id="cargo" name="cargo" readonly="true" class="form-control" value="<?php echo $despesa->Cargo ?>" /> </td>
									<td align="center" style="font-size: 11px; width:100px"><input style="width: 100px;" type="text" id="quant_<?php echo $a; ?>" name="quant_<?php echo $a; ?>" class="form-control" value="<?php echo $despesa->Quant ?>" /></td>
									<td align="center" style="font-size: 11px; width:150px"><input style="width: 150px;" type="text" id="valor_<?php echo $a; ?> " name="valor_<?php echo $a ?>" class="form-control" value="<?php echo $despesa->Valor ?>" /></td>
								</tr>
								@endforeach
								@endif

							</tbody>
						</table>
					</div>
					<div class="d-flex flex-wrap justify-content-around p-2">
						<div class="p-1">
							<a href="{{route('despesasRH', array($unidade->id))}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
						</div>
						<div class="p-1">
							<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" />
						</div>
					</div>
				</form>
			</div>

		</div>
	</div>
</div>
@endsection