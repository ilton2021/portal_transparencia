@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">VINCULAR GESTOR(ES) AO CONTRATO:</h3>
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
		<div class="col-md-12 col-sm-12 text-center">
			<div class="accordion" id="accordionExample">
				<div class="card">
				  <div class="card-header" id="headingOne">
					<h2 class="mb-0">
					  <a class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
						<strong>Gestor do Contrato</strong>
					  </a>
					</h2>
				  </div>
						<table class="table table-sm">
				 		  <thead class="bg-success">
							 <tr>
								<th scope="col">Nome</th>
							 </tr>
						  </thead>
						  <tbody>
						   @if(!empty($gestorContratos))
							 @foreach($gestorContratos as $gContrato)
							  <tr>
							    <td>{{$gContrato->Nome}}</td>
							  </tr>
							 @endforeach
						  @endif	 
						  </tbody>
				  </table>
				  
				  <div class="card-header" id="headingTwo">
					<h2 class="mb-0">
					  <a class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						<strong>Contrato</strong>
					  </a>
					</h2>
				  </div>
						<table class="table table-sm">
				 		  <thead class="bg-success">
							 <tr>
							    <th scope="col">ID</th>
								<th scope="col">Nome</th>
							 </tr>
						  </thead>
						  <tbody>
							 @foreach($contrato as $cont)
							  <tr>
							    <td>{{$cont->id}}</td>
								<?php $id = $cont->id; ?>
							    <td>{{$cont->objeto}}</td>
							  </tr>
							 @endforeach
						  </tbody>
				  </table>
				
				  <div class="card-header" id="headingThree">
					<h2 class="mb-0">
					  <a class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						<strong>Gestores</strong>
					  </a>
					</h2>
				  </div>
				     <form method="POST" action="{{ route('procurarPrestador', $unidade->id) }}">
					 <input type="hidden" name="_token" value="{{ csrf_token() }}">
				    <table class="table table-sm">
								<thead class="bg-success">
									<tr>
										<th scope="col">Nome</th>
										<th scope="col">Email</th>
										<th scope="col">Vincular</th>
									</tr>
								</thead>
								<tbody>
									 @foreach($gestores as $gestor)
									  <tr>
										<td style="font-size: 18px;">{{$gestor->nome}}</td>
										<td style="font-size: 18px;">{{$gestor->email}}</td>
										<td> <a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{route('validarGestorContrato', array($unidade->id, $gestor->id, $id))}}" > <i class="fas fa-check"></i></a> </td>
									  </tr>
									 @endforeach
								</tbody>
							<tr>
							  <td align="left"> <br /><br /> <a href="{{route('contratacaoCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
							  <a class="btn btn-dark btn-sm" style="color: #FFFFFF; margin-top: 10px;" href="{{route('responsavelNovo', array($unidade->id, $id))}}" > Adicionar Gestor <i class="fas fa-check"></i></a>
							</tr>
						</table>
					  </form>
				</div>
			</div>
		</div>							
	</div>
</div>
@endsection