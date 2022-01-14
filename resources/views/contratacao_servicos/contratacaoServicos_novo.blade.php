<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{Asset('css/app.css')}}">
    <title>Nova Contratação de serviços</title>
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
                                <strong style="color:azure;">Nova contratação de serviço</strong>
                            </a>
                        </h3>
                    </div>
                    @if ($errors->any())
                    <div class="alert alert-danger" style="font-size:20px;">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @elseif($sucesso =="ok")
                    <div class="alert alert-success" style="font-size:20px;">
                        <ul>
                            <li>{{ $validator }}</li>
                        </ul>
                    </div>
                    @endif
                    <form method="POST" action="{{route('salvarContratacaoServicos')}}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="card-header">
                            <div class="input-group mb-3">
                                <a href="{{route('paginaContratacaoServicos')}}" class="btn btn-warning" style="font-size:16px; margin-left:10px;background-color:rgb(255, 102, 0);color:cornsilk;font-family:arial">voltar</a>
                            </div>
                        </div>
                        <div style="margin-top:10px;margin-left:15px;margin-right:15px;" class="shadow p-3 mb-5 bg-white rounded">
                            <div class="input-group mb-3">
                                <label style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:60px">Texto:</label>
                                <textarea style="width:1000px;height: 40px;margin-top:15px;margin-left:20px" type="textarea" id=texto name="texto" rows="4" cols="50"></textarea>
                            </div>
                            <div class="input-group mb-3">
                                <label style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:60px">Data prazo inicial:</label>
                                <input style=" height: 40px;margin-top:15px;margin-left:20px" type="date" id=prazoInicial name="prazoInicial" rows="4" cols="50"></input>
                                <label style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:20px">Data prazo final:</label>
                                <input style=" height: 40px;margin-top:15px;margin-left:20px" type="date" id=prazoFinal name="prazoFinal" rows="4" cols="50"></input>
                            </div>
                            <div class="input-group mb-3">
                                <label style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:60px">Unidade:</label>
                                <select style="width:500px; height: 40px;margin-top:15px;margin-left:20px" name="unidade_id" id="unidade_id">
                                    @foreach($Unidades as $unidade)
                                    <option value="{{$unidade->id}}">{{$unidade->name}}</option>
                                    @endforeach
                                </select>
                                <label style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:10px">Arquivo:</label>
                                <input style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:10px" type="file" id="nome_arq" name="nome_arq"></input>
                            </div>
                            <div class="input-group mb-3">
                                <label style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:20px">Especialidade:</label>
                            </div>
                            <div class="input-group mb-3">
                                <table class="table table-hover">
                                    <tr>
                                        <input style="margin-left:20px;margin-top: 5px;" type="checkbox" onClick="toggle(this)" />
                                        <label style="font-family:Arial black, Helvetica, sans-serif;margin-left:10px;margin-bottom:30px;">Marcar/desmarcar todos</label>
                                        <?php $i = 1; ?>
                                        <?php $m = 8; ?>
                                        @foreach($especialidades as $especialidade)
                                        <td>
                                            <input type="checkbox" id="especialidade_<?php echo $i; ?>" class="especialidade" name="especialidade_<?php echo $i; ?>" value="<?php echo $especialidade->id; ?>">&nbsp{{$especialidade->nome}}</input>
                                            @if($i == $m )
                                            <?php $m += 8; ?>
                                        </td>
                                    </tr>
                                    @endif
                                    <?php $i++; ?>
                                    @endforeach
                                    </tr>
                                </table>
                                <input type="submit" class="btn btn-success btn-sm" style="font-size:20px" value="Salvar" id="Salvar" name="Salvar" />
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    </form>

</html>