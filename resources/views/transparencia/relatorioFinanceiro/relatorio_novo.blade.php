@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">CADASTRAR RELATÓRIO FINANCEIRO E DE EXECUÇÃO ANUAL:</h3>
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
		<div class="col-md-2 col-sm-0"></div>
		<div class="col-md-8 col-sm-12 text-center">
			<div class="accordion" id="accordionExample">
				<div class="card">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
						Relatório Financeiro e de Execução Anual: <i class="fas fa-check-circle"></i>
					</a>
				</div>
				<form action="{{\Request::route('storeRF'), $unidade->id}}" method="post" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">

					<div class="form-control mt-3" style="color:black">
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label><strong>Título:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input style="max-width: 500px" class="form-control" type="text" id="title" name="title" value="" required />
								</div>
							</div>
						</div>
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label><strong>Ano:</strong></label>
								</div>
								<div class="col-md-10 mr-2 d-inline-flex flex-wrap justify-content-sm-center justify-content-md-start">
									<?php
									$ano = date('Y', strtotime('now'));
									$anoini = $ano - 8;
									$anofim = $ano + 2;
									?>
									<select class="form-control" id="ano" name="ano" style="max-width: 100px;">
										<?php for ($a = $anoini; $a <= $anofim; $a++) { ?>
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
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label><strong>Arquivo:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input class="form-control" type="file" name="file_path" id="file_path" />
								</div>
							</div>
						</div>
					</div>
					<table>
						<tr>
							<td> <input hidden type="text" class="form-control" id="validar" name="validar" value="1"> </td>
							<td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
							<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="relatorioFinanceiro" /> </td>
							<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarRelatorioFinanceiro" /> </td>
							<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
						</tr>
					</table>

					<div class="d-flex justify-content-between">
						<div>
							<a href="{{route('cadastroRF', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
						</div>
						<div>
							<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" />
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-2 col-sm-0"></div>
		</div>
	</div>
</div>
@endsection