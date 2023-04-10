@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">EXCLUIR DESPESAS COM PESSOAL:</h3>
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
				<form action="{{route('destroyDRH', array($unidade->id, $ano, $mes, $tipo))}}" method="post">
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
							<tr>
								<td><input hidden type="text" name="mes" id="mes" value="{{$mes}}" /></td>
								<td><input hidden type="text" name="ano" id="ano" value="{{$ano}}" /></td>
								<td><input hidden type="text" name="tipo" id="tipo" value="{{$tipo}}" /></td>
							</tr>
						</tbody>
					</table>
					<div class="d-flex flex-wrap justify-content-around p-2">
						<div class="p-1">
							<b> Deseja Realmente Excluir esta Despesa Pessoal? </b> </td>
						</div>
					</div>
					<div class="d-flex flex-wrap justify-content-around p-2">
						<div class="p-1">
							<a href="{{route('despesasRH', array($unidade->id))}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
						</div>
						<div class="p-1">
							<input type="submit" class="btn btn-danger btn-sm" style="margin-top: 10px;" value="Excluir" id="Salvar" name="Salvar" />
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection