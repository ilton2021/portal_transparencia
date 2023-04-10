@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">CADASTRAR DEMONSTRATIVOS FINANCEIROS:</h3>
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
		<div class="col-md-1 col-sm-0"></div>
		<div class="col-md-10 col-sm-12 text-center">
			<div id="accordion">
				<div class="card ">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
						Demonstrativos Financeiros: <i class="fas fa-check-circle"></i>
					</a>
					<div class="card-body" style="font-size: 14px;">
						<form action="{{\Request::route('storeDF'), $unidade->id}}" method="post" enctype="multipart/form-data">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="form-control mt-3" style="color:black">
								<div class="form-row mt-2">
									<div class="form-group col-md-12 offset-1 d-inline-flex align-items-center">
										<div class="col-md-12 d-inline-flex align-items-center flex-wrap">
											<div class="p-2">
												<label><strong>Título: </strong></label>
											</div>
											<div class="p-2">
												<select id="title" name="title" class="form-control" style="max-width:250px">
													<option value="1">Relátorio Mensal</option>
													<option value="2">Prestação de contas</option>
												</select>
											</div>
											<div class="p-2">
												<label><strong>Tipo doc:</strong></label>
											</div>
											<div class="p-2">
												<select id="tipodoc" name="tipodoc" class="form-control" style="max-width:250px">
													<option value="1">Padrão</option>
													<option value="2">Maternidade</option>
													<option value="3">COVID</option>
													<option value="4">Prefeitura</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="form-row mt-2">
									<div class="form-group col-md-12 offset-1 d-inline-flex align-items-center flex-wrap">
										<div class="d-inline-flex align-items-center flex-wrap">
											<div class="p-2">
												<label><strong>Mês:</strong></label>
											</div>
											<div class="p-2">
												<select id="mes" name="mes" class="form-control" style="max-width: 200px">
													<option value="1">Janeiro</option>
													<option value="2">Fevereiro</option>
													<option value="3">Março</option>
													<option value="4">Abril</option>
													<option value="5">Maio</option>
													<option value="6">Junho</option>
													<option value="7">Julho</option>
													<option value="8">Agosto</option>
													<option value="9">Setembro</option>
													<option value="10">Outubro</option>
													<option value="11">Novembro</option>
													<option value="12">Dezembro</option>
												</select>
											</div>
										</div>
										<div class="d-inline-flex align-items-center flex-wrap">
											<div class="p-2">
												<label><strong>Ano:</strong></label>
											</div>
											<div class="p-2">
												<?php $ano = date('Y', strtotime('now')); ?>
												<select class="form-control" id="ano" name="ano" style="width: 100px;">
													<?php for ($a = 2020; $a <= 2025; $a++) { ?>
														@if($a == $ano)
														<option id="ano" name="ano" value="<?php echo $a; ?>" selected>{{ $a }}</option>
														@else
														<option id="ano" name="ano" value="<?php echo $a; ?>">{{ $a }}</option>
														@endif
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="form-row mt-2">
									<div class="form-group col-md-12 offset-1 d-inline-flex align-items-center">
										<div class="col-md-12 d-inline-flex align-items-center flex-wrap">
											<p id="GFG_UP" style="font-size: 15px; font-weight: bold;">
											</p>
											<div class="p-2">
												<label><strong>Arquivo:</strong></label>
											</div>
											<div class="p-2">
												<select id="tipoarq" name="tipoarq" class="form-control" style="max-width: 200px">
													<option selected value="1">PDF</option>
													<option value="2">RAR</option>
													<option value="3">LINK</option>
												</select>
											</div>
											<div name="vinculado" id="vinculado">
												<input class="form-control" type="file" id="file_path" name="file_path" value="" />
											</div>
											<div name="vinculado2" id="vinculado2">
												<input class="form-control" type="text" id="file_link" name="file_link" value="" placeholder="Cole o link do arquivo.." />
											</div>
										</div>
									</div>
								</div>
							</div>
							<table>
								<tr>
									<td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
									<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="demonstrativoFinanceiro" /> </td>
									<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarDemonstrativoFinanceiro" /> </td>
									<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
								</tr>
							</table>
							<div class="d-flex justify-content-between">
								<div>
									<a href="{{route('cadastroDF', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
								</div>
								<div>
									<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" />
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-1 col-sm-0"></div>
	</div>
</div>
<script>
	$('#file_path').on('change', function() {
		if (this.files[0].size > 16777216) {
			$('#GFG_DOWN').text("Insira um arquivo com 16 Mega bytes ou menos !");
		}
	});
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#vinculado2').hide();
		$('#tipoarq').change(function() {
			if ($('#tipoarq').val() == 1) {
				$('#vinculado').show();
				$('#vinculado2').hide();
			}
		});
		$('#tipoarq').change(function() {
			if ($('#tipoarq').val() == 2) {
				$('#vinculado2').hide();
				$('#vinculado').show();
			}
		});
		$('#tipoarq').change(function() {
			if ($('#tipoarq').val() == 3) {
				$('#vinculado').hide();
				$('#vinculado2').show();
			}
		});
	});

	function _(el) {
		return document.getElementById(el);
	}
</script>
@endsection