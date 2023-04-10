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
            <h5 class="bg-danger text-white rounded">Exclusão de documento de bens públicos</h5>
        </div>
    </div>
    <form method="POST" action="{{route('destroyBP',array($unidade->id,$bens_pub[0]->id))}}" enctype="multipart/form-data" id="formid">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @foreach($bens_pub as $bp)
        <div style="margin-top:5px;margin-left:15px;margin-right:15px;" class="shadow p-3 mb-4 bg-white rounded">
            <div class="d-flex flex-wrap justify-content-between">
                <div class="m-2">
                    <a href="{{route('cadastroBP',$unidade->id)}}" class="btn btn-warning" style="color:white;">Voltar</a>
                </div>
                <div class="d-flex flex-wrap justify-content-center">
                    <div class="m-2">
                        <label style="font-family:Arial black, Helvetica, sans-serif;">Mês:</label>
                    </div>
                    <div class="m-2">
                        <?php echo $bp->mes == 1 ? "<label> Janeiro</label>" : ""; ?>
                        <?php echo $bp->mes == 2 ? "<label> Fevereiro</label>" : ""; ?>
                        <?php echo $bp->mes == 3 ? "<label> Março</label>" : ""; ?>
                        <?php echo $bp->mes == 4 ? "<label> Abril</label>" : ""; ?>
                        <?php echo $bp->mes == 5 ? "<label> Maio</label>" : ""; ?>
                        <?php echo $bp->mes == 6 ? "<label> Junho</label>" : ""; ?>
                        <?php echo $bp->mes == 7 ? "<label> Julho</label>" : ""; ?>
                        <?php echo $bp->mes == 8 ? "<label> Agosto</label>" : ""; ?>
                        <?php echo $bp->mes == 9 ? "<label> Setembro</label>" : ""; ?>
                        <?php echo $bp->mes == 10 ? "<label> Outubro</label>" : ""; ?>
                        <?php echo $bp->mes == 11 ? "<label> Novembro</label>" : ""; ?>
                        <?php echo $bp->mes == 12 ? "<label> Dezembro</label>" : ""; ?>
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
                            if ($i == $bp->ano) {
                                echo $i;
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="m-2" id="containerEnviar">
                    <input type="submit" value="Excluir" id="Excluir" name="Excluir" class="btn btn-danger" />
                    <div id="blockEnviar"></div>
                </div>
            </div>
            <div class="d-flex flex-wrap justify-content-center">
                <div class="embed-responsive embed-responsive-21by9">
                    <iframe class="embed-responsive-item" src="{{asset($bp->file_path)}}"></iframe>
                </div>
            </div>
        </div>
        @endforeach
        <table>
			<tr>
				<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="BensPublicos" /> </td>
		        <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="excluirBensPublicos" /> </td>
        		<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
			</tr>
		</table>
    </form>
    <script>
        var $input = document.getElementById('input-file'),
            $fileName = document.getElementById('file-name');

        $input.addEventListener('change', function() {
            $fileName.textContent = this.value;
        });
    </script>
    @endsection