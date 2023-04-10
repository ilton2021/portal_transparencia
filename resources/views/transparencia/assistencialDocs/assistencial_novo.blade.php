@extends('navbar.default-navbar')
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

@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row">
    <div class="col-md-12 text-center">
        <h3>Relatório Assistencial</h3>
    </div>
    <div class="col-md-6 offset-md-3 text-center">
        <h5 class="bg-dark text-white rounded">Novo documento de relatório anual de gestão</h5>
    </div>
</div>
<form method="POST" action="{{route('storeRADOC',$unidade->id)}}" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div style="margin-top:5px;margin-left:15px;margin-right:15px;" class="shadow p-3 mb-4 bg-white rounded">
        <div class="d-flex flex-wrap justify-content-center">
            <div class="m-2">
                <label style="font-family:Arial black, Helvetica, sans-serif;">Título:</label>
            </div>
            <div class="m-2">
                <select class="form-control" name="titulo" id="titulo">
                    <option>Escolha o Título</option>
                    <option  value="Relatório Anual de Gestão">Relatório Anual de Gestão</option>
                    <option  value="Relatório Anual de Gestão - COVID">Relatório Anual de Gestão - COVID</option>
                    <option  value="Relatório Anual de Gestão - Maternidade">Relatório Anual de Gestão - Maternidade</option>
                </select>
            </div>
        </div>
        <div class="d-flex flex-wrap justify-content-center">
            <div class="m-2">
                <label style="font-family:Arial black, Helvetica, sans-serif;">Ano:</label>
            </div>
            <div class="m-2">
                <?php
                $anoini = intval(date('Y')) - 10;
                $anofim = intval(date('Y')) + 5;
                $s = "";
                ?>
                <select class="form-control" name="ano" id="ano">
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
                <a href="{{route('cadastroRA', $unidade->id)}}" class="btn btn-warning" style="color:white;">Voltar</a>
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