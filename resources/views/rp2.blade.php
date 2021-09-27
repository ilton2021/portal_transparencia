@extends('layouts.app2')
@section('content')
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>	
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('js/utils.js') }}" rel="stylesheet">
  <link href="{{ asset('js/bootstrap.js') }}" rel="stylesheet">
</head>
<div class="container text-center" style="color: #28a745"></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">Termo de Referência</h5>
		</div>
	</div>	
	<div class="row" style="margin-top: 25px; margin-left: 300px;">
		<div class="col-md-6 col-sm-6">
		<table class="table" style="width: 800px;">	
			@foreach($unidades as $und)
			 @if($und->id == 3) 	
				<tr>
					<td style="width: 800px;"> TR Serviços Médicos - Cardiologia Teste Ergométrico </td>
					<td> <center>
					<div class="card border-0 text-white" >
					<a href="{{asset('img/tr/Belo/TR Serviços Médicos - Cardiologia Teste Ergométrico.pdf')}}" width="100px"> Clique</a>
					</div></center>
					</td>
				</tr>
				<tr>
					<td style="width: 800px;"> TR Serviços Médicos - Cardiologia </td>
					<td> <center>
					<div class="card border-0 text-white" >
					<a href="{{asset('img/tr/Belo/TR Serviços Médicos - Cardiologia.pdf')}}" width="100px"> Clique</a>
					</div></center>
					</td>
				</tr>
				<tr>
					<td style="width: 800px;"> TR Serviços Médicos - Dermotato </td>
					<td> <center>
					<div class="card border-0 text-white" >
					<a href="{{asset('img/tr/Belo/TR Serviços Médicos - Dermotato.pdf')}}" width="100px"> Clique</a>
					</div></center>
					</td>
				</tr>
				<tr>
					<td style="width: 800px;"> TR Serviços Médicos - Gastro - Colonoscopia </td>
					<td> <center>
					<div class="card border-0 text-white" >
					<a href="{{asset('img/tr/Belo/TR Serviços Médicos - Gastro - Colonoscopia.pdf')}}" width="100px"> Clique</a>
					</div></center>
					</td>
				</tr>
				<tr>
					<td style="width: 800px;"> TR Serviços Médicos - Gastro - Consulta Ambulatorial </td>
					<td> <center>
					<div class="card border-0 text-white" >
					<a href="{{asset('img/tr/Belo/TR Serviços Médicos - Gastro - Consulta Ambulatorial.pdf')}}" width="100px"> Clique</a>
					</div></center>
					</td>
				</tr>
				<tr>
					<td style="width: 800px;"> TR Serviços Médicos - Gineologia </td>
					<td> <center>
					<div class="card border-0 text-white" >
					<a href="{{asset('img/tr/Belo/TR Serviços Médicos - Gineologia.pdf')}}" width="100px"> Clique</a>
					</div></center>
					</td>
				</tr>
				<tr>
					<td style="width: 800px;"> TR Serviços Médicos - Neurologia </td>
					<td> <center>
					<div class="card border-0 text-white" >
						<a href="{{asset('img/tr/Belo/TR Serviços Médicos - Neurologia.pdf')}}" width="100px"> Clique</a>
					</div></center>
					</td>
				</tr>
			@elseif($und->id == 4)
				<tr>
					<td style="width: 800px;"> TR VASCULAR </td>
					<td> <center>
					<div class="card border-0 text-white" >
					<a href="{{asset('img/tr/Arco/TR VASCULAR.pdf')}}" width="100px"> Clique</a>
					</div></center>
					</td>
				</tr>
				<tr>
					<td style="width: 800px;"> TR GASTRO-COLONOSCOPIA </td>
					<td> <center>
					<div class="card border-0 text-white" >
					<a href="{{asset('img/tr/Arco/TR GASTRO-COLONOSCOPIA.pdf')}}" width="100px"> Clique</a>
					</div></center>
					</td>
				</tr>
				<tr>
					<td style="width: 800px;"> TR CARDIOLOGISTA </td>
					<td> <center>
					<div class="card border-0 text-white" >
						<a href="{{asset('img/tr/Arco/TR CARDIOLOGISTA.pdf')}}" width="100px"> Clique</a>
					</div></center>
					</td>
				</tr>
				<tr>
					<td style="width: 800px;"> TR ENDOCRINO </td>
					<td> <center>
					<div class="card border-0 text-white" >
					<a href="{{asset('img/tr/Arco/TR ENDOCRINO.pdf')}}" width="100px"> Clique</a>
					</div></center>
					</td>
				</tr>
				<tr>
					<td style="width: 800px;"> TR MASTOLOGISTA </td>
					<td> <center>
					<div class="card border-0 text-white" >
						<a href="{{asset('img/tr/Arco/TR MASTOLOGISTA.pdf')}}" width="100px"> Clique</a>
					</div></center>
					</td>
				</tr>
			@endif
			@endforeach
		</table>	
		</div>
	</div><br><br>
	<center><b>Envie sua proposta para: juliana.silva@hcpgestao.org.br , franklin.rodrigues@hcpgestao.org.br</b></center>
</div>
</div>
@endsection