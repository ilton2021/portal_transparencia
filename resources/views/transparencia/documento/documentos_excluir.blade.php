@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">EXCLUIR DOCUMENTAÇÃO DE REGULARIDADE:</h3>
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
                        Documentação de Regularidade <i class="fas fa-check-circle"></i>
                    </a>
                </div>
                    <form method="post" action="{{ \Request::route('storeDR'), $unidade->id }}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-control mt-1" style="color:black">
						<div class="form-row mt-1">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label><strong>ID:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input class="form-control" readonly="true" style="width: 100px" type="text" id="id" name="id" value="<?php echo $documents->id; ?>" />
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label><strong>Título:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input class="form-control" readonly="true" style="width: 400px;" type="text" id="name" name="name" value="<?php echo $documents->name; ?>" />
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label><strong>Tipo de Documento:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									@if ($documents->type_id === 1)
									<input class="form-control" style="width: 400px;" id="type_id" name="type_id" value="CNPJ (OSS e Unidades Sob Gestão)" readonly="true" />
									@elseif ($documents->type_id === 2)
									<input class="form-control" style="width: 400px;" id="type_id" name="type_id" value="Fazenda Pública" readonly="true" />
									@elseif ($documents->type_id === 3)
									<input class="form-control" style="width: 400px;" id="type_id" name="type_id" value="Seguridade Social" readonly="true" />
									@elseif ($documents->type_id === 4)
									<input class="form-control" style="width: 400px;" id="type_id" name="type_id" value="FGTS" readonly="true" />
									@elseif ($documents->type_id === 5)
									<input class="form-control" style="width: 400px;" id="type_id" name="type_id" value="Justiça do Trabalho" readonly="true" />
									@elseif ($documents->type_id === 6)
									<input class="form-control" style="width: 400px;" id="type_id" name="type_id" value="CREMEPE" readonly="true" />
									@elseif ($documents->type_id === 7)
									<input class="form-control" style="width: 400px;" id="type_id" name="type_id" value="Qualificação Técnica - OSS" readonly="true" />
									@elseif ($documents->type_id === 8)
									<input class="form-control" style="width: 400px;" id="type_id" name="type_id" value="Experiência Anterior" readonly="true" />
									@elseif ($documents->type_id === 9)
									<input class="form-control" style="width: 400px;" id="type_id" name="type_id" value="CEBAS" readonly="true" />
									@endif
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label><strong>Arquivo:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input class="form-control" readonly="true" style="width: 400px;" type="text" id="path_file" name="path_file" value="<?php echo $documents->path_file; ?>" />
									<input type="hidden" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" />
								</div>
							</div>
						</div>
					</div>
					
					<table>
						 <tr>
						   <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
						   <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="documentosRegularidade" /> </td>
						   <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="excluirDocumentosRegularidade" /> </td>
						   <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
						 </tr>
					</table>
					
					<div class="form-control">
						<div class="d-flex justify-content-between">
							<div class="ml-2 mt-2" style="color:black">
								
								<h6> Deseja realmente Excluir este Documento de Regularidade?? </h6>
								
							</div>
						</div>
						<div class="d-flex justify-content-between">
							<div class="p-1">
								<a href="{{route('cadastroDR', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
							</div>
							<div class="p-1">
								<input type="submit" class="btn btn-danger btn-sm" style="margin-top: 10px;" value="Excluir" id="Salvar" name="Salvar" />
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