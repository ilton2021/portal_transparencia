@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
		   @if($docSelectiveProcess[0]->status_processos == 0)
			<h3 style="font-size: 18px;">ATIVAR RECURSOS HUMANOS:</h3>
		   @else
		 	<h3 style="font-size: 18px;">INATIVAR RECURSOS HUMANOS:</h3>
		   @endif
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
						<form action="{{\Request::route('inativarPS'), $unidade->id}}" method="post">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<table class="table table-sm">
							    <tr>
								  <td> ID: </td>
								  <td> <input class="form-control" readonly="true" style="width: 100px;" type="text" id="id" name="id" value="<?php echo $docSelectiveProcess[0]->id; ?>" /> </td>
								</tr>
								<tr>
								  <td> Título: </td>
								  <td> <input class="form-control" readonly="true" style="width: 650px;" type="text" id="title" name="title" title="<?php echo $docSelectiveProcess[0]->title; ?>" value="<?php echo $docSelectiveProcess[0]->title; ?>" /> </td>							  
								</tr>
								<tr>
								  <td> Arquivo: </td>
								  <td> <input class="form-control" readonly="true" style="width: 650px;" type="text" id="file_path" name="file_path" title="<?php echo $docSelectiveProcess[0]->file_path; ?>" value="<?php echo $docSelectiveProcess[0]->file_path; ?>" /> </td>
								</tr>
								<tr>
								  <td> Ano: </td>
								  <td> <input class="form-control" readonly="true" style="width: 100px;" type="number" id="ano" name="ano" value="<?php echo $docSelectiveProcess[0]->year; ?>" required /> </td>
								</tr>
							</table>
							
							<table>
							 <tr>
							   <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
							   <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="processoSeletivo" /> </td>
							   @if($docSelectiveProcess[0]->status_processos == 0)
							   <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="AtivarProcessoSeletivo" /> </td>
							   @else
							   <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="InativarProcessoSeletivo" /> </td>
							   @endif
							   <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
							 </tr>
							</table>
							
							<table>
								<tr>
								  <td colspan="2" align="left"> <br /><br /> <a href="{{route('cadastroPS', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
								  @if($docSelectiveProcess[0]->status_processos == 0)
								  <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Ativar" id="Ativar" name="Ativar" /> </td>
								  @else
								  <input type="submit" class="btn btn-primary btn-sm" style="margin-top: 10px;" value="Inativar" id="Inativar" name="Inativar" /> </td>
								  @endif
								</tr>
							</table>
						</form>
			</div>
        </div>
		<div class="col-md-1 col-sm-0"></div>
    </div>
</div>
@endsection