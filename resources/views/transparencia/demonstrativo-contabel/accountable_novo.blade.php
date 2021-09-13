@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">CADASTRAR DEMONSTRAÇÕES CONTÁBEIS E PARECERES:</h3>
		</div>
	</div>
	@if ($errors->any())
      <div class="alert alert-success">
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
		 <div class="accordion" id="accordionExample">
                <div class="card">
                    <a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
                        Demonstrações Contabéis e Pareceres: <i class="fas fa-check-circle"></i>
                    </a>
                </div>	
					 <form action="{{\Request::route('store'), $unidade->id}}" method="post" enctype="multipart/form-data">
					 <input type="hidden" name="_token" value="{{ csrf_token() }}">
						<table border="0" class="table-sm" style="line-height: 1.5;" >
						 <tr>
							<td> Título: </td>
							<td> <input style="width: 500px" class="form-control" type="text" id="title" name="title" value="" required /> </td>
						 </tr>
						 <tr>
						 <td> Ano: </td>
							 	 <td> <select id="ano" name="ano" class="form-control" style="width: 200px">
									<option value="2015" id="ano" name="ano">2015</option>
									<option value="2016" id="ano" name="ano">2016</option>
									<option value="2017" id="ano" name="ano">2017</option>
									<option value="2018" id="ano" name="ano">2018</option>
									<option value="2019" id="ano" name="ano">2019</option>
									<option value="2020" id="ano" name="ano">2020</option>
									<option value="2021" id="ano" name="ano">2021</option>
									<option value="2022" id="ano" name="ano">2022</option>
									<option value="2023" id="ano" name="ano">2023</option>
									<option value="2024" id="ano" name="ano">2024</option>
									<option value="2025" id="ano" name="ano">2025</option>	

								</select>	
							  </td> </tr>
						 <tr>
							<td> Arquivo: </td>
							<td> <input class="form-control" type="file" name="file_path" id="file_path" /> </td>
						 </tr>
						</table>
						
						<table>
						 <tr>
						   <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
						   <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="demonstrativoContabel" /> </td>
						   <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarDemonstrativoContabel" /> </td>
						   <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
						 </tr>
						</table>
						
						<table>
						 <tr>
						  <td> <br /> <a href="{{route('demonstrativoContCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a> </td>
						  <td> <br /> <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" /> </td>
						 </tr>
						</table>
						</form>
		</div>
		<div class="col-md-2 col-sm-0"></div>
		</div>
    </div>
</div>
@endsection