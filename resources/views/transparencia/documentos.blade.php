@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$undOss[0]->name}}</strong></div>
<div class="container-fluid" >
	<div class="row mt-3">
		<div class="col-md-12 text-center">
			<h5 style="font-size: 18px;">DOCUMENTAÇÃO DE REGULARIDADE</h5>
		</div>
		
		@if(Auth::check())
		@foreach ($permissao_users as $permissao)
		@if(($permissao->permissao_id == 4) && ($permissao->user_id == Auth::user()->id))
		@if ($permissao->unidade_id == $unidade->id)
		<div class="col-md-12 mt-1 text-center">
			<p><a href="{{route('cadastroDR', $unidade->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Alterar <i class="fas fa-edit"></i> </a></p>
		</div>
		@endif
		@endif
		@endforeach
		@endif
	
	</div>
	<div class="row" style="margin-top: 0px;">
		<div class="col-md-1"></div>
		<div class="col-md-10 text-center">
			@foreach($types as $type)
			<div class="accordion border-0" id="accordionExample">
				<div class="card">
					<div class="card-header border-0 p-2" id="headingOne" style="padding: 0px;">
						<h6>
							<a class="text-red no-underline text-wrap" type="button" data-toggle="collapse" data-target="#{{$type->id}}" aria-expanded="true" aria-controls="{{$type->id}}">
								{{$type->type_name}}
							</a>
						</h6>
					</div>
					<div id="{{$type->id}}" class="collapse {{$escolha == $type->type_name? 'show' : ''}}" aria-labelledby="headingOne" data-parent="#accordionExample">
						<div class="card-body d-flex flex-column justify-content-center justify-content-md-between">
							  <div class="d-sm-inline-flex text-sm-center flex-wrap justify-content-between">
								<div>
									@if($type->id == 1)
									@foreach($documents as $docs)
									@if($docs->type_id == $type->id)
									<center>
									<table class="table">
										<tr>
											<td style="width: 600px;">{{$docs->name}}</td>
											<td>
											  <i class="fas fa-arrow-right"></i>
											  <a href="{{asset('storage/')}}/{{$docs->path_file}}" target="_blank" class="badge badge-success">Download</a>
											</td>
										</tr>
									</table>
									</center>
									@endif
									@endforeach
									<table class="table">
									  
									  <tr>
										<td><b>Passo a Passo:</b></td>
										<td align="left">
											1) Digite o CNPJ da unidade no campo indicado; <br>
											2) Clique no Botão Sou Humano; <br>
											3) Por fim, clique no botão Consultar.
										</td>
									  </tr>
									  <tr>
										<td><b>Visualizar</b></td>
										<td>
										<section id="team" class="team section-bg">
										 <div class="container">
										  <div class="row">
										   <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
											<div class="member">
												<div class="member-img" style="width: 500px;">
												 <a href="{{asset('img/novas/cnpj.png')}}" title="Clique para Ampliar" data-gallery="portfolioGallery" class="portfolio-lightbox" title=""><img src="{{asset('img/novas/cnpj.png')}}" class="img-fluid" alt=""></a>
												 <div class="member-info"></div>
											    </div>
										    </div>
										   </div>
										  </div>
										 </div>
										</section>
										</td>
									  </tr>
									  <tr>
										<td><b>Como Acessar:</b></td>
										<td><a class="btn btn-success btn-sm" href="https://solucoes.receita.fazenda.gov.br/Servicos/cnpjreva/cnpjreva_solicitacao.asp" target="_blank">Clique aqui</a></td>
									  </tr>
									</table>
									
									@elseif($type->id == 2)
									<table class="table">
									  <tr>
										<td><b>Passo a Passo:</b></td>
										<td align="left">
										1) Tipo de Documento: Selecione CNPJ; <br>
										2) Digite o CNPJ da unidade; <br> 
										3) Clique no botão Localizar; <br>
										4) Clique no Botão Emitir; <br>
										5) Clique no botão Visualizar/Imprimir Documento.</td>
									  </tr>
									  <tr>
										<td><b>Visualizar</b></td>
										<td>
										<section id="team" class="team section-bg">
										 <div class="container">
										  <div class="row">
										   <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
											<div class="member">
												<div class="member-img" style="width: 500px;">
												 <a href="{{asset('img/novas/regularidade_fiscal.png')}}" title="Clique para Ampliar" data-gallery="portfolioGallery" class="portfolio-lightbox" title=""><img src="{{asset('img/novas/regularidade_fiscal.png')}}" class="img-fluid" alt=""></a>
												 <div class="member-info"></div>
											    </div>
										    </div>
										   </div>
										  </div>
										 </div>
										</section>
										</td>
									  </tr>
									  <tr>
										<td><b>Como Acessar:</b></td>
										<td><a class="btn btn-success btn-sm" href="https://efisco.sefaz.pe.gov.br/sfi_trb_gcc/PREmitirCertidaoRegularidadeFiscal" target="_blank">Clique aqui</a></td>
									  </tr>
									</table>
									@elseif($type->id == 3)
									<table class="table">
									 <tr>
										<td><b>Passo a Passo:</b></td>
										<td align="left">
										1) Digite o CNPJ da unidade no campo indicado; <br>
									  </tr>
									  <tr>
										<td><b>Visualizar</b></td>
										<td>
										<section id="team" class="team section-bg">
										 <div class="container">
										  <div class="row">
										   <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
											<div class="member">
												<div class="member-img" style="width: 500px;">
												 <a href="{{asset('img/novas/seguraridade_social.png')}}" title="Clique para Ampliar" data-gallery="portfolioGallery" class="portfolio-lightbox" title=""><img src="{{asset('img/novas/seguraridade_social.png')}}" class="img-fluid" alt=""></a>
												 <div class="member-info"></div>
											    </div>
										    </div>
										   </div>
										  </div>
										 </div>
										</section>
										</td>
									  </tr>
									  <tr>
										<td><b>Como Acessar:</b></td>
										<td><a class="btn btn-success btn-sm" href="https://solucoes.receita.fazenda.gov.br/Servicos/certidaointernet/PJ/Emitir" target="_blank">Clique aqui</a></td>
									  </tr>
									</table>
									@elseif($type->id == 4)
									<table class="table">
									  <tr>
										<td><b>Passo a Passo:</b></td>
										<td align="left">										
										1) Tipo de Inscrição: Selecione a opção CNPJ; <br>
										2) Digite o CNPJ da unidade no campo indicado; <br>
										3) Não é para ser preenchido o campo UF; <br>
										4) Digite os caracteres de confirmação; <br>
										5) Clique no Botão Consultar.</td>
									  </tr>
									  <tr>
										<td><b>Visualizar</b></td>
										<td>
										<section id="team" class="team section-bg">
										 <div class="container">
										  <div class="row">
										   <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
											<div class="member">
												<div class="member-img" style="width: 500px;">
												 <a href="{{asset('img/novas/fgts.png')}}" title="Clique para Ampliar" data-gallery="portfolioGallery" class="portfolio-lightbox" title=""><img src="{{asset('img/novas/fgts.png')}}" class="img-fluid" alt=""></a>
												 <div class="member-info"></div>
											    </div>
										    </div>
										   </div>
										  </div>
										 </div>
										</section>
										</td>
									  </tr>
									  <tr>
										<td><b>Como Acessar:</b></td>
										<td><a class="btn btn-success btn-sm" href="https://consulta-crf.caixa.gov.br/consultacrf/pages/consultaEmpregador.jsf" target="_blank">Clique aqui</a></td>
									  </tr>
									</table>
									@elseif($type->id == 5)
									<table class="table">
									  <tr>
										<td><b>Passo a Passo:</b></td>
										<td align="left">
										1) Clique na opção Emitir Certidão; <br>
										2) Digite o CNPJ da unidade no campo indicado; <br>
										3) Valide o reCAPTCHA (não sou um robô); <br>
										4) Clique na opção Emitir Certidão.</td>
									  </tr> 
									  <tr>
										<td><b>Visualizar</b></td>
										<td>
										<section id="team" class="team section-bg">
										 <div class="container">
										  <div class="row">
										   <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
											<div class="member">
												<div class="member-img" style="width: 500px;">
												 <a href="{{asset('img/novas/justica_trabalho.png')}}" title="Clique para Ampliar" data-gallery="portfolioGallery" class="portfolio-lightbox" title=""><img src="{{asset('img/novas/justica_trabalho.png')}}" class="img-fluid" alt=""></a>
												 <div class="member-info"></div>
											    </div>
										    </div>
										   </div>
										  </div>
										 </div>
										</section>
										</td>
									  </tr>
									  <tr>
										<td><b>Como Acessar:</b></td>
										<td><a class="btn btn-success btn-sm" href="https://www.tst.jus.br/web/guest/certidao" target="_blank">Clique aqui</a></td>
									  </tr>
									</table>
									@elseif($type->id == 6 || $type->id == 7 || $type->id == 8 || $type->id == 9)
									@foreach($documents as $docs)
									@if($docs->type_id == $type->id)
									<center>
									<table class="table">
										<tr>
											<td style="width: 600px;">{{$docs->name}}</td>
											<td>
											  <i class="fas fa-arrow-right"></i>
											  <a href="{{asset('storage/')}}/{{$docs->path_file}}" target="_blank" class="badge badge-success">Download</a>
											</td>
										</tr>
									</table>
									</center>
									@endif
									@endforeach
									@endif
								</div>
							  </div>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
		<div class="col-md-1"></div>
	</div>
</div>
  <script src="{{ asset('assets/vendor/purecounter/purecounter.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('assets/js/main.js') }}"></script>
@endsection