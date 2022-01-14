<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{Asset('css/app.css')}}">
    <title>Especialidades</title>
</head>
<body>
    @if ($sucesso == "ok")
    <div class="alert alert-success" style="font-size:20px;">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @elseif($sucesso == "no")
    <div class="alert alert-danger" style="font-size:20px;">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="row" style="margin-left:10px;margin-top:15px;margin-right:10px">
        <div class="col-md-12 col-sm-12 text-center">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="headingThree" style="background-color: rgb(58, 58, 58);">
                        <h3 class="mb-0">
                            <a>
                                <strong style="color:azure;">Especialidades Médicas</strong>
                            </a>
                        </h3>
                    </div>
                    <div class="card-header">
                        <form method="POST" action="{{route('pesquisarEspecialidade')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="input-group mb-3">
                                <input name="nomePesq" id="nomePesq" class="flex-fill" style="font-size:16px; " placeholder="Digite o nome"></input>
                                <button type="submit" style="font-size:18px; margin-left:10px;float:left; font-family:arial;" class="btn btn-primary" name="Pesquisar">Pesquisar</button>
                        </form>
                        <a href="{{route('novaEspecialidade')}}" class="btn btn-success" style="font-size:16px; margin-left:10px; font-family:arial">Nova Especialidade</a>
                        <a href="{{route('paginaContratacaoServicos')}}" class="btn btn-warning" style="font-size:16px; margin-left:10px;background-color:rgb(255, 102, 0);color:cornsilk;font-family:arial">voltar</a>
                    </div>
                </div>
                <table>
                    <div class="card-header">
                        <table class="table table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nome</th>
                                    <th>Alterar</th>
                                    <th>Excluir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($Especialidades as $especialidade)
                                <tr>
                                    <th class="text-truncate" style="font-size:16px;max-width:100px">{{$especialidade->nome}}</th>
                                    <th style="font-size:18px;max-width:5px;"><a href="{{route('pagAlteraEspeciali',$especialidade->id)}}"><button class="btn btn-dark"> Alterar</button></a></th>
                                    <th style="font-size:18px;max-width:10px;"><a href="{{route('pagExcluirEspeciali',$especialidade->id)}}"><button class="btn btn-danger"> Excluir</button></a></th>
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