@extends('navbar.default-navbar')
@section('content')
<style>
	* {
		margin: 0;
		padding: 0;
		box-sizing: border-box;
	}

	.content {
		display: flex;
		margin: auto;

	}

	.rTable {
		width: 100%;
		text-align: center;

	}

	.rTable thead {
		background: #28a745;
		font-weight: bold;
		color: #fff;
	}

	.rTable tbody tr:nth-child(2n) {
		background: #ccc;
	}

	.rTable th,
	.rTable td {
		padding: 7px 0;
	}

	@media screen and (max-width: 480px) {
		.content {
			width: 94%;
		}

		.rTable thead {
			display: none;
		}

		.rTable tbody td {
			display: flex;
			flex-direction: column;
		}
	}

	@media only screen and (min-width: 1200px) {
		.content {
			width: 100%;
		}

		.rTable tbody tr td:nth-child(1) {
			width: 10%;
		}

		.rTable tbody tr td:nth-child(2) {
			width: 30%;
		}

		.rTable tbody tr td:nth-child(3) {
			width: 20%;
		}

		.rTable tbody tr td:nth-child(4) {
			width: 10%;
		}

		.rTable tbody tr td:nth-child(5) {
			width: 30%;
		}
	}
</style>
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="row" style="margin-top: 25px;">
	<div class="col-md-12 text-center">
		<h5 style="font-size: 18px;">VISUALIZAR RELATÓRIO ASSISTENCIAL:</h5>
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
<div class="d-flex flex-wrap align-items-center text-center justify-content-start">
	<div class="p-2">
		<a href="{{route('transparenciaAssistencial', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
	</div>
</div>
<div class="d-flex flex-wrap align-items-center justify-content-center">
	<div class="p-2">
		<form action="" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			Ano de Referência:
		</form>
	</div>
	<div class="p-2">
		<input type="text" id="ano_ref" name="ano_ref" value="<?php if (sizeof($anosRef) > 0) {
																	echo $anosRef[0]->ano_ref;
																} else {
																	echo $anosRefDocs[0]->ano;
																} ?>" readonly="true" class="form-control" style="width: 100px" required value="" />
	</div>
</div>
<div class="mt-3 justify-content-center text-center">
	<div class="card text-center">
		<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
			Relatório Anual de Gestão: <i class="fas fa-check-circle"></i>
		</a>
	</div>
	<div class="d-flex flex-wrap align-items-center justify-content-md-center justify-content-center form-control">
		<div class="d-flex flex-wrap align-items-center text-center justify-content-center">
			@foreach($assistenDocs as $AD)
			<div class="row mt-1">
				<div class="col-md-12 d-flex justify-content-center">
					<div class="card border-0" style="width: 40rem; background-color: #fafafa;">
						<div class="card-body border-0">
							<div class="d-flex flex-column" id="headingOne">
								<div class="d-md-inline-flex justify-content-between border-bottom border-success align-items-center">
									<div class="p-1">
										<h6 style="font-size: 18px;"> {{$AD->titulo}}</h6>
									</div>
									<div class="p-1 text-center">
										<a href="{{asset($AD->file_path)}}" target="_blank" class="btn btn-success">Download <i class="bi bi-download"></i></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</div>
<div class="mt-3 justify-content-center text-center">
	<div class="card text-center">
		<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
			Planilha do Relátorio Assistencial: <i class="fas fa-check-circle"></i>
		</a>
	</div>

	<div class="d-flex flex-wrap align-items-center justify-content-md-between justify-content-center form-control">
		<?php if (sizeof($anosRef) > 0) { ?>
			<div class="d-flex flex-wrap align-items-center justify-content-center">
				<div class="p-2">
					<a class="text-success" href="{{route('exportAssistencialMensal',['id'=> $unidade->id, 'year'=> $anosRef[0]->ano_ref])}}" title="Download"><img src="{{asset('img/csv.png')}}" alt="" width="60"></a>
				</div>
				<div class="p-2">
					<a class="text-danger" href="{{route('assistencialPdf',['id'=> $unidade->id, 'year'=> $anosRef[0]->ano_ref])}}" title="Download"><img src="{{asset('img/pdf.png')}}" alt="" width="60"></a>
				</div>
			</div>
	</div>
</div>
<div>
	<div class="d-flex justify-content-between">
		<div class="m-1">
			<button class="btn btn-success" style="font-size:30px;" id="slideLeft" type="button">
				< </button>
		</div>
		<div class="m-1">
			<button class="btn btn-success" style="font-size:30px;" id="slideRight" type="button">
				>
			</button>
		</div>
	</div>
	<div class="content mt-2" style="overflow:hidden; height:45px" id="buttonScroll">

		<table class="rTable">
			<thead>
				<tr>
					<th class="p-2" scope="col">Descrição</th>
					<th class="p-2" scope="col">Meta Contratada/Mês</th>
					<th class="p-2" scope="col">Janeiro</th>
					<th class="p-2" scope="col">Fevereiro</th>
					<th class="p-2" scope="col">Março</th>
					<th class="p-2" scope="col">Abril</th>
					<th class="p-2" scope="col">Maio</th>
					<th class="p-2" scope="col">Junho</th>
					<th class="p-2" scope="col">Julho</th>
					<th class="p-2" scope="col">Agosto</th>
					<th class="p-2" scope="col">Setembro</th>
					<th class="p-2" scope="col">Outubro</th>
					<th class="p-2" scope="col">Novembro</th>
					<th class="p-2" scope="col">Dezembro</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="p-2"> <textarea class="form-control text-left" style="width: 250px;" type="text" id="" name="" title="" readonly="true"></textarea></td>
					<td class="p-2"> <textarea class="form-control text-left" style="width: 250px;" type="text" id="" name="" title="" readonly="true"></textarea></td>
					<td class="p-2"> <textarea class="form-control text-left" style="width: 250px;" type="text" id="" name="" title="" readonly="true"></textarea></td>
					<td class="p-2"> <textarea class="form-control text-left" style="width: 250px;" type="text" id="" name="" title="" readonly="true"></textarea></td>
					<td class="p-2"> <textarea class="form-control text-left" style="width: 250px;" type="text" id="" name="" title="" readonly="true"></textarea></td>
					<td class="p-2"> <textarea class="form-control text-left" style="width: 250px;" type="text" id="" name="" title="" readonly="true"></textarea></td>
					<td class="p-2"> <textarea class="form-control text-left" style="width: 250px;" type="text" id="" name="" title="" readonly="true"></textarea></td>
					<td class="p-2"> <textarea class="form-control text-left" style="width: 250px;" type="text" id="" name="" title="" readonly="true"></textarea></td>
					<td class="p-2"> <textarea class="form-control text-left" style="width: 250px;" type="text" id="" name="" title="" readonly="true"></textarea></td>
					<td class="p-2"> <textarea class="form-control text-left" style="width: 250px;" type="text" id="" name="" title="" readonly="true"></textarea></td>
					<td class="p-2"> <textarea class="form-control text-left" style="width: 250px;" type="text" id="" name="" title="" readonly="true"></textarea></td>
					<td class="p-2"> <textarea class="form-control text-left" style="width: 250px;" type="text" id="" name="" title="" readonly="true"></textarea></td>
					<td class="p-2"> <textarea class="form-control text-left" style="width: 250px;" type="text" id="" name="" title="" readonly="true"></textarea></td>
					<td class="p-2"> <textarea class="form-control text-left" style="width: 250px;" type="text" id="" name="" title="" readonly="true"></textarea></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="content mt-2" style="overflow-x:auto; height: 70vh;" id="buttonScroll2">
		<table class="rTable">
			<thead>
				<tr>
					<th hidden class="p-2" scope="col">Descrição</th>
					<th hidden class="p-2" scope="col">Meta Contratada/Mês</th>
					<th hidden class="p-2" scope="col">Janeiro</th>
					<th hidden class="p-2" scope="col">Fevereiro</th>
					<th hidden class="p-2" scope="col">Março</th>
					<th hidden class="p-2" scope="col">Abril</th>
					<th hidden class="p-2" scope="col">Maio</th>
					<th hidden class="p-2" scope="col">Junho</th>
					<th hidden class="p-2" scope="col">Julho</th>
					<th hidden class="p-2" scope="col">Agosto</th>
					<th hidden class="p-2" scope="col">Setembro</th>
					<th hidden class="p-2" scope="col">Outubro</th>
					<th hidden class="p-2" scope="col">Novembro</th>
					<th hidden class="p-2" scope="col">Dezembro</th>
				</tr>
			</thead>
			@if(!empty($anosRef))
			@foreach($anosRef as $aRef)
			<tbody>
				<tr>
					@if($aRef->tipolinha == 1)
					<td colspan="14" class="p-2">
						<div class="d-inline-flex d-flex justify-content-around form-control text-left bg-success">
							<label class="" <?php echo $aRef->descricao == "" ? 'hidden' : 'style="color:white; font-weight: bold;"'; ?> type="text" id="desc" name="desc" title="<?php echo $aRef->descricao; ?>" readonly="true">{{$aRef->descricao}}</label>
							<label class="" <?php echo $aRef->descricao == "" ? 'hidden' : 'style="color:white; font-weight: bold;"'; ?> type="text" id="desc" name="desc" title="<?php echo $aRef->descricao; ?>" readonly="true">{{$aRef->descricao}}</label>
							<label class="" <?php echo $aRef->descricao == "" ? 'hidden' : 'style="color:white; font-weight: bold;"'; ?> type="text" id="desc" name="desc" title="<?php echo $aRef->descricao; ?>" readonly="true">{{$aRef->descricao}}</label>
							<label class="" <?php echo $aRef->descricao == "" ? 'hidden' : 'style="color:white; font-weight: bold;"'; ?> type="text" id="desc" name="desc" title="<?php echo $aRef->descricao; ?>" readonly="true">{{$aRef->descricao}}</label>
						</div>
					</td>
					@else
					<td class="p-2"> <textarea class="form-control text-left" <?php echo $aRef->descricao == "" ? 'hidden' : 'style="width:250px;"'; ?> type="text" id="desc" name="desc" title="<?php echo $aRef->descricao; ?>" readonly="true">{{$aRef->descricao}}</textarea></td>
					<td class="p-2"> <textarea class="form-control text-left" style="width: 250px;" type="text" id="met" name="met" value="<?php echo $aRef->meta; ?>" title="<?php echo $aRef->meta; ?>" readonly="true">{{$aRef->meta}}</textarea></td>
					<td class="p-2"> <textarea class="form-control text-left" style="width: 250px;" type="text" id="jan" name="jan" value="<?php echo $aRef->janeiro; ?>" title="<?php echo $aRef->janeiro; ?>" readonly="true">{{$aRef->janeiro}}</textarea></td>
					<td class="p-2"> <textarea class="form-control text-left" style="width: 250px;" type="text" id="fev" name="fev" value="<?php echo $aRef->fevereiro; ?>" title="<?php echo $aRef->fevereiro; ?>" readonly="true">{{$aRef->fevereiro}}</textarea></td>
					<td class="p-2"> <textarea class="form-control text-left" style="width: 250px;" type="text" id="mar" name="mar" value="<?php echo $aRef->marco; ?>" title="<?php echo $aRef->marco; ?>" readonly="true">{{$aRef->marco}}</textarea></td>
					<td class="p-2"> <textarea class="form-control text-left" style="width: 250px;" type="text" id="abr" name="abr" value="<?php echo $aRef->abril; ?>" title="<?php echo $aRef->abril; ?>" readonly="true">{{$aRef->abril}}</textarea></td>
					<td class="p-2"> <textarea class="form-control text-left" style="width: 250px;" type="text" id="mai" name="mai" value="<?php echo $aRef->maio; ?>" title="<?php echo $aRef->maio; ?>" readonly="true">{{$aRef->maio}}</textarea></td>
					<td class="p-2"> <textarea class="form-control text-left" style="width: 250px;" type="text" id="jun" name="jun" value="<?php echo $aRef->junho; ?>" title="<?php echo $aRef->junho; ?>" readonly="true">{{$aRef->junho}}</textarea></td>
					<td class="p-2"> <textarea class="form-control text-left" style="width: 250px;" type="text" id="jun" name="jun" value="<?php echo $aRef->junho; ?>" title="<?php echo $aRef->junho; ?>" readonly="true">{{$aRef->julho}}</textarea></td>
					<td class="p-2"> <textarea class="form-control text-left" style="width: 250px;" type="text" id="ago" name="ago" value="<?php echo $aRef->agosto; ?>" title="<?php echo $aRef->agosto; ?>" readonly="true">{{$aRef->agosto}}</textarea></td>
					<td class="p-2"> <textarea class="form-control text-left" style="width: 250px;" type="text" id="set" name="set" value="<?php echo $aRef->setembro; ?>" title="<?php echo $aRef->setembro; ?>" readonly="true">{{$aRef->setembro}}</textarea></td>
					<td class="p-2"> <textarea class="form-control text-left" style="width: 250px;" type="text" id="out" name="out" value="<?php echo $aRef->outubro; ?>" title="<?php echo $aRef->outubro; ?>" readonly="true">{{$aRef->outubro}}</textarea></td>
					<td class="p-2"> <textarea class="form-control text-left" style="width: 250px;" type="text" id="nov" name="nov" value="<?php echo $aRef->novembro; ?>" title="<?php echo $aRef->novembro; ?>" readonly="true">{{$aRef->novembro}}</textarea></td>
					<td class="p-2"> <textarea class="form-control text-left" style="width: 250px;" type="text" id="dez" name="dez" value="<?php echo $aRef->dezembro; ?>" title="<?php echo $aRef->dezembro; ?>" readonly="true">{{$aRef->dezembro}}</textarea></td>
					@endif
				</tr>
			</tbody>
			@endforeach
			@endif
		</table>
	</div>
<?php } ?>
</div>
<script>
	const buttonRight = document.getElementById('slideRight');
	const buttonLeft = document.getElementById('slideLeft');

	buttonRight.onclick = function() {
		document.getElementById('buttonScroll').scrollLeft += 500;
		document.getElementById('buttonScroll2').scrollLeft += 500;
	};
	buttonLeft.onclick = function() {
		document.getElementById('buttonScroll').scrollLeft -= 500;
		document.getElementById('buttonScroll2').scrollLeft -= 500;
	};
</script>
@endsection