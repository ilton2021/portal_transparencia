@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid" style="margin-top: 25px;">
	<div class="row" style="margin-bottom: 25px;">
		<div class="col-md-12 text-center">
			<h5 style="font-size: 18px;">CADASTRAR DECRETO DE QUALIFICAÇÃO:</h5>
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
		<div class="col-md-0 col-sm-0"></div>
		<div class="col-md-12 col-sm-12 text-center">
			<div class="accordion" id="accordionExample">
				<div class="card">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
						Decreto de Qualificação <i class="fas fa-check-circle"></i>
					</a>
				</div>
				<form action="{{\Request::route('storeDE'), $unidade->id}}" method="post" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-control mt-3" style="color:black">
						<div class="form-row mt-1">
							<div class="form-group col-md-12 offset-md-1 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label><strong>Título:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input style="max-width: 550px" class="form-control" type="text" id="title" name="title" value="" required />
								</div>
							</div>
						</div>
						<div class="form-row mt-1">
							<div class="form-group col-md-12 offset-md-1 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label><strong>Número do Decreto:</strong></label>
								</div>
								<div class="col-md-3 mr-2">
									<input style="max-width: 200px" class="form-control" type="text" id="decreto" name="decreto" value="" required />
								</div>
								<div class="col-md-1 mr-2">
									<label><strong>Tipo:</strong></label>
								</div>
								<div class="col-md-5 mr-2">
									<select name="kind" id="kind" class="form-control" style="max-width: 200px">
										<option value="Governo"> Governo </option>
										<option value="Municipio"> Município </option>
									</select>
								</div>
							</div>
						</div>
						<div class="form-row mt-1">
							<div class="form-group col-md-12 offset-md-1 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label><strong>Arquivo:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input style="max-width: 550px" class="form-control" type="file" id="path_file" name="path_file" value="" required />
								</div>

							</div>
						</div>
					</div>
					<table>
						<tr>
							<td> <input type="hidden" id="unidade_id" name="unidade_id" value="1" /> </td>
							<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="decretos" /> </td>
							<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarDecretos" /> </td>
							<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
						</tr>
					</table>

					<div class="d-flex justify-content-between">
						<div>
							<a href="{{route('cadastroDE', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
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
</div>
@endsection