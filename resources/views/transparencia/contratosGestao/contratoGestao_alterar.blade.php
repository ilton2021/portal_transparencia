@extends('navbar.default-navbar')
@section('content')
<style>
	.file-button {
		background: #eee;
		border: 1px solid #aaa;
		border-radius: 3px;
		display: inline-block;
		padding: 2px 8px;
	}

	.file-name {
		width: 200px;
		border: 1px solid #aaa;
		overflow-wrap: break-word;
		padding: 2px;
	}

	input[type='file'] {
		display: none;
	}
</style>
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">ALTERAR CONTRATOS DE GESTÃO / ADITIVOS:</h3>
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
		<div class="col-md-8 offset-md-2 col-sm-12 text-center">
			<div id="accordion">
				<div class="card">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
						Contrato de Gestão / Aditivos: <i class="fas fa-check-circle"></i>
					</a>
					<div class="card-body" style="font-size: 14px;">
						<form action="{{\Request::route('updateCG'), $unidade->id}}" method="post" enctype="multipart/form-data">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">

							<div class="form-control mt-3" style="color:black">
								<div class="form-row mt-2">
									<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
										<div class="col-md-2 mr-2">
											<label><strong>Título:</strong></label>
										</div>
										<div class="col-md-10 mr-2">
											<input class="form-control" type="text" id="title" name="title" value="{{$contratos[0]->title}}" required />
										</div>
									</div>
								</div>
								<div class="form-row mt-2">
									<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
										<div class="col-md-2 mr-2">
											<label><strong>Arquivo:</strong></label>
										</div>
										<div class="col-md-10 mr-2">
											<input readonly="true" class="form-control" type="text" id="arquivo" name="arquivo" value="<?php echo $contratos[0]->path_file; ?>" />
										</div>
									</div>
								</div>
								<div class="form-row mt-2">
									<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
										<div class="col-md-2 mr-2">
											<label><strong>Arquivo:</strong></label>
										</div>
										<div class="col-md-10 mr-2 d-inline-flex flex-wrap justify-content-center">
											<label class="file-label p-1" for="path_file">
												<div class="file-button">Escolha o arquivo&hellip;</div>
											</label>
											<p class="file-name ml-1">Nenhum arquivo</p>
											<input class="form-control" id="path_file" type="file" name="path_file" require>
										</div>
									</div>
								</div>
							</div>

							<table>
								<tr>
									<td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
									<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="ContratoGestao" /> </td>
									<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="alterarContratoGestao" /> </td>
									<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
								</tr>
							</table>
							<div class="d-flex justify-content-between">
								<div>
									<a href="{{route('cadastroCG', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
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
</div>
<script>
	function update(e) {
		fileName.textContent = file.files[0].name;
	}
	const file = document.querySelector('#path_file'),
		fileName = document.querySelector('.file-name');
	file.addEventListener('change', update);
</script>
@endsection