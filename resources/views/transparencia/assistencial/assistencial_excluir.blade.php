@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-bottom: 25px; margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5 style="font-size: 18px;">EXCLUIR RELATÓRIO ASSISTENCIAL:</h5>
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
	<div class="d-flex flex-column">
		<div class="card">
			<a class="form-control text-center bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
				RELATÓRIO ASSISTENCIAL: <i class="fas fa-check-circle"></i>
			</a>
		</div>

		<form action="{{\Request::route('updateRA'), $unidade->id}}" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="d-inline-flex mt-2 flex-wrap align-items-center justify-content-center text-center form-control">
				<div class="p-2">
					Indicador:
				</div>
				<div class="p-2">
					<select id="indicador_id" name="indicador_id" class="form-control" onchange="exibir_ocultar(this)" readonly="true">
						<option value="1"> 1. Consultas Médicas </option>
						<option value="2"> 2. Comissão de Controle </option>
					</select>
				</div>
				<div class="p-2">
					Ano de Referência:
				</div>
				<div class="p-2">
					<input type="text" id="ano_ref" name="ano_ref" value="<?php echo $anosRef[0]->ano_ref; ?>" readonly="true" class="form-control" style="width: 100px" required value="" />
				</div>
			</div>
			<div class="mt-3 justify-content-center" style="max-width:163vh; overflow:auto;">
				<table class="table table-sm ">
					<thead class="bg-success">
						<tr>
							<th scope="col">Descrição</th>
							<th scope="col" width="400px;">Meta Contratada/Mês</th>
							<th scope="col">Janeiro</th>
							<th scope="col">Fevereiro</th>
							<th scope="col">Março</th>
							<th scope="col">Abril</th>
							<th scope="col">Maio</th>
							<th scope="col">Junho</th>
							<th scope="col">Julho</th>
							<th scope="col">Agosto</th>
							<th scope="col">Setembro</th>
							<th scope="col">Outubro</th>
							<th scope="col">Novembro</th>
							<th scope="col">Dezembro</th>
						</tr>
					</thead>
					@foreach($anosRef as $aRef)
					<tbody>
						<tr>
							<th> <input type="hidden" id="descricao" name="descricao" value="<?php echo $aRef->descricao; ?>" class="form-control" style="width: 100px" readonly="true" />{{ $aRef->descricao}}</td>
							<th width="400px;"> <input type="text" id="meta" name="meta" value="<?php echo $aRef->meta; ?>" class="form-control" style="width: 100px" readonly="true" /> </td>
							<th> <input type="text" id="janeiro" name="janeiro" value="<?php echo $aRef->janeiro; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							<th> <input type="text" id="fevereiro" name="fevereiro" value="<?php echo $aRef->fevereiro; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							<th> <input type="text" id="marco" name="marco" value="<?php echo $aRef->marco; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							<th> <input type="text" id="abril" name="abril" value="<?php echo $aRef->abril; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							<th> <input type="text" id="maio" name="maio" value="<?php echo $aRef->maio; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							<th> <input type="text" id="junho" name="junho" value="<?php echo $aRef->junho; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							<th> <input type="text" id="julho" name="julho" value="<?php echo $aRef->julho; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							<th> <input type="text" id="agosto" name="agosto" value="<?php echo $aRef->agosto; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							<th> <input type="text" id="setembro" name="setembro" value="<?php echo $aRef->setembro; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							<th> <input type="text" id="outubro" name="outubro" value="<?php echo $aRef->outubro; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							<th> <input type="text" id="novembro" name="novembro" value="<?php echo $aRef->novembro; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							<th> <input type="text" id="dezembro" name="dezembro" value="<?php echo $aRef->dezembro; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
						</tr>
					</tbody>
					@endforeach
					<table>
						<tr>
							<td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
							<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="relAssistencial" /> </td>
							<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarRelAssistencial" /> </td>
							<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
						</tr>
					</table>
				</table>
			</div>
			<div class="mt-4 text-start">
				<h6> Deseja realmente Excluir este Relatório Assistencial?? </h6>
			</div>
			<table>
				<tr>
					<td align="left">
						<a href="{{route('cadastroRA', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
						<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Excluir" id="Excluir" name="Excluir" />
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
@endsection