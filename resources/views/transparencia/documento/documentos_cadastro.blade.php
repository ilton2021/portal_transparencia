@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid" >
	<div class="row mt-3">
		<div class="col-md-12 text-center">
			<h5 style="font-size: 18px;">DOCUMENTAÇÃO DE REGULARIDADE</h5>
		</div>
		<div class="col-md-12 text-center">
			<div class="row justify-content-around">
				<div class="p-3">
					<a class="btn-sm btn-warning" style="color: #FFFFFF;" href="{{route('transparenciaDocumento', ['id' => $unidade->id, 'escolha' => 'CNPJ (OSS e Unidades Sob Gestão)'])}}"><i class="bi bi-reply-fill"></i> Voltar </a>
				</div>
				<div class="p-3">
					<a href="{{route('novoDR', $unidade->id)}}" class="btn-sm btn-dark" style="color: #FFFFFF;"> Novo <i class="fas fa-check"></i> </a>
				</div>
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
		<div class="col-md-1"></div>
		<div class="col-md-10 text-center">
			@foreach($types as $type)
			<div class="accordion border-0" id="accordionExample">
				<div class="card">
					<div class="card-header border-0 p-2" id="headingOne" style="padding: 0px;">
						<h6 class="mb-0">
							<a class=" text-dark no-underline" type="button" data-toggle="collapse" data-target="#{{$type->id}}" aria-expanded="true" aria-controls="{{$type->id}}">
								{{$type->type_name}}
							</a>
						</h6>
					</div>
					<div id="{{$type->id}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
						<div class="card-body d-flex flex-column justify-content-center justify-content-md-between">
							@foreach($documents as $docs)
							@if($docs->type_id == $type->id)
							<div class="d-sm-inline-flex text-sm-center flex-wrap justify-content-between">
								<div class="" style="font-size: 13px;">{{$docs->name}}</div>
								<div class="d-inline-flex justify-content-between">
									<div class="p-1">
										<a href="{{asset('storage/')}}/{{$docs->path_file}}" target="_blank" class="badge badge-success">Download</a>
									</div>
									<div class="p-1">
									  @if($docs->status_documentos == 0)
										<a title="Ativar" class="btn btn-success btn-sm" style="color: #000000;" href="{{route('telaInativarDR', array($unidade->id, $docs->id))}}"><i class="fas fa-times-circle"></i></a>
									  @else
										<a title="Inativar" class="btn btn-warning btn-sm" style="color: #000000;" href="{{route('telaInativarDR', array($unidade->id, $docs->id))}}"><i class="fas fa-times-circle"></i></a>
									  @endif
									</div>
									<!--div class="p-1">
										<a class="btn btn-danger btn-sm" style="color: #FFFFFF;" href="{{route('excluirDR', array($unidade->id, $docs->id))}}"><i class="bi bi-trash"></i></a>
									</div-->
								</div>
							</div>
							<div>
								<hr>
							</div>
							@endif
							@endforeach
						</div>
					</div>
				</div>
				@endforeach
			</div>
			<div class="col-md-1"></div>
		</div>
	</div>

@endsection