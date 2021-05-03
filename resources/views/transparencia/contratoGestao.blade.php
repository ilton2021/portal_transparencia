@extends('navbar.default-navbar')@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div><div class="container-fluid">	<div class="row" style="margin-top: 25px;">		<div class="col-md-12 text-center">			<h3 style="font-size: 18px;">CONTRATOS DE GESTÃO / ADITIVOS</h3>		</div>	</div>	<div class="row" style="margin-top: 25px;">		<div class="col-md-2 col-sm-0"></div>		<div class="col-md-8 col-sm-12 text-center">			<div id="accordion">			@if($unidade->id == 2 || $unidade->id == 1 || $unidade->id == 9)				<div class="card ">					<div class="card-header" id="headingOne">							<h5 class="mb-0">								<a class="btn btn-link text-dark no-underline" data-toggle="collapse" data-target="#2" aria-expanded="true" aria-controls="2">									Hospital da Mulher do Recife - Dra. Mercês Pontes Cunha								</a>								@if(Auth::check())								 @foreach ($permissao_users as $permissao)								  @if(($permissao->permissao_id == 11) && ($permissao->user_id == Auth::user()->id))								   @if ($permissao->unidade_id == $unidade->id)																	<a href="{{route('contratoCadastro', $unidade->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Alterar <i class="fas fa-edit"></i> </a></p>								   @endif								  @endif  								 @endforeach								@endif							</h5>					</div>					<div id="2" class="collapse {{$unidade->id == 2? 'show' : ''}}" aria-labelledby="headingOne" data-parent="#accordion">						@foreach($contratos as $contrato)						@if($contrato->unidade_id == 2)						<div class="card-body"  style="font-size: 14px;">						 <a class="text-dark no-underline" target="_blank" href="{{asset('storage/')}}/{{$contrato->path_file}}"><strong>{{$contrato->title}} <i style="color: #28a745;" class="fas fa-download"></i></strong></a>						</div>						@endif						@endforeach					</div>				</div>				@endif				@if($unidade->id == 3 || $unidade->id == 1 || $unidade->id == 9)				<div class="card" style="margin-top: 25px;">     				<div class="card-header" id="headingOne">						<h5 class="mb-0">							<a class="btn btn-link text-dark no-underline" data-toggle="collapse" data-target="#3" aria-expanded="true" aria-controls="3">								Unidade Pernambucana de Atenção Especializada - Padre Assis Neves							</a>							@if(Auth::check())							 @foreach ($permissao_users as $permissao)							  @if(($permissao->permissao_id == 11) && ($permissao->user_id == Auth::user()->id))							   @if ($permissao->unidade_id == $unidade->id)																 <a href="{{route('contratoCadastro', $unidade->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Alterar <i class="fas fa-edit"></i> </a></p>							   @endif							  @endif  						     @endforeach							@endif						</h5>					</div>					<div id="3" class="collapse {{$unidade->id == 3? 'show' : ''}}" aria-labelledby="headingOne" data-parent="#accordion">						@foreach($contratos as $contrato)						@if($contrato->unidade_id == 3)						<div class="card-body"  style="font-size: 14px;">							<a class="text-dark no-underline" target="_blank" href="{{asset('storage')}}/{{$contrato->path_file}}"><strong>{{$contrato->title}} <i style="color: #28a745;" class="fas fa-download"></i></strong></a>						</div>						@endif						@endforeach					</div>				</div>				@endif				@if($unidade->id == 4 || $unidade->id == 1 || $unidade->id == 9)				<div class="card" style="margin-top: 25px;">					<div class="card-header" id="headingOne">						<h5 class="mb-0">							<a class="btn btn-link text-dark no-underline" data-toggle="collapse" data-target="#4" aria-expanded="true" aria-controls="4">								Unidade Pernambucana de Atenção Especializada - Deputado Áureo Bradley							</a>							@if(Auth::check())							  @foreach ($permissao_users as $permissao)							  @if(($permissao->permissao_id == 11) && ($permissao->user_id == Auth::user()->id))							   @if ($permissao->unidade_id == $unidade->id)																 <a href="{{route('contratoCadastro', $unidade->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Alterar <i class="fas fa-edit"></i> </a></p>							   @endif							  @endif  						     @endforeach							@endif						</h5>					</div>					<div id="4" class="collapse {{$unidade->id == 4? 'show' : ''}}" aria-labelledby="headingOne" data-parent="#accordion">						@foreach($contratos as $contrato)						@if($contrato->unidade_id == 4)						<div class="card-body"  style="font-size: 14px;">							<a class="text-dark no-underline" target="_blank" href="{{asset('storage')}}/{{$contrato->path_file}}"><strong>{{$contrato->title}} <i style="color: #28a745;" class="fas fa-download"></i></strong></a>						</div>						@endif						@endforeach					</div>				</div>				@endif				@if($unidade->id == 5 || $unidade->id == 1 || $unidade->id == 9)				<div class="card" style="margin-top: 25px;">					<div class="card-header" id="headingOne">						<h5 class="mb-0">							<a class="btn btn-link text-dark no-underline" data-toggle="collapse" data-target="#5" aria-expanded="true" aria-controls="5">								Unidade de Pública de Atendimento Especializada - Deputado Antônio Luiz Filho							</a>							@if(Auth::check())							 @foreach ($permissao_users as $permissao)							  @if(($permissao->permissao_id == 11) && ($permissao->user_id == Auth::user()->id))							   @if ($permissao->unidade_id == $unidade->id)																 <a href="{{route('contratoCadastro', $unidade->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Alterar <i class="fas fa-edit"></i> </a></p>							   @endif							  @endif  						     @endforeach							@endif						</h5>					</div>					<div id="5" class="collapse {{$unidade->id == 5? 'show' : ''}}" aria-labelledby="headingOne" data-parent="#accordion">						@foreach($contratos as $contrato)						@if($contrato->unidade_id == 5)						<div class="card-body"  style="font-size: 14px;">							<a class="text-dark no-underline" target="_blank" href="{{asset('storage/')}}/{{$contrato->path_file}}"><strong>{{$contrato->title}} <i style="color: #28a745;" class="fas fa-download"></i></strong></a>						</div>						@endif						@endforeach					</div>				</div>				@endif				@if($unidade->id == 6 || $unidade->id == 1 || $unidade->id == 9)				<div class="card" style="margin-top: 25px;">					<div class="card-header" id="headingOne">						<h5 class="mb-0">							<a class="btn btn-link text-dark no-underline" data-toggle="collapse" data-target="#6" aria-expanded="true" aria-controls="6">								UPAE CARUARU - Ministro Fernando Lyra							</a>							@if(Auth::check())							 @foreach ($permissao_users as $permissao)							  @if(($permissao->permissao_id == 11) && ($permissao->user_id == Auth::user()->id))							   @if ($permissao->unidade_id == $unidade->id)																 <a href="{{route('contratoCadastro', $unidade->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Alterar <i class="fas fa-edit"></i> </a></p>							   @endif							  @endif  						     @endforeach							@endif						</h5>					</div>					<div id="6" class="collapse {{$unidade->id == 6? 'show' : ''}}" aria-labelledby="headingOne" data-parent="#accordion">						@foreach($contratos as $contrato)						@if($contrato->unidade_id == 6)						<div class="card-body"  style="font-size: 14px;">							<a class="text-dark no-underline" target="_blank" href="{{asset('storage/')}}/{{$contrato->path_file}}"><strong>{{$contrato->title}} <i style="color: #28a745;" class="fas fa-download"></i></strong></a>						</div>						@endif						@endforeach					</div>				</div>				@endif				@if($unidade->id == 7 || $unidade->id == 1 || $unidade->id == 9)				<div class="card" style="margin-top: 25px;">					<div class="card-header" id="headingOne">						<h5 class="mb-0">							<a class="btn btn-link text-dark no-underline" data-toggle="collapse" data-target="#7" aria-expanded="true" aria-controls="7">								Hospital São Sebastião							</a>							@if(Auth::check())							  @foreach ($permissao_users as $permissao)							  @if(($permissao->permissao_id == 11) && ($permissao->user_id == Auth::user()->id))							   @if ($permissao->unidade_id == $unidade->id)																 <a href="{{route('contratoCadastro', $unidade->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Alterar <i class="fas fa-edit"></i> </a></p>							   @endif							  @endif  						     @endforeach							@endif						</h5>					</div>					<div id="7" class="collapse {{$unidade->id == 7? 'show' : ''}}" aria-labelledby="headingOne" data-parent="#accordion">						@foreach($contratos as $contrato)						@if($contrato->unidade_id == 7)						<div class="card-body"  style="font-size: 14px;">							<a class="text-dark no-underline" target="_blank" href="{{asset('storage/')}}/{{$contrato->path_file}}"><strong>{{$contrato->title}} <i style="color: #28a745;" class="fas fa-download"></i></strong></a>						</div>						@endif						@endforeach					</div>				</div>				@endif				@if($unidade->id == 8 || $unidade->id == 1 || $unidade->id == 9)				<div class="card" style="margin-top: 25px;">					<div class="card-header" id="headingOne">						<h5 class="mb-0">							<a class="btn btn-link text-dark no-underline" data-toggle="collapse" data-target="#8" aria-expanded="true" aria-controls="8">								Hospital Provisório do Recife							</a>							@if(Auth::check())							  @foreach ($permissao_users as $permissao)							  @if(($permissao->permissao_id == 11) && ($permissao->user_id == Auth::user()->id))							   @if ($permissao->unidade_id == $unidade->id)																 <a href="{{route('contratoCadastro', $unidade->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Alterar <i class="fas fa-edit"></i> </a></p>							   @endif							  @endif  						     @endforeach							@endif						</h5>					</div>					<div id="8" class="collapse {{$unidade->id == 8? 'show' : ''}}" aria-labelledby="headingOne" data-parent="#accordion">						@foreach($contratos as $contrato)						@if($contrato->unidade_id == 8)						<div class="card-body"  style="font-size: 14px;">							<a class="text-dark no-underline" target="_blank" href="{{asset('storage/')}}/{{$contrato->path_file}}"><strong>{{$contrato->title}} <i style="color: #28a745;" class="fas fa-download"></i></strong></a>						</div>						@endif						@endforeach					</div>				</div>				@endif			</div>		</div>		<div class="col-md-2 col-sm-0"></div>	</div></div>@endsection