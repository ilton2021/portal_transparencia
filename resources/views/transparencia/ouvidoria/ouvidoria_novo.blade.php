@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">CADASTRAR OUVIDORIA:</h3>
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
						Ouvidoria: <i class="fas fa-check-circle"></i>
					</a>
					<div class="card-body" style="font-size: 14px;">
						<form action="{{\Request::route('storeOV'), $unidade->id}}" method="post">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<table>
								<tr>
									<td> <strong> Unidade: </strong> </td>
									<td> <select class="form-control" id="unidade_id" name="unidade_id">
										@foreach($unidades as $und)
										 <option id="unidade_id" name="unidade_id" value="<?php echo $und->id; ?>"> {{ $und->sigla }} </option>
										@endforeach
										</select>
									</td>
								</tr>
								<tr>
									<td> <strong>Responsável:</strong> </td>
									<td> <input style="" class="form-control" type="text" id="responsavel" name="responsavel" value="{{ old('responsavel') }}"  /> </td>
								</tr>
								<tr>
									<td> <strong> E-mail: </strong> </td>
									<td> <input style="width: 400px;" class="form-control" type="text" id="email" name="email" required value="{{ old('email') }}" /> </td>
								</tr>
								<tr>
									<td> <strong> Telefone: </strong> </td>
									<td> <input style="width: 400px" class="form-control" type="text" id="telefone" name="telefone" required value="{{ old('telefone') }}" /> </td>
								</tr>
								<td> <strong> Atendimento presencial: </strong> </td>
								<td> <input style="width: 400px" class="form-control" type="text" id="atendpresen" name="atendpresen"  value="{{ old('atendpresen') }}" /> </td>
								</tr>
								<td> <strong> Horário de funcionamento: </strong> </td>
								<td> <input style="width: 400px" class="form-control" type="text" id="hrfunciona" name="hrfunciona"  value="{{ old('hrfunciona') }}" /> </td>
								</tr> 
							</table>

							<table>
								<tr>
									<td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
									<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="Ouvidoria" /> </td>
									<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarOuvidoria" /> </td>
									<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
								</tr>
							</table>

							<table>
								<tr>
									<td> <br />
										<a href="{{route('cadastroOV', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
									</td>
									<td> &nbsp; </td>
									<td> <br />
										<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" />
									</td>
								</tr>
							</table>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-2 col-sm-0"></div>
	<br /> <br />
</div>
</div>
@endsection