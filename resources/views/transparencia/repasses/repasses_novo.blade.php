@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">CADASTRAR REPASSES RECEBIDOS:</h3>
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
		<div class="col-md-8 col-sm-8 text-center">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
                        Repasses: <i class="fas fa-check-circle"></i>
                    </a>
                </div>
					<p>
					<form action="{{\Request::route('store'), $unidade->id}}" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					 <table>
					  <tr>
					   <td> Mês: </td>
					   <td> &nbsp; </td>
					   <td>
						<select id="mes" name="mes" class="form-control">
						 <option value="janeiro">Janeiro</option>
						 <option value="feveiro">Fevereiro</option>
						 <option value="marco">Março</option>
						 <option value="abril">Abril</option>
						 <option value="maio">Maio</option>
						 <option value="junho">Junho</option>
						 <option value="julho">Julho</option>
						 <option value="agosto">Agosto</option>
						 <option value="setembro">Setembro</option>
						 <option value="outubro">Outubro</option>
						 <option value="novembro">Novembro</option>
						 <option value="dezembro">Dezembro</option>
						 </select>
					   </td>
					  </tr>
					  <tr>
					   <td> Ano: </td>
					   <td> &nbsp; </td>
					  <td> <select id="mes" name="mes" class="form-control">
						 <option value="janeiro" id="ano" name="ano">2015</option>
						 <option value="feveiro" id="ano" name="ano">2016</option>
						 <option value="marco" id="ano" name="ano">2017</option>
						 <option value="abril" id="ano" name="ano">2018</option>
						 <option value="maio" id="ano" name="ano">2019</option>
						 <option value="junho" id="ano" name="ano">2020</option>
						 <option value="julho" id="ano" name="ano">2021</option>
						 <option value="agosto" id="ano" name="ano">2022</option>
						 <option value="setembro" id="ano" name="ano">2023</option>
						 <option value="outubro" id="ano" name="ano">2024</option>
						 <option value="novembro" id="ano" name="ano">2025</option>					  
						</td>
						</tr>
					  <tr>
					   <td> Contratado: </td>
					   <td> &nbsp; </td>
					   <td> <input class="form-control" type="text" step= "any" id="contratado" name="contratado" value="" required />  </td>
					  </tr>
					  <tr>
					   <td> Recebido: </td>
					   <td> &nbsp; </td>
					   <td> <input class="form-control" type="text" step= "any" id="recebido" name="recebido" value="" required />  </td>
					  </tr>
					  <tr>
					   <td> Desconto: </td>
					   <td> &nbsp; </td>
					   <td> <input class="form-control" type="number" step= "any" id="desconto" name="desconto" value="" required />  </td>
					  </tr>
					 </table>
					 
					 <table>
					   <tr>
						 <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
						 <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="repasses" /> </td>
						 <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarRepasses" /> </td>
						 <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
					   </tr>
					 </table>
					 
					 <table>
					  <tr>
						<td> 
						  <br/><a href="{{route('repasseCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
						  <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" />
						</td>
					  </tr>
					 </table>
					</form>
				   </p>
			</div>
		</div>
	</div>
</div>
@endsection