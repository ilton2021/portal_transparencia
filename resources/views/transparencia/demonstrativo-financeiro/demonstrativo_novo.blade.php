@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">CADASTRAR DEMONSTRATIVOS FINANCEIROS:</h3>
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
		<div class="col-md-2 col-sm-0"></div>
		<div class="col-md-8 col-sm-12 text-center">
			<div id="accordion">
				<div class="card ">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
                        Demonstrativos Financeiros: <i class="fas fa-check-circle"></i>
                    </a>
				    <div class="card-body"  style="font-size: 14px;">
						<form action="{{\Request::route('store'), $unidade->id}}" method="post" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<table>
							 <tr>
							   <td> Título: </td>
							   <td> <input class="form-control" readonly="true" type="text" id="title" name="title" value="Relatório Mensal" required /> </td>
							 </tr>
							 <tr>
							   <td> Mês: </td>
							   <td> 
								<select id="mes" name="mes" class="form-control" style="width: 200px">
								    <option value="1">Janeiro</option>
									<option value="2">Fevereiro</option>
									<option value="3">Março</option>
									<option value="4">Abril</option>
									<option value="5">Maio</option>
									<option value="6">Junho</option>
									<option value="7">Julho</option>
									<option value="8">Agosto</option>
									<option value="9">Setembro</option>
									<option value="10">Outubro</option>
									<option value="11">Novembro</option>
									<option value="12">Dezembro</option>
								</select>
							   </td>
							 </tr>
							 <tr>
							   <td> Ano: </td>
							 	 <td> <select id="ano" name="ano" class="form-control" style="width: 200px">
									<option value="2015" id="ano" name="ano">2015</option>
									<option value="2016" id="ano" name="ano">2016</option>
									<option value="2017" id="ano" name="ano">2017</option>
									<option value="2018" id="ano" name="ano">2018</option>
									<option value="2019" id="ano" name="ano">2019</option>
									<option value="2020" id="ano" name="ano">2020</option>
									<option value="2021" id="ano" name="ano">2021</option>
									<option value="2022" id="ano" name="ano">2022</option>
									<option value="2023" id="ano" name="ano">2023</option>
									<option value="2024" id="ano" name="ano">2024</option>
									<option value="2025" id="ano" name="ano">2025</option>	

								</select>	
							  </td>
							</tr>
							 <tr>
							   <td> Arquivo: </td>
							   <td> <input class="form-control" type="file" id="file_path" name="file_path" value="" /> </td>
							 </tr>
							</table>
							
							<table>
							 <tr>
							   <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
							   <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="demonstrativoFinanceiro" /> </td>
							   <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarDemonstrativoFinanceiro" /> </td>
							   <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
							 </tr>
							</table>
							
							<table>
							  <tr>
								<td> <a href="{{route('demonstrativoFinanCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a> </td>
								<td> <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" /> </td>
							  </tr>
							</table>
						</form>
					</div>
				</div>
			</div>
		</div>	
		<div class="col-md-2 col-sm-0"></div>	
    </div>
</div>
@endsection