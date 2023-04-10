<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="pt-br">
    <title>HCP Gest&atilde;o</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{asset('css/style-dashboard.css')}}">
    <link rel="shortcut icon" href="{{asset('img/favico.png')}}">
    <!-- Font Awesome KIT -->
    <script src="https://kit.fontawesome.com/7656d93ed3.js" crossorigin="anonymous"></script>
    <!--Jquery-->
    <script src="{{asset('js/jquery.min.js')}}" crossorigin="anonymous"></script>
    <!--Icones bootstrap-->
    <link rel="stylesheet" href="{{asset('css/bootstrap-icons.css')}}">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <style>
        .wrapper {
            display: inline-flex;
            list-style: none;
        }

        .wrapper .icon {
            position: relative;
            background: #ffffff;
            border-radius: 50%;
            padding: 15px;
            margin: 10px;
            width: 50px;
            height: 50px;
            font-size: 18px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .wrapper .tooltip {
            position: absolute;
            top: 0;
            font-size: 14px;
            background: #ffffff;
            color: #ffffff;
            padding: 5px 8px;
            border-radius: 5px;
            box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);

        }

        .wrapper .tooltip::before {
            position: absolute;
            content: "";
            height: 8px;
            width: 10px;
            background: #ffffff;
            bottom: -3px;
            left: 50%;
            transform: translate(-50%) rotate(45deg);
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .wrapper .icon:hover .tooltip {
            top: 45px;
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        .wrapper .icon:hover span,
        .wrapper .icon:hover .tooltip {
            text-shadow: 0px -1px 0px rgba(0, 0, 0, 0.1);
        }

        .wrapper .facebook:hover,
        .wrapper .facebook:hover .tooltip,
        .wrapper .facebook:hover .tooltip::before {
            background: green;
            color: #ffffff;
        }
    </style>
</head>

<body>
    @section('sidebar')
    <div class="wrapper" >
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header d-flex justify-content-center" style="background-color:  #3c3c3c">
                @if(Auth::check())
                <a href="{{route('home')}}">
                    <img src="{{asset('img/favico.png')}}" width="80">
                </a>
                @else
                <a href="{{route('welcome')}}">
                    <img src="{{asset('img/favico.png')}}" width="80">
                </a>
                @endif
            </div>
            <ul class="list-unstyled components" style="padding-top: 0px;">
                <li class="{{ (\Request::route()->getName() == 'transparenciaHome') ? 'active' : '' }}">
                    <a href="{{route('transparenciaHome', $unidade->id)}}" style="font-size: 10px;">INSTITUCIONAL</a>
                </li>
                <li class="{{ (\Request::route()->getName() == 'transparenciaHome') ? 'active' : '' }}">
                    <a href="{{route('transparenciaHomeOss',$unidade->id)}}" style="font-size: 10px;">INSTITUCIONAL OSS</a>
                </li>
                <li class="nav-item dropdown {{ (\Request::route()->getName() == 'transparenciaOrganizacional') ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle" href="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" style="font-size: 10px;"> ESTRUTURA ORGANIZACIONAL </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown" style="font-size: 12px;">
                      <li> <a class="dropdown-item" href="{{route('transparenciaOrganizacional', $unidade->id)}}">Regimento interno</a> </li>
                      <li> <a class="dropdown-item" href="{{route('transparenciaOrganizacional', $unidade->id)}}">Organograma</a> </li>
                    </ul>
                </li>
                <li class="nav-item dropdown {{ (\Request::route()->getName() == 'transparenciaOrganizacionalOss') ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle" href="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" style="font-size: 10px;"> ESTRUTURA ORGANIZACIONAL OSS </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown" style="font-size: 12px;">
                      <li> <a class="dropdown-item" href="{{route('transparenciaOrganizacionalOss', $unidade->id)}}">Regimento interno</a> </li>
                      <li> <a class="dropdown-item" href="{{route('transparenciaOrganizacionalOss', $unidade->id)}}">Organograma</a> </li>
                    </ul>
                </li>
                <li class="nav-item dropdown {{ (\Request::route()->getName() == 'transparenciaMembros') ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle" href="membros" role="button" data-toggle="dropdown" aria-haspopup="true" style="font-size: 10px;"> MEMBROS DIRIGENTES OSS </a>
                    <ul class="dropdown-menu" aria-labelledby="membros" style="font-size: 12px;">
                      <li> <a class="dropdown-item" href="{{route('transparenciaMembros', ['id' => $unidade->id, 'escolha' => 'Associados'])}}">Associados</a> </li>
                      <li> <a class="dropdown-item" href="{{route('transparenciaMembros', ['id' => $unidade->id, 'escolha' => 'Conselho administrativo'])}}">Conselho administrativo</a> </li>
                      <li> <a class="dropdown-item" href="{{route('transparenciaMembros', ['id' => $unidade->id, 'escolha' => 'Conselho fiscal'])}}">Conselho fiscal</a> </li>
                      <li> <a class="dropdown-item" href="{{route('transparenciaMembros', ['id' => $unidade->id, 'escolha' => 'Superintendentes'])}}">Superintendentes</a> </li>
                    </ul>
                </li>
                <li class="{{ (\Request::route()->getName() == 'transparenciaCompetencia') ? 'active' : '' }}">
                    <a href="{{route('transparenciaCompetencia', $unidade->id)}}" style="font-size: 10px;">COMPETÊNCIAS</a>
                </li>
                <li class="{{ (\Request::route()->getName() == 'transparenciaEstatuto') ? 'active' : '' }}">
                    <a href="{{route('transparenciaEstatuto', $unidade->id)}}" style="font-size: 10px;">ESTATUTO SOCIAL E ATAS DO ESTATUTO OSS</a>
                </li>
                <li class="nav-item dropdown {{ (\Request::route()->getName() == 'transparenciaDocumento') ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle" href="regularidade" role="button" data-toggle="dropdown" aria-haspopup="true" style="font-size: 10px;"> DOCUMENTAÇÃO DE REGULARIDADE OSS </a>
                    <ul class="dropdown-menu" aria-labelledby="regularidade" style="font-size: 12px;">
                      <li> <a class="dropdown-item" href="{{route('transparenciaDocumento', ['id' => $unidade->id, 'escolha' => 'CNPJ (OSS e Unidades Sob Gestão)'])}}">CNPJ (OSS e Unidades Sob Gestão)</a> </li>
                      <li> <a class="dropdown-item" href="{{route('transparenciaDocumento', ['id' => $unidade->id, 'escolha' => 'Fazenda púlica'])}}">Fazenda púlica</a> </li>
                      <li> <a class="dropdown-item" href="{{route('transparenciaDocumento', ['id' => $unidade->id, 'escolha' => 'Seguridade social'])}}">Seguridade social</a> </li>
                      <li> <a class="dropdown-item" href="{{route('transparenciaDocumento', ['id' => $unidade->id, 'escolha' => 'FGTS'])}}">FGTS</a> </li>
                      <li> <a class="dropdown-item" href="{{route('transparenciaDocumento', ['id' => $unidade->id, 'escolha' => 'Justiça do trabalho'])}}">Justiça do trabalho</a> </li>
                      <li> <a class="dropdown-item" href="{{route('transparenciaDocumento', ['id' => $unidade->id, 'escolha' => 'CREMEPE'])}}">CREMEPE</a> </li>
                      <li> <a class="dropdown-item" href="{{route('transparenciaDocumento', ['id' => $unidade->id, 'escolha' => 'Qualificação técnica - OSS'])}}">Qualificação técnica - OSS</a> </li>
                      <li> <a class="dropdown-item" href="{{route('transparenciaDocumento', ['id' => $unidade->id, 'escolha' => 'Experiência anterior'])}}">Experiência anterior</a> </li>
                      <li> <a class="dropdown-item" href="{{route('transparenciaDocumento', ['id' => $unidade->id, 'escolha' => 'CEBAS'])}}">CEBAS</a> </li>
                    </ul>
                </li>
                <li class="nav-item dropdown {{ (\Request::route()->getName() == 'transparenciaContratoGestao') ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle" href="contratos" role="button" data-toggle="dropdown" aria-haspopup="true" style="font-size: 10px;"> CONTRATOS DE GESTÃO / ADITIVOS </a>
                    <ul class="dropdown-menu" aria-labelledby="contratos" style="font-size: 12px; !important;">
                        @if($unidade->id == 2 || $unidade->id == 1)
                        <li> <a class="dropdown-item" href="{{route('transparenciaContratoGestao', ['id' => $unidade->id, 'escolha' => 'HMR'])}}">HMR</a> </li>
                        @endif
                        @if($unidade->id == 3 || $unidade->id == 1)
                        <li> <a class="dropdown-item" href="{{route('transparenciaContratoGestao', ['id' => $unidade->id, 'escolha' => 'UPAE BELO JARDIM'])}}">UPAE BELO JARDIM</a> </li>
                        @endif
                        @if($unidade->id == 4 || $unidade->id == 1)
                        <li> <a class="dropdown-item" href="{{route('transparenciaContratoGestao', ['id' => $unidade->id, 'escolha' => 'UPAE ARCOVERDE'])}}">UPAE ARCOVERDE</a> </li>
                        @endif
                        @if($unidade->id == 5 || $unidade->id == 1)
                        <li> <a class="dropdown-item" href="{{route('transparenciaContratoGestao', ['id' => $unidade->id, 'escolha' => 'UPAE ARRUDA'])}}">UPAE ARRUDA</a> </li>
                        @endif
                        @if($unidade->id == 6 || $unidade->id == 1)
                        <li> <a class="dropdown-item" href="{{route('transparenciaContratoGestao', ['id' => $unidade->id, 'escolha' => 'UPAE CARUARU'])}}">UPAE CARUARU</a> </li>
                        @endif
                        @if($unidade->id == 7 || $unidade->id == 1)
                        <li> <a class="dropdown-item" href="{{route('transparenciaContratoGestao', ['id' => $unidade->id, 'escolha' => 'HOSPITAL SÃO SEBASTIÃO'])}}">HOSPITAL SÃO SEBASTIÃO</a> </li>
                        @endif
                        @if($unidade->id == 8 || $unidade->id == 1)
                        <li> <a class="dropdown-item" href="{{route('transparenciaContratoGestao', ['id' => $unidade->id, 'escolha' => 'HOSPITAL PROVISÓRIO DO RECIFE'])}}">HOSPITAL PROVISÓRIO DO RECIFE</a> </li>
                        @endif
                        @if($unidade->id == 9 || $unidade->id == 1)
                        <li> <a class="dropdown-item" href="{{route('transparenciaContratoGestao', ['id' => $unidade->id, 'escolha' => 'UPA IGARASSU'])}}">UPA IGARASSU</a> </li>
                        @endif
                        @if($unidade->id == 10 || $unidade->id == 1)
                        <li> <a class="dropdown-item" href="{{route('transparenciaContratoGestao', ['id' => $unidade->id, 'escolha' => 'UPAE PALMARES'])}}">UPAE PALMARES</a> </li>
                        @endif
                     </ul>
                </li>
                <li class="{{ (\Request::route()->getName() == 'transparenciaFinanReports') ? 'active' : '' }}">
                    <a href="{{route('transparenciaFinanReports', $unidade->id)}}" style="font-size: 10px;">RELATÓRIO FINANCEIRO E DE EXECUÇÃO ANUAL</a>
                </li>
                <li class="{{ (\Request::route()->getName() == 'transparenciaDecreto') ? 'active' : '' }}">
                    <a href="{{route('transparenciaDecreto', $unidade->id)}}" style="font-size: 10px;">DECRETO DE QUALIFICAÇÃO OSS</a>
                </li>
                <li class="{{ (\Request::route()->getName() == 'transparenciaAccountable') ? 'active' : '' }}">
                    <a href="{{route('transparenciaAccountable', $unidade->id)}}" style="font-size: 10px;">DEMONSTRAÇÕES CONTÁBEIS</a>
                </li>
                <li class="{{ (\Request::route()->getName() == 'transparenciaDemonstrative') ? 'active' : '' }}">
                    <a href="{{route('transparenciaDemonstrative',  $unidade->id)}}" style="font-size: 10px;">DEMONSTRATIVOS FINANCEIROS</a>
                </li>
                <li class="{{ (\Request::route()->getName() == 'transparenciaAssistencial') ? 'active' : '' }}">
                    <a href="{{route('transparenciaAssistencial', $unidade->id)}}" style="font-size: 10px;">RELATÓRIO ASSISTENCIAL</a>
                </li>
                <li class="{{ (\Request::route()->getName() == 'transparenciaRepasses') ? 'active' : '' }}">
                    <a href="{{route('transparenciaRepasses',  $unidade->id)}}" style="font-size: 10px;">REPASSES RECEBIDOS</a>
                </li>
                <li class="{{ (\Request::route()->getName() == 'transparenciaContratacao') ? 'active' : '' }}">
                    <a href="{{route('transparenciaContratacao', $unidade->id)}}" style="font-size: 10px;">CONTRATAÇÕES</a>
                </li>
                <li class="{{ (\Request::route()->getName() == 'transparenciaRecursosHumanos') ? 'active' : '' }}">
                    <a href="{{route('transparenciaRecursosHumanos', $unidade->id)}}" style="font-size: 10px;">RECURSOS HUMANOS</a>
                </li>
                <li class="{{ (\Request::route()->getName() == 'transparenciaRegulamento') ? 'active' : '' }}">
                    <a href="{{route('transparenciaRegulamento', $unidade->id)}}" style="font-size: 10px;">REGULAMENTOS PRÓPRIOS OSS</a>
                </li>
                @if(Auth::check())
                <?php $id = Auth::user()->id; ?>
                @if($id == 1 || $id == 26 || $id == 10)
                <li class="{{ (\Request::route()->getName == 'cadastroPermissao') ? 'active' : '' }}">
				    <a href="{{ route('cadastroPermissao', $unidade->id) }}" style="font-size: 10px">PERMISSÃO</a>
				</li>
                <li class="{{ (\Request::route()->getName == 'relatorios') ? 'active' : '' }}">
				    <a href="{{ route('relatorios', $unidade->id) }}" style="font-size: 10px">RELATÓRIOS</a>
				</li>
                @endif
                @endif
                <li class="{{ (\Request::route()->getName() == 'transparenciaBensPublicos') ? 'active' : '' }}">
                    <a href="{{route('transparenciaBensPublicos', $unidade->id)}}" style="font-size: 10px;">BENS PÚBLICOS</a>
                </li>
                <li class="{{ (\Request::route()->getName() == 'transparenciaOuvidoria') ? 'active' : '' }}">
                    <a href="{{route('transparenciaOuvidoria', $unidade->id)}}" style="font-size: 10px;">SERVIÇO INFORMAÇÃO AO CIDADÃO - SIC <i class="fas fa-globe"></i></a>
                </li>
            </ul>
            <ul class="list-unstyled components">
                <li class="active">
                    <a style="font-size: 10px;"> ÚLTIMA ATUALIZAÇÃO: <strong>{{ isset($lastUpdated) ? date("d/m/Y", strtotime($lastUpdated)) : ""  }}</strong></a>
                </li>
            </ul>
        </nav>
        <!-- Page Content  -->
        @show
        <div class="container p-4 col-md-9">
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

                            <li class="nav-item icon facebook">
                                <span class="tooltip text-center">{{$unidadeMenu->sigla}}</span>
                                <a class="nav-link" href="{{route('transparenciaHome', $unidadeMenu->id)}}"><img src="{{asset('img')}}/{{$unidadeMenu->icon_img}}" alt="..." class="rounded-circle border border-success    " width="50" height="50" title="{{$unidadeMenu->name}}"></a>
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
                $(document).ready(function() {
                    $('#sidebarCollapse').on('click', function() {
                        $('#sidebar').toggleClass('active');
                    });
                });
            </script>
        </div>
    </div>
</body>

</html>