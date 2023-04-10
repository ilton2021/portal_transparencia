@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
		  @if($conselhoAdm->status_conselho_adms == 0)
			<h5 style="font-size: 18px;">ATIVAR MEMBROS DIRIGENTES:</h5>
		  @else
		    <h5 style="font-size: 18px;">INATIVAR MEMBROS DIRIGENTES:</h5>
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
		<div class="col-md-12 col-sm-12 text-center">
			<div class="accordion" id="accordionExample">
				<div class="card">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
						CONSELHO DE ADMINISTRAÇÃO <i class="fas fa-check-circle"></i>
					</a>
				</div>
				<form action="{{\Request::route('destroyCA'), $unidade->id}}" method="post" id="formid">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-control mt-3" style="color:black">
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<labe><strong>ID:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input class="form-control" style="max-width: 100px;" type="type" id="id" name="id" value="<?php echo $conselhoAdm->id; ?>" disabled="true" />
								</div>
							</div>
						</div>
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<labe><strong>Nome:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input class="form-control" style="max-width: 450px;" type="text" id="name" name="name" value="<?php echo $conselhoAdm->name; ?>" disabled="true" />
								</div>
							</div>
						</div>
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<labe><strong>Cargo:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input class="form-control" style="max-width: 450px;" type="text" id="cargo" name="cargo" value="<?php echo $conselhoAdm->cargo; ?>" disabled="true" />
								</div>
							</div>
						</div>
					</div>
					<table>
						<tr>
							<td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
							<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="membrosConselhoAdm" /> </td>
							@if($conselhoAdm->status_conselho_adms == 0)
							  <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="AtivarMembrosConselhoAdm" /> </td>
							@else
							  <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="InativarMembrosConselhoAdm" /> </td>
							@endif
							<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
						</tr>
					</table>
					<div class="form-control">
						<div class="d-flex justify-content-between">
							<div class="ml-2" style="color:black">
								<p>
								<h6> Deseja realmente Inativar este Membro Dirigente?? </h6>
								</p>
							</div>
						</div>
						<div class="d-flex justify-content-between">
							<div class="p-2">
								<a href="{{route('listarCA', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
							</div>
							<div class="p-2" id="containerEnviar">
								@if($conselhoAdm->status_conselho_adms == 0)
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
</div>
@endsection