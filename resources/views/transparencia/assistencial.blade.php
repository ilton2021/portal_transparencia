@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row mb-2" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5 style="font-size: 18px;">RELATÓRIO ASSISTENCIAL</h5>
			@if(Auth::check())
			 @foreach ($permissao_users as $permissao)
			  @if(($permissao->permissao_id == 8) && ($permissao->user_id == Auth::user()->id))
			   @if ($permissao->unidade_id == $unidade->id)
			    <div class="d-flex mt-4 justify-content-center">
				@if($unidade->id == 8)
				 <p align="right"><a href="{{route('cadastroRAC', $unidade->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Alterar <i class="fas fa-edit"></i> </a></p>
				@else
				 <p align="right"><a href="{{route('cadastroRA', $unidade->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Alterar <i class="fas fa-edit"></i> </a></p>
			    </div>
			    @endif
			   @endif
			  @endif
		 	 @endforeach
			@endif
		</div>
	</div>
	
	<div class="row mt-3">
		<div class="col-md-12">
			<div class="d-flex m-2 justify-content-sm-start justify-content-lg-start justify-content-md-start" style="overflow:auto;">
				@foreach($anosRef as $year)
				<div class="p-2">
					<button class="btn btn-success btn-lg " type="button" data-toggle="collapse" data-target="#{{$year}}" aria-expanded="false" aria-controls="{{$year}}">
						{{$year}}
					</button>
				</div>
				@endforeach
			</div>
			@foreach($anosRef as $year)
			<div class="collapse border-0" id="{{$year}}">
				<div class="card border-0 card-body" style="background-color: #fafafa;">
					<div class="d-inline-flex flex-wrap justify-content-center text-center">
						<h5 class="text-success"><strong>{{$year}}</strong></h5>
					</div>
					<div class="d-inline-flex flex-wrap justify-content-center text-center">
						@if(Auth::check())
						<div class="p-2">
							<a class="text-success" href="{{route('exportAssistencialMensal',['id'=> $unidade->id, 'year'=> $year])}}" title="Download"><img src="{{asset('img/csv.png')}}" alt="" width="60"></a>
						</div>
						<div class="p-2">
							<a class="text-danger" href="{{route('assistencialPdf',['id'=> $unidade->id, 'year'=> $year])}}" title="Download"><img src="{{asset('img/pdf.png')}}" alt="" width="60"></a> </td>
						</div>
						@else
						<a href="{{route('visualizarAssistencial', ['id' => $unidade->id, 'year' => $year])}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Visualizar <i class="fas fa-bars"></i> </a>
						@endif
					</div>
				</div>
			</div>
			@endforeach
			@if($unidade->id == 8)
			<div class="row" style="margin-top: 25px;">
				<div class="col-md-2 col-sm-0"></div>
				<div class="col-md-8 col-sm-20 text-center">
					@foreach ($assistencialCovid->pluck('ano')->unique() as $ano)
					<a class="btn btn-success" data-toggle="collapse" href="#{{$ano}}" role="button" aria-expanded="false" aria-controls="{{$ano}}">{{$ano}}</a>
					@endforeach
					@foreach ($assistencialCovid->pluck('ano')->unique() as $financialReport)
					<div class="collapse border-0" id="{{$financialReport}}">
						<table class="table" style="margin-left: -200px;">
							@foreach ($assistencialCovid as $item)
							@if ($item->ano == $financialReport)
							<tr>
								<td>
									<p style="margin-top: 10px; color: #000000;">{{ $item->mes }}</p>
								</td>
								<td><a href="{{asset('storage')}}/{{$item->file_path}}" style="width: 650px;" target="_blank" class="list-group-item list-group-item-action" style="padding: 5px 5px;">{{$item->titulo}} - <span class="badge badge-secondary">{{$item->mes}}/{{$item->ano}}</span> <i style="color:#65b345" class="fas fa-cloud-download-alt"></i></a></td>
							</tr>
							@endif
							@endforeach
						</table>
					</div>
					@endforeach
					<div class="container" style="margin-top: 15px;">
						<h2 style="font-size: 80px; color:#65b345"><i class="fas fa-file-pdf"></i></h2>
					</div>
				</div>
				<div class="col-md-2 col-sm-0"></div>
			</div>
			@endif
		</div>
	</div>
</div>

<div class="container text-center" style="margin-top: 15px;">
	<h2 style="font-size: 80px; color:#65b345"><i class="fas fa-file-pdf"></i></h2>
</div>
@endsection