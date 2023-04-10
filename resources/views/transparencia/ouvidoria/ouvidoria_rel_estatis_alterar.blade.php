@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid" style="margin-top: 25px;">
    <a class="btn btn-warning btn-sm m-1" href="{{route('cadastroOVRelatorioES', $unidade->id)}}">Voltar <i class="bi bi-arrow-counterclockwise"></i></a>
    <div class="d-flex justify-content-center align-items-center">
        <h5 class="m-1" style="font-size: 18px;">Alterar Relatório estastístico - PAI</h5>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger text-center">
        <ul style="list-style: none;">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="m-2 p-4 border border-success rounded">
        <form class="text-center" action="{{route('updateOVRelatorioES', array($unidade->id,$relEstatisc->id))}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group text-center">
                <label for="file"><b>Arquivo</b></label>
                <input class="form-control" type="file" id="arquivo" name="arquivo" />
                <small id="pdfHelp" class="form-text text-muted">O arquivo deve ser no formato PDF.</small>
            </div>
            <div class="d-flex justify-content-center text-center">
                <div class="form-group">
                    <label for="mes"><b>Mês</b></label>
                    <select class="form-control" id="mes" name="mes">
                        <option {{$relEstatisc->mes == 1 ? "selected" : "" }} value="1">Janeiro</option>
                        <option {{$relEstatisc->mes == 2 ? "selected" : "" }} value="2">Fevereiro</option>
                        <option {{$relEstatisc->mes == 3 ? "selected" : "" }} value="3">Março</option>
                        <option {{$relEstatisc->mes == 4 ? "selected" : "" }} value="4">Abril</option>
                        <option {{$relEstatisc->mes == 5 ? "selected" : "" }} value="5">Maio</option>
                        <option {{$relEstatisc->mes == 6 ? "selected" : "" }} value="6">Junho</option>
                        <option {{$relEstatisc->mes == 7 ? "selected" : "" }} value="7">Julho</option>
                        <option {{$relEstatisc->mes == 8 ? "selected" : "" }} value="8">Agosto</option>
                        <option {{$relEstatisc->mes == 9 ? "selected" : "" }} value="9">Setembro</option>
                        <option {{$relEstatisc->mes == 10 ? "selected" : "" }} value="10">Outubro</option>
                        <option {{$relEstatisc->mes == 11 ? "selected" : "" }} value="11">Novembro</option>
                        <option {{$relEstatisc->mes == 12 ? "selected" : "" }} value="12">Dezembro</option>
                    </select>
                </div>
                <div class="form-check">
                    <label for="ano"><b>Ano</b></label>
                    <input type="text" class="form-control" id="ano" name="ano" onkeypress="return onlynumber();" maxlength="4" value="{{$relEstatisc->ano}}" />
                </div>
            </div>
            <table>
                <tr>
                    <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
                    <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="ouvidoriaRelEstastic" /> </td>
                    <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="alterarOuvidoriaRelEstastic" /> </td>
                    <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
                </tr>
            </table>
            <input type="submit" class="btn btn-success btn-sm" value="Salvar" id="Salvar" name="Salvar" />
        </form>
    </div>
</div>
<script>
    function onlynumber(evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
        //var regex = /^[0-9.,]+$/;
        var regex = /^[0-9.]+$/;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault) theEvent.preventDefault();
        }
    }
</script>
@endsection