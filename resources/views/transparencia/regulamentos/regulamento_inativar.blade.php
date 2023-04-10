@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			@if($manuais[0]->status_manuais == 0)
			 <h3 style="font-size: 18px;">ATIVAR REGULAMENTOS PRÓPRIOS:</h3>
			@else
			 <h3 style="font-size: 18px;">INATIVAR REGULAMENTOS PRÓPRIOS:</h3>
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
		<div class="col-md-0 col-sm-0"></div>
		<div class="col-md-12 col-sm-12 text-center">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
                        Regulamento Próprios <i class="fas fa-check-circle"></i>
                    </a>
                </div>
                    <form method="post" action="{{ \Request::route('inativarRG'), $unidade->id }}" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<table border="0" class="table-sm" style="line-height: 1.5;" WIDTH="1020">
					  <tr>
					    <td> Título: </td>
						<td> <input class="form-control" style="width: 600px;" type="text" id="name" name="name" value="<?php echo $manuais[0]->title; ?>" readonly="true" /> </td> 
					  </tr>
					  <tr>
						<td> Arquivo: </td>
						<td> <input class="form-control" style="width: 600px;" type="text" id="path_file" name="path_file" value="<?php echo $manuais[0]->path_file; ?>" readonly="true" /> </td>
					  </tr>
					  <tr>
						<td> Imagem: </td>
						<td> <input class="form-control" style="width: 600px;" type="text" id="path_img" name="path_img" value="<?php echo $manuais[0]->path_img; ?>" readonly="true" /> </td>
					  </tr>
					</table>
					
					<table>
						 <tr>
						   <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
						   <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="regulamento" /> </td>
						   @if($manuais[0]->status_manuais == 0)
						   <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="AtivarRegulamento" /> </td>
						   @else
						   <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="InativarRegulamento" /> </td>
						   @endif
						   <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
						 </tr>
					</table>
					
					<table>
					 <tr>
					   <td align="left">
					     <br /><br /> <p><h6 align="left"> Deseja realmente Inativar este Regulamento Próprio?? </h6></p>
						 <a href="{{route('cadastroRG', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
					     @if($manuais[0]->status_manuais == 0)
						  <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Ativar" id="Ativar" name="Ativar" />
						 @else
						  <input type="submit" class="btn btn-primary btn-sm" style="margin-top: 10px;" value="Inativar" id="Inativar" name="Inativar" />
						 @endif
					   </td>
					 </tr>
					</table>
                  </div>
            </div>
        </div>
		<div class="col-md-0 col-sm-0"></div>
    </div>
</div>
@endsection