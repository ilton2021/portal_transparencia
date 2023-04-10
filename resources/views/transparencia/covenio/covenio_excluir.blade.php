@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">EXCLUIR COVÊNIO:</h3>
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
                        Covênio: <i class="fas fa-check-circle"></i>
                    </a>
						<div class="card-body"  style="font-size: 14px;">
							<form action="{{\Request::route('store'), $unidade->id}}" method="post" enctype="multipart/form-data">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<table>
							    <tr>
								 <td> <strong>Título:</strong> </td>
								 <td> <input style="" class="form-control" type="text" id="title" name="title" value="<?php echo $covenios[0]->path_name; ?>" readonly="true" /> </td> 
								</tr> 
								<tr>
								 <td> <br/> <strong> Arquivo: </strong> </td>
								 <td> <br/> <input style="width: 500px;" class="form-control" type="text" id="path_file" name="path_file" readonly="true" value="<?php echo $covenios[0]->path_file; ?>" /> </td>
								</tr>
							</table>
							
							<table>
							  <tr>     
							    <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
								<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="Covenio" /> </td>
								<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="ExcluirCovenio" /> </td>
								<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
							  </tr>
							</table>
							
							<table>
								<tr>
								  <td align="left"> <br />
									<p><h6 align="left"> Deseja realmente Excluir este Covênio?? </h6></p>
									<a href="{{route('covenioCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
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
		<div class="col-md-2 col-sm-0"></div>
		<br /> <br />
		
	</div>
</div>
@endsection