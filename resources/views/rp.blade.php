@extends('layouts.app')
@section('title','Termo de Referência')
@section('content')

<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
	<link href="{{ asset('css/rp_estilo.css') }}" rel="stylesheet">
	<link href="{{ asset('js/utils.js') }}" rel="stylesheet">
	<link href="{{ asset('js/bootstrap.js') }}" rel="stylesheet">
</head>

<body>
	<div class="rodape">
	<center><b>Envie sua proposta para: contratacaodeservicos@hcpgestao.org.br</b></center>
	</div>
	<div id="rp-container" class="col-md-12">
		<div id="cards-container" class="row">
			<?php $hoje = date('Y-m-d', strtotime('now')); ?>
			<?php $count = 0 ?>
			@foreach($contratacao_servicos as $CS)
			 @foreach($unidades as $und)
			  @if($und->id == $CS->unidade_id)
			   @if($hoje >= $CS->prazoInicial && $hoje <= $CS->prazoFinal)
				<div class="card col-md-3">
					<img src="{{asset('img')}}/{{$und->path_img}}" alt="">
					<div class="card-body">
						<center><p style="margin-top: -10px;font-family:arial black">{{$und->sigla}}</p></center>
						<center><p style="margin-top: -10px; margin-left -10px;" class="card-date">As Propostas devem ser enviadas a partir do dia: <?php echo date('d/m/Y', strtotime($CS->prazoInicial)); ?> até o dia: <?php echo date('d/m/Y', strtotime($CS->prazoFinal)); ?>.</p></center>
						<center><a href="{{ route('rp2', $CS->id) }}" class="btn btn-primary">Clique Aqui</a></center>
					</div>
				</div>
				@elseif($CS->prazoProrroga != "")
				@if($CS->prazoProrroga >= $hoje)
				<div class="card col-md-3">
					<img src="{{asset('img')}}/{{$und->path_img}}" alt="">
					<div class="card-body">
						<center><p style="margin-top: -10px;font-family:arial black">{{$und->sigla}}</p></center>
						<center><p style="margin-top: -10px; margin-left -10px;" class="card-date">O envio das propostas foi prorrogado até o dia <?php echo date('d/m/Y', strtotime($CS->prazoProrroga)); ?>.</p></CENter>
						<center><a style="margin-top: 20px;" href="{{ route('rp2', $CS->id) }}" class="btn btn-primary">Clique Aqui</a></center>
					</div>
				</div>
				@endif
				@endif
				@endif
				@endforeach
				<?php $count = $count + 1;?>
				@if($count == 6)
				<?php $count = 0;?>
				</div>
				</div>
				<div id="rp-container" class="col-md-12">
				<div id="cards-container" class="row">
				@endif
				@endforeach
		</div>
	</div>
	</div>
	</div>
</body>
@endsection