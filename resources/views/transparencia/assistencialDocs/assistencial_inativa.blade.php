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
        <h3>Relatório Anual de Gestão</h3>
    </div>
    <div class="col-md-8 offset-md-2 text-center">
        <h5 class="bg-danger text-white rounded">Exclusão de documento de Relatório Anual de Gestão</h5>
    </div>
</div>
<form method="POST" action="#" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @foreach($assistenDoc as $AD)
    <div style="margin-top:5px;margin-left:15px;margin-right:15px;" class="shadow p-3 mb-4 bg-white rounded">
        <div class="d-flex flex-wrap justify-content-center">
            <div class="m-2">
                <label style="font-family:Arial black, Helvetica, sans-serif;">Título</label>
            </div>
            <div class="m-2">
                <label >{{$AD->titulo}}</label>
            </div>
        </div>
        <div class="d-flex flex-wrap justify-content-between">
            <div class="m-2">
                <a href="{{route('assistencialCadastro',$unidade->id)}}" class="btn btn-warning" style="color:white;">Voltar</a>
            </div>
            <div class="d-flex flex-wrap justify-content-center">
                <div class="m-2">
                    <label style="font-family:Arial black, Helvetica, sans-serif;">Mês:</label>
                </div>
                <div class="m-2">
                    <?php echo $AD->admes == 1 ? "<label> Janeiro</label>" : ""; ?>
                    <?php echo $AD->admes == 2 ? "<label> Fevereiro</label>" : ""; ?>
                    <?php echo $AD->admes == 3 ? "<label> Março</label>" : ""; ?>
                    <?php echo $AD->admes == 4 ? "<label> Abril</label>" : ""; ?>
                    <?php echo $AD->admes == 5 ? "<label> Maio</label>" : ""; ?>
                    <?php echo $AD->admes == 6 ? "<label> Junho</label>" : ""; ?>
                    <?php echo $AD->admes == 7 ? "<label> Julho</label>" : ""; ?>
                    <?php echo $AD->admes == 8 ? "<label> Agosto</label>" : ""; ?>
                    <?php echo $AD->admes == 9 ? "<label> Setembro</label>" : ""; ?>
                    <?php echo $AD->admes == 10 ? "<label> Outubro</label>" : ""; ?>
                    <?php echo $AD->admes == 11 ? "<label> Novembro</label>" : ""; ?>
                    <?php echo $AD->admes == 12 ? "<label> Dezembro</label>" : ""; ?>
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

                    <?php for ($i = $anoini; $i <= $anofim; $i++) {
                        if ($i == $AD->ano) {
                            echo $i;
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="m-2">
                <input type="submit" value="Excluir" id="Excluir" name="Excluir" class="btn btn-danger" />
            </div>
        </div>

        <div class="d-flex flex-wrap justify-content-center">
            <div class="embed-responsive embed-responsive-21by9">
                <iframe class="embed-responsive-item" src="{{asset($AD->file_path)}}"></iframe>
            </div>
        </div>
    </div>
    @endforeach
</form>
<script>
    var $input = document.getElementById('input-file'),
        $fileName = document.getElementById('file-name');

    $input.addEventListener('change', function() {
        $fileName.textContent = this.value;
    });
</script>

@endsection