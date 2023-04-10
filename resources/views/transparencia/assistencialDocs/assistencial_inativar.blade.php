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
        @if($assistenDoc[0]->status_ass_doc == 0)
          <h5 class="bg-primary text-white rounded">Ativar documento de Relatório Anual de Gestão</h5>
        @else
          <h5 class="bg-primary text-white rounded">Inativar documento de Relatório Anual de Gestão</h5>
        @endif
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
                <a href="{{route('cadastroRADOC', array($unidade->id, $AD->id))}}" class="btn btn-warning" style="color:white;">Voltar</a>
            </div>
            <div class="d-flex flex-wrap justify-content-center">
                <div class="m-2">
                    <label style="font-family:Arial black, Helvetica, sans-serif;">Mês:</label>
                </div>
                <div class="m-2">
                    <?php echo $AD->mes == 1 ? "<label> Janeiro</label>" : ""; ?>
                    <?php echo $AD->mes == 2 ? "<label> Fevereiro</label>" : ""; ?>
                    <?php echo $AD->mes == 3 ? "<label> Março</label>" : ""; ?>
                    <?php echo $AD->mes == 4 ? "<label> Abril</label>" : ""; ?>
                    <?php echo $AD->mes == 5 ? "<label> Maio</label>" : ""; ?>
                    <?php echo $AD->mes == 6 ? "<label> Junho</label>" : ""; ?>
                    <?php echo $AD->mes == 7 ? "<label> Julho</label>" : ""; ?>
                    <?php echo $AD->mes == 8 ? "<label> Agosto</label>" : ""; ?>
                    <?php echo $AD->mes == 9 ? "<label> Setembro</label>" : ""; ?>
                    <?php echo $AD->mes == 10 ? "<label> Outubro</label>" : ""; ?>
                    <?php echo $AD->mes == 11 ? "<label> Novembro</label>" : ""; ?>
                    <?php echo $AD->mes == 12 ? "<label> Dezembro</label>" : ""; ?>
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
               @if($assistenDoc[0]->status_ass_doc == 0)
                <input type="submit" value="Ativar" id="Ativar" name="Ativar" class="btn btn-success" />
               @else
                <input type="submit" value="Inativar" id="Inativar" name="Inativar" class="btn btn-primary" />
               @endif
            </div>
        </div>

        <div class="d-flex flex-wrap justify-content-center">
            <div class="embed-responsive embed-responsive-21by9">
                <iframe class="embed-responsive-item" src="{{asset($AD->file_path)}}"></iframe>
            </div>
        </div>
        <table>
		  <tr>
			<td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
			<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="relAssistencial" /> </td>
			<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarRelAssistencial" /> </td>
			<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
		  </tr>
		</table>
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