@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
    <div class="row" style="margin-bottom: 25px; margin-top: 25px;">
        <div class="col-md-12 text-center">
            <h5  style="font-size: 18px;">RELATÓRIO ASSISTENCIAL</h5>
			<p align="right"><a href="{{route('transparenciaAssistencial', array($unidade->id,1))}}" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>&nbsp;&nbsp;&nbsp;<a class="btn btn-dark btn-sm" style="color: #FFFFFF;" href="{{route('assistencialNovo', $unidade->id)}}"> Novo <i class="fas fa-check"></i> </a></li></p>
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
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="d-flex justify-content-around">
                @foreach($anosRef as $year)
                <button class="btn btn-success btn-lg " type="button" data-toggle="collapse" data-target="#{{$year}}" aria-expanded="false" aria-controls="{{$year}}">
                    {{$year}}
                </button>
                @endforeach
            </div>
            @foreach($anosRef as $year)
            <div class="collapse border-0" id="{{$year}}" style="margin-top: 8px;">
                <div class="card border-0 card-body" style="background-color: #fafafa;">
                    <div class="d-flex justify-content-around text-center">
                        <div class="col-md-6">
                            <div class="container" style="margin-bottom: 10px;">
                                <h5 class="text-success"><strong>{{$year}}</strong></h5>
                            </div>
                            <a  class="text-success" href="{{route('exportAssistencialMensal',['id'=> $unidade->id, 'year'=> $year])}}" title="Download"><img src="{{asset('img/csv.png')}}" alt="" width="60"></a>
                        </div>
                        <div class="col-md-6">
                            <div class="container" style="margin-bottom: 10px;">
                                <h5 class="text-danger"><strong>{{$year}}</strong></h5>
								<a  class="text-danger" href="{{route('assistencialPdf',['id'=> $unidade->id, 'year'=> $year])}}" title="Download"><img src="{{asset('img/pdf.png')}}" alt="" width="60"></a>
                            </div>
                        </div>
						<div class="col-md-6">
							<h5 class="text-danger"><strong>{{$year}}</strong></h5>
							<a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{route('assistencialNovo', array($unidade->id, 'year'=> $year))}}" > <i class="fas fa-edit"></i></a>
	    					<a class="btn btn-danger btn-sm" style="color: #FFFFFF;" href="{{route('assistencialExcluir', array($unidade->id, 'year'=> $year))}}" > <i class="fas fa-times-circle"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="col-md-2"></div>
    </div>
</div>
@endsection