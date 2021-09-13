@extends('navbar.default-navbar')
@section('content')
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>	
  <link href="{{ asset('js/utils.js') }}" rel="stylesheet">
  <link href="{{ asset('js/bootstrap.js') }}" rel="stylesheet">
<script>
		$("#cpf").keyup(function() {
				$("#cpf").val(this.value.match(/[0-11]*/));
			});

			document.addEventListener('keydown', function(event) { //pega o evento de precionar uma tecla
	 	if(event.keyCode != 46 && event.keyCode != 8){//verifica se a tecla precionada nao e um backspace e delete
		var i = document.getElementById("cpf").value.length; //aqui pega o tamanho do input
		if (i === 3)
		  document.getElementById("cpf").value = document.getElementById("cpf").value + ".";
		if (i === 7)
		  document.getElementById("cpf").value = document.getElementById("cpf").value + ".";
		if (i === 11) //aqui faz a divisoes colocando um ponto no terceiro e setimo indice
		  document.getElementById("cpf").value = document.getElementById("cpf").value + "-";
	 	 }
	});	
</script>
</head>
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">MEMBROS DIRIGENTES</h5>
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
		<div class="col-md-12 col-sm-12">


			<div class="accordion" id="accordionExample">
				<div class="card">
					<div class="card-header d-flex justify-content-between" id="headingOne">
						<h5 class="mb-0">
							<a class="btn btn-link text-dark no-underline" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								ASSOCIADOS <i class="far fa-list-alt"></i>
							</a>
						</h5>
						<h5 class="mb-0">
							<li class="list-inline-item"><a href="{{route('associadoNovo', $unidade->id)}}" id="Novo" name="Novo" type="button" class="btn btn-dark btn-sm" style="color: #FFFFFF;"> Novo <i class="fas fa-check"></i> </a></li>	
							<a href="{{route('transparenciaMembros', ['id' => $unidade->id, 'escolha' => 'Associados'])}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
						</h5>
						
					</div>
						    
						<div class="card-body">
							<div class="container text-center"><h5 style="font-size: 15px;"><strong>Estrutura Organizacional do Hospital de Câncer de Pernambuco - Associados Efetivos</strong></h5></div>
							<div class="row">
								<div class="col-md-2 col-sm-0"></div>
								<div class="col-md-8 col-sm-12">
									<table class="table table-sm">
										<thead >
											<tr class="text-center">
												<th class="border-bottom" scope="col">Nome</th>
												<th class="border-bottom" scope="col">CPF</th>
												<th class="border-bottom" scope="col">Alterar</th>
												<th class="border-bottom" scope="col">Excluir</th>
											</tr>
										</thead>
										<tbody class="">
											@foreach($associados as $associado)
												@csrf
												<tr>
													<td style="font-size: 12px;">{{$associado->name}} </td>
													<td style="font-size: 12px;">{{$associado->cpf}} </td>
													<td> <center> <a class="btn btn-info btn-sm" href="{{route('associadoAlterar', array($unidade->id, $associado->id))}}" ><i class="fas fa-edit"></i></a> </center> </td>
													<td> <center> <a class="btn btn-danger btn-sm" href="{{route('associadoExcluir', array($unidade->id, $associado->id))}}" ><i class="fas fa-times-circle"></i></a> </center> </td>
												</tr>
											</form>
											@endforeach
										</tbody>
									</table>
								</div>
								<div class="col-md-2 col-sm-0"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
@endsection