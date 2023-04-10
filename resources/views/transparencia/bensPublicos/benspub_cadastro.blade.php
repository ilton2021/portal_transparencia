@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
    @if($errors->any())
    <div class="alert alert-danger" style="font-size:16px;">
        <ul class="list-unstyled">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @elseif(isset($sucesso))
    @if($sucesso =="ok")
    <div class="alert alert-success" style="font-size:16px;">
        <ul class="list-unstyled">
            <li>{{ $validator }}</li>
        </ul>
    </div>
    @endif
    @endif
    <div class="row" style="margin-top: 25px;">
        <div class="col-md-12 text-center">
            <h3 style="font-size: 18px;">BENS PÚBLICOS</h3>

            <h6 class="btn btn-success" style="font-size: 18px;">Cadastros</h6>
        </div>
    </div>
    <div class="row" style="">
        <div class="col-md-6 text-center">
            <a href="{{route('transparenciaBensPublicos',$unidade->id)}}" class="btn btn-warning" style="font-size:13px;color:white;">Voltar <i class="fas fa-undo-alt"></i></a> 
        </div>
        <div class="col-md-6 text-center">
            <a href="{{route('novoBP',$unidade->id)}}" class="btn btn-dark" style="font-size:13px;">Novo <i class="fas fa-check"></i></a>
        </div>
    </div>
    @foreach($bens_pub as $bp)
    <div class="row mt-1">
        <div class="col-md-12 d-flex justify-content-center">
            <div class="card border-0" style="width: 40rem; background-color: #fafafa;">
                <div class="card-body border-0">
                    <div class="d-flex flex-column" id="headingOne">
                        <div class="d-md-inline-flex justify-content-between border-bottom border-success align-items-center">
                            <div class="p-1">
                                <h6 style="font-size: 18px;"> Bens Publicos - {{$bp->ano}} </h6>
                            </div>
                            <div class="p-1 text-center">
                                <a href="{{asset($bp->file_path)}}" target="_blank" class="btn btn-success">Download <i class="bi bi-download"></i></a>
                                @if($bp->status_bens == 0)
                                <a title="Ativar" href="{{route('telaInativarBP', array($unidade->id,$bp->id))}}" class="btn btn-success"> <i class="fas fa-times-circle"></i></a>
                                @else
                                <a title="Inativar" href="{{route('telaInativarBP', array($unidade->id,$bp->id))}}" class="btn btn-warning"> <i class="fas fa-times-circle"></i></a>
                                @endif
                                <!--a title="Excluir" href="{{route('excluirBP', array($unidade->id,$bp->id))}}" class="btn btn-danger"> <i class="bi bi-trash"></i></a-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @if(sizeof($bens_pub) == 0)
    <div class="row" style="margin-top: 25px;">
        <div class="col-md-2 col-sm-0"></div>
        <div class="col-md-8 col-sm-12 text-center">
            <div class="container text-center">
                <h1 class="text-success"><i class="fas fa-clock"></i></h1>
            </div>
            <h4 style="margin-top: 20px;" class="text-success">Aguardando visita da Secretária de Saúde<h4>
        </div>
        <div class="col-md-2 col-sm-0"></div>
    </div>
    @endif
    @endsection