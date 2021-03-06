@extends('navbar.default-navbar')
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>	
  <link href="{{ asset('js/utils.js') }}" rel="stylesheet">
  <link href="{{ asset('js/bootstrap.js') }}" rel="stylesheet">


<script>
document.addEventListener('keydown', function(event) { //pega o evento de precionar uma tecla
	  if(event.keyCode != 46 && event.keyCode != 8){//verifica se a tecla precionada nao e um backspace e delete
		var i = document.getElementById("telefone").value.length; //aqui pega o tamanho do input
		if (i === 0)
		  document.getElementById("telefone").value = document.getElementById("telefone").value + "(";
		if (i === 3)
		  document.getElementById("telefone").value = document.getElementById("telefone").value + ")";
		if (i === 8) //aqui faz a divisoes colocando um ponto no terceiro e setimo indice
		  document.getElementById("telefone").value = document.getElementById("telefone").value + "-";
	  }
      document.addEventListener('keydown', function(event) { //pega o evento de precionar uma tecla
	  if(event.keyCode != 46 && event.keyCode != 8){//verifica se a tecla precionada nao e um backspace e delete
		var i = document.getElementById("cnpj").value.length; //aqui pega o tamanho do input
		if (i === 2)
		  document.getElementById("cnpj").value = document.getElementById("cnpj").value + ".";
		if (i === 6)
		  document.getElementById("cnpj").value = document.getElementById("cnpj").value + ".";
		if (i === 11) //aqui faz a divisoes colocando um ponto no terceiro e setimo indice
		  document.getElementById("cnpj").value = document.getElementById("cnpj").value + "/";
	  
		if (i === 15) //aqui faz a divisoes colocando um ponto no terceiro e setimo indice
		  document.getElementById("cnpj").value = document.getElementById("cnpj").value + "-";
	 
	  } 
	});
</script>

</head>


<meta name="csrf-token" content="{{ csrf_token() }}">
	@if ($errors->any())
      <div class="alert alert-success">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div>
	@endif 
<div class="container text-center" style="color: #28a745">Voc?? est?? em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
    <div class="row" style="margin-top: 25px;">
        <div class="col-md-12 text-center">
            <h3 style="font-size: 18px;">INSTITUCIONAL</h3>
				@if(Auth::check())
				 @foreach ($permissao_users as $permissao)
					@if(($permissao->permissao_id == 1) && ($permissao->user_id == Auth::user()->id))
					  @if ($permissao->unidade_id == $unidade->id)
			             <p style="margin-right: -930px"><a class="btn btn-dark btn-sm" style="margin-top: 10px;" href="{{route('institucionalNovo', $unidade->id)}}"> Novo <i class="fas fa-check"></i> </a></p>
			          @endif
			        @endif
			     @endforeach   
				@endif
		</div>
    </div>
	<form action="{{\Request::route('update',$unidade->id)}}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="col-md-7" style="font-size: 13px;">  
            <table class="table-sm" style="line-height: 1.5;">
                <tbody>
	                 <tr>
                        <td style="border-top: none;"><strong>Perfil: </strong></td>
                        <td style="border-top: none;" id="txtPerfil">{{$unidade->owner}}</td>
				    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>CNPJ: </strong></td>
                        <td style="border-top: none;" id="txtCnpj">{{ preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})/", "\$1.\$2.\$3/\$4\$5-", $unidade->cnpj)}}</td>
				    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>Nome Unidade: </strong></td>
                        <td style="border-top: none;" id="txtNome">{{$unidade->name}}</td>
				    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>Logradouro: </strong></td>
                        <td style="border-top: none;" id="txtLogradouro">{{$unidade->address}} , {{$unidade->numero == null ? ' s/n' : $unidade->numero}}</td>
				    </tr>
                    @if(isset($unidade->further_info) || $unidade->further_info !== null)
                    <tr>
                        <td style="border-top: none;"><strong>Complemento: </strong></td>
                        <td style="border-top: none;" id="txtComplemento">{{$unidade->further_info}}</td>
				    </tr>
                    @endif
                    <tr>
                        <td style="border-top: none;"><strong>Bairro: </strong></td>
                        <td style="border-top: none;" id="txtBairro">{{$unidade->district}}</td>
				    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>Cidade: </strong></td>
                        <td style="border-top: none;" id="txtCity">{{$unidade->city}}</td>
				    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>UF: </strong></td>
                        <td style="border-top: none;" id="txtUf">{{$unidade->uf}}</td>
				    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>CEP: </strong></td>
                        <td style="border-top: none;" id="txtCep">{{preg_replace("/(\d{2})(\d{3})/", "\$1.\$2-", $unidade->cep)}}</td>
				    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>Telefone: </strong></td>
                        <td style="border-top: none;" id="txtTelefone">{{preg_replace("/(\d{4})(\d{4})/", "\$1-\$2", $unidade->telefone)}}</td>
				    </tr>
                    <tr>
                        <td style="border-top: none;"><strong>Hor??rio: </strong></td>
                        <td style="border-top: none;" id="txtHorario">{{$unidade->time}}</td>
				    </tr>
                    @if(isset($unidade->cnes) || $unidade->cnes !== null)
                    <tr>
                        <td style="border-top: none;"><strong>CNES: </strong></td>
                        <td style="border-top: none;" id="txtCnes">{{$unidade->cnes}}</td>
				    </tr>
                    @endif

                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <div style="height: 30px;">
                <div class="h-25 d-inline-block" style="width: 120px;"></div>
            </div>
            @if($unidade->id == 8)
			 <div class="mapouter"><div class="gmap_canvas"><iframe width="400" height="250" frameborder="0" style="border:0;" allowfullscreen="" id="gmap_canvas" src="https://maps.google.com/maps?q=hospital%20provisorio%20do%20recife%201&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe><a href="https://www.embedgooglemap.net/blog/divi-discount-code-elegant-themes-coupon/"></a></div><style></style></div>	
			@else
             <iframe src="{{$unidade->google_maps}}" width="400" height="250" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
			@endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-12"  style="font-size: 13px;">
            <table style="line-height: 1.5;">
                <tbody>
                    @if(isset($unidade->capacity) || $unidade->capacity !== null)
                    <tr>
                        <td class="text-justify" style="border-top: none;" colspan="2" id="txtCapacity"><strong>Capacidade: </strong>{!! $unidade->capacity !!}</td>
				    </tr>
					<tr>
						&nbsp;&nbsp;&nbsp;&nbsp;
					</tr>
                    @endif
                    @if(isset($unidade->specialty) || $unidade->specialty !== null)
                    <tr>
                        <td class="text-justify" style="border-top: none;" colspan="2" id="txtSpecialty"><strong>Especialidades: </strong>{!!$unidade->specialty!!}</td>
				    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <br>
    <div class="col-md-8">
            @if($unidade->id == 8)
             <h3 style="font-size: 18px;">INFORMA????ES SOBRE A UNIDADE DE SA??DE: </h3>
			  <h3 style="font-size: 18px;">HOSPITAL DE CAMPANHA AURORA</h3> <br>
			  <p style="color:#28a745;"><strong>1.	INTRODU????O</strong></p>

			  <p align="justify" style="color:#28a745;">O modelo de Organiza????o Social de Sa??de, a ser adotado para gest??o do HOSPITAL DE CAMPANHA AURORA, 
			     busca a modernidade e o aprimoramento da efici??ncia na presta????o dos servi??os p??blicos de sa??de, tendo por objetivos: </p>
			  <p align="justify" style="color:#28a745;">???	Potencializar a qualidade na execu????o dos servi??os de sa??de e atendimento ?? popula????o 
				    com suspeita ou diagnosticada com o novo Coronav??rus (Covid - 19 / S??ndrome 
					Respirat??ria Aguda Grave - SRAG). </p>
			  <p align="justify" style="color:#28a745;">???	Ampliar a capacidade de atendimento, com oferta de leitos cl??nicos e de unidade de 
					terapia intensiva exclusivos para atendimentos aos pacientes com suspeita ou 
					diagnosticados com o novo Coronav??rus (Covid - 19 / S??ndrome Respirat??ria Aguda 
					Grave - SRAG);</p>
			  <p align="justify" style="color:#28a745;">???	Melhorar o servi??o ofertado ao usu??rio SUS com assist??ncia humanizada. </p>

			  <p style="color:#28a745;">2.	INFORMA????ES SOBRE A UNIDADE A SER GERIDA PELA OSS</p>

			  <p style="color:#28a745;">HOSPITAL DE CAMPANHA AURORA</p>

			  <p align="justify" style="color:#28a745;">O HOSPITAL DE CAMPANHA AURORA, situado na Rua da Aurora, 1675,
				Santo Amaro, Recife/PE.</p>

			  <p style="color:#28a745;">3.	SERVI??OS </p>

			  <p align="justify" style="color:#28a745;">0 HOSPITAL DE CAMPANHA AURORA ser?? estruturado com perfil de 
				 hospital de grande porte, 160 leitos aptos a realizar procedimentos de m??dia e alta 
				 complexidade para atendimento exclusivo aos pacientes suspeitos ou diagnosticados com o 
				 novo Coronav??rus (Covid - 19/ S??ndrome Respirat??ria Aguda Grave - SRAG) atrav??s de Cuidados 
				 Intensivos e Interna????o, em regime de demanda regulada pelo Munic??pio do Recife. </p>
			  <p align="justify" style="color:#28a745;">3.1.	Servi??o de Apoio Diagn??stico e Terap??utico - SADT A unidade hospitalar dever?? 
						disponibilizar exames e a????es de apoio diagn??stico e terap??utico a pacientes atendidos em 
						regime de Interna????o em leitos cl??nicos e de unidade terapia intensiva. </p>
			  <p style="color:#28a745;">3.2.	Interna????o </p>

			  <p align="justify" style="color:#28a745;">O hospital funcionar?? com capacidade operacional para 160 leitos de interna????o assim 
				 distribu??dos:</p>
			  <p style="color:#28a745;">???	60 leitos cl??nicos de enfermaria de isolamento; </p>
			  <p style="color:#28a745;">???	100 leitos de Unidade de Terapia Intensiva ??? UTI Geral. </p>
			  <p align="justify" style="color:#28a745;">Todos os leitos do hospital dever??o estar disponibilizados para a Central de Regula????o Leitos do 
				 Estado. </p>
				 
			  <p style="color:#28a745;">3.2.1.	ASSIST??NCIA HOSPITALAR</p>

			  <p align="justify" style="color:#28a745;">A assist??ncia ?? sa??de prestada em regime de hospitaliza????o compreende o conjunto de 
				 atendimentos oferecidos ao paciente suspeito ou diagnosticado com o novo Coronav??rus (Covid
				 - 19/ S??ndrome Respirat??ria Aguda Grave - SRAG), desde sua admiss??o no hospital at?? sua alta 
				 hospitalar, incluindo-se a?? todos os atendimentos e procedimentos necess??rios para obter ou 
				 completar o diagn??stico e as terap??uticas necess??rias para o tratamento no ??mbito hospitalar. 
				 No processo de hospitaliza????o est??o inclu??dos: </p>
			 <p align="justify" style="color:#28a745;">3.2.2.	Tratamento das poss??veis complica????es que possam ocorrer ao longo do processo 
						assistencial, tanto na fase de tratamento, quanto na fase de recupera????o. </p>
			 <p align="justify" style="color:#28a745;">3.2.3.	Tratamentos concomitantes, diferentes daquele classificado como diagn??stico 
						principal que motivaram a interna????o do paciente, que podem ser necess??rios, 
						adicionalmente, devido ??s condi????es especiais do paciente e/ou outras causas. </p>
			 <p align="justify" style="color:#28a745;">3.2.4.	Tratamento medicamentoso que seja requerido durante o processo de interna????o.</p>
			 <p align="justify" style="color:#28a745;">3.2.5.	Procedimentos e cuidados de enfermagem, necess??rios durante o processo de 
						interna????o.</p>
			 <p align="justify" style="color:#28a745;">3.2.6.	Alimenta????o, inclu??da a assist??ncia nutricional, alimenta????o enteral e parenteral. </p>
			 <p align="justify" style="color:#28a745;">3.2.7.	Assist??ncia por equipe m??dica especializada, pessoal de enfermagem e pessoal t??cnico. </p>
			 <p align="justify" style="color:#28a745;">3.2.8.	O material descart??vel necess??rio para os cuidados de enfermagem e tratamentos. </p>

			 <p align="justify" style="color:#28a745;">3.2.9.	Di??rias de hospitaliza????o em quarto compartilhado ou individual, quando necess??rio, 
						devido ??s condi????es especiais do paciente e quarto de isolamento. </p>
			 <p style="color:#28a745;">3.2.10.	Sangue e hemoderivados. </p>
			 <p style="color:#28a745;">3.2.11.	Hemodi??lise para os pacientes internados. </p>
			 <p style="color:#28a745;">3.2.12.	Fornecimento de roupas hospitalares. </p>
			 <p align="justify" style="color:#28a745;">3.2.13. Procedimentos especiais que se fizerem necess??rios ao adequado atendimento e 
						tratamento do paciente, de acordo com a capacidade instalada, respeitando a 
						complexidade e o perfil estabelecido para o HOSPITAL DE CAMPANHA AURORA </p>
			@endif
        </div>
	<br>
	<table>
		<tr>
			<td>
				<a href="{{route('transparenciaInstitucionalPdf', $unidade->id)}}" target="__blank" class="btn btn-success btn-sm" style="margin-top: 10px;">Download <i class="fas fa-file-pdf"></i></a>
			</td>
			<td> 
				@if(Auth::check())
				 @foreach ($permissao_users as $permissao)
					@if(($permissao->permissao_id == 1) && ($permissao->user_id == Auth::user()->id))
					  @if ($permissao->unidade_id == $unidade->id)
			             <a class="btn btn-info btn-sm" style="margin-top: 10px;" href="{{route('institucionalCadastro', $unidade->id)}}"> Alterar <i class="fas fa-edit"></i></a>
			          @endif
			        @endif
			     @endforeach   
				@endif
			</td>
		</tr>
	</table>
	</form>
</div>
</div>
</div>

@endsection
