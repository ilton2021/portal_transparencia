@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-bottom: 25px; margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5 style="font-size: 18px;">REGIMENTO INTERNO</h5>
		</div>
	</div>
	<div class="row justify-content-md-between justify-content-center">
		<div class="col-6 p-2">
			<a class="btn btn-warning btn-sm text-white" href="{{route('transparenciaOrganizacional', $unidade->id)}}"><strong> Voltar <strong><i class="fas fa-undo-alt"></i></a></td>
		</div>
		<div class="p-2">
			<?php if (sizeof($regimentos) == 0) { ?>
				<a href="{{route('novoRE', $unidade->id)}}" class="btn btn-dark btn-sm" style="color: #FFFFFF;"> Novo <i class="fas fa-check"></i> </a>
			<?php } else { ?>
				<a href="{{route('alterarRE', [$unidade->id, $regimentos[0]->id])}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Substituir <i class="fas fa-check"></i> </a>
				@if($regimentos[0]->status_regimento == 0)
				 <a title="Ativar" class="btn btn-success btn-sm" href="{{route('telaInativarRE', array($regimentos[0]->id, $unidade->id))}}"><i class="fas fa-times-circle"></i> </a>
				@else
				 <a title="Inativar" class="btn btn-warning btn-sm" href="{{route('telaInativarRE', array($regimentos[0]->id, $unidade->id))}}"><i class="fas fa-times-circle"></i> </a>
				@endif
				<!--a class="btn btn-danger btn-sm" href="{{route('excluirRE', [$unidade->id, $regimentos[0]->id])}}"><i class="bi bi-trash3"></i></a-->
			<?php } ?>
		</div>
	</div>
	</div>
	<?php if (sizeof($regimentos) > 0) { ?>
		<div class="embed-responsive embed-responsive-16by9">
			<iframe class="embed-responsive-item" src="{{asset('storage')}}/{{$regimentos[0]->file_path}}"></iframe>
		</div>
	<?php } ?>
</div>
@endsection