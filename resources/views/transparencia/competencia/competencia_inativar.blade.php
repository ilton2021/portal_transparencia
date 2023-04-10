@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			@if($competenciasMatriz[0]->status_competencias == 0)
			  <h3 style="font-size: 18px;">ATIVAR COMPETÊNCIA:</h3>
			@else
			  <h3 style="font-size: 18px;">INATIVAR COMPETÊNCIA:</h3>
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
		<div class="col-md-0 col-sm-0"></div>
		<div class="col-md-12 col-sm-12 text-center">
			<div class="accordion" id="accordionExample">
				<div class="card">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
						Matriz de competência <i class="fas fa-check-circle"></i>
					</a>
					<form method="post" action="{{ route('inativarCP', array($unidade->id, $competenciasMatriz[0]->id)) }}" id="formid">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-control mt-3" style="color:black">
							<div class="form-row mt-2">
								<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
									<div class="col-md-2 mr-2">
										<input class="form-control" type="hidden" id="unidade_id" name="unidade_id" value="<?php echo $competenciasMatriz[0]->unidade_id; ?>" />
										<label><strong>ID: </strong></label>
									</div>
									<div class="col-md-10 mr-2">
										<input class="form-control" style="max-width: 100px;" readonly="true" type="text" id="setor" name="setor" value="<?php echo $competenciasMatriz[0]->id; ?>" />
									</div>
								</div>
							</div>
							<div class="form-row mt-2">
								<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
									<div class="col-md-2 mr-2">
										<input class="form-control" type="hidden" id="unidade_id" name="unidade_id" value="<?php echo $competenciasMatriz[0]->unidade_id; ?>" />
										<label><strong>Setor: </strong></label>
									</div>
									<div class="col-md-10 mr-2">
										<input class="form-control" style="max-width: 400px;" readonly="true" type="text" id="setor" name="setor" value="<?php echo $competenciasMatriz[0]->setor; ?>" />
									</div>
								</div>
							</div>
							<div class="form-row mt-2">
								<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
									<div class="col-md-2 mr-2">
										<input class="form-control" type="hidden" id="unidade_id" name="unidade_id" value="<?php echo $competenciasMatriz[0]->unidade_id; ?>" />
										<label><strong>Cargo: </strong></label>
									</div>
									<div class="col-md-10 mr-2">
										<input class="form-control" style="max-width: 400px;" readonly="true" type="text" id="cargo" name="cargo" value="<?php echo $competenciasMatriz[0]->cargo; ?>" />
									</div>
								</div>
							</div>
							<div class="form-row mt-2">
								<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
									<div class="col-md-2 mr-2">
										<input class="form-control" type="hidden" id="unidade_id" name="unidade_id" value="<?php echo $competenciasMatriz[0]->unidade_id; ?>" />
										<label><strong>Descrição: </strong></label>
									</div>
									<div class="col-md-10 mr-2">
										<textarea class="form-control" type="textarea" readonly="true" cols="10" rows="10" id="descricao" name="descricao" value=""><?php echo $competenciasMatriz[0]->descricao; ?></textarea>
									</div>
								</div>
							</div>
						</div>

						<table>
							<tr>
								<td> <input hidden type="text" class="form-control" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /> </td>
								<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="Competencias" /> </td>
								@if($competenciasMatriz[0]->status_competencias == 0)
								  <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="AtivarCompetencias" /> </td>
								@else
								  <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="InativarCompetencias" /> </td>
								@endif
								<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
							</tr>
						</table>
						<div class="d-flex flex-column justify-content-around form-control mt-2">
							<div class="p-2" style="color:black">
								<h6> Deseja realmente Inativar esta Competência?? </h6>
							</div>
							<div class="d-inline-flex justify-content-around">
								<div class="p-2">
									<a href="{{route('cadastroCP', array($unidade->id, $competenciasMatriz[0]->id))}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
								</div>
								<div class="p-2" id="containerEnviar">
								    @if($competenciasMatriz[0]->status_competencias == 0)
									  <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Ativar" id="Ativar" name="Ativar" />
									@else
									  <input type="submit" class="btn btn-primary btn-sm" style="margin-top: 10px;" value="Inativar" id="Inativar" name="Inativar" />
									@endif
									<div id="blockEnviar"></div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-0 col-sm-0"></div>
	</div>
</div>
@endsection