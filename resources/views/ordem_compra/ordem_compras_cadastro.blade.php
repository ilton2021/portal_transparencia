@extends('layouts.app')
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{asset('img/favico.png')}}">
        <link rel="stylesheet" type="text/css" href="resourcers\views\ordem_compra\style.css" media="screen" />

        <title>Portal da Transparencia - HCP</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
	    <script src="https://kit.fontawesome.com/7656d93ed3.js" crossorigin="anonymous"></script>
        <style>
        .navbar .dropdown-menu .form-control {
            width: 300px;
        }
        </style>
    </head>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3" style="background-image: linear-gradient(to right, #28a745, #28a745); height: auto; border-radius: 175px 175px 175px 175px;">
        </div>
        <div class="col-md-3" style="background-image: linear-gradient(to right, #28a745, #28a745); height: auto; border-radius: 175px 175px 175px 175px;">        
        </div>
        <div class="col-md-3" style="background-image: linear-gradient(to right, #28a745, #28a745); height: auto; border-radius: 175px 175px 175px 175px;">
        </div>
        <div class="col-md-3" style="background-image: linear-gradient(to right, #28a745, #28a745); height: auto; border-radius: 175px 175px 175px 175px;">
        </div>
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
 <section id="unidades">
    <div class="container" style="margin-top:30px; margin-bottom:20px;">
        <div class="row">
            <div class="col-12 text-center">
                <span><h3 style="color:#65b345; margin-bottom:0px;">ORDENS DE COMPRAS</h3></span>
            </div>
        </div>
        <div class="row">
            <div class="col-5">
                <div class="progress" style="height: 3px;">
                    <div  class="progress-bar" role="progressbar" style="width: 100%; background-color: #65b345;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <div class="col-2 text-center"></div>
            <div class="col-5">
                <div class="progress" style="height: 3px;">
                    <div  class="progress-bar" role="progressbar" style="width: 100%; background-color: #65b345;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
   <form action = "{{route('procuraOrdemCompra', $unidade[0]->id)}}"> 
    <table class="table" style = "margin-left:1px">
        <tr>    
            <td>
                <a class="btn btn-dark  btn-sm" class="form-control" style="color: #FFFFFF; margin-left: 70px; margin-bottom: 15px; height: 28px;" href="{{route('trasparenciaOrdemCompraNovo', $unidade[0]->id)}}" > Novo <i class="fas fa-check"></i></a>    
            </td>
           <td> <select class="custom-select mr-sm-2" style="width: 140px" id="funcao" name="funcao">
                  <option id="funcao" name="funcao" value="0">Selecione</option>
                  <option id="funcao" name="funcao" value="1">Data de Solicitação</option>
                  <option id="funcao" name="funcao" value="2">Data de Autorização</option>
            </select> </td>         
            <td><input type="date" id="data" name="data" class="form-control" style="width: 140px" ></td>
            <td> <select class="custom-select mr-sm-2" style="width: 140px" id="funcao2" name="funcao2">
                  <option id="funcao2" name="funcao2" value="0">Selecione</option>
                  <option id="funcao2" name="funcao2" value="1">Fornecedor</option>
                  <option id="funcao2" name="funcao2" value="2">Número da Solicitação</option>
                  <option id="funcao2" name="funcao2" value="3">Número da Nota Fiscal</option>

            </select> </td>     
            <td><input id="text" name="text" type="text" class="form-control" style="width: 140px;" placeholder="..."></td>
            <td><button type="submit" class="btn btn-primary" style="margin-right: 35px; margin-bo 15px; height: 35px;" >Pesquisar  <i class="fas fa-search"></i></button>
            </td>
        </tr>   
    </table>
    </form> 
	<div class="container d-flex justify-content-between">
        <div class="row">
            <table class="table" style="margin-left: 15px; width: 100%;">
                <thead>
                 <tr>
                   <td colspan='1' width="110px;"><center> <b>Solicitação</b> </center></td>
                   <td colspan='15'><center><b>Ordens de Compra</b></center></td>
                   <td colspan='13'><center><b></b></center></td>
                 </tr>
                 <tr>
                    <td style="font-size: 13px" colspan = '1'> Número </td>
                    <td style="padding-right: 68px; font-size: 13px" colspan = '1'> Data </td>
                    <td style="padding-right: 10px; font-size: 13px"> NºO.C </td>
                    <td style="padding-right: 18px; font-size: 13px"> Data Autorização </td>
                    <td style="padding-right: 43px; font-size: 13px"> Fornecedor </td>
                    <td style="padding-right: 1px; font-size: 13px"> CNPJ </td>
                    <td style="padding-right: 65px; font-size: 13px"> Valor Total </td>
                    <td style="padding-right: 1px; font-size: 13px"> Produto </td>
                    <td style="padding-right: 1px; font-size: 13px"> Qtd. Recebida </td>
                    <td style="padding-right: 50px;font-size: 13px"> Total Recebido </td>
                    <td style="padding-right: 1px; font-size: 13px"> <u><b>Opções</b></u></td>
                    <td style="padding-right: 1px; font-size: 13px"> <u><b>Arquivos</b></u></td>
                  </tr>
                 </thead>
                   @foreach($processos as $prc)
                   <tr>
                    <td style = "font-size: 13px;"> {{ $prc->numeroSolicitacao }} </td>
                    <td style = "font-size: 13px;"> {{ date('d-m-Y', strtotime($prc->dataSolicitacao)) }} </td>
                    <td style = "font-size: 13px;"> {{ $prc->numeroOC }} </td>
                    <td style = "font-size: 13px;"> {{ date('d-m-Y', strtotime($prc->dataAutorizacao)) }} </td>
                    <td style = "font-size: 13px;"> {{ $prc->fornecedor }} </td>
                    <td style = "font-size: 13px;"> {{ $prc->cnpj }} </td>
                    <td style = "font-size: 13px;"> {{ "R$ ".number_format($prc->totalValorOC, 2,',','.') }} </td>
                    <td style = "font-size: 13px;"> {{ $prc->produto }} </td>
                    <td style = "font-size: 13px;"> {{ $prc->quantidadeRecebida }} </td>
                    <td style = "font-size: 13px;"> {{ "R$ ".number_format($prc->valorTotalRecebido, 2,',','.') }} </td>
                    <td> <div class="dropdown">
                    <a class="btn btn-outline-info" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-caret-down"></i>               
                     </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                     <a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{ route('ordemCompraAlterar', array($unidade[0]->id, $prc->id)) }}" > <i class="fas fa-edit"></i></a>
                     <a class="btn btn-danger btn-sm" style="color: #FFFFFF;" href="{{route('ordemCompraExcluir', array($unidade[0]->id, $prc->id))}}" ><i class="fas fa-times-circle"></i></a> </center>
                     <a class="btn btn-warning btn-sm" style="color: #FFFFFF;" href="{{route('arquivosOrdemCompra', array($unidade[0]->id, $prc->id))}}" ><i class="fa fa-file-o" ></i></a> </center>
                    </div>
                    </div></td>
                    <td> 
                        <a class="badge badge-pill badge-outline-warning dropdown-toggle" type="button" href="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-cloud-download"></i>
                        <div id="div" class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="font-size: 12px;">
                            @foreach($processos as $prc) 
                                @if($prc->processo_id == $processos[0]->id)
                                    <a id="div" class="dropdown-item" href="{{asset('../public/storage/')}}/{{$processoA->file_path}}" target="_blank">Arquivo</a>
                                @endif
                            @endforeach
                        </div>	
                        </a>
                    </td>
                   </tr> 
                   @endforeach   
            </table>
        </div>
    </div>
</section >    
@endsection
	