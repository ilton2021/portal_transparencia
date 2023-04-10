@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;"> COMPETÊNCIAS</h3>
		</div>
	</div>
    @if ($errors->any())
      <div class="alert alert-success">
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
                        Matriz de competência <i class="fas fa-check-circle"></i>
						</a>
				</div>
                    <form method="post" action="{{ \Request::route('updateCP', $competenciasMatriz[0]->id) }}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-control mt-1" style="color:black">
							<div class="form-row mt-2">
								<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
									<div class="col-md-2 mr-2">
										<input type="hidden" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" />
										<label><strong>Setor:</strong></label>
									</div>
									<div class="col-md-10 mr-2">
										<input class="form-control" style="max-width: 400px;" readonly="true" type="text" id="setor" name="setor" value="<?php echo $competenciasMatriz[0]->setor; ?>" />
									</div>
								</div>
							</div>
							<div class="form-row mt-2">
								<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
									<div class="col-md-2 mr-2">
										<input type="hidden" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" />
										<label><strong>Cargo:</strong></label>
									</div>
									<div class="col-md-10 mr-2">
										<input class="form-control" style="max-width: 400px;" readonly="true" type="text" id="cargo" name="cargo" value="<?php echo $competenciasMatriz[0]->cargo; ?>" />
									</div>
								</div>
							</div>
							<div class="form-row mt-2">
								<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
									<div class="col-md-2 mr-2">
										<input type="hidden" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" />
										<label><strong>Descrição:</strong></label>
									</div>
									<div class="col-md-10 mr-2">
										<textarea class="form-control" type="textarea" readonly="true" cols="10" rows="10" id="descricao" name="descricao" value=""><?php echo $competenciasMatriz[0]->descricao; ?></textarea>
									</div>
								</div>
							</div>
						</div>
						</div>
						<div class="d-flex justify-content-around form-control mt-2">
							<div class="p-2">
								<a href="{{route('transparenciaCompetencia', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
							</div>
							<div class="p-2">
								<a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{route('alterarCP', array($unidade->id, $competenciasMatriz[0]->id))}}"> Alterar <i class="fas fa-edit"></i></a>
							</div>
							<div class="p-2">
							  @if($competenciasMatriz[0]->status_competencias == 0)
								<a class="btn btn-success btn-sm" style="color: #000000;" href="{{route('telaInativarCP', array($unidade->id, $competenciasMatriz[0]->id))}}"> Ativar <i class="fas fa-times-circle"></i></a>
							  @else
								<a class="btn btn-warning btn-sm" style="color: #000000;" href="{{route('telaInativarCP', array($unidade->id, $competenciasMatriz[0]->id))}}"> Inativar <i class="fas fa-times-circle"></i></a>
							  @endif
							</div>
							<!--div class="p-2">
								<a class="btn btn-danger btn-sm" style="color: #FFFFFF;" href="{{route('excluirCP', array($unidade->id, $competenciasMatriz[0]->id))}}"> Excluir <i class="bi bi-trash"></i></a>
							</div-->
						</div>
					
                </div>
            </div>
        </div>
		<div class="col-md-0 col-sm-0"></div>
    </div>
</div>
@endsection