<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="pt-br">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>	
    <link href="{{ asset('js/utils.js') }}" rel="stylesheet">
    <link href="{{ asset('js/bootstrap.js') }}" rel="stylesheet">
    <title>HCP - Gestão</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{asset('css/style-dashboard.css')}}">
    <link rel="shortcut icon" href="{{asset('img/favico.png')}}">
    <!-- Font Awesome KIT -->
    <script src="https://kit.fontawesome.com/7656d93ed3.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar" >
            <div class="sidebar-header d-flex justify-content-center" style="background-color:  #3c3c3c">
				@if(Auth::check())
				<a href="{{route('home')}}">
                    <img src="{{asset('img/favico.png')}}" width="80" >
                </a>
				@else
				<a href="{{route('welcome')}}">
                    <img src="{{asset('img/favico.png')}}" width="80" >
                </a>
				@endif
		    </div>
            <ul class="list-unstyled components" style="padding-top: 0px;">
				<li class="{{ (\Request::route()->getName() == 'trasparenciaHome') ? 'active' : '' }}">
					<a href="{{route('trasparenciaHome', $unidade->id)}}" style="font-size: 10px;">INSTITUCIONAL</a>
			    </li>
				@if($unidade->id != 1)
				<li class="{{ (\Request::route()->getName() == 'trasparenciaHome') ? 'active' : '' }}">
					<a href="{{route('trasparenciaHome', 1)}}" style="font-size: 10px;">INSTITUCIONAL OSS</a>
			    </li>
				@endif
                <li class="nav-item dropdown {{ (\Request::route()->getName() == 'trasparenciaOrganizacional') ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 10px;">ESTRUTURA ORGANIZACIONAL</a>
                    <div class="dropdown-menu list-unstyled" aria-labelledby="navbarDropdown">                        
                        <a style="font-size: 10px !important;" href="{{route('trasparenciaOrganizacional', $unidade->id)}}">Regimento interno</a>
                        <a style="font-size: 10px !important;" href="{{route('trasparenciaOrganizacional', $unidade->id)}}">Organograma</a>
                    </div>
				<li>
				@if($unidade->id != 1)
				<li class="nav-item dropdown {{ (\Request::route()->getName() == 'trasparenciaOrganizacional') ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 10px;">ESTRUTURA ORGANIZACIONAL OSS</a>
                    <div class="dropdown-menu list-unstyled" aria-labelledby="navbarDropdown">                        
                        <a style="font-size: 10px !important;" href="{{route('trasparenciaOrganizacional', 1)}}">Regimento interno</a>
                        <a style="font-size: 10px !important;" href="{{route('trasparenciaOrganizacional', 1)}}">Organograma</a>
                    </div>
				<li>	
				@endif
                @if($unidade->id == 1 || $unidade->id == 9)
                <li class="nav-item dropdown {{ (\Request::route()->getName() == 'transparenciaMembros') ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle" id="membros" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 10px;">MEMBROS DIRIGENTES</a>
                    <div class="dropdown-menu list-unstyled" aria-labelledby="membros">
                        <a style="font-size: 10px !important;" href="{{route('transparenciaMembros', ['id' => $unidade->id, 'escolha' => 'Associados'])}}">Associados</a>
                        <a style="font-size: 10px !important;" href="{{route('transparenciaMembros', ['id' => $unidade->id, 'escolha' => 'Conselho administrativo'])}}">Conselho administrativo</a>
                        <a style="font-size: 10px !important;" href="{{route('transparenciaMembros', ['id' => $unidade->id, 'escolha' => 'Conselho fiscal'])}}">Conselho fiscal</a>
                        <a style="font-size: 10px !important;" href="{{route('transparenciaMembros', ['id' => $unidade->id, 'escolha' => 'Superintendentes'])}}">Superintendentes</a>
                    </div>
                </li>
                @endif
				@if($unidade->id != 1)
                <li class="nav-item dropdown {{ (\Request::route()->getName() == 'transparenciaMembros') ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle" id="membros" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 10px;">MEMBROS DIRIGENTES OSS</a>
                    <div class="dropdown-menu list-unstyled" aria-labelledby="membros">
                        <a style="font-size: 10px !important;" href="{{route('transparenciaMembros', ['id' => 1, 'escolha' => 'Associados'])}}">Associados</a>
                        <a style="font-size: 10px !important;" href="{{route('transparenciaMembros', ['id' => 1, 'escolha' => 'Conselho administrativo'])}}">Conselho administrativo</a>
                        <a style="font-size: 10px !important;" href="{{route('transparenciaMembros', ['id' => 1, 'escolha' => 'Conselho fiscal'])}}">Conselho fiscal</a>
                        <a style="font-size: 10px !important;" href="{{route('transparenciaMembros', ['id' => 1, 'escolha' => 'Superintendentes'])}}">Superintendentes</a>
                    </div>
                </li>
                @endif
                @if($unidade->id != 1 && $unidade->id != 9)
                <li class="{{ (\Request::route()->getName() == 'transparenciaCompetencia') ? 'active' : '' }}">
                <a href="{{route('transparenciaCompetencia', $unidade->id)}}" style="font-size: 10px;">COMPETÊNCIAS</a>
                </li>
                @endif
                @if($unidade->id == 1 || $unidade->id == 9)
                <li class="{{ (\Request::route()->getName() == 'transparenciaEstatuto') ? 'active' : '' }}">
                    <a href="{{route('transparenciaEstatuto', $unidade->id)}}" style="font-size: 10px;">ESTATUTO SOCIAL E ATAS DO ESTATUTO</a>
                </li>
                @endif
				@if($unidade->id != 1)
                <li class="{{ (\Request::route()->getName() == 'transparenciaEstatuto') ? 'active' : '' }}">
                    <a href="{{route('transparenciaEstatuto', 1)}}" style="font-size: 10px;">ESTATUTO SOCIAL E ATAS DO ESTATUTO OSS</a>
                </li>
                @endif
                @if($unidade->id == 1 || $unidade->id == 9)                
                <li class="nav-item dropdown {{ (\Request::route()->getName() == 'transparenciaDocumento') ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle" id="regularidade" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 10px;">DOCUMENTAÇÃO DE REGULARIDADE</a>
                    <div class="dropdown-menu list-unstyled" aria-labelledby="regularidade">
                        <a href="{{route('transparenciaDocumento', ['id' => $unidade->id, 'escolha' => 'CNPJ (OSS e Unidades Sob Gestão)'])}}" style="font-size: 10px !important;">CNPJ (OSS e Unidades Sob Gestão)</a>
                        <a href="{{route('transparenciaDocumento', ['id' => $unidade->id, 'escolha' => 'Fazenda púlica'])}}" style="font-size: 10px !important;">Fazenda púlica</a>
                        <a href="{{route('transparenciaDocumento', ['id' => $unidade->id, 'escolha' => 'Seguridade social'])}}" style="font-size: 10px !important;">Seguridade social</a>
                        <a href="{{route('transparenciaDocumento', ['id' => $unidade->id, 'escolha' => 'FGTS'])}}" style="font-size: 10px !important;">FGTS</a>
                        <a href="{{route('transparenciaDocumento', ['id' => $unidade->id, 'escolha' => 'Justiça do trabalho'])}}" style="font-size: 10px !important;">Justiça do trabalho</a>
                        <a href="{{route('transparenciaDocumento', ['id' => $unidade->id, 'escolha' => 'CREMEPE'])}}" style="font-size: 10px !important;">CREMEPE</a>
                        <a href="{{route('transparenciaDocumento', ['id' => $unidade->id, 'escolha' => 'Qualificação técnica - OSS'])}}" style="font-size: 10px !important;">Qualificação técnica - OSS</a>
                        <a href="{{route('transparenciaDocumento', ['id' => $unidade->id, 'escolha' => 'Experiência anterior'])}}" style="font-size: 10px !important;">Experiência anterior</a>
                        <a href="{{route('transparenciaDocumento', ['id' => $unidade->id, 'escolha' => 'CEBAS'])}}" style="font-size: 10px !important;">CEBAS</a>
                    </div>
                </li>
                @else  
                <li class="nav-item dropdown {{ (\Request::route()->getName() == 'transparenciaDocumento') ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle" id="regularidade" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 10px;">DOCUMENTAÇÃO DE REGULARIDADE OSS</a>
                    <div class="dropdown-menu list-unstyled" aria-labelledby="regularidade">
                        <a href="{{route('transparenciaDocumento', ['id' => 1, 'escolha' => 'CNPJ (OSS e Unidades Sob Gestão)'])}}" style="font-size: 10px !important;">CNPJ (OSS e Unidades Sob Gestão)</a>
                        <a href="{{route('transparenciaDocumento', ['id' => 1, 'escolha' => 'Fazenda púlica'])}}" style="font-size: 10px !important;">Fazenda púlica</a>
                        <a href="{{route('transparenciaDocumento', ['id' => 1, 'escolha' => 'Seguridade social'])}}" style="font-size: 10px !important;">Seguridade social</a>
                        <a href="{{route('transparenciaDocumento', ['id' => 1, 'escolha' => 'FGTS'])}}" style="font-size: 10px !important;">FGTS</a>
                        <a href="{{route('transparenciaDocumento', ['id' => 1, 'escolha' => 'Justiça do trabalho'])}}" style="font-size: 10px !important;">Justiça do trabalho</a>
                        <a href="{{route('transparenciaDocumento', ['id' => 1, 'escolha' => 'CREMEPE'])}}" style="font-size: 10px !important;">CREMEPE</a>
                        <a href="{{route('transparenciaDocumento', ['id' => 1, 'escolha' => 'Qualificação técnica - OSS'])}}" style="font-size: 10px !important;">Qualificação técnica - OSS</a>
                        <a href="{{route('transparenciaDocumento', ['id' => 1, 'escolha' => 'Experiência anterior'])}}" style="font-size: 10px !important;">Experiência anterior</a>
                        <a href="{{route('transparenciaDocumento', ['id' => 1, 'escolha' => 'CEBAS'])}}" style="font-size: 10px !important;">CEBAS</a>
                    </div>
                </li>
                @endif
                <li class="nav-item dropdown {{ (\Request::route()->getName() == 'transparenciaContratoGestao') ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle" id="contratos" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 10px;">CONTRATOS DE GESTÃO / ADITIVOS</a>
                    <div class="dropdown-menu list-unstyled" aria-labelledby="contratos">
                        @if($unidade->id == 2 || $unidade->id == 1 || $unidade->id == 9)
                        <a href="{{route('transparenciaContratoGestao', ['id' => $unidade->id, 'escolha' => 'HMR'])}}" style="font-size: 10px !important;">HMR</a>
                        @endif
                        @if($unidade->id == 3 || $unidade->id == 1 || $unidade->id == 9)
                        <a href="{{route('transparenciaContratoGestao', ['id' => $unidade->id, 'escolha' => 'UPAE BELOA JARDIM'])}}" style="font-size: 10px !important;">UPAE BELOA JARDIM</a>
                        @endif
                        @if($unidade->id == 4 || $unidade->id == 1 || $unidade->id == 9)
                        <a href="{{route('transparenciaContratoGestao', ['id' => $unidade->id, 'escolha' => 'UPAE ARCOVERDE'])}}" style="font-size: 10px !important;">UPAE ARCOVERDE</a>
                        @endif
                        @if($unidade->id == 5 || $unidade->id == 1 || $unidade->id == 9)
                        <a href="{{route('transparenciaContratoGestao', ['id' => $unidade->id, 'escolha' => 'UPAE ARRUDA'])}}" style="font-size: 10px !important;">UPAE ARRUDA</a>
                        @endif
                        @if($unidade->id == 6 || $unidade->id == 1 || $unidade->id == 9)
                        <a href="{{route('transparenciaContratoGestao', ['id' => $unidade->id, 'escolha' => 'UPAE CARUARU'])}}" style="font-size: 10px !important;">UPAE CARUARU</a>
                        @endif
                        @if($unidade->id == 7 || $unidade->id == 1 || $unidade->id == 9)
                        <a href="{{route('transparenciaContratoGestao', ['id' => $unidade->id, 'escolha' => 'HOSPITAL SÃO SEBASTIÃO'])}}" style="font-size: 10px !important;">HOSPITAL SÃO SEBASTIÃO</a>
                        @endif
			            @if($unidade->id == 8 || $unidade->id == 1 || $unidade->id == 9)
                        <a href="{{route('transparenciaContratoGestao', ['id' => $unidade->id, 'escolha' => 'HOSPITAL PROVISÓRIO DO RECIFE'])}}" style="font-size: 10px !important;">HOSPITAL PROVISÓRIO DO RECIFE</a>
                        @endif
                    </div>
                </li>
                @if($unidade->id != 1 && $unidade->id != 9)
                <li class="{{ (\Request::route()->getName() == 'transparenciaFinanReports') ? 'active' : '' }}">
                <a href="{{route('transparenciaFinanReports', $unidade->id)}}" style="font-size: 10px;">RELATÓRIO FINANCEIRO E DE EXECUÇÃO ANUAL</a>
                </li>
                @endif
                @if($unidade->id == 9)
                <li class="{{ (\Request::route()->getName() == 'transparenciaCovenio') ? 'active' : '' }}">
                <a href="{{route('transparenciaCovenio', $unidade->id)}}" style="font-size: 10px;">COVÊNIO</a>
                </li>
                @endif
                @if($unidade->id == 1 || $unidade->id == 9)
                <li class="{{ (\Request::route()->getName() == 'transparenciaDecreto') ? 'active' : '' }}">
                    <a href="{{route('transparenciaDecreto', $unidade->id)}}" style="font-size: 10px;">DECRETO DE QUALIFICAÇÃO</a>
                </li>
				@endif
				@if($unidade->id != 1)
                <li class="{{ (\Request::route()->getName() == 'transparenciaDecreto') ? 'active' : '' }}">
                    <a href="{{route('transparenciaDecreto', 1)}}" style="font-size: 10px;">DECRETO DE QUALIFICAÇÃO OSS</a>
                </li>
                @endif
                @if($unidade->id == 9)
                <li>
                <a target="_blank" href="http://hcpgestao.org.br/transparencia/unidades/hcp/desp_com_pessoal/index.php" style="font-size: 10px;">DESPESAS COM PESSOAL</a>
                </li>
               @endif
			   @if($unidade->id != 1)
                <li class="{{ (\Request::route()->getName() == 'transparenciaAccountable') ? 'active' : '' }}">
                <a href="{{route('transparenciaAccountable', $unidade->id)}}" style="font-size: 10px;">DEMONSTRAÇÕES CONTÁBEIS</a>
                </li>
				@endif
                @if($unidade->id == 9)
                <li class="{{ (\Request::route()->getName() == 'transparenciaProcessoCotacao') ? 'active' : '' }}">
                <a href="{{route('transparenciaProcessoCotacao', $unidade->id)}}" style="font-size: 10px;">PROCESSOS DE COTAÇÃO DE PREÇO</a>
                </li>
                @endif
                @if($unidade->id == 9)
                <li class="{{ (\Request::route()->getName() == 'transparenciaContasAtual') ? 'active' : '' }}">
                <a href="{{route('transparenciaContasAtual', $unidade->id)}}" style="font-size: 10px;">RELATÓRIO DE CONTAS ATUAL</a>
                </li>
                @endif
                @if($unidade->id == 9)
                <li class="{{ (\Request::route()->getName() == 'transparenciaRelMensalExecucao') ? 'active' : '' }}">
                <a href="{{route('transparenciaRelMensalExecucao', $unidade->id)}}" style="font-size: 10px;">RELATÓRIO MENSAL DE EXECUÇÃO</a>
                </li>
                @endif
                @if($unidade->id == 9)
                <li class="{{ (\Request::route()->getName() == 'transparenciaMensalFinanceiroExercico') ? 'active' : '' }}">
                <a href="{{route('transparenciaMensalFinanceiroExercico', $unidade->id)}}" style="font-size: 10px;">RELATÓRIO MENSAL FINANCEIRO DO EXERCÍCIO</a>
                </li>
                @endif
                @if($unidade->id != 1 && $unidade->id != 9)
                <li class="{{ (\Request::route()->getName() == 'transparenciaDemonstrative') ? 'active' : '' }}">
                <a href="{{route('transparenciaDemonstrative',  $unidade->id)}}" style="font-size: 10px;">DEMONSTRATIVOS FINANCEIROS</a>
                </li>
                @endif
                @if($unidade->id != 1 && $unidade->id != 9)
                <li class="{{ (\Request::route()->getName() == 'transparenciaAssistencial') ? 'active' : '' }}">
                    <a href="{{route('transparenciaAssistencial', $unidade->id)}}" style="font-size: 10px;">RELATÓRIO ASSISTENCIAL</a>
                </li>
                @endif
				@if($unidade->id != 1)
				<li class="{{ (\Request::route()->getName() == 'transparenciaRepasses') ? 'active' : '' }}">
                <a href="{{route('transparenciaRepasses',  $unidade->id)}}" style="font-size: 10px;">REPASSES RECEBIDOS</a>
                </li>
				@endif
                @if($unidade->id != 1 && $unidade->id != 9)
                <li class="{{ (\Request::route()->getName() == 'transparenciaContratacao') ? 'active' : '' }}">
                <a href="{{route('transparenciaContratacao', $unidade->id)}}" style="font-size: 10px;">CONTRATAÇÕES</a>
                </li>
                @endif
                @if($unidade->id != 1 && $unidade->id != 9)
                <li class="{{ (\Request::route()->getName() == 'transparenciaRecursosHumanos') ? 'active' : '' }}">
                <a href="{{route('transparenciaRecursosHumanos', $unidade->id)}}" style="font-size: 10px;">RECURSOS HUMANOS</a>
                </li>
                @endif
                @if($unidade->id == 1 || $unidade->id == 9)
                <li class="{{ (\Request::route()->getName() == 'transparenciaRegulamento') ? 'active' : '' }}">
                    <a href="{{route('transparenciaRegulamento', $unidade->id)}}" style="font-size: 10px;">REGULAMENTOS PRÓPRIOS</a>
                </li>
                @endif
				@if($unidade->id != 1)
                <li class="{{ (\Request::route()->getName() == 'transparenciaRegulamento') ? 'active' : '' }}">
                    <a href="{{route('transparenciaRegulamento', 1)}}" style="font-size: 10px;">REGULAMENTOS PRÓPRIOS OSS</a>
                </li>
                @endif
				@if(Auth::check())
					<?php $id = Auth::user()->id; ?>
						@if($id == 1)
					      <li class="{{ (\Request::route()->getName == 'cadastroPermissao') ? 'active' : '' }}">
					         <a href="{{ route('cadastroPermissao', $unidade->id) }}" style="font-size: 10px">PERMISSÃO</a>
						  </li>
						@endif
				@endif
               <!--<li class="{{ (\Request::route()->getName() == 'transparenciaManual') ? 'active' : '' }}">
                    <a href="{{route('transparenciaManual', $unidade->id)}}" style="font-size: 10px;">MANUAIS</a>
                </li>
                <li class="{{ (\Request::route()->getName() == 'transparenciaPregao') ? 'active' : '' }}">
                   <a href="{{route('transparenciaPregao', $unidade->id)}}" style="font-size: 10px;">CONVÊNIOS</a>
                </li>
                <li class="{{ (\Request::route()->getName() == 'transparenciaDespesas') ? 'active' : '' }}">
                    <a href="{{route('transparenciaDespesas', $unidade->id)}}" style="font-size: 10px;">DESPESAS COM PESSOAL</a>
                </li>-->
				@if($unidade->id != 1)
                <li class="{{ (\Request::route()->getName() == 'transparenciaBensPublicos') ? 'active' : '' }}">
                  <a href="{{route('transparenciaBensPublicos', $unidade->id)}}" style="font-size: 10px;">BENS PÚBLICOS</a>
                </li>			
				@endif             
                <li class="{{ (\Request::route()->getName() == 'transparenciaOuvidoria') ? 'active' : '' }}">
				  <a href="{{route('transparenciaOuvidoria', $unidade->id)}}" style="font-size: 10px;">SERVIÇO DE INFORMAÇÃO AO CIDADÃO - SIC <i class="fas fa-globe"></i></a>
				</li>
            </ul>
            <ul class="list-unstyled components">
                <li class="active">
               <a style="font-size: 10px;">  ÚLTIMA ATUALIZAÇÃO: <strong>{{ isset($lastUpdated) ? date("d/m/Y", strtotime($lastUpdated)) : ""  }}</strong></a>
                </li>
            </ul>
        </nav>
        <!-- Page Content  -->
        <div id="content">
            <nav class="navbar navbar-expand-lg bg-light" style="box-shadow: none; background: #f6f6f6; padding-top: 0px; margin-bottom: 0px;">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-success">
                        <i class="fas fa-bars"></i>
                        <span>MENU</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            @foreach($unidadesMenu as $unidadeMenu)
                            @if($unidadeMenu->id !== $unidade->id)
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('trasparenciaHome', $unidadeMenu->id)}}"><img src="{{asset('img')}}/{{$unidadeMenu->icon_img}}" alt="..." class="rounded-circle border border-success    " width="50" height="50" title="{{$unidadeMenu->name}}"></a>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </nav>
            @yield('content')
            <!-- jQuery CDN - Slim version (=without AJAX) -->
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <!-- Popper.JS -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
            <!-- Bootstrap JS -->
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
            <script type="text/javascript">
                $(document).ready(function () {
                  $('#sidebarCollapse').on('click', function () {
                        $('#sidebar').toggleClass('active');
                    });
                });
            </script>

<script type="text/javascript">
	 $("#cep").focusout(function(){
		//Início do Comando AJAX
		$.ajax({
			//O campo URL diz o caminho de onde virá os dados
			//É importante concatenar o valor digitado no CEP
			url: 'https://viacep.com.br/ws/'+$(this).val()+'/json/unicode/',
			//Aqui você deve preencher o tipo de dados que será lido,
			//no caso, estamos lendo JSON.
			dataType: 'json',
			//SUCESS é referente a função que será executada caso
			//ele consiga ler a fonte de dados com sucesso.
			//O parâmetro dentro da função se refere ao nome da variável
			//que você vai dar para ler esse objeto.
			success: function(resposta){
				//Agora basta definir os valores que você deseja preencher
				//automaticamente nos campos acima.
				$("#address").val(resposta.logradouro);
				$("#further_info").val(resposta.complemento);
				$("#district").val(resposta.bairro);
				$("#city").val(resposta.localidade);
				$("#uf").val(resposta.uf);
				//Vamos incluir para que o Número seja focado automaticamente
				//melhorando a experiência do usuário
				$("#numero").focus();
			}
		});
	 });
	 </script>

        </body>
</html>