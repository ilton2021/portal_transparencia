@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
    @if ($errors->any())
      <div class="alert alert-success">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div>
	@endif 
<div class="d-flex flex-column text-center mt-3">
	<h5 style="font-size: 16px;">ESTATUTO SOCIAL E ATAS DO ESTATUTO SOCIAL</h5>
	<div class="d-inline-flex justify-content-around">
		<div class="p-2">
			<a href="{{route('transparenciaEstatuto', $unidade->id)}}" class="btn btn-warning btn-sm " style="color: #FFFFFF;"><i class="bi bi-reply-fill"></i> Voltar </a>
		</div>
		<div class="p-2">
			<a href="{{route('novoES', $unidade->id)}}" class="btn btn-dark btn-sm" style="color: #FFFFFF;"> Novo <i class="fas fa-check"></i> </a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8 offset-md-2 text-center">
			<ul class="list-group">
				@foreach($estatutos as $estatuto)
				<li class="list-group-item d-inline-flex flex-wrap justify-content-center justify-content-sm-between align-items-center border-top" style="background-color: #fafafa">
					<div style="font-size:14px;">
						<strong>{{$estatuto->name}}</strong>
					</div>
					<div class="d-flex nowrap">
						<div class="p-1">
							<a href="{{asset('storage/')}}/{{$estatuto->path_file}}" target="_blank" class="btn btn-success btn-sm" style="font-size: 12px;">Download <i class="fas fa-file-download"></i></a>
						</div>
						<div class="p-1">
						   @if($estatuto->status_estatuto == 0)
						    <center> <a title="Ativar" class="btn btn-success btn-sm" style="color: #000000;" href="{{route('telaInativarES', array($unidade->id, $estatuto->id))}}"><i class="fas fa-times-circle"></i></a> </center>
						   @else
						    <center> <a title="Inativar" class="btn btn-warning btn-sm" style="color: #000000;" href="{{route('telaInativarES', array($unidade->id, $estatuto->id))}}"><i class="fas fa-times-circle"></i></a> </center>
						   @endif
						</div>
						<!--div class="p-1">
							<center> <a class="btn btn-danger btn-sm" style="color: #FFFFFF;" href="{{route('excluirES', array($unidade->id, $estatuto->id))}}"><i class="bi bi-trash"></i></a> </center>
						</div-->
					</div>
			  	</li>
				@endforeach
			</ul>
		</div>
	</div>
</div>

@endsection