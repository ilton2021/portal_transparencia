@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">EXCLUIR CONTRATAÇÕES:</h3>
		</div>
	</div>
	
	@if ( isset($errors) && count ( $errors ) > 0 )
		<div class="alert alert-danger">
			@foreach ( $errors->all() as $error )
				<p> {{ $error }} </p>
			@endforeach
		</div>
	@endif
	
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 col-sm-12 text-center">
			<div class="accordion" id="accordionExample">
				<div class="card">
				  <div class="card-header" id="headingTwo">
					<h2 class="mb-0">
					  <a class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						<strong>Cotações</strong>
					  </a>
					</h2>
					
				  </div>
				  <form action="{{\Request::route('destroyCotacao'), $unidade->id}}" method="post" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					  <table>
						<tr>
						 <td> Processo de Cotações: </td>
						 <td> 
							<input style="width: 400px" type="text" class="form-control" readonly="true" id="proccess_name" name="proccess_name" value="<?php echo $cotacoes[0]->proccess_name; ?>" />
						 </td>
						</tr>
						<tr>
					     <td> Arquivo: </td>
						 <td> <input class="form-control" readonly="true" type="text" id="file_path" name="file_path" value="<?php echo $cotacoes[0]->file_name; ?>" /> </td>
						</tr>
					  </table>
					  
					    <table>
						   <tr>
						     <td> <input type="hidden" id="ordering" name="ordering" value="0" /> </td>
							 <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
							 <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="contratacaoCotacoes" /> </td>
							 <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="excluirContratacaoCotacoes" /> </td>
							 <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
						   </tr>
						</table>
						
					  <table>	
						<tr>
							<td align="left"><br /><br /><h6 align="left"> Deseja realmente Excluir esta Cotação?? </h6></td>
						</tr>
						<tr>
					     <td align="left">
						 <br /><a href="{{route('cadastroCotacoes', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
					     <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Excluir" id="Excluir" name="Excluir" /> 
					     </td>
					    </tr>
					  </table>
				  </form>
				  
				</div>				
			  </div> 	
        </div>
    </div>
</div>
@endsection