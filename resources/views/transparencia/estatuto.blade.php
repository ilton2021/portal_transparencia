@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$undOss[0]->name}}</strong></div>
<div class="d-flex flex-column text-center mt-3">
	<h5 style="font-size: 18px;">ESTATUTO SOCIAL E ATAS DO ESTATUTO SOCIAL</h5>
			@if(Auth::check())
			 @foreach ($permissao_users as $permissao)
			  @if(($permissao->permissao_id == 14) && ($permissao->user_id == Auth::user()->id))
			   @if ($permissao->unidade_id == $unidade->id)
                <div>
	            	<a href="{{route('cadastroES', $undOss[0]->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Alterar <i class="fas fa-edit"></i> </a></p>
            	</div>
			   @endif 
			  @endif
		     @endforeach		
			@endif
			<div class="row">
			    <div class="col-md-10 offset-md-1 text-center">
			        <ul class="list-group">
    				@foreach($estatutos as $estatuto)
    				<li class="list-group-item d-flex flex-wrap justify-content-center justify-content-sm-between align-items-center border-top" style="background-color: #fafafa">
					<div style="font-size: 14px;">
    			    	<strong>{{$estatuto->name}}</strong>
    			   	</div>
    			   	<div class="ml-2">
    			    	<a href="{{asset('storage')}}/{{$estatuto->path_file}}" target="_blank" class="btn btn-success btn-sm" style="font-size: 12px;">Download <i class="fas fa-file-download" style="margin-left: 5px;"></i></a>
    			  	<div>
    			  	</li>
    				@endforeach
			</ul>
		</div>
	</div>
</div>
@endsection