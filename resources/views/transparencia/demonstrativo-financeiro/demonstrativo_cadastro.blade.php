@extends('navbar.default-navbar')
@section('content')

<style>
	:root {
		--bg: #dcdde1;
		--color-icon: #535c68;
		--social-icon1: #e4405f;
		--social-icon2: #3b5999;
		--social-icon3: #e4405f;
		--social-icon4: #cd201f;
		--social-icon5: #0077B5;
	}

	* {
		margin: 0;
		padding: 0;
	}

	section {
		width: 100%;
		height: 100vh;
		display: flex;
		align-items: center;
		justify-content: center;
		background: var(--bg);
		z-index: -10;
	}

	.icon-list {
		width: 100%;
		max-width: 50rem;
		padding: 0 1.5rem;
		display: flex;
		justify-content: space-between;
	}

	.icon-item {
		list-style: none
	}

	.icon-link {
		display: inline-flex;
		font-size: 3rem;
		text-decoration: none;
		color: var(--color-icon);
		width: 3rem;
		height: 3rem;
		transition: .5s linear;
		position: relative;
		z-index: 1;
		margin: auto
	}

	.icon-link:hover {
		color: #fff;
	}

	.icon-link i {
		margin: auto;
	}

	.icon-link::before {
		content: '';
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		width: 3rem;
		height: 3rem;
		background: green;
		border-radius: 50%;
		z-index: -1;
		transform: scale(0);
		transition: 0.3s cubic-bezier(.95, .32, .37, 1.21);
	}

	.icon-link:hover::before {
		transform: scale(1);
	}

	.icon-item:nth-child(1) a:hover:before {
		background: var(--social-icon1);
	}

	.icon-item:nth-child(2) a:hover:before {
		background: var(--social-icon2);
	}

	.icon-item:nth-child(3) a:hover:before {
		background: var(--social-icon3);
	}

	.icon-item:nth-child(4) a:hover:before {
		background: var(--social-icon4);
	}

	.icon-item:nth-child(5) a:hover:before {
		background: var(--social-icon5);
	}
</style>

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">

	<div class="d-flex flex-column text-center mt-3">
		<div>
			<h3 style="font-size: 18px;">DEMONSTRATIVOS FINANCEIROS</h3>
		</div>
		<div class="d-flex justify-content-around">
			<div>
				<a href="{{route('transparenciaDemonstrative', array($unidade->id,1))}}" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
			</div>
			<div>
				<a href="{{route('novoDF', $unidade->id)}}" class="btn btn-dark btn-sm" style="color: #FFFFFF;"> Novo <i class="fas fa-check"></i> </a>
			</div>
		</div>
	</div>

	<div class="row" style="margin-top: 25px;">
		<div class="col-md-1 col-sm-0"></div>
		<div class="col-md-10 col-sm-12 text-center">
			@foreach ($financialReports->pluck('ano')->unique() as $ano)
			<div class="d-inline-flex flex-wrap">
				<div class="p-2">
					<a class="btn btn-success" data-toggle="collapse" href="#{{$ano}}" role="button" aria-expanded="false" aria-controls="{{$ano}}">{{$ano}}</a>
				</div>
			</div>
			@endforeach
			@foreach ($financialReports->pluck('ano')->unique() as $financialReport)
			<div class="collapse border-0" id="{{$financialReport}}">
				<div class="card card-body border-0" style="background-color: #fafafa">
					@foreach ($financialReports as $item)
					@if ($item->ano == $financialReport)
					<div class="d-flex flex-column justify-content-center border-bottom border-success">
						<div class="d-md-inline-flex justify-content-between">
							<div class="p-2">
								@if($item->tipoarq == 0 || $item->tipoarq == 1)
								<i style="color:#65b345; font-size:25px;" class="bi bi-filetype-pdf"></i>
								@elseif($item->tipoarq == 2)
								<i style="color:#65b345; font-size:25px;" class="bi bi-file-zip-fill"> </i>
								@elseif($item->tipoarq == 3)
								<i style="color:#65b345; font-size:25px;" class="bi bi-link"></i>
								@endif

								{{$item->title}} -

								<span class="badge badge-secondary">{{$item->mes}}/{{$item->ano}}</span>
							</div>

							<div class="d-inline-flex">
								@if($item->tipoarq == 0 || $item->tipoarq == 1 || $item->tipoarq == 2)
								<div class="p-2">
									<a class="icon-link" href="{{asset('storage')}}/{{$item->file_path}}" target="_blank"><i style="color:#65b345; font-size:25px;" class="bi bi-download"></i></a>
								</div>
								@elseif($item->tipoarq == 3)
								<div class="p-2">
									<a class="icon-link" href="{{$item->file_link}}" target="_blank" style="padding: 5px 5px;"><i style="color:#65b345; font-size:25px;" class="bi bi-globe"></i></a>
								</div>
								@endif
								<div class="p-2 mt-2">
									<a class="btn btn-info btn-sm" href="{{route('alterarDF', array($unidade->id, $item))}}"><i class="bi bi-pencil-square"></i></a>
								</div>
								<div class="p-2 mt-2">
									@if($item->status_financeiro == 0)
									  <a title="Ativar" class="btn btn-success btn-sm" style="color: #FFFFFF;" href="{{route('telaInativarDF', array($unidade->id, $item->id))}}"><i class="fas fa-times-circle"></i></a>
									@else	
									  <a title="Inativar" class="btn btn-warning btn-sm" style="color: #FFFFFF;" href="{{route('telaInativarDF', array($unidade->id, $item->id))}}"><i class="fas fa-times-circle"></i></a>
									@endif
								</div>
								<!--div class="p-2 mt-2">
									<a class="btn btn-danger btn-sm" href="{{route('excluirDF', array($unidade->id, $item))}}"><i class="bi bi-trash3-fill"></i></a>
								</div-->
							</div>
						</div>
					</div>
					@endif
					@endforeach
				</div>
			</div>
			@endforeach
			<div class="container" style="margin-top: 15px;">
				<h2 style="font-size: 80px; color:#65b345"><i class="fas fa-file-pdf"></i></h2>
			</div>
		</div>
		<div class="col-md-1 col-sm-0"></div>
	</div>
</div>
@endsection