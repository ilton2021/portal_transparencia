@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">DEMONSTRAÇÕES CONTÁBEIS E PARECERES</h3>
			<div class="d-flex justify-content-around">
				<a href="{{route('transparenciaAccountable', array($unidade->id,1))}}" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
				<a class="btn btn-dark btn-sm" style="color: #FFFFFF;" href="{{route('novoDC', $unidade->id)}}"> Novo <i class="fas fa-check"></i></a>
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
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-2 col-sm-0"></div>
		<div class="col-md-8 col-sm-12">
			<div class="accordion" id="accordionExample">
				@foreach ($demonstrativoContaveis->pluck('ano')->unique() as $ano)
				<div class="card border-bottom" style="margin-bottom: 5px;">
					<a class="btn text-decoration-none" type="button" data-toggle="collapse" href="#{{$ano}}Competência" aria-expanded="true" aria-controls="{{$ano}}Competência">
						<strong>Competência {{$ano}}</strong> <i style="color:#65b345;" class="fas fa-search-dollar"></i>
					</a>
					<div id="{{$ano}}Competência" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
						<div class="card-body border-0">
							<div class="d-flex flex-column">
								@foreach ($demonstrativoContaveis as $demonstrativoContabel)
								@if ($ano === $demonstrativoContabel->ano)
								<div class="d-md-inline-flex justify-content-between border-bottom border-success align-items-center">
									<div class="p-2">
										<h6 style="font-size: 12px;">{{$demonstrativoContabel->title}}</h6>
									</div>
									<div class="p-2 text-center text-nowrap">
										<a href="{{asset('storage/')}}/{{$demonstrativoContabel->file_path}}" target="_blank" class="badge badge-success">Download</a>
										@if($demonstrativoContabel->status_contabel == 0)
										  <a title="Ativar" class="btn btn-success btn-sm" style="color: #FFFFFF;" href="{{route('telaInativarDC', array($unidade->id, $demonstrativoContabel->id))}}"><i class="fas fa-times-circle"></i></a>
										@else	
										  <a title="Inativar" class="btn btn-warning btn-sm" style="color: #FFFFFF;" href="{{route('telaInativarDC', array($unidade->id, $demonstrativoContabel->id))}}"><i class="fas fa-times-circle"></i></a>
										@endif
										<!--a class="btn btn-danger btn-sm" style="color: #FFFFFF;" href="{{route('excluirDC', array($unidade->id, $demonstrativoContabel->id))}}"><i class="bi bi-trash3-fill"></i></a-->
									</div>
								</div>
								@endif
								@endforeach
							</div>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
		<div class="col-md-2 col-sm-0"></div>
	</div>
</div>
@endsection