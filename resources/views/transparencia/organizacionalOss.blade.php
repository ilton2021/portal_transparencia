@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$undOss[0]->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-bottom: 25px; margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">ESTRUTURA ORGANIZACIONAL</h5>
		</div>
	</div>	
	<div class="row">
		<div class="col-md-12">
		    @if($qtd > 0)
    		    @if(empty($reg[0]))
    			<h3 style="font-size: 15px;"><strong>REGIMENTO INTERNO</strong></h3>
    			<h3 style="font-size: 12px;"></h3>
    			<ul class="list-inline">
    				
    				<li class="list-inline-item">
    					<h5 style="font-size: 12px;">Regimento Interno:</h5>
    				</li>
    			@else
    				<li class="list-inline-item">
    					<h5 style="font-size: 12px;">{{ $reg[0]->title }}</h5>
    				</li>
    			@endif
				<li class="list-inline-item"><a href="{{asset('storage')}}/{{$reg[0]->file_path}}" target="_blank" class="btn btn-success btn-sm"><i class="fas fa-file-download" style="margin-right: 5px;"></i>Download</a></li>
			@endif
				@if(Auth::check())
				 @foreach ($permissao_users as $permissao)
				  @if(($permissao->permissao_id == 2) && ($permissao->user_id == Auth::user()->id))
				   @if ($permissao->unidade_id == $undOss[0]->id)
				    <li class="list-inline-item"><a href="{{route('cadastroRE', $undOss[0]->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Alterar <i class="bi bi-paperclip"></i> </a></li>
				   @endif
				  @endif
				 @endforeach 
				@endif
			</ul>
		</div>
	</div>
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12">
			<div class="mt-3>
				<h3 style=" font-size: 15px;"><strong>ORGANOGRAMA</strong></h3>
			</div>
			<div class="mt-3>
				<h5 style=" font-size: 12px;">Estrutura Organizacional {{ stristr($undOss[0]->name, 'Unidade') == true || stristr($undOss[0]->name, 'Sociedade') == true ? 'da' : 'do'}} {{$undOss[0]->name}}</h5>

			</div>
            <li class="list-inline-item">
			    <h5 style="font-size: 12px;">Organograma do HCP Gestão (Clique no botão para abrir)</h5>
			</li>
			@if(sizeof($arqOrgano) > 0)
			<li class="list-inline-item"><a href="{{asset('storage')}}/{{$arqOrgano[0]->file_path}}" class="btn btn-success btn-sm" target="_blank"><i class="fas fa-file-download" style="margin-right: 5px;"></i>Download</a></li>
			@endif
				@if(Auth::check())
				 @foreach ($permissao_users as $permissao)
				  @if(($permissao->permissao_id == 2) && ($permissao->user_id == Auth::user()->id))
				   @if ($permissao->unidade_id == $undOss[0]->id)
    				<li class="list-inline-item"><a href="{{route('organograma', $undOss[0]->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Alterar <i class="bi bi-paperclip"></i> </a></li>
    			   @endif
    			  @endif
    			 @endforeach 
				@endif
			</ul>
			@if(Auth::check())
    			@foreach ($permissao_users as $permissao)
        			@if(($permissao->permissao_id == 2) && ($permissao->user_id == Auth::user()->id))
            			@if ($permissao->unidade_id == $undOss[0]->id)
            			<div class="mt-4">
				            <h3 style="font-size: 15px;"><strong>ESTRUTURA ORGANIZACIONAL</strong></h3>
			            </div>
            			@endif
        			@endif
    			@endforeach
			@endif
			@if($undOss[0]->id > 0)
			<div class="row" style="overflow: auto;">
			<table class="table table-sm" >
				<thead class="bg-success">
					<tr>
						<th scope="col">Cargo</th>
						<th scope="col">Nome</th>
						<th scope="col">E-mail</th>
						<th scope="col">Telefone</th>
					</tr>
				</thead>
				<tbody>
					@foreach($estruturaOrganizacional as $organizacional)
					<tr>
						<td style="font-size: 11px;">{{$organizacional->cargo}}</td>
						<td style="font-size: 11px;">{{$organizacional->name}}</td>
						<td style="font-size: 11px;">{{$organizacional->email}}</td>
						<td style="font-size: 11px;">{{$organizacional->telefone}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			</div>
			@if(Auth::check())
    			@foreach ($permissao_users as $permissao)
        			@if(($permissao->permissao_id == 2) && ($permissao->user_id == Auth::user()->id))
            			@if ($permissao->unidade_id == $undOss[0]->id)
            			<div class="d-flex justify-content-end">
            				<li class="list-inline-item"><a href="{{route('cadastroOR', $undOss[0]->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Alterar <i class="fas fa-edit"></i> </a></li>
            			</div>
            			@endif
        			@endif
    			@endforeach
			@endif
			@endif
		</div>
	</div>
</div>
</div>
</div>

@endsection