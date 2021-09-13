@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">CADASTRAR RECURSOS HUMANOS:</h3>
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
		<div class="col-md-1 col-sm-0"></div>
		<div class="col-md-10 col-sm-12 text-center">
			<div class="accordion" id="accordionExample">
				<div class="card">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#SELETIVO" aria-expanded="true" aria-controls="SELETIVO">
						PROCESSO SELETIVO <i class="fas fa-tasks"></i>
					</a>				
						<form action="{{\Request::route('storeSeletivo'), $unidade->id}}" method="post" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<table class="table table-sm">
								<tr>
								  <td> Título: </td>
								  <td> <input class="form-control" style="width: 500px;" type="text" id="title" name="title" value="" required /> </td>							  
								</tr>
								<tr>
								  <td> Arquivo: </td>
								  <td> <input class="form-control" type="file" name="file_path" id="file_path" required /> </td>
								</tr>
								<tr>
								  <td> Ano: </td>
								  <td> 
									<select id="year" name="year" class="form-control" style="width: 200px;">
										<option id="year" name="year" value="2020">2020</option>  
										<option id="year" name="year" value="2021">2021</option>
										<option id="year" name="year" value="2022">2022</option>
										<option id="year" name="year" value="2023">2023</option>
										<option id="year" name="year" value="2024">2024</option>
										<option id="year" name="year" value="2025">2025</option>
									</select>
								  </td>
								</tr>
							</table>
							
							<table>
							 <tr>
							   <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
							   <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="processoSeletivo" /> </td>
							   <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarProcessoSeletivo" /> </td>
							   <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
							 </tr>
							</table>
							
							<table>
								<tr>
								  <td colspan="2" align="left"> <br /><br /> <a href="{{route('processoSCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
								  <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" /> </td>
								</tr>
							</table>
						</form>
			</div>
        </div>
		<div class="col-md-1 col-sm-0"></div>
    </div>
</div>
@endsection