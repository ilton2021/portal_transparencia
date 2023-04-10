@extends('navbar.default-navbar')
@section('content')

<style>
    input[type='file'] {
        display: none
    }

    .input-wrapper label {
        background-color: #3498db;
        border-radius: 5px;
        color: #fff;
        margin: 10px;
        padding: 6px 20px
    }

    .input-wrapper label:hover {
        background-color: #2980b9
    }
</style>
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
    @if($errors->any())
    <div class="alert alert-danger" style="font-size:16px;">
        <ul class="list-unstyled text-center">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @elseif(isset($sucesso))
    @if($sucesso =="ok")
    <div class="alert alert-success" style="font-size:16px;">
        <ul class="list-unstyled text-center">
            <li>{{ $validator }}</li>
        </ul>
    </div>
    @endif
    @endif
    <div class="row">
        <div class="col-md-12 text-center">
            <h3>BENS PÚBLICOS</h3>
        </div>
        <div class="col-md-6 offset-md-3 text-center">
            <h5 class="bg-dark text-white rounded">Novo documento de bens públicos</h5>
        </div>
    </div>
    <form method="POST" action="{{route('benspubstore',$unidade->id)}}" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div style="margin-top:5px;margin-left:15px;margin-right:15px;" class="shadow p-3 mb-4 bg-white rounded">
            <div class="d-flex flex-wrap justify-content-center">
                <div class="m-2">
                    <label style="font-family:Arial black, Helvetica, sans-serif;">Mês:</label>
                </div>
                <div class="m-2">
                    <?php
                    $mes = intval(date('m'));
                    $s = "";
                    ?>
                    <select class="form-control" name="mes" id="mes">
                        <option>Escolha o mês</option>
                        <option <?php echo $mes == 1 ? "selected" : ""; ?> value="1">Janeiro</option>
                        <option <?php echo $mes == 2 ? "selected" : ""; ?> value="2">Fevereiro</option>
                        <option <?php echo $mes == 3 ? "selected" : ""; ?> value="3">Março</option>
                        <option <?php echo $mes == 4 ? "selected" : ""; ?> value="4">Abril</option>
                        <option <?php echo $mes == 5 ? "selected" : ""; ?> value="5">Maio</option>
                        <option <?php echo $mes == 6 ? "selected" : ""; ?> value="6">Junho</option>
                        <option <?php echo $mes == 7 ? "selected" : ""; ?> value="7">Julho</option>
                        <option <?php echo $mes == 8 ? "selected" : ""; ?> value="8">Agosto</option>
                        <option <?php echo $mes == 9 ? "selected" : ""; ?> value="9">Setembro</option>
                        <option <?php echo $mes == 10 ? "selected" : ""; ?> value="10">Outubro</option>
                        <option <?php echo $mes == 11 ? "selected" : ""; ?> value="11">Novembro</option>
                        <option <?php echo $mes == 12 ? "selected" : ""; ?> value="12">Dezembro</option>
                    </select>
                </div>
                <div class="m-2">
                    <label style="font-family:Arial black, Helvetica, sans-serif;">Ano:</label>
                </div>
                <div class="m-2">
                    <?php
                    $anoini = intval(date('Y')) - 5;
                    $anofim = intval(date('Y')) + 5;
                    $s = "";
                    ?>
                    <select class="form-control" name="ano" id="mes">
                        <option>Escolha o mês</option>
                        <?php for ($i = $anoini; $i <= $anofim; $i++) {
                            if ($i == intval(date('Y'))) {
                                $s = "selected";
                            } else {
                                $s = "";
                            } ?>
                            <option {{$s}} value="{{$i}}">{{$i}}</option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="d-flex flex-wrap justify-content-center">
                <div class="m-2">
                    <label for='input-file' class="p-1 bg-info text-white rounded">
                        Clique aqui para selecionar um arquivo
                    </label>
                </div>
            </div>
            <div class="d-flex flex-wrap justify-content-center">
                <div class="m-2">
                    <input id='input-file' type='file' name="input-file" value='' />
                    <span id='file-name'></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 text-center">
                    <a href="{{route('benspubshow',$unidade->id)}}" class="btn btn-warning" style="color:white;">Voltar</a>
                </div>
                <div class="col-md-6 text-center">
                    <input type="submit" value="Salvar" id="Salvar" name="Salvar" class="btn btn-success" />
                </div>
            </div>
        </div>

    </form>
    <script>
        var $input = document.getElementById('input-file'),
            $fileName = document.getElementById('file-name');

        $input.addEventListener('change', function() {
            $fileName.textContent = this.value;
        });
    </script>
    @endsection