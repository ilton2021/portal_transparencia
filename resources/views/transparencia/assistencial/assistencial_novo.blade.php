@extends('navbar.default-navbar')
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

@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="row" style="margin-bottom: 25px; margin-top: 25px;">
	<div class="col-md-12 text-center">
		<h5 style="font-size: 18px;">CADASTRAR RELATÓRIO ASSISTENCIAL:</h5>
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
<container>
	<div class="d-flex flex-column">
		<form action="{{\Request::route('storeRA'), $unidade->id}}" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<div>
				<a class="form-control text-center bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
					RELATÓRIO ASSISTENCIAL: <i class="fas fa-check-circle"></i>
				</a>
			</div>
			<div class="d-inline-flex mt-2 flex-wrap align-items-center justify-content-center form-control">
				<div class="p-2">Indicador:</div>
				<div class="p-2">
					<select id="indicador_id" name="indicador_id" class="form-control" onchange="exibir_ocultar(this)">
						<option value="1"> 1. Consultas Médicas </option>
						<option value="2"> 2. Comissão de Controle </option>
					</select>
				</div>
				<div class="p-2">Ano de Referência:</div>
				<div class="p-2">
					<?php //$ano = date('Y', strtotime('now')); 
					?>
					<select class="form-control" id="ano_ref" name="ano_ref" style="width: 100px;">
						<?php for ($a = 2018; $a <= 2025; $a++) { ?>
							@if($a == $ano)
							<option id="ano_ref" name="ano_ref" value="<?php echo $a; ?>" selected>{{ $a }}</option>
							@else
							<option id="ano_ref" name="ano_ref" value="<?php echo $a; ?>">{{ $a }}</option>
							@endif<?php } ?>
					</select>
				</div>
			</div>
			<div class="d-flex flex-column align-items-center mt-2 form-control">
				<div class="d-inline-flex flex-wrap justify-content-center text-center">
					<div class="p-1" style="width: 195px;">Tipo Linha:</div>
					<div class="p-1">
						<select class="form-control" id="tipolinha" name="tipolinha" style="width:200px" require>
							<option id="tipolinha" name="tipolinha" value="0" selected>Comum</option>
							<option id="tipolinha" name="tipolinha" value="1">Título</option>
						</select>
					</div>
				</div>

				<div class="d-inline-flex flex-wrap justify-content-center text-center">
					<div class="p-1" style="width: 195px;">Descrição:</div>
					<div class="p-1"><input type="text" id="descricao" name="descricao" value="" class="form-control" required style="max-width:auto" required /></div>
				</div>
				<div name="vinculado" id="vinculado">
					<div class="d-inline-flex flex-wrap justify-content-center text-center">
						<div class="p-1" style="width: 195px;"> Controlada/Mês:</div>
						<div class="p-1"><input type="text" id="meta" name="meta" value="" class="form-control" style="max-width:auto" /></div>
					</div>
					<div class="d-inline-flex flex-wrap justify-content-center text-center">
						<div class="p-1" style="width: 195px;"> Janeiro: </div>
						<div class="p-1"><input type="text" id="janeiro" name="janeiro" value="" class="form-control" style="max-width:auto" /> </div>
					</div>
					<div class="d-inline-flex flex-wrap justify-content-center text-center">
						<div class="p-1" style="width: 195px;">Fevereiro: </div>
						<div class="p-1"> <input type="text" id="fevereiro" name="fevereiro" value="" class="form-control" style="max-width:auto" /></div>
					</div>
					<div class="d-inline-flex flex-wrap justify-content-center text-center">
						<div class="p-1" style="width: 195px;"> Março:</div>
						<div class="p-1"> <input type="text" id="marco" name="marco" value="" class="form-control" style="max-width:auto" /></div>
					</div>
					<div class="d-inline-flex flex-wrap justify-content-center text-center">
						<div class="p-1" style="width: 195px;"> Abril:</div>
						<div class="p-1"> <input type="text" id="abril" name="abril" value="" class="form-control" style="max-width:auto" /> </div>
					</div>
					<div class="d-inline-flex flex-wrap justify-content-center text-center">
						<div class="p-1" style="width: 195px;"> Maio: </div>
						<div class="p-1"> <input type="text" id="maio" name="maio" value="" class="form-control" style="max-width:auto" /></div>
					</div>
					<div class="d-inline-flex flex-wrap justify-content-center text-center">
						<div class="p-1" style="width: 195px;">Junho: </div>
						<div class="p-1"> <input type="text" id="junho" name="junho" value="" class="form-control" style="max-width:auto" /></div>
					</div>
					<div class="d-inline-flex flex-wrap justify-content-center text-center">
						<div class="p-1" style="width: 195px;"> Julho: </div>
						<div class="p-1"><input type="text" id="julho" name="julho" value="" class="form-control" style="max-width:auto" /> </div>
					</div>
					<div class="d-inline-flex flex-wrap justify-content-center text-center">
						<div class="p-1" style="width: 195px;">Agosto: </div>
						<div class="p-1"> <input type="text" id="agosto" name="agosto" value="" class="form-control" style="max-width:auto" /> </div>
					</div>
					<div class="d-inline-flex flex-wrap justify-content-center text-center">
						<div class="p-1" style="width: 195px;">Setembro: </div>
						<div class="p-1"> <input type="text" id="setembro" name="setembro" value="" class="form-control" style="max-width:auto" /> </div>
					</div>
					<div class="d-inline-flex flex-wrap justify-content-center text-center">
						<div class="p-1" style="width: 195px;"> Outubro:</div>
						<div class="p-1"> <input type="text" id="outubro" name="outubro" value="" class="form-control" style="max-width:auto" /></div>
					</div>
					<div class="d-inline-flex flex-wrap justify-content-center text-center">
						<div class="p-1" style="width: 195px;"> Novembro: </div>
						<div class="p-1"><input type="text" id="novembro" name="novembro" value="" class="form-control" style="max-width:auto" /> </div>
					</div>
					<div class="d-inline-flex flex-wrap justify-content-center text-center">
						<div class="p-1" style="width: 195px;">Dezembro: </div>
						<div class="p-1"><input type="text" id="dezembro" name="dezembro" value="" class="form-control" style="max-width:auto" /> </div>
					</div>
				</div>
			</div>
			<div class="d-flex mt-2 justify-content-sm-around justify-content-center">
				<div class="p-2">
					<a href="{{route('cadastroRA', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
				</div>
				<div class="p-2">
					<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Adicionar" id="Salvar" name="Salvar" />
				</div>
			</div>

			<table>
				<tr>
					<td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
					<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="relAssistencial" /> </td>
					<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarRelAssistencial" /> </td>
					<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
				</tr>
			</table>


		</form>
		<div>
			<div class="d-flex justify-content-between">
				<button class="btn btn-success" id="slideLeft" type="button">Slide left</button>
				<button class="btn btn-success" id="slideRight" type="button">Slide right</button>
			</div>
			<div class="content mt-2" style="overflow:hidden; height:45px" id="buttonScroll">

				<table class="rTable">
					<thead>
						<tr>
							<th class="p-2" scope="col">Alterar</th>
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
							<td> <a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="#"> Alterar <i class="fas fa-times-circle"></i></a></td>
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
			<div class="content mt-2" style="overflow-x:hidden; height: 70vh;" id="buttonScroll2">

				<table class="rTable">
					<thead>
						<tr>
							<th hidden class="p-2" scope="col">Alterar</th>
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
							<td> <a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{route('alterarRA', array($unidade->id, $aRef->id))}}"> Alterar <i class="fas fa-times-circle"></i></a> </td>
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

		</div>

		<div class="d-flex justify-content-center aling text-center">
			<div class="p-1">
				<a href="{{route('cadastroRA', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
			</div>
		</div>

	</div>
</container>
</div>
<script>
	const buttonRight = document.getElementById('slideRight');
	const buttonLeft = document.getElementById('slideLeft');

	buttonRight.onclick = function() {
		document.getElementById('buttonScroll').scrollLeft += 300;
		document.getElementById('buttonScroll2').scrollLeft += 300;
	};
	buttonLeft.onclick = function() {
		document.getElementById('buttonScroll').scrollLeft -= 300;
		document.getElementById('buttonScroll2').scrollLeft -= 300;
	};

	//Exibição de campos
	$(document).ready(function() {
		$('#vinculado').show();
		$('#tipolinha').change(function() {
			if ($('#tipolinha').val() !== 0) {
				$('#vinculado').hide();
			} else {
				$('#vinculado').show();
			}
		});
		$('#tipolinha').change(function() {
			if ($('#tipolinha').val() == 0) {
				$('#vinculado').show();
			} else {
				$('#vinculado').hide();
			}
		});
	});
</script>
@endsection