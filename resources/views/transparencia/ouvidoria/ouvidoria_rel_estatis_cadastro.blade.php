@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid" style="margin-top: 25px;">

    <div class="d-flex justify-content-around align-items-center">
        <a class="btn btn-warning btn-sm m-1" href="{{route('transparenciaOuvidoria', $unidade->id)}}">Voltar <i class="bi bi-arrow-counterclockwise"></i></a>

        <h5 class="m-1" style="font-size: 18px;">Relatório estastístico - PAI</h5>

        <a class="btn btn-info btn-sm m-1" href="{{route('novoOVRelatorioES', $unidade->id)}}">Novo <i class="bi bi-plus-square"></i></a>

    </div>
    @if ($errors->any())
    <div class="alert alert-success text-center">
        <ul style="list-style: none;">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="row" style="margin-top: 25px;">
        <div class="col-md-1 col-sm-0"></div>
        <div class="col-md-10 col-sm-12 text-center">
            @foreach ($relatoriosEs->pluck('ano')->unique() as $ano)
            <div class="d-inline-flex flex-wrap">
                <div class="p-2">
                    <a class="btn btn-success" data-toggle="collapse" href="#{{$ano}}" role="button" aria-expanded="false" aria-controls="{{$ano}}">{{$ano}}</a>
                </div>
            </div>
            @endforeach
            @if(sizeof($relatoriosEs) > 0)
            @foreach ($relatoriosEs->pluck('ano')->unique() as $RF)
            <div class="collapse border border-success m-2 rounded" id="{{$RF}}">
                <div class="card card-body border-0" style="background-color: #fafafa">
                    @foreach ($relatoriosEs as $item)
                    @if ($item->ano == $RF)
                    <div class="d-flex flex-column justify-content-center border-bottom border-success">
                        <div class="d-md-inline-flex justify-content-between align-items-center {{$item->status_ouvi_rel_estas == 0 ? 'bg-secondary':''}}">
                            <div class="p-1" style="font-size:16px;">
                                <b class="{{$item->status_ouvi_rel_estas == 0 ? 'text-white':''}}">Relatório estastístico - </b>
                                <span class="badge badge-secondary"><b>{{$item->mes}}/{{$item->ano}}</b></span>
                            </div>
                            <div class="d-inline-flex">
                                <div class="p-2">
                                    <a title="Abrir" class="icon-link" href="{{asset('storage')}}/{{$item->file_path}}" target="_blank"> <i style="color:#65b345; font-size:32px;" class="bi bi-file-earmark-arrow-down-fill"></i></a>
                                </div>
                                <div class="p-2 mt-2">
                                    <a title="Alterar" class="btn btn-info btn-sm" data-toggle="modal" data-target="#alterar{{$item->id}}"><i class="bi bi-pencil-square"></i></a>
                                    <div class="modal fade" id="alterar{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
                                                    <h5 class="modal-title" id="exampleModalLabel">Alterar documento</h5>
                                                    <a title="Alterar" href="{{route('alterarOVRelatorioES', array($unidade->id,$item->id))}}" class="btn btn-info btn-sm">Alterar</a>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="embed-responsive embed-responsive-16by9">
                                                        <iframe class="embed-responsive-item" src="{{asset('storage')}}/{{$item->file_path}}"></iframe>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2 mt-2">
                                    @if($item->status_ouvi_rel_estas == 0)
                                    <a title="Ativar" class="btn btn-success btn-sm" style="color: #FFFFFF;" data-toggle="modal" data-target="#statusAtivar{{$item->id}}"><i class="bi bi-power"></i></a>
                                    <div class="modal fade" id="statusAtivar{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form class="text-center" action="{{route('statusOVRelatorioES', array($unidade->id,$item->id))}}" method="post" enctype="multipart/form-data">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Reativar documento</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Ao reativar o documento o mesmo ficará <b>visivel</b> para os visitantes do site.
                                                        <br><b>Deseja realmente <b style="color:green">reativar</b> este documento ?</b>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <table>
                                                            <tr>
                                                                <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
                                                                <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="ouvidoriaRelEstastic" /> </td>
                                                                <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="reativarOuvidoriaRelEstastic" /> </td>
                                                                <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
                                                            </tr>
                                                        </table>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
                                                        <input type="submit" class="btn btn-success btn-sm" value="Ativar" id="Ativar" name="Ativar" />
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <a title="Inativar" class="btn btn-danger btn-sm" style="color: #FFFFFF;" data-toggle="modal" data-target="#statusInativar{{$item->id}}"><i class="bi bi-power"></i></a>
                                    <div class="modal fade" id="statusInativar{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form class="text-center" action="{{route('statusOVRelatorioES', array($unidade->id,$item->id))}}" method="post" enctype="multipart/form-data">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Inativar documento</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Ao inativar o documento o mesmo ficará oculto para os visitantes do site porém ficará visivel você gestor.
                                                        <br><b>Deseja realmente <b style="color:red">inativar</b> este documento ?</b>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <table>
                                                            <tr>
                                                                <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
                                                                <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="ouvidoriaRelEstastic" /> </td>
                                                                <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="inativarOuvidoriaRelEstastic" /> </td>
                                                                <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
                                                            </tr>
                                                        </table>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
                                                        <input type="submit" class="btn btn-danger btn-sm" value="Inativar" id="Inativar" name="Inativar" />
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            @endforeach
            @else
            <div class="container" style="margin-top: 15px;">
                <h2 style="font-size: 80px; color:#65b345"><i class="fas fa-file-pdf"></i></h2>
            </div>
            @endif
        </div>
        <div class="col-md-1 col-sm-0"></div>
    </div>

</div>
@endsection