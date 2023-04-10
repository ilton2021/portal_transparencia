@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$undOss[0]->name}}</strong></div>
<div class="container-fluid mt-2">
	<div class="row p-3">
		<div class="col-md-12 text-center">
			<h5 style="font-size: 18px;">DECRETO DE QUALIFICAÇÃO</h5>
			@if(Auth::check())
			@foreach ($permissao_users as $permissao)
			@if(($permissao->permissao_id == 15) && ($permissao->user_id == Auth::user()->id))
			
			<a href="{{route('cadastroDE', $undOss[0]->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Alterar <i class="fas fa-edit"></i> </a>
			
			@endif
			@endforeach
			@endif
		</div>
	</div>
	<div class="row">
		<div class="col-md-5 offset-md-1 d-flex justify-content-center">
			<div class="card border-0" style="width: 25rem; background-color: #fafafa;">
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
							<div class="p-2 text-center">
								<a href="{{asset('storage/')}}/{{$decreto->path_file}}" target="_blank" class="badge badge-success">Download <i class="bi bi-download"></i></a>
							</div>
						</div>
						@endif
						@endforeach
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-5 d-flex justify-content-center">
			<div class="card border-0" style="width: 25rem; background-color: #fafafa;">
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
							<div class="p-2 text-center">
								<a href="{{asset('storage/')}}/{{$decreto->path_file}}" target="_blank" class="badge badge-success">Download <i class="bi bi-download"></i></a>
							</div>

						</div>
						@endif
						@endforeach
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-1"></div>
	</div>
</div>
@endsection