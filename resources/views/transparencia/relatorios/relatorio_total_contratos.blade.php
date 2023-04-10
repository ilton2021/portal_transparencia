@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">RELATÓRIO - TOTAL DE CONTRATOS</h3>
            <p style="margin-right: -800px;"><a href="{{route('relatorios', $unidade->id)}}" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a></p>
			<BR><BR>
		</div>
	</div>
        @if($unidade->id == 1)
         <form action="{{\Request::route('relatorioPesqTotalContratos')}}" method="post">
         <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <table class="table">
                <tr>
                <td align="right">Unidade:</td>
                <td>
            <center>
            <select width="400px" class="form-control" id="unidade_id" name="unidade_id" required>
                <option id="unidade_id" name="unidade_id" value="0">Selecione...</option>
                @foreach($unidades as $unidade)
                 @if($unidade->id != 1)
                  <option id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>">{{ $unidade->sigla }}</option>
                 @endif
                @endforeach
            </select>
            </center>
            </td>
            <td>
                <input type="submit" id="pesquisar" name="pesquisar" class="btn btn-sm btn-info" value="Pesquisar"> 
                </td>
            </tr>
        </table>
        @endif
	    <table class="table">
            <tr>
              <td>
                  QUANTIDADE DE CONTRATOS:
              </td>
              <td>
                  <b>{{ $qtdContratos }}</b>
              </td>
            </tr>
            <tr>
              <td>
                  QUANTIDADE DE ADITIVOS:
              </td>
              <td>
                  <b>{{ $qtdAditivos }}</b>
              </td>
            </tr>
        </table>
</div>
@endsection