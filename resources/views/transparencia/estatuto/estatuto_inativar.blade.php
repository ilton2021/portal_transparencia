@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
		  @if($estatutos->status_estatuto == 0)
			<h3 style="font-size: 18px;"> ATIVAR ESTATUTOS SOCIAL E ATAS:</h3>
		  @else
		    <h3 style="font-size: 18px;"> INATIVAR ESTATUTOS SOCIAL E ATAS:</h3>
		  @endif
		</div>
	</div>
	@if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div>
	@endif 
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-0 col-sm-0"></div>
		<div class="col-md-12 col-sm-12 text-center">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
                        Estatuto Social e Atas do Estatuto Social <i class="fas fa-check-circle"></i>
                    </a>
                </div>
                    <form method="post" action="{{ \Request::route('inativarES'), $unidade->id }}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-control mt-3" style="color:black">
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<labe><strong>Título:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input class="form-control" style="max-width: 500px;" type="text" id="name" name="name" value="<?php echo $estatutos->name; ?>" readonly="true" />
								</div>
							</div>
						</div>
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<labe><strong>Arquivo:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input class="form-control" style="max-width: 600px;" type="text" id="path_file" name="path_file" value="<?php echo $estatutos->path_file; ?>" readonly="true" />
								</div>
							</div>
						</div>
					</div>
                    <table>
						<tr>
							<td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
							<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="estatutoAta" /> </td>
							 @if($estatutos->status_estatuto == 0)
							  <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="AtivarEstatutoAta" /> </td>
							 @else
							  <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="InativarEstatutoAta" /> </td>
							 @endif
							<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
						</tr>
					</table>
					<div class="form-control">
						<div class="d-flex justify-content-between">
							<div class="ml-2" style="color:black">
								<p>
								<strong><h6>Deseja realmente Inativar este Estatuto/Ata?? </h6></strong>
								</p>
							</div>
						</div>
						<div class="d-flex justify-content-between">
							<div class="p-2">
								<a href="{{route('cadastroES', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
							</div>
							<div class="p-2">
							   @if($estatutos->status_estatuto == 0)
								<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Ativar" id="Ativar" name="Ativar" />
							   @else
							    <input type="submit" class="btn btn-primary btn-sm" style="margin-top: 10px;" value="Inativar" id="Inativar" name="Inativar" />
                               @endif
							</div>
						</div>
					</div>
                  </div>
            </div>
        </div>
		<div class="col-md-0 col-sm-0"></div>
    </div>
</div>
@endsection