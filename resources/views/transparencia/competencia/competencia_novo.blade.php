@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;"> CADASTRAR COMPETÊNCIAS:</h3>
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
						Matriz de competência <i class="fas fa-check-circle"></i>
					</a>
				</div>
				<form method="post" action="{{ \Request::route('storeCP'), $unidade->id }}" id="formid">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-control mt-3" style="color:black">
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label><strong>Setor:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input class="form-control" style="width: 400px;" type="text" id="setor" name="setor" value="" list="setors" required />
									<datalist id="setors">
										@foreach($setores as $s)
										<option value="{{$s->setor}}">
											@endforeach
									</datalist>
								</div>
							</div>
						</div>
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label><strong>Cargo:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input class="form-control" style="width: 400px;" type="text" id="cargo" name="cargo" value="" list="cargos" required />
									<datalist id="cargos">
										@foreach($cargos as $c)
										<option value="{{$c->cargo}}">
											@endforeach
									</datalist>
								</div>
							</div>
						</div>
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label><strong>Descrição:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<textarea class="form-control autoTxtArea" type="textarea" cols="10" rows="1" id="descricao" name="descricao" value="" required></textarea>
									<input type="hidden" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" />
								</div>
							</div>
						</div>
					</div>
					<table>
						<tr>
							<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="Competencias" /> </td>
							<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarCompetencias" /> </td>
							<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
						</tr>
					</table>

					<div class="d-flex justify-content-around form-control mt-2">
						<div class="p-2">
							<a href="{{route('transparenciaCompetencia', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
						</div>
						<div class="p-2" id="containerEnviar">
							<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" />
							<div id="blockEnviar"></div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	//Auto ajuste do text-area da capacidade
	var txtAreas = document.querySelectorAll('.autoTxtArea');
	for (x = 0; x < txtAreas.length; x++) {
		txtAreas[x].addEventListener('input', function() {
			if (this.scrollHeight > this.offsetHeight) this.rows += 1;
		});
	}
</script>
@endsection