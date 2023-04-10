@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5 style="font-size: 18px;">CADASTRAR MEMBROS DIRIGENTES:</h5>
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
			<div class="accordion" id="accordionExample">
				<div class="card">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
						SUPERINTENDENTES <i class="fas fa-check-circle"></i>
					</a>
				</div>
				<form action="{{\Request::route('storeSP'), $unidade->id}}" method="post" id="formid">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-control mt-3" style="color:black">
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label><strong>Nome:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input class="form-control" style="max-width: 400px;" type="text" id="name" name="name" value="" />
								</div>
							</div>
						</div>
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label><strong>Cargo:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input class="form-control" style="max-width: 400px;" type="text" id="cargo" name="cargo" value="" />
								</div>
							</div>
						</div>
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label><strong>Tipo Membro:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input class="form-control" readonly="true" style="max-width: 300px;" type="text" id="tipo_membro" name="tipo_membro" value="Superintendentes" />
								</div>
							</div>
						</div>
					</div>

					<table>
						<tr>
							<td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
							<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="Superintendentes" /> </td>
							<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarSuperintendentes" /> </td>
							<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
						</tr>
					</table>

					<div class="d-flex justify-content-between">
						<div>
							<a href="{{route('listarSP', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
						</div>
						<div id="containerEnviar">
							<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" />
							<div id="blockEnviar"></div>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
</div>
@endsection