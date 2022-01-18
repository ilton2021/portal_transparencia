<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{Asset('css/app.css')}}">
    <title>Alterar especialidade</title>
</head>
<body>
    @if ($sucesso == "ok")
    <div class="alert alert-success" style="font-size:20px;">
        <ul>
            @foreach ($errors->all() as $error)
            <li><center>{{ $error }}</center></li>
            @endforeach
        </ul>
    </div>
    @elseif($sucesso == "no")
    <div class="alert alert-danger" style="font-size:20px;">
        <ul>
            @foreach ($errors->all() as $error)
            <li><center>{{ $error }}</center></li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="row" style="margin-top: 25px;">
        <div class="col-md-12 col-sm-12 text-center">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="headingThree" style="background-color: rgb(58, 58, 58);">
                        <h3 class="mb-0">
                            <a>
                                <strong style="color:azure;">Alterar especialidade médica</strong>
                            </a>
                        </h3>
                    </div>
                    @foreach($Especialidades as $especialidade)
                    <form method="POST" action="{{route('AlteraEspeciali',$especialidade->id)}}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="card-header">
                            <div class="input-group mb-3">
                                <a href="{{route('paginaEspecialidade')}}" class="btn btn-warning" style="font-size:16px; margin-left:10px;background-color:rgb(255, 102, 0);color:cornsilk;font-family:arial">voltar</a>
                            </div>
                        </div>
                        <div style="margin-top:10px;margin-left:15px;margin-right:15px;" class="shadow p-3 mb-5 bg-white rounded">
                            <div class="input-group mb-3">
                                <label style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:60px">Nome:</label>

                                <input style="width:1000px;height: 40px;margin-top:15px;margin-left:20px;font-size:18px" type="textarea" id=nome name="nome" rows="4" cols="50" value="{{$especialidade->nome}}"></input>

                            </div>
                            <div class="input-group mb-3">
                                <button type="submit" class="btn btn-primary" style="font-size:15px; margin-top:10px" value="Excluir" id="Excluir" name="Excluir">Alterar</button>
                            </div>
                    </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    </div>


</html>