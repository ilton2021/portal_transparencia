@extends('navbar.default-navbar')
@section('content')
	@if ($errors->any())
	<div class="alert alert-success">
		<ul>
			@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
	@endif
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">CONTRATOS DE GESTÃO / ADITIVOS</h3>
			<div class="row justify-content-around" style="margin-top: 25px;">
				<a href="{{route('transparenciaContratoGestao', array($unidade->id,1))}}" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
				<a class="btn btn-dark btn-sm" style="color: #FFFFFF;" href="{{route('novoCG', $unidade->id)}}"> Novo <i class="fas fa-check"></i> </a>
			</div>
		</div>
	</div>

	<div class="row" style="margin-top: 25px;">
		<div class="col-md-2 col-sm-0"></div>
		<div class="col-md-8 col-sm-12 text-center">
			<div id="accordion">

				<div class="card">
					<div class="card-header" id="headingOne">
						<h5 class="mb-0">
							<a class="text-dark no-underline" style="font-size:15px" data-toggle="collapse" data-target="#1" aria-expanded="true" aria-controls="2">
								{{$unidade->name}}
							</a>
						</h5>
					</div>

					<div id="1" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
						@foreach($contratos as $contrato)
						<div class="d-flex flex-column justify-content-center justify-content-md-between border-bottom" id="headingOne">
							<div class="d-sm-inline-flex text-center justify-content-between">
								<div class="d-flex align-items-center p-2">
									<a class="text-dark no-underline" target="_blank" href="{{asset('storage/')}}/{{$contrato->path_file}}"><strong>{{$contrato->title}} </strong><i style="color: #28a745;" class="fas fa-download"></i></a>
								</div>
								<div class="d-inline-flex justify-content-between align-items-center">
									<div class="p-2">
										<a class="btn btn-info btn-sm" href="{{route('alterarCG', array($unidade->id, $contrato->id))}}"><i class="bi bi-pencil-square"></i></a>
									</div>
									<div class="p-2">
									  @if($contrato->status_contratos == 0)
										<a title="Ativar" class="btn btn-success btn-sm" href="{{route('telaInativarCG', array($unidade->id, $contrato->id))}}"><i class="fas fa-times-circle"></i></a>
									  @else
									    <a title="Inativar" class="btn btn-warning btn-sm" href="{{route('telaInativarCG', array($unidade->id, $contrato->id))}}"><i class="fas fa-times-circle"></i></a>
									  @endif
									</div>
									<!--div class="p-2">
										<a class="btn btn-danger btn-sm" href="{{route('excluirCG', array($unidade->id, $contrato->id))}}"><i class="bi bi-trash3-fill"></i></a>
									</div-->
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-2 col-sm-0"></div>
	</div>
</div>
@endsection