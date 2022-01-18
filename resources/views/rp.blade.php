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
			<h5 style="font-size: 18px;">Termo de Referência</h5>
		</div>
	</div><br><br>
	<?php $hoje = date('Y-m-d', strtotime('now'));?>
	<div class="row" style="margin-top: 25px; margin-left: 80px;">
		<div class="col-md-6 col-sm-6">
			<table class="table table-sm table-bordered" style="width: 1200px;">
			<tr>
			@foreach($contratacao_servicos as $CS)
			 @foreach($unidades as $und)
				@if($und->id == $CS->unidade_id)
				 @if($hoje >= $CS->prazoInicial && $hoje <= $CS->prazoFinal)
					<td>
						<center>
							<div class="card border-0 text-white">
								<a href="{{ route('rp2', $CS->id) }}"><img id="img-unity" src="{{asset('img')}}/{{$und->path_img}}" width="150px"></a>
							</div>
						</center>
					</td>
					<td style="width: 300px;"><br><center><b> {{ $und->name }} </b></center></td>
					<td>		
						<center><br><b> As Propostas devem ser enviadas a partir do dia: <?php echo date('d/m/Y', strtotime($CS->prazoInicial)); ?> até o dia: <?php echo date('d/m/Y', strtotime($CS->prazoFinal));?>.</b></center>
					</td>
				 @elseif($CS->prazoProrroga != "")
				  @if($CS->prazoProrroga >= $hoje)
					<td>
						<center>
							<div class="card border-0 text-white">
								<a href="{{ route('rp2', $CS->id) }}"><img id="img-unity" src="{{asset('img')}}/{{$und->path_img}}" width="100px"></a>
							</div>
						</center>
					</td>
					<td style="width: 200px;"> {{ $und->name }} </td>
					<td>
						<center><b>({{$und->sigla}}) - O envio das propostas foi prorrogado até o dia <?php echo date('d/m/Y', strtotime($CS->prazoProrroga)); ?></b></center>
					</td>
				  @endif
				 @endif
				@endif
			 @endforeach
			@endforeach
			    </tr>	
			</table>
		</div>
	</div>
	
	
	<br><br><br><br><br><br>
	<center><b>Envie sua proposta para: juliana.silva@hcpgestao.org.br , franklin.rodrigues@hcpgestao.org.br</b></center>
</div>
</div>
@endsection
