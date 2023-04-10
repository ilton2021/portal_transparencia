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
            <a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
                Novo processo de contratação de terceiros <i class="fas fa-check-circle"></i>
            </a>
            <form action="{{ \Request::route('storeProcessContrataTerceiros'), $unidade->id }}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group m-3">
                    <label for="exampleFormControlInput1">Nome do processo</label>
                    <input type="text" class="form-control" id="proccess_name" name="proccess_name" placeholder="Digite o nome do processo..." value="{{ old('proccess_name') }}">
                </div>

                <div class="d-flex justify-content-between flex-wrap">
                    <div class="d-flex justify-content-start aling-items-center m-3">
                        <div class="d-flex flex-column">
                            <label for="exampleFormControlSelect1">Mês</label>
                            <select class="form-control" id="mes" name="mes">
                                <option <?php old('mes') == 1 ? "selected" : "" ?> id="mes" name="mes" value="1">Janeiro
                                </option>
                                <option <?php echo old('mes') == 2 ? "selected" : "" ?> id="mes" name="mes" value="2"> Fevereiro
                                </option>
                                <option <?php echo old('mes') == 3 ? "selected" : "" ?> id="mes" name="mes" value="3">Março
                                </option>
                                <option <?php echo old('mes') == 4 ? "selected" : "" ?> id="mes" name="mes" value="4">Abril
                                </option>
                                <option <?php echo old('mes') == 5 ? "selected" : "" ?> id="mes" name="mes" value="5">Maio
                                </option>
                                <option <?php echo old('mes') == 6 ? "selected" : "" ?> id="mes" name="mes" value="6">Junho
                                </option>
                                <option <?php echo old('mes') == 7 ? "selected" : "" ?> id="mes" name="mes" value="7">Julho
                                </option>
                                <option <?php echo old('mes') == 8 ? "selected" : "" ?> id="mes" name="mes" value="8">Agosto
                                </option>
                                <option <?php echo old('mes') == 9 ? "selected" : "" ?> id="mes" name="mes" value="9">Setembro
                                </option>
                                <option <?php echo old('mes') == 10 ? "selected" : "" ?> id="mes" name="mes" value="10">Outubro
                                </option>
                                <option <?php echo old('mes') == 11 ? "selected" : "" ?> id="mes" name="mes" value="11">Novembro
                                </option>
                                <option <?php echo old('mes') == 12 ? "selected" : "" ?> id="mes" name="mes" value="12">Dezembro
                                </option>
                            </select>
                        </div>
                        <div class="d-flex flex-column ml-1">
                            <label for="exampleFormControlSelect1">Ano</label>
                            <select class="form-control" id="ano" name="ano">
                                <?php
                                for ($i = 2000; $i < 2030; $i++) {
                                ?>
                                    <option <?php echo old('ano') == $i ? "selected" : "" ?> id="ano" name="ano" value="{{ $i }}">
                                        {{ $i }}
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex flex-column m-3">
                        <label>Arquivo</label>
                        <input class="form-control" type="file" id="file_path" name="file_path" value="{{old('file_path')}}" required />
                    </div>
                </div>
                <div class="d-flex justify-content-around p-1">
                    <a href="{{ route('cadastroCotacoes', $unidade->id) }}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm m-4" style=" color: #FFFFFF;">
                        Voltar <i class="fas fa-undo-alt"></i>
                    </a>
                    <input type="submit" class="btn btn-success btn-sm m-4" value="Salvar" id="Salvar" name="Salvar" />
                </div>
            </form>
        </div>

    </div>
</div>

@endsection