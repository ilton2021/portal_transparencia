@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-bottom: 25px; margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">SERVIDORES CEDIDOS:</h5>
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
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12">
			<div class="col-md-12 text-center">
			<p style="margin-right: -860px;"><a href="{{route('transparenciaRecursosHumanos', array($unidade->id,1))}}" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>&nbsp;&nbsp;&nbsp;<a class="btn btn-dark btn-sm" style="color: #FFFFFF;" href="{{route('servidoresNovo', $unidade->id)}}"> Novo <i class="fas fa-check"></i> </a></p>
			</div>
			@if($unidade->id > 1)
			<table class="table table-sm " id="my_table">
				<thead class="bg-success">
					<tr>
						<th scope="col">Cargo</th>
						<th scope="col">Nome</th>
						<th scope="col">Matrícula</th>
						<th scope="col">Data Início</th>
						<th scope="col">Alterar</th>
						<th scope="col">Excluir</th>
					</tr>
				</thead>
				<tbody>				
					@foreach($servidores as $servidor)
					<tr>
						<td style="font-size: 11px;">{{$servidor->cargo}}</td>
						<td style="font-size: 11px;">{{$servidor->nome}}</td>
						<td style="font-size: 11px;">{{$servidor->matricula}}</td>
						<td style="font-size: 11px;">{{date('d-m-Y',strtotime($servidor->data_inicio))}}</td>
						<td> <a class="btn btn-info btn-sm" href="{{route('servidoresAlterar', array($servidor->id, $unidade->id))}}" ><i class="fas fa-edit"></i></a> </td>
						<td> <a class="btn btn-danger btn-sm" href="{{route('servidoresExcluir', array($servidor->id, $unidade->id))}}" ><i class="fas fa-times-circle"></i> </td>
					</tr>
					@endforeach
				</tbody>
			</table>
			@endif
		</div>
	</div> <br/><br/>
</div>
</div>
@endsection