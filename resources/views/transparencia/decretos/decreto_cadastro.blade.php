@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid mt-2">
	<div class="row p-3">
		<div class="col-md-12 text-center">
			<h5 style="font-size: 18px;">DECRETO DE QUALIFICAÇÃO</h5>
			<div class="d-flex justify-content-around">
				<a href="{{route('transparenciaDecreto', $unidade->id)}}" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
				<a href="{{route('novoDE', $unidade->id)}}" class="btn btn-dark btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Novo <i class="fas fa-check"></i> </a>
			</div>
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
	<div class="row">
		<div class="col-md-5 offset-md-1 d-flex justify-content-center">
			<div class="card border-0" style="width: 30rem; background-color: #fafafa;">
				<div>
					<img class="img-fluid" src="{{asset('img/logoGov.png')}}" alt="Card image cap">
				</div>
				<div class="card-body border-0">
					<div class="d-flex flex-column" id="headingOne">
						@foreach($decretos as $decreto)
						@if($decreto->kind === 'Governo')
						<div class="d-md-inline-flex justify-content-between border-bottom border-success align-items-center">
							<div class="p-2">
								<h6 style="font-size: 12px;">{{$decreto->title}}</h6>
							</div>
							<div class="d-inline-flex justify-content-sm-between align-items-center text-center">
								<div class="p-2">
									<a href="{{asset('storage/')}}/{{$decreto->path_file}}" target="_blank" class="badge badge-success">Download <i class="bi bi-download"></i></a>
								</div>
								<div class="p-2">
						 		 @if($decreto->status_decreto == 0)		
								  <a title="Ativar" class="btn btn-success btn-sm" style="color: #000000;" href="{{route('telaInativarDE', array($unidade->id, $decreto->id))}}"> <i class="fas fa-times-circle"></i></a>
								 @else
								  <a title="Inativar" class="btn btn-warning btn-sm" style="color: #000000;" href="{{route('telaInativarDE', array($unidade->id, $decreto->id))}}"> <i class="fas fa-times-circle"></i></a>
								 @endif
								</div>
								<!--div class="p-2 text">
									<a class="btn btn-danger btn-sm" style="color: #FFFFFF;" href="{{route('excluirDE', array($unidade->id, $decreto->id))}}"> <i class="bi bi-trash3-fill"></i></a>
								</div-->
							</div>

						</div>
						@endif
						@endforeach
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-5 d-flex">
			<div class="card border-0" style="width: 30rem; background-color: #fafafa;">
				<div>
					<img class="img-fluid" src="{{asset('img/logo-prefeitura-recife.png')}}" alt="Card image cap">
				</div>
				<div class="card-body">
					<div class="d-flex flex-column" id="headingOne">
						@foreach($decretos as $decreto)
						@if($decreto->kind === 'Municipio')
						<div class="d-md-inline-flex justify-content-between border-bottom border-success align-items-center">
							<div class="p-2">
								<h6 style="font-size: 12px;">{{$decreto->title}}</h6>
							</div>
							<div class="d-inline-flex">
								<div class="p-2 text-center">
									<a href="{{asset('storage/')}}/{{$decreto->path_file}}" target="_blank" class="badge badge-success">Download <i class="bi bi-download"></i></a>
								</div>
								<div class="p-2">
						 		 @if($decreto->status_decreto == 0)		
								  <a title="Ativar" class="btn btn-success btn-sm" style="color: #000000;" href="{{route('telaInativarDE', array($unidade->id, $decreto->id))}}"> <i class="fas fa-times-circle"></i></a>
								 @else
								  <a title="Inativar" class="btn btn-warning btn-sm" style="color: #000000;" href="{{route('telaInativarDE', array($unidade->id, $decreto->id))}}"> <i class="fas fa-times-circle"></i></a>
								 @endif
								</div>
								<!--div class="p-2">
									<a class="btn btn-danger btn-sm" style="color: #FFFFFF;" href="{{route('excluirDE', array($unidade->id, $decreto->id))}}"> <i class="bi bi-trash3-fill"></i></i></a>
								</div-->
							</div>
						</div>
						@endif
						@endforeach
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-1"></div>
	</div>
</div>
@endsection