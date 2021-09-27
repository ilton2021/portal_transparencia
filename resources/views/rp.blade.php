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
			  @if($und->id == 3 || $und->id == 4 || $und->id == 6)
				<tr>
					<td style="width: 800px;"> {{ $und->name }} </td>
					<td> <center>
					<div class="card border-0 text-white" >
						<a href="{{ route('rp2', $und->id) }}"><img id="img-unity" src="{{asset('img')}}/{{$und->path_img}}" width="100px"></a>
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