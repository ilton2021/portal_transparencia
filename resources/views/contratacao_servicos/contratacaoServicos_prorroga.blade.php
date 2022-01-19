<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{Asset('css/app.css')}}">
    <title>Prorrogação Contratação de serviços</title>
    <script language="JavaScript">
        //Marcar ou desmarcar todas a especialidades
        function toggle(source) {
            checkboxes = document.getElementsByClassName('especialidade');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = source.checked;
            }
        }
        //Verificando se pelo um checkbox especialidade foi marcado
    </script>
</head>

<body>
    <div class="row" style="margin-top: 25px;">
        <div class="col-md-12 col-sm-12 text-center">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="headingThree" style="background-color: rgb(58, 58, 58);">
                        <h3 class="mb-0">
                            <a>
                                <strong style="color:azure;">Prorrogação de contratação de serviço</strong>
                            </a>
                        </h3>
                    </div>
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
                    @foreach($contratacao_servicos as $CS)
                    <form method="POST" action="{{route('prorrContr',$CS->id)}}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="card-header">
                            <div class="input-group mb-3">
                                <a href="{{route('paginaContratacaoServicos')}}" class="btn btn-warning" style="font-size:16px; margin-left:10px;background-color:rgb(255, 102, 0);color:cornsilk;font-family:arial">voltar</a>
                            </div>
                        </div>
                        <div style="margin-top:10px;margin-left:15px;margin-right:15px;" class="shadow p-3 mb-5 bg-white rounded">
                            <div class="input-group mb-3">
                                <label style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:60px">Data prazo prorrogação:</label>
                                <input style=" height: 40px;margin-top:15px;margin-left:20px" type="date" id="prazoProrroga" name="prazoProrroga" rows="4" cols="50" value="{{$CS->prazoProrroga}}" ></input>
                            </div>
                            <table>
                            <th>
                             @if($CS->arquivo_errat != "")
                                    <label style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:60px">Arquivo:</label>
                                    <td>
                                        <a href="{{asset('storage/')}}/{{$CS->arquivo_errat}}" target="_blank" title="<?php echo $CS->arquivo_errat; ?>" class="list-group-item list-group-item-action" style="width:350px;height:70px; font-family:arial black; font-size:15px;margin-left:10px"><?php echo explode('/', (substr($CS->arquivo_errat,0,80)))[1]; ?></a>
                                    </td>
                                    <td>
                                        <a type="submit" class="btn btn-danger btn-sm" href="{{route('exclArqErratContr',$CS->id)}}" style="margin-left:10px;;margin-top:20px;height:25px">X<i class="fas fa-times-circle"></i></a>
                                    </td>
                                    @else
                                    <label style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:60px">Arquivo:</label>
                                    <input style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:10px" type="file" id="nome_arq_errat" name="nome_arq_errat"></input>
                                    @endif
                            </th>
                            </table>
                            <div>
                                <button type="submit" class="btn btn-info btn-sm" style="font-size:20px" value="salvar" id="salvar" name="salvar">Salvar</button>
                                </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    </form>
    
    @endforeach

</html>