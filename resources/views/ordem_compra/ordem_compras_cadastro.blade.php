@extends('layouts.app')
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{asset('img/favico.png')}}">
        <title>Portal da Transparencia - HCP</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!-- BOOTSTRAP -->
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
        <!-- OWN STYLE -->
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
		<!-- Font Awesome KIT -->
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

  <div class="container">
        <div class="row">
            <div class="col-sm-12">
				@if (Session::has('mensagem'))
				 @if ($text == true)
				   <div class="container">
					 <div class="alert alert-success {{ Session::get ('mensagem')['class'] }} ">
						  {{ Session::get ('mensagem')['msg'] }}
					 </div>
				   </div>
				  @endif
				@endif
            </div>
		</div>
    </div>


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
    <a class="btn btn-dark  btn-sm" style="color: #FFFFFF;" href="{{route('trasparenciaOrdemCompraNovo', $unidade[0]->id)}}" > Novo <i class="fas fa-check"></i></a>    
	<div class="container d-flex justify-content-between">
        <div class="row">
            <table class="table" style="margin-left: -45px">
                <thead>
                 <tr>
                   <td colspan='2' width="200px;"><center> <b>Solicitação</b> </center></td>
                   <td colspan='13'><center><b>Ordens de Compra</b></center></td>
                 </tr>
                 <tr> 
                    <td> Número </td>
                    <td> Data </td>
                    <td> Nº O.C </td>
                    <td> Data Autorização </td>
                    <td> Fornecedor </td>
                    <td> CNPJ </td>
                    <td> Valor Total </td>
                    <td> Produto </td>
                    <td> Quantidade Recebida </td>
                    <td> Valor Total Recebido </td>
                  </tr>
                 </thead>
                 
                   @foreach($processos as $prc)
                   <tr>
                    <td> {{ $prc->numeroSolicitacao }} </td>
                    <td> {{ date('d-m-Y', strtotime($prc->dataSolicitacao)) }} </td>
                    <td> {{ $prc->numeroOC }} </td>
                    <td> {{ date('d-m-Y', strtotime($prc->dataAutorizacao)) }} </td>
                    <td> {{ $prc->fornecedor }} </td>
                    <td> {{ $prc->cnpj }} </td>
                    <td> {{ "R$ ".number_format($prc->totalValorOC, 2,',','.') }} </td>
                    <td> {{ $prc->produto }} </td>
                    <td> {{ $prc->quantidadeRecebida }} </td>
                    <td> {{ "R$ ".number_format($prc->valorTotalRecebido, 2,',','.') }} </td>
                   </tr> 
                   @endforeach   
            </table>
        </div>
    </div>
 
    </section >    
@endsection
	