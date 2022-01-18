<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{Asset('css/app.css')}}">
    <title>Contratação de serviços</title>
</head>

<body>
    <div class="row" style="margin-top:15px;margin-left:5px;margin-right:5px">
        <div class="col-md-12 col-sm-12 text-center">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="headingThree" style="background-color: rgb(58, 58, 58);">
                        <h3 class="mb-0">
                            <a>
                                <strong style="color:azure;">Contratações de serviços</strong>
                            </a>
                        </h3>
                    </div>
                    <div class="card-header">
                        <form method="POST" action="{{route('pesquisarContratacao')}}" >
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="input-group mb-3">
                                <select style="margin-top:10px;font-family:arial;" class="form-control" id="unidade_id" name="unidade_id">
                                    <option value="" id="unidade_id" name="unidade_id">Selecione a Unidade</option>
                                    @foreach($unidades as $unidade)
                                    <option value="<?php echo $unidade->id; ?>" id="unidade_id" name="unidade_id">{{ $unidade->name }}</option>
                                    @endforeach
                                </select>
                                <!--label style="margin-right:10px;margin-left:10px;margin-top: 15px;">Prazo Inicial:</label>
                                <input id="pesqIni" name="pesqIni" style="margin-top: 10px;height:36px" type="date"></input>
                                <label style="margin-right:10px;margin-left:10px;margin-top: 15px;">Prazo Final:</label>
                                <input id="pesqFim" name="pesqFim" style="margin-top: 10px;height:36px" type="date"></input-->

                                <button type="submit" style="margin-top: 8px;font-size:18px; margin-left:10px;float:left; font-family:arial;height:40px;" class="btn btn-primary" name="Pesquisar">Pesquisar</button>
                        </form>
                        <a href="{{route('novaContratacaoServicos')}}" class="btn btn-success" style="margin-top: 8px;height:40px;font-size:16px; margin-left:10px; font-family:arial">Nova contratação</a>
                        <a href="{{route('paginaEspecialidade')}}" class="btn btn-success" style="margin-top: 8px;height:40px;font-size:16px; margin-left:10px; font-family:arial">Especialidades</a>
                        <a href="{{route('home')}}" class="btn btn-warning" style="margin-top: 8px;height:40px;font-size:16px; margin-left:10px;background-color:rgb(255, 102, 0);color:cornsilk;font-family:arial">voltar</a>
                    </div>
                </div>
                <table>
                    <div class="card-header">
                        <table class="table table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Texto</th>
                                    <th>Unidade</th>
                                    <th>Prorrogar</th>
                                    <th>Alterar</th>
                                    <th>Excluir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contratacao_servicos as $CS)
                                <tr>

                                    <th class="text-truncate" style="font-size:16px;max-width:150px;">{{$CS->texto}}</th>
                                    <th class="text-truncate" style="font-size:16px;max-width:40px;">
                                        @if($CS->unidade_id==1)
                                        HCP
                                        @elseif($CS->unidade_id==2)
                                        HMR
                                        @elseif($CS->unidade_id==3)
                                        UPAE Belo Jardim
                                        @elseif($CS->unidade_id==4)
                                        UPAE Arcoverde
                                        @elseif($CS->unidade_id==5)
                                        UPAE Arruda
                                        @elseif($CS->unidade_id==6)
                                        UPAE Caruaru
                                        @elseif($CS->unidade_id==7)
                                        HSS
                                        @elseif($CS->unidade_id==8)
                                        HCA
                                        @endif
                                    </th>
                                    <th style="font-size:18px;max-width:5px;"><a href="{{route('pagProrrContr',$CS->id)}}"><button class="btn btn-info"> Prorrogar</button></a></th>
                                    <th style="font-size:18px;max-width:5px;"><a href="{{route('pagAlteraContratacao',$CS->id)}}"><button class="btn btn-dark"> Alterar</button></a></th>
                                    <th style="font-size:18px;max-width:10px;"><a href="{{route('pagExcluirContratacao',$CS->id)}}"><button class="btn btn-danger"> Excluir</button></a></th>
                                </tr>                                                   
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </table>
            </div>
        </div>
    </div>
</body>

</html>