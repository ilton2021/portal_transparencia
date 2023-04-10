@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">RELATÓRIOS</h3>
			<BR><BR>
		</div>
	</div>
		  <p>
			<a class="btn btn-success btn-sm" href="{{ route('relatorioTotalContratos', $unidade->id) }}">
			  <strong>RELATÓRIO TOTAL DE CONTRATOS/ADITIVOS POR UNIDADE</strong> 
			</a> <BR> <BR>
            <!--a class="btn btn-success btn-sm" href="{{ route('relatorioDespesasUnidade', $unidade->id) }}">
			  <strong>RELATÓRIO TOTAL DE DESPESAS POR UNIDADE / MÊS / ANO</strong> 
			</a> <BR> <BR-->
            <a class="btn btn-success btn-sm" href="{{ route('relatorioUltAtualizacoes', $unidade->id) }}">
			  <strong>RELATÓRIO DAS ÚLTIMAS ATUALIZAÇÕES</strong> 
			</a>  
		  </p>
</div>
@endsection