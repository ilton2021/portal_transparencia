@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
    <div class="row" style="margin-top: 25px;">
        <div class="col-md-12 text-center">
            <h5 style="font-size: 18px;">RELATÓRIOS ASSISTENCIAL</h5>
            <div class="p-2">
                <a href="{{route('cadastroRA', array($unidade->id,1))}}" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
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
    <div class="row mt-2 form-control">
        <div class="d-flex d-flex-inline justify-content-center">
            <div class="p-2">
                <h5><i class="bi bi-filetype-pdf" style="font-size:40px;"></i> Relatório Anual de Gestão </h5>
            </div>
            <div class="p-2">
                <a class="btn btn-dark btn-sm" style="color: #FFFFFF;" href="{{route('novoRADOC', $unidade->id)}}"> Novo <i class="fas fa-check"></i> </a></li>
            </div>
        </div>
        <div class="d-flex m-2 justify-content-sm-start justify-content-lg-center justify-content-md-center" style="overflow:auto;">
            <?php $anoatual = ""; ?>
            @foreach($anosRefDocs as $year)
            <?php if ($anoatual !== $year->ano) { ?>
                <div class="p-2">
                    <button class="btn btn-success btn-lg " type="button" data-toggle="collapse" data-target="#{{$year->ano}}d" aria-expanded="false" aria-controls="{{$year->ano}}d">
                        {{$year->ano}}
                    </button>
                </div>
            <?php }
            $anoatual = $year->ano; ?>
            @endforeach
        </div>
        @foreach($anosRefDocs as $year)
        <div class="collapse border-0" id="{{$year->ano}}d" style="margin-top: 8px;">
            <div class="card border border-success card-body m-2" style="background-color: #fafafa;">
                <div class="d-flex flex-wrap justify-content-around text-center">
                    <div class="p-2">
                        <div class="container" style="margin-bottom: 10px;">
                            <h5 class="text-success"><strong>{{$year->ano}}</strong></h5>
                        </div>
                    </div>
                </div>

                <div class="card border border-success card-body m-2" style="background-color: #fafafa;">
                    @foreach($assistenDocs as $AD)
                    @if($AD->ano == $year->ano)

                    <div class="row mt-1">
                        <div class="col-md-12 d-flex justify-content-center">
                            <div class="card border-0" style="width: 40rem; background-color: #fafafa;">
                                <div class="card-body border-0">
                                    <div class="d-flex flex-column" id="headingOne">
                                        <div class="d-md-inline-flex justify-content-between border-bottom border-success align-items-center">
                                            <div class="p-1">
                                                <h6 style="font-size: 18px;"> {{$AD->titulo}}</h6>
                                            </div>
                                            <div class="p-1 text-center">
                                                <a href="{{asset($AD->file_path)}}" target="_blank" class="btn btn-success">Download <i class="bi bi-download"></i></a>
                                                 @if($AD->status_ass_doc == 1)
                                                  <a title="Inativar" href="{{route('telaInativarRADOC',array($unidade->id,$AD->id))}}" class="btn btn-warning"> <i class="fas fa-times-circle"></i></a>
                                                 @else
                                                  <a title="Ativar" href="{{route('telaInativarRADOC',array($unidade->id,$AD->id))}}" class="btn btn-success"> <i class="fas fa-times-circle"></i></a>
                                                 @endif
                                                <!--a href="{{route('excluirRADOC',array($unidade->id,$AD->id))}}" class="btn btn-danger"> <i class="bi bi-trash"></i></a-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection