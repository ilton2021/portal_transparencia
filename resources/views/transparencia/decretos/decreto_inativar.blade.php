@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid" style="margin-top: 25px;">
	<div class="row" style="margin-bottom: 25px;">
		<div class="col-md-12 text-center">
		  @if($decretos[0]->status_decreto == 0)
			<h5 style="font-size: 18px;">ATIVAR DECRETO DE QUALIFICAÇÃO:</h5>
		  @else
		    <h5 style="font-size: 18px;">INATIVAR DECRETO DE QUALIFICAÇÃO:</h5>
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
									<input style="width: 550px" class="form-control" type="text" id="title" name="title" value="<?php echo $decretos[0]->title; ?>" readonly="true" />
								</div>
							</div>
						</div>
						<div class="form-row mt-1">
							<div class="form-group col-md-12 offset-md-1 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label><strong>Número do Decreto:</strong></label>
								</div>
								<div class="col-md-3 mr-2">
									<input style="width: 200px" class="form-control" type="text" id="decreto" name="decreto" value="<?php echo $decretos[0]->decreto; ?>" readonly="true" />
								</div>
								<div class="col-md-1 mr-2">
									<label><strong>Tipo:</strong></label>
								</div>
								<div class="col-md-5 mr-2">
									<input name="kind" id="kind" type="text" readonly="true" class="form-control" style="width: 200px" value="<?php echo $decretos[0]->kind; ?>" />
								</div>
							</div>
						</div>
						<div class="form-row mt-1">
							<div class="form-group col-md-12 offset-md-1 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label><strong>Arquivo:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input style="width: 550px" class="form-control" type="text" id="path_file" name="path_file" value="<?php echo $decretos[0]->path_file; ?>" readonly="true" />
								</div>

							</div>
						</div>
					</div>
					<table>
						<tr>
							<td> <input type="hidden" id="unidade_id" name="unidade_id" value="1" /> </td>
							<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="decretos" /> </td>
							@if($decretos[0]->status_decreto == 0)
							  <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="AtivarDecretos" /> </td>
							@else
							  <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="InativarDecretos" /> </td>
							@endif
							<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
						</tr>
					</table>
					<div class="form-control">
						<div class="d-flex justify-content-between">
							<div class="ml-2" style="color:black">
								<p>
								<h6> Deseja realmente Excluir este Decreto de Qualificação?? </h6>
								</p>
							</div>
						</div>
						<div class="d-flex justify-content-between">
							<div class="p-2">
								<a href="{{route('cadastroDE', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
							</div>
							<div class="p-2">
							   @if($decretos[0]->status_decreto == 0)
								<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Ativar" id="Ativar" name="Ativar" />
							   @else
							    <input type="submit" class="btn btn-primary btn-sm" style="margin-top: 10px;" value="Inativar" id="Inativar" name="Inativar" />
							   @endif
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection