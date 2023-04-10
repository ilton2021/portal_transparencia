@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">MEMBROS DIRIGENTES</h5>
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
		<div class="col-md-12 col-sm-12">
			<div class="accordion" id="accordionExample">
				<div class="card">
					<div class="card-header d-flex flex-wrap justify-content-center justify-content-md-between" id="headingOne">
						<h5 class="mb-0">
							<a class="btn btn-link text-dark no-underline" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								CONSELHO FISCAL <i class="far fa-list-alt"></i>
							</a>
						</h5>
						<h5 class="mb-0"> 
							<li class="list-inline-item"><a id="Novo" name="Novo" type="button" class="btn btn-dark btn-sm" style="color: #FFFFFF;" href="{{route('novoCF', $unidade->id)}}"> Novo <i class="fas fa-check"></i> </a></li>	
							<a href="{{route('transparenciaMembros', ['id' => $unidade->id, 'escolha' => 'Conselho fiscal'])}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
						</h5>
					</div>
						    
						<div class="card-body">
							<div class="container text-center"><h5 style="font-size: 15px;"><strong>Estrutura Organizacional do Hospital de Câncer de Pernambuco - Conselho Fiscal</strong></h5></div>
							<div class="row">
								<div class="col-md-2 col-sm-0"></div>
								<div class="col-md-8 col-sm-12"  style="overflow:auto;">
									<table class="table table-sm">
										<thead >
											<tr class="text-center">
												<th class="border-bottom" scope="col">Nome</th>
												<th class="border-bottom" scope="col">Level</th>
												<th class="border-bottom" scope="col">Alterar</th>
												<th class="border-bottom" scope="col">Inativar</th>
												<!--th class="border-bottom" scope="col">Excluir</th-->
											</tr>
										</thead>
										@foreach($conselhoFiscs as $conselhoFisc)
										<tbody class="">
											<tr>
												<td style="font-size: 12px;">{{$conselhoFisc->name}}</td>
												<td style="font-size: 12px;">{{$conselhoFisc->level}}</td>
												<td> <center> <a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{route('alterarCF', array($unidade->id, $conselhoFisc->id))}}" ><i class="fas fa-edit"></i></a> </center> </td>
												@if($conselhoFisc->status_conselho_fiscs == 0)
												<td> <center> <a title="Ativar" class="btn btn-success btn-sm" style="color: #00000;" href="{{route('telaInativarCF', array($unidade->id, $conselhoFisc->id))}}" ><i class="fas fa-times-circle"></i></a> </center> </td>
												@else
												<td> <center> <a title="Inativar" class="btn btn-warning btn-sm" style="color: #00000;" href="{{route('telaInativarCF', array($unidade->id, $conselhoFisc->id))}}" ><i class="fas fa-times-circle"></i></a> </center> </td>
												@endif
												<!--td> <center> <a class="btn btn-danger btn-sm" style="color: #FFFFFF;" href="{{route('excluirCF', array($unidade->id, $conselhoFisc->id))}}" ><i class="bi bi-trash"></i></a> </center> </td-->
											</tr>
										</tbody>
										@endforeach	
									</table>
								</div>
								<div class="col-md-2 col-sm-0"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
@endsection