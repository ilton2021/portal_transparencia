@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
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
						INATIVAR/ATIVAR DEMONSTRATIVOS FINANCEIROS: <i class="fas fa-check-circle"></i>
					</a>
					<div class="card-body" style="font-size: 14px;">
						<form action="{{\Request::route('inativarDF'), $unidade->id}}" method="post">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="mt-3" style="color:black">
								<div class="form-row mt-1">
									<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
										<div class="col-md-2 mr-2">
											<label><strong>Título:</strong></label>
										</div>
										<div class="col-md-10 mr-2">
											<input style="max-width: 300px;" class="form-control" readonly="true" type="text" id="title" name="title" value="<?php echo $financialReports[0]->title; ?>" />
										</div>
									</div>
								</div>
								<div class="form-row mt-1">
									<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
										<div class="col-md-2 mr-2">
											<label><strong>Mês: </strong></label>
										</div>
										<div class="col-md-10 mr-2">
											<input style="max-width: 100px;" readonly="true" class="form-control" type="number" id="mes" name="mes" value="<?php echo $financialReports[0]->mes; ?>" maxlength="12" size="2" />
										</div>
									</div>
								</div>
								<div class="form-row mt-1">
									<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
										<div class="col-md-2 mr-2">
											<label><strong>Ano: </strong></label>
										</div>
										<div class="col-md-10 mr-2">
											<input style="max-width: 100px;" readonly="true" class="form-control" type="number" id="ano" name="ano" value="<?php echo $financialReports[0]->ano; ?>" />
										</div>
									</div>
								</div>
								<div class="form-row mt-1">
									<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
										<div class="col-md-2 mr-2">
											<label><strong>Arquivo: </strong></label>
										</div>
										<div class="col-md-10 mr-2">
											<input style="max-width: 700px;" class="form-control" readonly="true" type="text" id="file_path" name="file_path" value="<?php echo $financialReports[0]->file_path; ?>" />
										</div>
									</div>
								</div>
							</div>
							<table>
								<tr>
									<td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
									<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="demonstrativoFinanceiro" /> </td>
									 @if($financialReports[0]->status_financeiro == 0)
									  <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="AtivarDemonstrativoFinanceiro" /> </td>
									 @else
									  <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="InativarDemonstrativoFinanceiro" /> </td>
									 @endif
									<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
								</tr>
							</table>
					</div>
				</div>

				<div class="form-control mt-2">
					<div class="d-flex justify-content-between text-center">
						<div class="ml-2" style="color:black">
							<p>
							<h6> Deseja realmente Inativar este Demonstrativo Financeiro?? </h6>
							</p>
						</div>
					</div>
					<div class="d-flex flex-column">
						<div class="d-md-inline-flex justify-content-between align-items-center">
							<div class="p-2 text-center">
								<a href="{{route('cadastroDF', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
							</div>
							<div class="p-2 text-center">
								@if($financialReports[0]->status_financeiro == 0)
								  <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Ativar" id="Ativar" name="Ativar" />
								@else
								  <input type="submit" class="btn btn-primary btn-sm" style="margin-top: 10px;" value="Inativar" id="Inativar" name="Inativar" />
								@endif
							</div>
						</div>
					</div>
				</div>
				</form>
			</div>
		</div>
		<div class="col-md-1 col-sm-0"></div>
	</div>
</div>
@endsection