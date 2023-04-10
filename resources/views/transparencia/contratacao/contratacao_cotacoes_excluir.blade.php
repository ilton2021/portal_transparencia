@extends('navbar.default-navbar')
@section('content')
    <script type="text/javascript">
        function mudar(valor) {
            var status = document.getElementById('proccess_name').value;
            if (status == "COVID") {
                document.getElementById('proccess_name2').disabled = false;
            } else {
                document.getElementById('proccess_name2').disabled = true;
            }
        }
    </script>
    <div class="container text-center" style="color: #28a745">Você está em: <strong>{{ $unidade->name }}</strong></div>
    <div class="container-fluid">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="col-md-12 col-sm-12 text-center mt-2">

            <div class="card rounded border border-success">
                <a class="card-header bg-success text-decoration-none text-white bg-success" type="button"
                    data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
                    @if ($cotacoes[0]->proccess_name == 'MAPA DE COTAÇÕES')
                        Inativar mapa de cotações
                    @else
                        Excluir processo de contratação de terceiros
                    @endif
                    <i class="fas fa-check-circle"></i>
                </a>
                <form action="{{ route('destroyProcessos', [$unidade->id, $cotacoes[0]->id]) }}" method="post"
                    enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group m-3">
                        <label for="exampleFormControlInput1">Nome do processo</label>
                        <input type="text" class="form-control" id="proccess_name" name="proccess_name"
                            value="<?php echo $cotacoes[0]->proccess_name; ?>" disabled>
                    </div>
                    <div class="d-flex justify-content-center flex-wrap">
                        <div class="d-flex justify-content-start aling-items-center m-3">
                            <div class="d-flex flex-column">
                                <label for="exampleFormControlSelect1">Mês</label>
                                <input style="width: 160px;" type="text" class="form-control" id="mes"
                                    name="mes" value="<?php
                                    echo $cotacoes[0]->mes == 1 ? 'Janeiro' : ($cotacoes[0]->mes == 2 ? 'Fevereiro' : ($cotacoes[0]->mes == 3 ? 'Março' : ($cotacoes[0]->mes == 4 ? 'Abril' : ($cotacoes[0]->mes == 5 ? 'Maio' : ($cotacoes[0]->mes == 6 ? 'Junho' : ($cotacoes[0]->mes == 7 ? 'Julho' : ($cotacoes[0]->mes == 8 ? 'Agosto' : ($cotacoes[0]->mes == 9 ? 'Setembro' : ($cotacoes[0]->mes == 10 ? 'Outubro' : ($cotacoes[0]->mes == 11 ? 'Novembro' : ($cotacoes[0]->mes == 12 ? 'Dezembro' : '')))))))))));
                                    ?>" disabled />
                            </div>
                            <div class="d-flex flex-column ml-1">
                                <label for="exampleFormControlSelect1">Ano</label>
                                <input style="width: 100px;" type="text" class="form-control" id="ano"
                                    name="ano" value="{{ $cotacoes[0]->ano }}" disabled />
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-3">
                        <label>Arquivo</label>
                        <input class="form-control" type="text" id="file_path" name="file_path"
                            value="{{ $cotacoes[0]->file_name }}" disabled />
                    </div>

                    <div class="d-flex justify-content-around p-2">
                        <a href="{{ route('cadastroCotacoes', $unidade->id) }}" id="Voltar" name="Voltar" type="button"
                            class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;">
                            Voltar <i class="fas fa-undo-alt"></i>
                        </a>
                        @if ($cotacoes[0]->status_cotacao == 0)
                            <strong> <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px; color:white" value="Ativar"
                                id="Salvar" name="Salvar" /></strong>
                        @else
                        <strong><input type="submit" class="btn btn-danger btn-sm" style="margin-top: 10px;color:white" value="Inativar"
                                id="Salvar" name="Salvar" /></strong>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection