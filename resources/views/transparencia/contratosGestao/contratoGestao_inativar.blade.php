@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			@if($contratos[0]->status_contratos == 0)
			  <h3 style="font-size: 18px;">ATIVAR CONTRATOS DE GESTÃO / ADITIVOS:</h3>
			@else
			  <h3 style="font-size: 18px;">INATIVAR CONTRATOS DE GESTÃO / ADITIVOS:</h3>
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
		<div class="col-md-8 offset-md-2 col-sm-12 text-center">
			<div id="accordion">
				<div class="card ">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
						Contratos de Gestão / Aditivos <i class="fas fa-check-circle"></i>
					</a>
				</div>
				<form action="{{\Request::route('inativar'), $unidade->id}}" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-control mt-3" style="color:black">
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label><strong>ID:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input class="form-control" style="max-width: 100px;" readonly="true" type="text" id="id" name="id" value="<?php echo $contratos[0]->id; ?>" />
								</div>
							</div>
						</div>
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label><strong>Título:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input style="max-width: 400px;" class="form-control" readonly="true" type="text" id="title" name="title" value="<?php echo $contratos[0]->title; ?>" />
								</div>
							</div>
						</div>
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label><strong>Caminho:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input style="max-width: 500px;" readonly="true" class="form-control" type="text" id="path_file" name="path_file" value="<?php echo $contratos[0]->path_file; ?>" />
								</div>
							</div>
						</div>
					</div>
					<table>
						<tr>
							<td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
							<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="ContratoGestao" /> </td>
							@if($contratos[0]->status_contratos == 0)
							  <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="AtivarContratoGestao" /> </td>
							@else
							  <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="InativarContratoGestao" /> </td>
							@endif
							<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
						</tr>
					</table>
					<div class="form-control">
						<div class="d-flex justify-content-between">
							<div class="ml-2" style="color:black">
								<p>
								<h6>Deseja realmente Inativar este Contrato de Gestão?? </h6>
								</p>
							</div>
						</div>
						<div class="d-flex justify-content-between">
							<div class="p-2">
								<a href="{{route('cadastroCG', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
							</div>
							<div class="p-2">
							  @if($contratos[0]->status_contratos == 0)
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
</div>
</div>
<div class="col-md-2 col-sm-0"></div>
</div>
@endsection