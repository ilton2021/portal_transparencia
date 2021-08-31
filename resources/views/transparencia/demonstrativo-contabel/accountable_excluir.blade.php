@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">EXCLUIR DEMONSTRAÇÕES CONTÁBEIS E PARECERES:</h3>
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
		<div class="col-md-8 col-sm-12">
		<div class="accordion" id="accordionExample">
                <div class="card">
                    <a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
                        Demonstrações Contábeis e Pareceres: <i class="fas fa-check-circle"></i>
                    </a>
				 <form action="{{\Request::route('store'), $unidade->id}}" method="post" enctype="multipart/form-data">
				 <input type="hidden" name="_token" value="{{ csrf_token() }}">
					<table>
					 <tr>
						<td> ID: </td>
						<td> <input style="width: 90px;" readonly="true" class="form-control" type="text" id="id" name="id" value="<?php echo $demonstrativoContaveis[0]->id; ?>" /> </td>
					 </tr>
					 <tr>
						<td> Título: </td>
						<td> <input style="width: 500px;" readonly="true" class="form-control" type="text" id="title" name="title" value="<?php echo $demonstrativoContaveis[0]->title; ?>" /> </td>
					 </tr>
					 <tr>
						<td> Ano: </td>
						<td> <input style="width: 90px;" readonly="true" class="form-control" type="number" id="ano" name="ano" value="<?php echo $demonstrativoContaveis[0]->ano; ?>" /> </td>
					 </tr>
					 <tr>
						<td> Arquivo: </td>
						<td> <input style="width: 550px;" readonly="true" class="form-control" type="text" name="file_path" id="file_path" value="<?php echo $demonstrativoContaveis[0]->file_path; ?>" /> </td>
					 </tr>
					</table>
					
					<table>
						 <tr>
						   <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
						   <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="demonstrativoContabel" /> </td>
						   <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="excluirDemonstrativoContabel" /> </td>
						   <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
						 </tr>
					</table>
					
					<table>
					 <tr>
					  <td> <br /><br /> <p><h6 align="left"> Deseja realmente Excluir esta Demonstração Contábeis e Pareceres?? </h6></p> </td>
					 </tr>
					 <tr>
					  <td><br /> <a href="{{route('demonstrativoContCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a> 
						 <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Excluir" id="Excluir" name="Excluir" /> </td>
					 </tr>
				    </table>
				</form>
				</div>
				<div class="col-md-2 col-sm-0"></div>
		</div>
    </div>
</div>
@endsection