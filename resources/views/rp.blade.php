@extends('layouts.app2')
@section('title','Termo de Referência')
@section('content')
<head>
    <link href="{{ asset('css/rp_cards.css') }}" rel="stylesheet">
</head>
<body>
	<section id="portfolio-details" class="portfolio-details">
		<center><b>Envie sua proposta para: contratacaodeservicos@hcpgestao.org.br</b></center>
		<div class="container">
			<div class="row gy-3">
				<section class="cards">
				    <?php $id = 1; ?>
					@foreach($contratacao_servicos as $CS)
					@if($CS->status == 1)
					<div class="card">
						<div class="image">
							<img src="{{asset('img')}}/{{$CS->path_img}}" alt="">
						</div>
						<div class="content">
							<center>
								<p class="p-1 title text--medium"><b>{{$CS->nomeUnidade}}</b></p>
								<button id="<?php echo $id?>" class="buttonanimado" type="text" onclick="aumentabutton(<?php echo $id?>)" style="font-size:11px;width:200px; height:60px;overflow: hidden;text-overflow: ellipsis;white-space: wrap; border:none; border-radius:10px; background-color:DodgerBlue;outline:none;color:white">{{$CS->titulo}}</button>
							</center>
							@if($CS->tipoPrazo == 1 && $CS->prazoProrroga == "")
							<center>
								<p class="title text--medium">As Propostas devem ser enviadas a partir do dia: <?php echo date('d/m/Y', strtotime($CS->prazoInicial)); ?> até o dia: <?php echo date('d/m/Y', strtotime($CS->prazoFinal)); ?>.</p>
							</center>
							@elseif($CS->prazoProrroga != "")
							<center>
								<p class="title text--medium">O envio das propostas foi prorrogado até o dia <?php echo date('d/m/Y', strtotime($CS->prazoProrroga)); ?>.</p>
							</center>
							@elseif($CS->tipoPrazo == 0)
							<center>
								<p class="title text--medium">As propostas devem ser enviadas a partir do dia: <?php echo date('d/m/Y', strtotime($CS->prazoInicial)); ?>, <br> faça o seu credenciamento. </p>
							</center>
							@endif
							<center><a style="margin-bottom:20px" href="{{ route('rp2', $CS->id) }}" class="btn btn-primary">Clique Aqui</a></center>
						</div>
					</div>
					<?php $id = $id + 1;?>
					@endif
					@endforeach
					<!--div class="card">
						<div class="image">
							<img src="{{asset('img')}}/{{('upae-palmares.jpg')}}" alt="">
						</div>
						<div class="content">
							<center>
								<p class="p-1 title text--medium"><b>UPAE PALMARES</b></p>
								<button id="<?php echo 21?>" class="buttonanimado" type="text" onclick="aumentabutton(<?php echo 21?>)" style="width:200px; height:60px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap; border:none; border-radius:10px; background-color:DodgerBlue;outline:none;color:white">Serviços Laboratoriais</button>
							</center>
							<center>
								<p class="title text--medium">As Propostas devem ser enviadas a partir do dia: 09/09/2022 até o dia: 15/09/2022.</p>
							</center>
							<center><a style="margin-bottom:20px" href="{{ route('rp3', 1) }}" class="btn btn-primary">Clique Aqui</a></center>
						</div>
					</div-->
					
				</section>
			</div>
		</div>
	</section>
		<script>
		function aumentabutton(idAtual) {
			console.log(idAtual);
			let altura = document.getElementById(idAtual).style.height;
			if (altura == "60px") {
				document.getElementById(idAtual).style.height = "200px";
				document.getElementById(idAtual).style.whiteSpace = "";
			} else {
				document.getElementById(idAtual).style.height = "60px";
				document.getElementById(idAtual).style.whiteSpace = "wrap";
			}
		}
	</script>
</body>
@endsection