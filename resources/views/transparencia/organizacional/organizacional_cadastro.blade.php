@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-bottom: 25px; margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5 style="font-size: 18px;">ESTRUTURA ORGANIZACIONAL:</h5>
		</div>
	</div>
	@if ($errors->any())
	<div class="alert alert-success">
		<ul>
			@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
	@endif
	<div class="d-flex justify-content-between">
		<div class="p-2">
			<a href="{{route('transparenciaOrganizacional', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> Voltar<i class="fas fa-undo-alt"></i> </a>
		</div>
		<div class="p-2">
			<a href="{{route('novoOR', $unidade->id)}}" class="btn btn-dark btn-sm" style="color: #FFFFFF;"> Novo <i class="fas fa-check"></i> </a>
		</div>
	</div>
	@if($unidade->id > 1)
	<div style="overflow:auto;">
		<table class="table table-sm " id="my_table">
			<thead class="bg-success">
				<tr>
					<th scope="col">Cargo</th>
					<th scope="col">Nome</th>
					<th scope="col">E-mail</th>
					<th scope="col">Alterar</th>
					<th scope="col">Inativar</th>
					<!--th scope="col">Excluir</th-->
				</tr>
			</thead>
			<tbody>

				@foreach($estruturaOrganizacional as $organizacional)
				<tr>
					<input hidden type="text" id="idOrg" name="idOrg" value="<?php echo $organizacional->id; ?>">
					<td style="font-size: 11px;">{{$organizacional->cargo}}</td>
					<td style="font-size: 11px;">{{$organizacional->name}}</td>
					<td style="font-size: 11px;">{{$organizacional->email}}</td>
					<td><center><a class="btn btn-info btn-sm" href="{{route('alterarOR', array($organizacional->id, $unidade->id))}}"><i class="fas fa-edit"></i></a></center></td>
					@if($organizacional->status_organizacional == 0)
					<td><center><a title="Ativar" class="btn btn-success btn-sm" href="{{route('telaInativarOR', array($organizacional->id, $unidade->id))}}"><i class="fas fa-times-circle"></i></center></td>
					@else
					<td><center><a title="Inativar" class="btn btn-warning btn-sm" href="{{route('telaInativarOR', array($organizacional->id, $unidade->id))}}"><i class="fas fa-times-circle"></i></center></td>
					@endif
					<!--td><center><a class="btn btn-danger btn-sm" href="{{route('excluirOR', array($organizacional->id, $unidade->id))}}"><i class="bi bi-trash"></i></center></td-->
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	@endif
</div>
@endsection