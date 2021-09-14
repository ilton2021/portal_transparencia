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
		var i = document.getElementById("telefone").value.length; //aqui pega o tamanho do input
		if (i === 0)
		  document.getElementById("telefone").value = document.getElementById("telefone").value + "(";
		if (i === 3)
		  document.getElementById("telefone").value = document.getElementById("telefone").value + ")";
		if (i === 8) //aqui faz a divisoes colocando um ponto no terceiro e setimo indice
		  document.getElementById("telefone").value = document.getElementById("telefone").value + "-";
	  }
	});
	</script>
</head>

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-bottom: 25px; margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">ESTRUTURA ORGANIZACIONAL:</h5>
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
		<div class="col-md-12">
			<h3 style="font-size: 15px;"><strong>ORGANOGRAMA</strong></h3>
			<h5 style="font-size: 12px;">Estrutura Organizacional {{ stristr($unidade->name, 'Unidade') == true || stristr($unidade->name, 'Sociedade') == true ? 'da' : 'do'}} {{$unidade->name}}</h5>	
			<ul class="list-inline">
				<li class="list-inline-item"><h5 style="font-size: 12px;">Organograma do HCP Gestão: </h5></li>
				<li class="list-inline-item"><a href="{{asset('storage/organograma.pdf')}}" target="_blank" class="btn btn-success btn-sm"><i class="fas fa-file-download" style="margin-right: 5px;"></i>Download</a></li>
				@if($unidade->id === 1)
				<li class="list-inline-item"><a href="{{route('organograma', $unidade->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Alterar <i class="fas fa-edit"></i> </a></li>
				@endif
				<p align="right"><a href="{{route('organizacionalNovo', $unidade->id)}}" class="btn btn-dark btn-sm" style="color: #FFFFFF;"> Novo <i class="fas fa-check"></i> </a></p>
			</ul>
			@if($unidade->id > 1)
			<table class="table table-sm " id="my_table">
				<thead class="bg-success">
					<tr>
						<th scope="col">Cargo</th>
						<th scope="col">Nome</th>
						<th scope="col">E-mail</th>
						<th scope="col">Telefone</th>
						<th scope="col">Alterar</th>
						<th scope="col">Excluir</th>
					</tr>
				</thead>
				<tbody>
					
					@foreach($estruturaOrganizacional as $organizacional)
					<tr>
						<input hidden type="text" id="idOrg" name="idOrg" value="<?php echo $organizacional->id; ?>">
						<td style="font-size: 11px;">{{$organizacional->cargo}}</td>
						<td style="font-size: 11px;">{{$organizacional->name}}</td>
						<td style="font-size: 11px;">{{$organizacional->email}}</td>
						<td style="font-size: 11px;">{{$organizacional->telefone}}</td>
						<td> <a class="btn btn-info btn-sm" href="{{route('organizacionalAlterar', array($organizacional->id, $unidade->id))}}" ><i class="fas fa-edit"></i></a> </td>
						<td> <a class="btn btn-danger btn-sm" href="{{route('organizacionalExcluir', array($organizacional->id, $unidade->id))}}" ><i class="fas fa-times-circle"></i> </td>
					</tr>
					@endforeach
				</tbody>
			</table>
			@endif
		</div>
	</div> <br/><br/>
	
	<a href="{{route('transparenciaOrganizacional', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
</div>
</div>
</div>

@endsection