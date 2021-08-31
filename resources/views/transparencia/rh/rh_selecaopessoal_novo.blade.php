@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">CADASTRAR RECURSOS HUMANOS:</h3>
		</div>
	</div>
	
	@if (Session::has('mensagem'))
		@if ($text == true)
		<div class="container">
	     <div class="alert alert-danger {{ Session::get ('mensagem')['class'] }} ">
		      {{ Session::get ('mensagem')['msg'] }}
		 </div>
		</div>
		@endif
	@endif
	
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-1 col-sm-0"></div>
		<div class="col-md-10 col-sm-12 text-center">
			<div class="accordion" id="accordionExample">
				<div class="card">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
						SELEÇÃO DE PESSOAL <i class="fas fa-check-circle"></i>
					</a>				
				</div>
					<form action="{{\Request::route('storeSelecao'), $unidade->id}}" method="post">	
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<table class="table table-sm">
							<tr>
							  <td> Cargo: </td>
							  <td>
								<select class="form-control" style="width: 500px;" id="cargo_name" name="cargo_name">							  
							    @foreach ( $cargos as $cargo )
								  <option style="width: 500px;"> {{ $cargo->cargo_name }} </option>
								@endforeach
								</select>
							  </td>							  
						    </tr>
							<tr>
							  <td> Quantidade: </td>
							  <td> <input class="form-control" style="width: 100px;" type="number" id="quantidade" name="quantidade" value="" required /> </td>
							</tr>
							<tr>
							<td> Ano: </td>
							 	 <td> <select id="ano" name="ano" class="form-control" style="width: 100px">
									<option value="2021" id="ano" name="ano">2021</option>
									<option value="2022" id="ano" name="ano">2022</option>
									<option value="2023" id="ano" name="ano">2023</option>
									<option value="2024" id="ano" name="ano">2024</option>
									<option value="2025" id="ano" name="ano">2025</option>
									<option value="2026" id="ano" name="ano">2021</option>
									<option value="2027" id="ano" name="ano">2022</option>
									<option value="2028" id="ano" name="ano">2023</option>
									<option value="2029" id="ano" name="ano">2024</option>
									<option value="2030" id="ano" name="ano">2025</option>	
	

								</select>	
							  </td>						</tr>
							<input hidden type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" />
						</table>
						
						<table>
							 <tr>
							   <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
							   <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="selecaoPessoal" /> </td>
							   <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarSelecaoPessoal" /> </td>
							   <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
							 </tr>
						</table>
						
						<table>
							<tr>
							  <td colspan="2" align="left"> <br /><br /> <a href="{{route('selecaoPCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
							  <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" /> </td>
							  <td> <br /><br /> <a href="{{route('selecaoPCargos', $unidade->id)}}" class="btn btn-dark btn-sm" style="margin-top: 10px; margin-left: 580px; color: #FFFFFF;"> Novo Cargo <i class="fas fa-check"></i> </a> </td>
							</tr>
						</table>
					</form>
			</div>
        </div>
		<div class="col-md-1 col-sm-0"></div>
    </div>
</div>
@endsection