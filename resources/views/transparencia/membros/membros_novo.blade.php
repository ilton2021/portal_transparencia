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
			<h5  style="font-size: 18px;">CADASTRAR MEMBROS DIRIGENTES:</h5>
		</div>
	</div>
	
	
	@if ($errors->any())
			<div class="alert alert-danger">
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
						<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
							ASSOCIADOS EFETIVOS: <i class="fas fa-check-circle"></i>
						</a>
					</div>
						<form action="{{\Request::route('store'), $unidade->id}}" method="post">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<table border="0" class="table table-sm">
								<tr>
									<td> Nome: </td>
									<td> <input class="form-control" style="width: 400px;" type="text" id="name" name="name" value="" required /> </td>
								</tr>
								<tr>
									<td> CPF: </td>
									<td> <input class="form-control" style="width: 300px;" type="text" id="cpf" name="cpf" max="11" value="" required /> </td>
								</tr>
								<tr>
									<td> Tipo Membro: </td>
								    <td> <input class="form-control" readonly="true" style="width: 300px;" type="text" id="tipo_membro" name="tipo_membro" value="Associados Efetivos" /> </td>
								</tr>
							</table>
							
							<table>
							 <tr>
							   <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
							   <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="membrosDirigentes" /> </td>
							   <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarMembrosDirigentes" /> </td>
							   <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
							 </tr>
							</table>
							
							<table>
								<tr>
									<td> 
										<a href="{{route('listarAssociado', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
										<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" />
									</td>
								</tr>
							</table>
						</form>
			</div>								
		</div>
	</div>
</div>
@endsection