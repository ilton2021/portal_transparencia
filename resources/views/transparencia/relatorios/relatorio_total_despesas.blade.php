@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
  <div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">RELATÓRIO - TOTAL DE DESPESAS</h3>
            <p style="margin-right: -800px;"><a href="{{route('relatorios', $unidade->id)}}" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a></p>
			<BR><BR>
		</div>
	</div>
    <table class="table">
    <form action="{{route('relatorioPesquisaDespesas', $unidade->id)}}" method="POST">
	  <input type="hidden" name="_token" value="{{ csrf_token() }}">    
            <tr>
              <td> Mês:
                <select id="mes" name="mes" class="form-control">
                  <option id="mes" name="mes" value="">Selecione..</option>
                  <option id="mes" name="mes" value="1">JANEIRO</option>    
                  <option id="mes" name="mes" value="2">FEVEREIRO</option>    
                  <option id="mes" name="mes" value="3">MARÇO</option>    
                  <option id="mes" name="mes" value="4">ABRIL</option>    
                  <option id="mes" name="mes" value="5">MAIO</option>    
                  <option id="mes" name="mes" value="6">JUNHO</option>    
                  <option id="mes" name="mes" value="7">JULHO</option>    
                  <option id="mes" name="mes" value="8">AGOSTO</option>    
                  <option id="mes" name="mes" value="9">SETEMBRO</option>    
                  <option id="mes" name="mes" value="10">OUTUBRO</option>    
                  <option id="mes" name="mes" value="11">NOVEMBRO</option>    
                  <option id="mes" name="mes" value="12">DEZEMBRO</option>    
                </select>
              </td>
              <td> Ano: <?php $ano = date('Y', strtotime('now')); ?>
                <select id="ano" name="ano" class="form-control" required>
                  <option id="ano" name="ano" value="">Selecione..</option>
                  @for($a = 2016; $a <= $ano; $a++)
                    <option id="ano" name="ano" value="<?php echo $a; ?>">{{ $a }}</option>   
                  @endfor
                </select>
              </td>
              <td>
                <input type="submit" class="btn btn-primary btn-sm" style="margin-top: 10px;" value="Pesquisar" id="Pesquisar" name="Pesquisar" /> </td>
              </td>
            </tr>
    </form>
    </table>    
    <table class="table">
      <tr>
        <td>
          QUANTIDADE DE DESPESAS:
        </td>
        <td colspan="2">
          <b><?php echo "R$ ".$qtd; ?></b>
        </td>
      </tr>
    </table>
</div>
@endsection