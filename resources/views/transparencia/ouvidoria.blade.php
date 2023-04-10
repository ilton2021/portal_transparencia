@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid" style="margin-top: 25px;">
	<div class="row" style="margin-bottom: 25px;">
		<div class="col-md-12 text-center">
			<h5 style="font-size: 18px;">SERVIÇO DE INFORMAÇÃO AO CLIENTE - SIC <i class="fas fa-globe"></i></h5>

		</div>
	</div> <br>
	<div class="row d-flex justify-content-center">

		<table border="0" class="table table-sm" align="center">
			@if($unidade->id == 3 || $unidade->id == 4 || $unidade->id == 6 || $unidade->id == 7 || $unidade->id == 9 || $unidade->id == 10)
			<tr>
				<td align="center"> <img class="img-fluid card-img-top" style="width: 22rem; background-color: #fafafa;" src="{{asset('img/logoGov.png')}}" alt="Card image cap"> </td>
			</tr>
			@elseif($unidade->id == 2 || $unidade->id == 5 || $unidade->id == 8)
			<tr>
				<td align="center"> <img class="img-fluid card-img-top" style="width: 22rem; background-color: #fafafa;" src="{{asset('img/logo-prefeitura-recife.png')}}" alt="Card image cap"> </td>
			</tr>
			<tr>
				<td align="center"> </td>
			</tr>
			@else
			<tr>
				<td align="center"> <img class="card-img-top" style="width: 22rem; background-color: #fafafa;" src="{{asset('img/logoGov.png')}}" alt="Card image cap"> </td>
				<td align="center"> <img class="card-img-top" style="width: 22rem; background-color: #fafafa;" src="{{asset('img/logo-prefeitura-recife.png')}}" alt="Card image cap"> </td>
			</tr>
			<tr>
				<td align="center"> <strong><a href="http://www.portaisgoverno.pe.gov.br/web/ouvidoria/formularios-lai" target="_blank" style="font-size: 11px;">SERVIÇO DE INFORMAÇÃO AO CIDADÃO - SIC <i class="fas fa-globe"></i> clique aqui <i class="fas fa-globe"></i></a> </strong> </td>
				<td align="center"> <strong><a href="https://ouvidoria.recife.pe.gov.br/" target="_blank" style="font-size: 11px;">SERVIÇO DE INFORMAÇÃO AO CIDADÃO - SIC <i class="fas fa-globe"></i> clique aqui <i class="fas fa-globe"></i></a></strong></td>
			</tr>
			@endif
		</table>

		<div class="text-center">

			<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Atendimento Eletrônico</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Atendimento Presencial</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Relatório Estatístico - PAI</a>
				</li>
			</ul>

			<div class="tab-content" id="pills-tabContent">
				<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

					@if($unidade->id == 3 || $unidade->id == 4 || $unidade->id == 6 || $unidade->id == 7 || $unidade->id == 9 || $unidade->id == 10)
					<table border="0" class="table table-success">
						<br>
						<tr>
							<td>
								<center><strong> <a href="http://www.portaisgoverno.pe.gov.br/web/ouvidoria/formularios-lai" target="_blank" style="font-size: 11px;">SERVIÇO DE INFORMAÇÃO AO CIDADÃO - SIC <i class="fas fa-globe"></i> clique aqui <i class="fas fa-globe"></i></a> </strong></center>
							</td>
						</tr>
						<tr>
							<td>
								<center><strong>
										<font size="2"> Passo a Passo para Solicitar Informação ou Reclamação </font> <a href="{{asset('storage/ouvidoria.pdf')}}" target="_blank"> <img src="{{asset('img/pdf.png')}}" style="font-size: 11px;" width="30px" height="30px"> </a>
									</strong></center>
							</td>
						</tr>
					</table>
					@elseif($unidade->id == 2 || $unidade->id == 5 || $unidade->id == 8)
					<table border="0" class="table table-success">
						<br>
						<tr>
							<td>
								<center><strong><a href="https://ouvidoria.recife.pe.gov.br/" target="_blank" style="font-size: 17px;">Serviço de Informação ao Cidadão - SIC <br> <i class="fas fa-globe"></i> clique aqui <i class="fas fa-globe"></i></a></strong></center>
							</td>
						</tr>
						<tr>
							<td>
								<center>
										<label style="font-size:15px">Para obter acesso ao Passo a Passo de como Solicitar Informação ou Reclamação <strong><a href="{{asset('storage/ouvidoria_prefeitura.pdf')}}" target="_blank">clique aqui</a></strong></label> <a href="{{asset('storage/ouvidoria_prefeitura.pdf')}}" target="_blank"> <img src="{{asset('img/pdf.png')}}" style="font-size: 11px;" width="30px" height="30px"> </a>
									</center>
							</td>
						</tr>
					</table>
					@else
					<table border="0" class="table table-success">
						<br>
						<tr>
							<td>
								<center><strong>
										<font size="2"> Passo a Passo para Solicitar Informação ou Reclamação </font> <a href="{{asset('storage/ouvidoria.pdf')}}" target="_blank"> <img src="{{asset('img/pdf.png')}}" style="font-size: 11px;" width="30px" height="30px"> </a>
									</strong></center>
							</td>
						</tr>
					</table>
					@endif
					
					<div class="d-sm-block justify-content-sm-center table-success rounded mt-4 ">
					    @foreach($ouvidorias as $o)
						<div class="d-flex flex-column justify-content-center">
							<div class="d-flex flex-column justify-content-center">
								<div class="d-sm-inline-flex text-center justify-content-sm-center">
									<div class="d-flex flex-column justify-content-center p-2 text-center">
										<div><label><label style="font-size:17px;">@</label><b> E-mail da ouvidoria da unidade:</b></label></div>
										<div><label>{{$o->email}}</label></div>
									</div>
								</div>
							</div>
						</div>
					 @endforeach
					</div>
					@if($unidade->id == 2 || $unidade->id == 5)
					<div class="d-sm-block justify-content-sm-center table-success rounded mt-4 ">
						<div class="d-flex flex-column justify-content-center">
							<div class="d-flex flex-column justify-content-center">
								<div class="d-sm-inline-flex text-center justify-content-sm-center">
									<div class="d-flex flex-column justify-content-center p-1 text-center">
										<div><label><label style="font-size:17px;"></label><b> Ouvidoria municipal de saúde</b></label>
    										<div class="d-flex flex-column" style="font-size:15px;">
    										   <label> <i class="bi bi-telephone-fill"></i> Contato: 0800 281 1520</label>
    										    <label>Segunda a sexta-feira das 7h às 19h.</label>
    										    <label><i class="bi bi-envelope"></i> ouvidoria.saude@recife.pe.gov.br</label>
    										</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					@endif
				</div>
				<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
					@if(Auth::check())
					<div class="d-flex justify-content-center m-1">
						<a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{route('cadastroOV', $unidade->id)}}"> Alterar <i class="fas fa-edit"></i> </a>
					</div>
					@endif
					<div class="d-sm-block table-success rounded">
						<div class="d-flex flex-column">
							@foreach($ouvidorias as $o)
							<div class="d-flex flex-column text-center border-bottom border-success">
								<div class="d-sm-inline-flex justify-content-sm-between text-sm-left">
									<div class="d-flex flex-column p-2">
										<div><label><i style="font-size:25px;" class="bi bi-building"></i><b> Endereço de Atendimento:</b></label></div>
										<div><label>{{$unidade->address . ", " . $unidade->numero . ", ". $unidade->city . ","}} <br> {{$unidade->district}} - {{$unidade->uf}} - CEP {{$unidade->cep}}</label></div>
									</div>
									<div class="d-flex flex-column text-sm-right p-2">
										@if($o->responsavel !== NULL)
										<div><label><i style="font-size:25px;" class="bi bi-person-circle"></i><b> Responsável:</b></label></div>
										<div><label>{{$o->responsavel}}</label></div>
										@endif
									</div>
								</div>
							</div>
							<div class="d-flex flex-column text-center border-bottom border-success">
								<div class="d-sm-inline-flex justify-content-between text-sm-left">
									<div class="d-flex flex-column p-2">
										@if($o->email !== NULL)
										<div><label><label style="font-size:20px;">@</label> <b> E-mail:</b> {{$o->email}}</label></div>
										@endif
									</div>
									<div class="d-flex flex-column text-sm-right p-2">
										@if($o->atendpresen !== NULL)
										<div><label><i style="font-size:25px;" class="bi bi-chat-right-dots"></i><b> Setor atendimento:</b></label></div>
										<div><label>{{$o->atendpresen}}</label></div>
										@endif
									</div>
								</div>
							</div>
							<div class="d-flex flex-column text-center">
								<div class="d-sm-inline-flex justify-content-between text-sm-left">
									<div class="d-flex flex-column p-2">
										@if($o->hrfunciona !== NULL)
										<div><label><i style="font-size:25px;" class="bi bi-stopwatch-fill"></i><b> Horário de funcionamento:</b></label></div>
										<div><label>{{$o->hrfunciona}}</label></div>
										@endif
									</div>
									<div class="d-flex flex-column text-sm-right p-2">
										@if($o->telefone !== NULL)
										<div><label><i style="font-size:25px;" class="bi bi-telephone"></i><b> Telefone</b></label></div>
										<div><label>{{$o->telefone}}</label></div>
										@endif
									</div>
								</div>
							</div>
							@endforeach
						</div>
					</div>
					@if($unidade->id !== 2 && $unidade->id !== 5)
					<div class="d-sm-block justify-content-sm-center table-success rounded mt-4 ">
						<div class="d-flex flex-column justify-content-center">
							<div class="d-flex flex-column justify-content-center">
								<div class="d-sm-inline-flex text-center justify-content-sm-center">
									<div class="d-flex flex-column justify-content-center p-2 text-center">
										@if($unidade->id == 2 || $unidade->id == 5)
										<!--div><label><i style="font-size:25px;" class="bi bi-building"></i><b> Endereço de Atendimento ouvidoria do municipio:</b></label></div>
										<div><label></label></div-->
										@else
										<div><label><i style="font-size:25px;" class="bi bi-building"></i><b> Endereço de Atendimento ouvidoria do estado:</b></label></div>
										<div><label>Rua Santo Elias, 535, 8º andar, Espinheiro, Recife-PE. CEP: 52020-090</label></div>
										<div><labe>Informações: (081) 3183-0800 / 162</labe></div>
										<div><label>Horário de funcionamento: 8h às 17h</label></div>
										@endif
									</div>
								</div>
							</div>

						</div>
					</div>
					@else
					@endif
				</div>
				<div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
					@if(Auth::check())
					<div class="d-flex justify-content-center m-1">
						<a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{route('cadastroOVRelatorioES', $unidade->id)}}"> Alterar <i class="fas fa-edit"></i> </a>
					</div>
					@endif
					<div class="row" style="margin-top: 25px;">
						<div class="col-md-1 col-sm-0"></div>
						<div class="col-md-10 col-sm-12 text-center">
							@foreach ($relatoriosEs->pluck('ano')->unique() as $ano)
							<div class="d-inline-flex flex-wrap">
								<div class="p-2">
									<a class="btn btn-success" data-toggle="collapse" href="#{{$ano}}" role="button" aria-expanded="false" aria-controls="{{$ano}}">{{$ano}}</a>
								</div>
							</div>
							@endforeach
							@if(sizeof($relatoriosEs) > 0)
							@foreach ($relatoriosEs->pluck('ano')->unique() as $RF)
							<div class="collapse border border-success m-2 rounded" id="{{$RF}}">
								<div class="card card-body border-0" style="background-color: #fafafa">
									@foreach ($relatoriosEs as $item)
									@if ($item->ano == $RF)
									<div class="d-flex flex-column justify-content-center border-bottom border-success">
										<div class="d-md-inline-flex justify-content-between align-items-center">
											<div class="p-1" style="font-size:16px;">
												Relatório estastístico -
												<span class="badge badge-secondary">{{$item->mes}}/{{$item->ano}}</span>
											</div>
											<div class="d-inline-flex">
												<div class="p-2">
													<a class="icon-link" href="{{asset('storage')}}/{{$item->file_path}}" target="_blank"> <i style="color:#65b345; font-size:32px;" class="bi bi-file-earmark-arrow-down-fill"></i></a>
												</div>
											</div>
										</div>
									</div>
									@endif
									@endforeach
								</div>
							</div>
							@endforeach
							@else
							<div class="container" style="margin-top: 15px;">
								<h2 style="font-size: 80px; color:#65b345"><i class="fas fa-file-pdf"></i></h2>
							</div>
							@endif
						</div>
						<div class="col-md-1 col-sm-0"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
@endsection