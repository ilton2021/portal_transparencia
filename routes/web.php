<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', 'IndexController@index')->name('welcome');
Route::get('/rp', 'IndexController@rp')->name('rp');
Route::get('/rp2/{id}', 'IndexController@rp2')->name('rp2');
Route::get('/rp3/{id}', 'IndexController@rp3')->name('rp3');
Route::get('/rp4/{id}', 'IndexController@rp4')->name('rp4');

Route::prefix('transparencia')->group( function(){
	Route::get('/{id}', 'IndexController@transparenciaHome')->name('transparenciaHome');
	Route::get('/Oss/{id}', 'IndexController@transparenciaHomeOss')->name('transparenciaHomeOss');
	Route::get('associados/export', 'IndexController@exportAssociados')->name('exportAssociados');
    Route::get('conselhoadmin/export', 'IndexController@exportConselhoAdm')->name('exportConselhoAdm');
    Route::get('conselhofisc/export', 'IndexController@exportConselhoFisc')->name('exportConselhoFisc');
    Route::get('superintendente/export', 'IndexController@exportSuperintendente')->name('exportSuperintendente');
    Route::get('estatuto/{id}', 'IndexController@transparenciaEstatuto')->name('transparenciaEstatuto');
    Route::get('documentos/{id}/{escolha}', 'IndexController@transparenciaDocumento')->name('transparenciaDocumento');
    Route::get('organizacional/{id}', 'IndexController@transparenciaOrganizacional')->name('transparenciaOrganizacional');
    Route::get('organizacional/Oss/{id}', 'IndexController@transparenciaOrganizacionalOss')->name('transparenciaOrganizacionalOss');
    Route::get('decreto/{id}', 'IndexController@transparenciaDecreto')->name('transparenciaDecreto');
    Route::get('manual/{id}', 'IndexController@transparenciaManual')->name('transparenciaManual');
    Route::get('pregao/{id}', 'IndexController@transparenciaPregao')->name('transparenciaPregao');
    Route::get('contratos-gestao/{id}/{escolha}', 'IndexController@transparenciaContratoGestao')->name('transparenciaContratoGestao');
    Route::get('despesas/{id}', 'IndexController@transparenciaDespesas')->name('transparenciaDespesas');
    Route::get('regulamento/{id}', 'IndexController@transparenciaRegulamento')->name('transparenciaRegulamento');
    Route::get('assistencial/{id}', 'IndexController@transparenciaAssistencial')->name('transparenciaAssistencial');
    Route::get('assistencial/export/{id}/{year}', 'IndexController@exportAssistencialMensal')->name('exportAssistencialMensal');
    Route::get('assistencial/export/{id}', 'IndexController@exportAssistencialAnual')->name('exportAssistencialAnual');
	Route::get('assistencial/{id}/visualizar', 'IndexController@visualizarAssistencial')->name('visualizarAssistencial');
    Route::get('institucional/{id}', 'IndexController@transparenciaInstitucionalPdf')->name('transparenciaInstitucionalPdf');
    Route::get('competencia/{id}', 'IndexController@transparenciaCompetencia')->name('transparenciaCompetencia');
	Route::get('relatorioGerencial/{id}', 'IndexController@transparenciaRelatorioGerencial')->name('transparenciaRelatorioGerencial');
    Route::get('relatorio-financeiro/{id}','IndexController@transparenciaFinanReports')->name('transparenciaFinanReports');
    Route::get('demonstrativo-financeiro/{id}','IndexController@transparenciaDemonstrative')->name('transparenciaDemonstrative');
    Route::get('demonstrativo-contabel/{id}','IndexController@transparenciaAccountable')->name('transparenciaAccountable');
	Route::get('membros/{id}/{escolha}', 'IndexController@transparenciaMembros')->name('transparenciaMembros');
    Route::get('repasses-recebidos/{id}','IndexController@transparenciaRepasses')->name('transparenciaRepasses');
    Route::get('repasses/export/{id}/{year}', 'IndexController@repassesExport')->name('repassesExport');
	Route::get('repasses-recebidos/export/{id}/{year}', 'IndexController@repassesSomExport')->name('repassesSomExport');
    Route::get('contratacao/{id}','IndexController@transparenciaContratacao')->name('transparenciaContratacao');
	Route::get('contratacao/{id}/pesquisarMesCotacao/{mes}/{ano}','IndexController@pesquisarMesCotacao')->name('pesquisarMesCotacao');
    Route::get('recursos-humanos/{id}','IndexController@transparenciaRecursosHumanos')->name('transparenciaRecursosHumanos');
	Route::get('bens-publicos/{id_und}', 'IndexController@transparenciaBensPublicos')->name('transparenciaBensPublicos');
	Route::get('pdf/assistencial/{id}/{year}','IndexController@assistencialPdf')->name('assistencialPdf'); 
	Route::get('covenio/{id}','IndexController@transparenciaCovenio')->name('transparenciaCovenio');
	Route::get('relcontasAtual/{id}','IndexController@transparenciaContasAtual')->name('transparenciaContasAtual');
	Route::get('relmensalExecucao/{id}','IndexController@transparenciaRelMensalExecucao')->name('transparenciaRelMensalExecucao');
	Route::get('relfinanceiroExercicio/{id}','IndexController@transparenciaMensalFinanceiroExercico')->name('transparenciaMensalFinanceiroExercico');
	Route::get('resultadoProcessosCotacao/{id}','IndexController@transparenciaProcessoCotacao')->name('transparenciaProcessoCotacao');
	Route::get('ouvidoria/{id}','IndexController@transparenciaOuvidoria')->name('transparenciaOuvidoria');
	Route::get('home_compras/ordem_compra/ordemCompraVisualizar/{id}','IndexController@visualizarOrdemCompra')->name('visualizarOrdemCompra');
	Route::post('home_compras/ordem_compra/ordemCompraVisualizar/{id}','IndexController@procuraVisualizarOrdemCompra')->name('procuraVisualizarOrdemCompra');
	Route::get('recursos-humanos/{id}/selecaoPcadastro/despesasUsuarioRH','IndexController@despesasUsuarioRH')->name('despesasUsuarioRH');
	Route::post('recursos-humanos/{id}/selecaoPcadastro/despesasRH','IndexController@despesasUsuarioRHProcurar')->name('despesasUsuarioRHProcurar');
});

Auth::routes();

Route::get('auth/login','UserController@telaLogin')->name('telaLogin');
Route::get('auth/login/reset','UserController@telaEmail')->name('telaEmail');
//Route::get('auth/register', 'UserController@telaRegistro')->name('telaRegistro');
//Route::post('auth/register', 'UserController@store')->name('store');
Route::get('auth/passwords/email', 'UserController@telaEmail')->name('telaEmail');
Route::post('auth/login', 'UserController@Login')->name('Login');
Route::get('auth/login/emailreset', 'UserController@emailReset')->name('emailReset');
Route::post('auth/login/emailreset','UserController@emailReset')->name('emailReset');
Route::get('auth/passwords/reset', 'UserController@telaReset')->name('telaReset');
Route::post('auth/passwords/reset','UserController@resetarSenha')->name('resetarSenha');

Route::middleware(['auth'])->group( function() {

	//Ordem de Compra
	Route::get('home_compras', 'HomeController@home_compras')->name('home_compras');
	Route::get('home_compras/ordem_compra/{id}','HomeController@transparenciaOrdemCompra')->name('transparenciaOrdemCompra');
	Route::post('home_compras/ordem_compra/{id}','HomeController@procuraOrdemCompra')->name('procuraOrdemCompra');
	Route::get('home_compras/ordem_compra/novo/{id}/arquivo','HomeController@transparenciaOrdemCompraNovoArquivo')->name('transparenciaOrdemCompraNovoArquivo');
	Route::post('home_compras/ordem_compra/novo/{id}/arquivo','HomeController@storeOrdemCompraNovoArquivo')->name('storeOrdemCompraNovoArquivo');
	Route::get('home_compras/ordem_compra/novo/{id}','HomeController@transparenciaOrdemCompraNovo')->name('transparenciaOrdemCompraNovo');
	Route::get('home_compras/ordem_compra/alterar/ordemCompraAlterar/{unidade_id}/{id}','HomeController@ordemCompraAlterar')->name('ordemCompraAlterar');
	Route::get('home_compras/ordem_compra/excluir/ordemCompraExcluir/{unidade_id}/{id}','HomeController@ordemCompraExcluir')->name('ordemCompraExcluir');
	Route::post('home_compras/ordem_compra/{id}/cadastroArquivosOrdemCompra/{id_processo}','HomeController@storeArquivoOrdemCompra')->name('storeArquivoOrdemCompra');
	Route::get('home_compras/ordem_compra/{id}/cadastroArquivosOrdemCompra/addOrdemCompra','HomeController@addOrdemCompra')->name('addOrdemCompra');
	Route::post('home_compras/ordem_compra/{id}/cadastcadastroArquivosOrdemCompraroCotacoes/addOrdemCompra', 'HomeController@storeExcelOrdemCompra')->name('storeExcelOrdemCompra');
	Route::get('home_compras/ordem_compra/{id}/cadastroArquivosOrdemCompra/addOrdemCompra','HomeController@addOrdemCompra')->name('addOrdemCompra');
	Route::get('home_compras/ordem_compra/{id}/cadastroArquivosOrdemCompra/{id_processo}','HomeController@arquivosOrdemCompra')->name('arquivosOrdemCompra');
	Route::post('home_compras/ordem_compra/novo/{id}','HomeController@storeOrdemCompra')->name('storeOrdemCompra');
	Route::post('home_compras/ordem_compra/alterar/ordemCompraAlterar/{unidade_id}/{id}','HomeController@updateOrdemCompra')->name('updateOrdemCompra');
	Route::post('home_compras/ordem_compra/excluir/ordemCompraExcluir/{unidade_id}/{id}','HomeController@destroyOrdemCompra')->name('destroyOrdemCompra');
	
	//Contratação de serviços
	Route::get('contracaoServicos/{id_und}','ContratacaoServicosController@paginaContratacaoServicos')->name('paginaContratacaoServicos');
	Route::post('contracaoServicos/{id_und}','ContratacaoServicosController@paginaContratacaoServicos')->name('paginaContratacaoServicos');
	Route::get('contracaoServicos/nova/{id_und}', 'ContratacaoServicosController@novaContratacaoServicos')->name('novaContratacaoServicos');
	Route::post('contracaoServicos/nova/{id_und}', 'ContratacaoServicosController@novaContratacaoServicos')->name('novaContratacaoServicos');
    Route::post('contracaoServicos/cadastro/{id_und}', 'ContratacaoServicosController@salvarContratacaoServicos')->name('salvarContratacaoServicos');
	Route::get('contracaoServicos/pesquisa/{id_und}', 'ContratacaoServicosController@pesquisarContratacao')->name('pesquisarContratacao');
	Route::post('contracaoServicos/pesquisa/{id_und}', 'ContratacaoServicosController@pesquisarContratacao')->name('pesquisarContratacao');
	Route::get('contracaoServicos/paginaexcluir/{id}/{id_und}','ContratacaoServicosController@pagExcluirContratacao')->name('pagExcluirContratacao');
	Route::get('contracaoServicos/confirmexcluir/{id}/{id_und}','ContratacaoServicosController@excluirContratacao')->name('excluirContratacao');
	Route::get('contracaoServicos/excEspContr/{idContr}/{idEsp}','ContratacaoServicosController@exclEspeContr')->name('exclEspeContr');
	Route::get('contracaoServicos/paginaAlterar/{id}/{id_und}','ContratacaoServicosController@pagAlteraContratacao')->name('pagAlteraContratacao');
	Route::get('contracaoServicos/confirAlterar/{id}/{id_und}','ContratacaoServicosController@alteraContratacao')->name('alteraContratacao');
	Route::post('contracaoServicos/confirAlterar/{id}/{id_und}','ContratacaoServicosController@alteraContratacao')->name('alteraContratacao');
	Route::get('contracaoServicos/exclArqContr/{id}/{id_und}','ContratacaoServicosController@exclArqContr')->name('exclArqContr');
	Route::post('contracaoServicos/exclArqContr/{id}/{id_und}','ContratacaoServicosController@exclArqContr')->name('exclArqContr');
	Route::get('contracaoServicos/pagProrrContr/{id}/{id_und}','ContratacaoServicosController@pagProrrContr')->name('pagProrrContr');
	Route::post('contracaoServicos/prorrContr/{id}/{id_und}','ContratacaoServicosController@prorrContr')->name('prorrContr');
	Route::get('contracaoServicos/exclArqErratContr/{id}/','ContratacaoServicosController@exclArqErratContr')->name('exclArqErratContr');
	Route::post('contracaoServicos/exclArqErratContr/{id}/','ContratacaoServicosController@exclArqErratContr')->name('exclArqErratContr');
	

	Route::get('especialidade/cadastro/{id_und}','ContratacaoServicosController@paginaEspecialidade')->name('paginaEspecialidade');
	Route::post('especialidade/cadastro/{id_und}','ContratacaoServicosController@paginaEspecialidade')->name('paginaEspecialidade');
	Route::get('especialidade/nova/{id_und}','ContratacaoServicosController@novaEspecialidade')->name('novaEspecialidade');
	Route::post('especialidade/nova/{id_und}','ContratacaoServicosController@novaEspecialidade')->name('novaEspecialidade');
	Route::post('especialidade/cadastro/{id_und}','ContratacaoServicosController@salvarEspecialidade')->name('salvarEspecialidade');
	Route::get('especialidade/{id_und}','ContratacaoServicosController@pesquisarEspecialidade')->name('pesquisarEspecialidade');
	Route::post('especialidade/{id_und}','ContratacaoServicosController@pesquisarEspecialidade')->name('pesquisarEspecialidade');
	Route::get('especialidade/paginaExclusao/{id}/{id_und}','ContratacaoServicosController@pagExcluirEspeciali')->name('pagExcluirEspeciali');
	Route::get('especialidade/confirExclusao/{id}/{id_und}','ContratacaoServicosController@excluirEspecialidade')->name('excluirEspecialidade');
	Route::get('especialidade/paginaAlterar/{id}/{id_und}','ContratacaoServicosController@pagAlteraEspeciali')->name('pagAlteraEspeciali');
	Route::get('especialidade/confirAlterar/{id}/{id_und}','ContratacaoServicosController@AlteraEspeciali')->name('AlteraEspeciali');
	Route::post('especialidade/confirAlterar/{id}/{id_und}','ContratacaoServicosController@AlteraEspeciali')->name('AlteraEspeciali');


	Route::prefix('home')->group( function(){
		Route::get('', 'HomeController@index')->name('home');
		Route::get('/{id}', 'HomeController@index')->name('index');	
		
		//Permissao
		Route::get('permissao/{id}', 'PermissaoController@cadastroPermissao')->name('cadastroPermissao');
		Route::get('permissao/{id}/permissaoNovo', 'PermissaoController@permissaoNovo')->name('permissaoNovo');
		Route::get('permissao/{id}/permissaoUsuarioNovo', 'PermissaoController@permissaoUsuarioNovo')->name('permissaoUsuarioNovo');
		Route::get('permissao/{id}/permissaoAlterar/{id_permissao}', 'PermissaoController@permissaoAlterar')->name('permissaoAlterar');
		Route::post('permissao/{id}/permissaoAlterar/{id_permissao}','PermissaoController@update')->name('update');
		Route::get('permissao/{id}/permissaoExcluir/{id_permissao}', 'PermissaoController@permissaoExcluir')->name('permissaoExcluir');
		Route::post('permissao/{id}/permissaoExcluir/{id_permissao}','PermissaoController@destroy')->name('destroy');
		////
		
		//Institucional
		Route::get('institucionalCadastro/{id}', 'InstitucionalController@institucionalCadastro')->name('institucionalCadastro');
		Route::get('institucionalCadastro/{id}/institucionalNovo','InstitucionalController@institucionalNovo')->name('institucionalNovo');
		Route::get('institucionalCadastro/institucionalAlterar/{id}','InstitucionalController@institucionalAlterar')->name('institucionalAlterar');
		Route::get('institucionalCadastro/institucionalExcluir/{id}','InstitucionalController@institucionalExcluir')->name('institucionalExcluir');
		Route::post('institucionalCadastro/institucionalAlterar/{id}','InstitucionalController@update')->name('update');
		Route::post('institucionalCadastro/institucionalExcluir/{id}','InstitucionalController@destroy')->name('destroy');

		//Organizacional
		Route::get('organizacionalCadastro/{id}', 'OrganizationalController@cadastroOR')->name('cadastroOR');
		Route::get('organizacionalNovo/{id}', 'OrganizationalController@novoOR')->name('novoOR');
		Route::post('organizacionalNovo/{id}', 'OrganizationalController@storeOR')->name('storeOR');
		Route::get('organizacionalAlterar/{id_item}/unidade/{id_unidade}', 'OrganizationalController@alterarOR')->name('alterarOR');
		Route::post('organizacionalAlterar/{id_item}/unidade/{id_unidade}', 'OrganizationalController@updateOR')->name('updateOR');
		Route::get('organizacionalExcluir/{id_item}/unidade/{id_unidade}', 'OrganizationalController@excluirOR')->name('excluirOR');
		Route::post('organizacionalExcluir/{id_item}/unidade/{id_unidade}', 'OrganizationalController@destroyOR')->name('destroyOR');
		Route::get('organizacionalInativar/{id_item}/unidade/{id_unidade}', 'OrganizationalController@telaInativarOR')->name('telaInativarOR');
		Route::post('organizacionalInativar/{id_item}/unidade/{id_unidade}', 'OrganizationalController@inativarOR')->name('inativarOR');
		////
	
		//RegimentoInterno
		Route::get('regimento/{id}', 'RegimentoInternoController@cadastroRE')->name('cadastroRE');
		Route::get('regimento/{id}/regimentoNovo', 'RegimentoInternoController@novoRE')->name('novoRE');
		Route::post('regimento/{id}/regimentoNovo', 'RegimentoInternoController@storeRE')->name('storeRE');
		Route::get('regimento/{id}/regimentoExcluir/{id_escolha}', 'RegimentoInternoController@excluirRE')->name('excluirRE');
		Route::post('regimento/{id}/regimentoExcluir/{id_escolha}', 'RegimentoInternoController@destroyRE')->name('destroyRE');
		Route::get('regimento/{id}/regimentoAlterar/{id_escolha}', 'RegimentoInternoController@alterarRE')->name('alterarRE');
		Route::post('regimento/{id}/regimentoAlterar/{id_escolha}', 'RegimentoInternoController@updateRE')->name('updateRE');
		Route::get('regimento/{id}/regimentoInativar/{id_escolha}', 'RegimentoInternoController@telaInativarRE')->name('telaInativarRE');
		Route::post('regimento/{id}/regimentoInativar/{id_escolha}', 'RegimentoInternoController@inativarRE')->name('inativarRE');
		////

		//Competências
		Route::get('competencia/{id_unidade}/competenciaListar', 'CompetenciaController@listarCP')->name('listarCP');
		Route::get('competencia/{id_unidade}/competenciaNovo', 'CompetenciaController@novoCP')->name('novoCP');
		Route::post('competencia/{id_unidade}/competenciaNovo', 'CompetenciaController@storeCP')->name('storeCP');
		Route::get('competencia/{id_unidade}/competenciaCadastro/{id_item}', 'CompetenciaController@cadastroCP')->name('cadastroCP');
		Route::get('competencia/{id_unidade}/competenciaAlterar/{id_item}', 'CompetenciaController@alterarCP')->name('alterarCP');
		Route::post('/competencia/{id_unidade}/competenciaAlterar/{id_item}', 'CompetenciaController@updateCP')->name('updateCP');
		Route::get('competencia/{id_unidade}/competenciaExcluir/{id_item}', 'CompetenciaController@excluirCP')->name('excluirCP');
		Route::post('/competencia/{id_unidade}/competenciaExcluir/{id_item}', 'CompetenciaController@destroyCP')->name('destroyCP');
		Route::get('competencia/{id_unidade}/competenciaInativar/{id_item}', 'CompetenciaController@telaInativarCP')->name('telaInativarCP');
		Route::post('/competencia/{id_unidade}/competenciaInativar/{id_item}', 'CompetenciaController@inativarCP')->name('inativarCP');
		///
		
		//Organograma
		Route::get('organograma/{id}', 'OrganizationalController@organograma')->name('organograma');
		Route::get('organograma/{id}/organogramaNovo', 'OrganizationalController@novoOG')->name('novoOG');
		Route::post('organograma/{id}/organogramaNovo', 'OrganizationalController@storeOG')->name('storeOG');
		Route::get('organograma/{id}/organogramaExcluir', 'OrganizationalController@excluirOG')->name('excluirOG');
		Route::post('organograma/{id}/organogramaExcluir', 'OrganizationalController@destroyOG')->name('destroyOG');
		Route::get('organograma/{id}/organogramaInativar', 'OrganizationalController@telaInativarOG')->name('telaInativarOG');
		Route::post('organograma/{id}/organogramaInativar', 'OrganizationalController@inativarOG')->name('inativarOG');
		////
		
		//Associados:	
		Route::get('membros/{id}/Associados/associadoNovo', 'AssociadoController@novoAS')->name('novoAS');
		Route::post('membros/{id_unidade}/Associados/associadoNovo', 'AssociadoController@storeAS')->name('storeAS');
		Route::get('membros/{id}/Associados/listarAssociado', 'AssociadoController@listarAS')->name('listarAS');
		Route::get('membros/{id_unidade}/Associados/associadoAlterar/{id_associado}', 'AssociadoController@alterarAS')->name('alterarAS');
		Route::post('membros/{id_unidade}/Associados/associadoAlterar/{id_associado}', 'AssociadoController@updateAS')->name('updateAS');
		Route::get('membros/{id}/Associados/associadoExcluir/{id_associado}', 'AssociadoController@excluirAS')->name('excluirAS');
		Route::post('membros/{id_unidade}/Associados/associadoExcluir/{id_associado}', 'AssociadoController@destroyAS')->name('destroyAS');
		Route::get('membros/{id}/Associados/associadoInativar/{id_associado}', 'AssociadoController@telaInativarAS')->name('telaInativarAS');
		Route::post('membros/{id_unidade}/Associados/associadoInativar/{id_associado}', 'AssociadoController@inativarAS')->name('inativarAS');
		////
	
		//ConselhoAdm
		Route::get('membros/{id}/Associados/listarConselhoAdm', 'ConselhoAdmController@listarCA')->name('listarCA');
		Route::get('membros/{id}/Associados/conselhoAdmNovo', 'ConselhoAdmController@novoCA')->name('novoCA');
		Route::post('membros/{id_unidade}/Associados/conselhoAdmNovo', 'ConselhoAdmController@storeCA')->name('storeCA');
		Route::get('membros/{id_unidade}/Associados/conselhoAdmAlterar/{id_associado}', 'ConselhoAdmController@alterarCA')->name('alterarCA');
		Route::post('membros/{id_unidade}/Associados/conselhoAdmAlterar/{id_associado}', 'ConselhoAdmController@updateCA')->name('updateCA');
		Route::get('membros/{id}/Associados/conselhoAdmExcluir/{id_associado}', 'ConselhoAdmController@excluirCA')->name('excluirCA');
		Route::post('membros/{id_unidade}/Associados/conselhoAdmExcluir/{id_associado}', 'ConselhoAdmController@destroyCA')->name('destroyCA');
		Route::get('membros/{id}/Associados/conselhoAdmInativar/{id_associado}', 'ConselhoAdmController@telaInativarCA')->name('telaInativarCA');
		Route::post('membros/{id_unidade}/Associados/conselhoAdmInativar/{id_associado}', 'ConselhoAdmController@inativarCA')->name('inativarCA');
		////

		//ConselhoFisc
		Route::get('membros/{id}/Associados/listarConselhoFisc', 'ConselhoFiscController@listarCF')->name('listarCF');
		Route::get('membros/{id}/Associados/conselhoFiscNovo', 'ConselhoFiscController@novoCF')->name('novoCF');
		Route::post('membros/{id_unidade}/Associados/conselhoFiscNovo', 'ConselhoFiscController@storeCF')->name('storeCF');
		Route::get('membros/{id_unidade}/Associados/conselhoFiscAlterar/{id_associado}', 'ConselhoFiscController@alterarCF')->name('alterarCF');
		Route::post('membros/{id_unidade}/Associados/conselhoFiscAlterar/{id_associado}', 'ConselhoFiscController@updateCF')->name('updateCF');
		Route::get('membros/{id}/Associados/conselhoFiscExcluir/{id_associado}', 'ConselhoFiscController@excluirCF')->name('excluirCF');
		Route::post('membros/{id_unidade}/Associados/conselhoFiscExcluir/{id_associado}', 'ConselhoFiscController@destroyCF')->name('destroyCF');
		Route::get('membros/{id}/Associados/conselhoFiscInativar/{id_associado}', 'ConselhoFiscController@telaInativarCF')->name('telaInativarCF');
		Route::post('membros/{id_unidade}/Associados/conselhoFiscInativar/{id_associado}', 'ConselhoFiscController@inativarCF')->name('inativarCF');
		////
		
		//Superintendente
		Route::get('membros/{id}/Superentendentes/listarSuper', 'SuperintendentesController@listarSP')->name('listarSP');
		Route::get('membros/{id}/Superentendentes/superNovo', 'SuperintendentesController@novoSP')->name('novoSP');
		Route::post('membros/{id_unidade}/Superentendentes/superNovo', 'SuperintendentesController@storeSP')->name('storeSP');
		Route::get('membros/{id_unidade}/Superentendentes/superAlterar/{id_super}', 'SuperintendentesController@alterarSP')->name('alterarSP');
		Route::post('membros/{id_unidade}/Superentendentes/superAlterar/{id_super}', 'SuperintendentesController@updateSP')->name('updateSP');
		Route::get('membros/{id}/Superentendentes/superExcluir/{id_super}', 'SuperintendentesController@excluirSP')->name('excluirSP');
		Route::post('membros/{id_unidade}/Superentendentes/superExcluir/{id_super}', 'SuperintendentesController@destroySP')->name('destroySP');
		Route::get('membros/{id}/Superentendentes/superInativar/{id_super}', 'SuperintendentesController@telaInativarSP')->name('telaInativarSP');
		Route::post('membros/{id_unidade}/Superentendentes/superInativar/{id_super}', 'SuperintendentesController@inativarSP')->name('inativarSP');
		////
		
		//ContratodeGestão
		Route::get('contratos-gestao/{id_unidade}/contratoCadastro', 'ContratoController@cadastroCG')->name('cadastroCG');
		Route::get('contratos-gestao/{id_unidade}/contratoNovo', 'ContratoController@novoCG')->name('novoCG');
		Route::post('contratos-gestao/{id_unidade}/contratoNovo', 'ContratoController@storeCG')->name('storeCG');
		Route::get('contratos-gestao/{id_unidade}/contratoAlterar/{escolha}', 'ContratoController@alterarCG')->name('alterarCG');
		Route::post('contratos-gestao/{id_unidade}/contratoAlterar/{escolha}', 'ContratoController@updateCG')->name('updateCG');
		Route::get('contratos-gestao/{id_unidade}/contratoExcluir/{escolha}', 'ContratoController@excluirCG')->name('excluirCG');
		Route::post('contratos-gestao/{id_uniddae}/contratoExcluir/{escolha}', 'ContratoController@destroyCG')->name('destroyCG');
		Route::get('contratos-gestao/{id_unidade}/contratoInativar/{escolha}', 'ContratoController@telaInativarCG')->name('telaInativarCG');
		Route::post('contratos-gestao/{id_uniddae}/contratoInativar/{escolha}', 'ContratoController@inativarCG')->name('inativarCG');
		////

		//Demonstrativo Financeiro
		Route::get('demonstrativo-financeiro/{id_unidade}/financeiroCadastro', 'DemonstrativoFinanceiroController@cadastroDF')->name('cadastroDF');
		Route::get('demonstrativo-financeiro/{id_unidade}/financeiroNovo', 'DemonstrativoFinanceiroController@novoDF')->name('novoDF');
		Route::post('demonstrativo-financeiro/{id_unidade}/financeiroNovo', 'DemonstrativoFinanceiroController@storeDF')->name('storeDF');
		Route::get('demonstrativo-financeiro/{id_unidade}/financeiroAlterar/{id_item}', 'DemonstrativoFinanceiroController@alterarDF')->name('alterarDF');
		Route::post('demonstrativo-financeiro/{id_unidade}/financeiroAlterar/{id_item}', 'DemonstrativoFinanceiroController@updateDF')->name('updateDF');
		Route::get('demonstrativo-financeiro/{id_unidade}/financeiroExcluir/{id_item}', 'DemonstrativoFinanceiroController@excluirDF')->name('excluirDF');
		Route::post('demonstrativo-financeiro/{id_unidade}/financeiroExcluir/{id_item}', 'DemonstrativoFinanceiroController@destroyDF')->name('destroyDF');
		Route::get('demonstrativo-financeiro/{id_unidade}/inativarInativar/{id_item}', 'DemonstrativoFinanceiroController@telaInativarDF')->name('telaInativarDF');
		Route::post('demonstrativo-financeiro/{id_unidade}/inativarInativar/{id_item}', 'DemonstrativoFinanceiroController@inativarDF')->name('inativarDF');
		////

		//Demonstrativo Contabil
		Route::get('demonstrativo-contabel/{id_unidade}/contabelCadastro', 'DemonstracaoContabelController@cadastroDC')->name('cadastroDC');
		Route::get('demonstrativo-contabel/{id_unidade}/contabelNovo', 'DemonstracaoContabelController@novoDC')->name('novoDC');
		Route::post('demonstrativo-contabel/{id_unidade}/contabelNovo', 'DemonstracaoContabelController@storeDC')->name('storeDC');
		Route::get('demonstrativo-contabel/{id_unidade}/contabelExcluir/{id_item}', 'DemonstracaoContabelController@excluirDC')->name('excluirDC');
		Route::post('demonstrativo-contabel/{id_unidade}/contabelExcluir/{id_item}', 'DemonstracaoContabelController@destroyDC')->name('destroyDC');
		Route::get('demonstrativo-contabel/{id_unidade}/contabelInativar/{id_item}', 'DemonstracaoContabelController@telaInativarDC')->name('telaInativarDC');
		Route::post('demonstrativo-contabel/{id_unidade}/contabelInativar/{id_item}', 'DemonstracaoContabelController@inativarDC')->name('inativarDC');
		////
		
		//Repasses Recebidos	
		Route::get('repasses-recebidos/{id}/repassesCadastro', 'RepasseController@cadastroRP')->name('cadastroRP');
		Route::get('repasses-recebidos/{id}/repassesNovo', 'RepasseController@novoRP')->name('novoRP');
		Route::post('repasses-recebidos/{id}/repassesNovo', 'RepasseController@storeRP')->name('storeRP');
		Route::get('repasses-recebidos/{id_unidade}/repassesAlterar/{id_item}', 'RepasseController@alterarRP')->name('alterarRP');
		Route::post('repasses-recebidos/{id_unidade}/repassesAlterar/{id_item}', 'RepasseController@updateRP')->name('updateRP');
		Route::get('repasses-recebidos/{id}/repassesExcluir/{id_item}', 'RepasseController@excluirRP')->name('excluirRP');
		Route::post('repasses-recebidos/{id_unidade}/repassesExcluir/{id_item}', 'RepasseController@destroyRP')->name('destroyRP');
		Route::get('repasses-recebidos/{id}/repassesInativar/{id_item}', 'RepasseController@telaInativarRP')->name('telaInativarRP');
		Route::post('repasses-recebidos/{id_unidade}/repassesInativar/{id_item}', 'RepasseController@inativarRP')->name('inativarRP');
		////

	    //Contratacoes
		Route::get('contratacao/{id}/contratacaoCadastro', 'ContratacaoController@contratacaoCadastro')->name('contratacaoCadastro');
		Route::get('contratacao/{id}/cadastroContratos/', 'ContratacaoController@cadastroContratos')->name('cadastroContratos');
		Route::get('contratacao/{id}/cadastroContratos/pesquisarPrestador/', 'ContratacaoController@pesquisarPrestador')->name('pesquisarPrestador');
		Route::post('contratacao/{id}/cadastroContratos/procurarPrestador', 'ContratacaoController@procurarPrestador')->name('procurarPrestador');
		Route::get('contratacao/{id}/cadastroContratos/{id_prestador}', 'ContratacaoController@pesqPresdator')->name('pesqPresdator');
		Route::get('contratacao/{id}/cadastroPrestador', 'ContratacaoController@prestadorCadastro')->name('prestadorCadastro');
		Route::get('contratacao/{id}/cadastroResponsavel/{id_contrato}', 'ContratacaoController@responsavelCadastro')->name('responsavelCadastro');
		Route::get('contratacao/{id}/validarResponsavel/{id_contrato}/{id_gestor}', 'ContratacaoController@validarGestorContrato')->name('validarGestorContrato');
		Route::get('contratacao/{id}/responsavelNovo/{id_contrato}', 'ContratacaoController@responsavelNovo')->name('responsavelNovo');
		Route::get('contratacao/{id}/excluirContratos/{id_contrato}', 'ContratacaoController@excluirContratos')->name('excluirContratos');
		Route::get('contratacao/{id}/excluirCotacoes/{id_cotacao}', 'ContratacaoController@excluirCotacoes')->name('excluirCotacoes');
		Route::get('contratacao/{id}/validarCotacoes/{id_cotacao}', 'ContratacaoController@validarCotacoes')->name('validarCotacoes');
		Route::get('contratacao/{id}/alterarContratos/{id_contrato}/{id_prestador}', 'ContratacaoController@alterarContratos')->name('alterarContratos');
		Route::get('contratacao/{id}/alterarAditivo/{id_aditivo}/{id_contrato}', 'ContratacaoController@alterarAditivo')->name('alterarAditivo');
		Route::get('contratacao/{id}/cadastroCotacoes/addCotacao', 'ContratacaoController@addCotacao')->name('addCotacao');
		Route::get('contratacao/{id}/cadastroArquivosCotacoes/{id_processo}', 'ContratacaoController@arquivosCotacoes')->name('arquivosCotacoes');
		Route::post('contratacao/{id}/alterarContratos/{id_contrato}/{id_prestador}', 'ContratacaoController@updateContratos')->name('updateContratos');
		Route::post('contratacao/{id}/alterarAditivo/{id_contrato}/{id_prestador}', 'ContratacaoController@updateAditivo')->name('updateAditivo');
		Route::post('contratacao/{id}/excluirContratos/{id_contrato}', 'ContratacaoController@destroy')->name('destroy');
		Route::get('contratacao/{id}/excluirContratos/{id_aditivo}/{id_prestador}', 'ContratacaoController@excluirAditivos')->name('excluirAditivos');
		Route::get('contratacao/{id}/excluirAditivos/{id_aditivo}', 'ContratacaoController@excluirAditivo')->name('excluirAditivo');
		Route::post('contratacao/{id}/excluirAditivos/{id_aditivo}', 'ContratacaoController@destroyAditivo')->name('destroyAditivo');
		////

		//Cotacoes
		Route::get('contratacao/{id}/cadastroCotacoes','ContratacaoController@cadastroCotacoes')->name('cadastroCotacoes');
		Route::get('contratacao/{id}/cadastroCotacoes/cotacoesNovo','ContratacaoController@cotacoesNovo')->name('cotacoesNovo');
		Route::get('contratacao/{id}/cadastroCotacoes/excluirCotacoes/{id_cotacao}','ContratacaoController@excluirCotacoes')->name('excluirCotacoes');
		Route::post('contratacao/{id}/cadastroCotacoes/excluirCotacoes/{id_cotacao}','ContratacaoController@destroyCotacao')->name('destroyCotacao');
		////

		//RH - SeleçãoPessoal
		Route::get('recursos-humanos/{id}/selecaoPCadastro', 'RHController@cadastroSP')->name('cadastroSP');
		Route::get('recursos-humanos/{id}/selecaoPCadastro/selecaoPNovo', 'RHController@novoSP')->name('novoSP');
		Route::post('recursos-humanos/{id}/selecaoPCadastro/selecaoPNovo', 'RHController@storeSP')->name('storeSP');
		Route::get('recursos-humanos/{id}/selecaoPCadastro/selecaoPNovo/selecaoPCargos', 'RHController@cargosSP')->name('cargosSP');
		Route::post('recursos-humanos/{id}/selecaoPCadastro/selecaoPNovo/selecaoPCargos', 'RHController@storeCargosSP')->name('storeCargosSP');
		Route::get('recursos-humanos/{id}/selecaoPCadastro/selecaoPAlterar/{id_item}', 'RHController@alterarSP')->name('alterarSP');
		Route::post('recursos-humanos/{id}/selecaoPCadastro/selecaoPAlterar/{id_item}', 'RHController@updateSP')->name('updateSP');
		Route::get('recursos-humanos/{id}/selecaoPCadastro/selecaoPExcluir/{id_item}', 'RHController@excluirSP')->name('excluirSP');
		Route::post('recursos-humanos/{id}/selecaoPCadastro/selecaoPExcluir/{id_item}', 'RHController@destroySP')->name('destroySP');

		//DespesasPessoais
		Route::get('recursos-humanos/{id}/despesas', 'DespesasPessoaisController@cadastroDRH')->name('cadastroDRH');
		Route::post('recursos-humanos/{id}/despesas', 'DespesasPessoaisController@storeDRH')->name('storeDRH');
		Route::get('recursos-humanos/{id}/selecaoPcadastro/despesasRH', 'RHController@despesasRH')->name('despesasRH');
		Route::post('recursos-humanos/{id}/selecaoPcadastro/despesasRH', 'RHController@despesasRHProcurar')->name('despesasRHProcurar');
		Route::get('recursos-humanos/{id}/selecaoPcadastro/excluirDespesasRH', 'RHController@excluirDRH')->name('excluirDRH');
		Route::post('recursos-humanos/{id}/selecaoPcadastro/excluirDespesasRH', 'RHController@destroyDRH')->name('destroyDRH');
		Route::get('recursos-humanos/{id}/selecaoPcadastro/alterarDespesaRH/{ano}/{mes}/{tipo}', 'RHController@alterarDRH')->name('alterarDRH');
		Route::post('recursos-humanos/{id}/selecaoPcadastro/alterarDespesaRH/{ano}/{mes}/{tipo}', 'RHController@updateDRH')->name('updateDRH');
		Route::get('recursos-humanos/{id}/selecaoPcadastro/inativarDespesaRH/{ano}/{mes}/{tipo}/{tp}', 'RHController@telaInativarDRH')->name('telaInativarDRH');
		Route::post('recursos-humanos/{id}/selecaoPcadastro/inativarDespesaRH/{ano}/{mes}/{tipo}/{tp}', 'RHController@inativarDRH')->name('inativarDRH');
		Route::get('recursos-humanos/{id}/selecaoPcadastro/deletarDespesaRH/{ano}/{mes}/{tipo}', 'RHController@deletarRH')->name('deletarDRH');
		Route::post('recursos-humanos/{id}/selecaoPcadastro/deletarDespesaRH/{ano}/{mes}/{tipo}', 'RHController@destroyDRH')->name('destroyDRH');
		////

		//RH - Processo Seletivo
		Route::get('recursos-humanos/{id}/processoSCadastro', 'RHController@cadastroPS')->name('cadastroPS');
		Route::get('recursos-humanos/{id}/processoSCadastro/processoSNovo', 'RHController@novoPS')->name('novoPS');
		Route::post('recursos-humanos/{id}/processoSCadastro/processoSNovo', 'RHController@storePS')->name('storePS');
		Route::get('recursos-humanos/{id}/processoSCadastro/processoSExcluir/{id_item}', 'RHController@excluirPS')->name('excluirPS');
		Route::post('recursos-humanos/{id}/processoSCadastro/processoSExcluir/{id_item}', 'RHController@destroyPS')->name('destroyPS');
		Route::get('recursos-humanos/{id}/processoSCadastro/processoSInativar/{id_item}', 'RHController@telaInativarPS')->name('telaInativarPS');
		Route::post('recursos-humanos/{id}/processoSCadastro/processoSInativar/{id_item}', 'RHController@inativarPS')->name('inativarPS');
		////

		//RH - SP Cedidos
		Route::get('recursos-humanos/{id}/servidoresPCadastro','RHController@servidoresPCadastro')->name('servidoresPCadastro');

		//RH - Regulamento
		Route::get('recursos-humanos/{id}/regulamentoCadastro','RHController@regulamentoCadastro')->name('regulamentoCadastro');
		////
		
		//Regulamento
		Route::get('regulamento/{id}/regulamentoCadastro', 'RegulamentoController@cadastroRG')->name('cadastroRG');
		Route::get('regulamento/{id}/regulamentoNovo', 'RegulamentoController@novoRG')->name('novoRG');
		Route::post('regulamento/{id}/regulamentoNovo', 'RegulamentoController@storeRG')->name('storeRG');
		Route::get('regulamento/{id}/regulamentoExcluir/{id_escolha}', 'RegulamentoController@excluirRG')->name('excluirRG');
		Route::post('regulamento/{id}/regulamentoExcluir/{id_escolha}', 'RegulamentoController@destroyRG')->name('destroyRG');
		Route::get('regulamento/{id}/regulamentoInativar/{id_escolha}', 'RegulamentoController@telaInativarRG')->name('telaInativarRG');
		Route::post('regulamento/{id}/regulamentoInativar/{id_escolha}', 'RegulamentoController@inativarRG')->name('inativarRG');
		////

		//Estatuto/Ata
		Route::get('estatuto/{id}/estatutoCadastro', 'EstatutoController@cadastroES')->name('cadastroES');
		Route::get('estatuto/{id}/estatutoCadastro/estatutoNovo', 'EstatutoController@novoES')->name('novoES');
		Route::post('estatuto/{id}/estatutoCadastro/estatutoNovo', 'EstatutoController@storeES')->name('storeES');
		Route::get('estatuto/{id}/estatutoCadastro/estatutoExcluir/{id_estatuto}', 'EstatutoController@excluirES')->name('excluirES');
		Route::post('estatuto/{id}/estatutoCadastro/estatutoExcluir/{id_estatuto}', 'EstatutoController@destroyES')->name('destroyES');
		Route::get('estatuto/{id}/estatutoCadastro/estatutoInativar/{id_estatuto}', 'EstatutoController@telaInativarES')->name('telaInativarES');
		Route::post('estatuto/{id}/estatutoCadastro/estatutoInativar/{id_estatuto}', 'EstatutoController@inativarES')->name('inativarES');
		////

		//DocumentosRegularidade
		Route::get('documentos/{id}/documentosCadastro', 'DocumentacaoRegularidadeController@cadastroDR')->name('cadastroDR');
		Route::get('documentos/{id}/documentosCadastro/documentosNovo', 'DocumentacaoRegularidadeController@novoDR')->name('novoDR');
		Route::post('documentos/{id}/documentosCadastro/documentosNovo', 'DocumentacaoRegularidadeController@storeDR')->name('storeDR');
		Route::get('documentos/{id}/documentosCadastro/documentosExcluir/{id_escolha}', 'DocumentacaoRegularidadeController@excluirDR')->name('excluirDR');
		Route::post('documentos/{id}/documentosCadastro/documentosExcluir/{id_escolha}', 'DocumentacaoRegularidadeController@destroyDR')->name('destroyDR');
		Route::get('documentos/{id}/documentosCadastro/documentosInativar/{id_escolha}', 'DocumentacaoRegularidadeController@telaInativarDR')->name('telaInativarDR');
		Route::post('documentos/{id}/documentosCadastro/documentosInativar/{id_escolha}', 'DocumentacaoRegularidadeController@inativarDR')->name('inativarDR');
		////

		//Decreto
		Route::get('decreto/{id}/decretoCadastro', 'DecretoController@cadastroDE')->name('cadastroDE');
		Route::get('decreto/{id}/decretoNovo', 'DecretoController@novoDE')->name('novoDE');
		Route::post('decreto/{id}/decretoNovo', 'DecretoController@storeDE')->name('storeDE');
		Route::get('decreto/{id}/decretoExcluir/{id_escolha}', 'DecretoController@excluirDE')->name('excluirDE');
		Route::post('decreto/{id}/decretoExcluir/{id_escolha}', 'DecretoController@destroyDE')->name('destroyDE');
		Route::get('decreto/{id}/decretoAlterar/{id_escolha}', 'DecretoController@telaInativarDE')->name('telaInativarDE');
		Route::post('decreto/{id}/decretoAlterar/{id_escolha}', 'DecretoController@inativarDE')->name('inativarDE');
		////
		
		//Covênio
		Route::get('covenio/{id}/cadastroCovenio', 'CoveniosController@covenioCadastro')->name('covenioCadastro');
		Route::get('covenio/{id}/covenioNovo', 'CoveniosController@covenioNovo')->name('covenioNovo');
		Route::get('covenio/{id}/excluirCovenio/{id_escolha}', 'CoveniosController@covenioExcluir')->name('covenioExcluir');
		Route::post('covenio/{id}/excluirCovenio/{id_escolha}', 'CoveniosController@destroy')->name('destroy');	
		////
		
		//RelatorioGerencial
		Route::get('relmensalExecucao/{id}', 'IndexController@transparenciaRelatorioGerencial')->name('transparenciaRelatorioGerencial');
		Route::get('relmensalExecucao/{id}/cadastroRelGerencial', 'RelatorioGerencialController@cadastroRelGerencial')->name('cadastroRelGerencial');
		Route::get('relmensalExecucao/{id}/cadastroRelGerencial/relatorioGerencialNovo', 'RelatorioGerencialController@relatorioGerencialNovo')->name('relatorioGerencialNovo');
		Route::post('relmensalExecucao/{id}/cadastroRelGerencial/relatorioGerencialNovo', 'RelatorioGerencialController@storeRelatorioG')->name('storeRelatorioG');
		Route::get('relmensalExecucao/{id}/cadastroRelGerencial/relatorioGerencialExcluir/{id_rel}', 'RelatorioGerencialController@relatorioGerencialExcluir')->name('relatorioGerencialExcluir');
		Route::post('relmensalExecucao/{id}/cadastroRelGerencial/relatorioGerencialExcluir/{id_rel}', 'RelatorioGerencialController@destroy')->name('destroy');
		
		//ServidoresCedidos
		Route::get('servidoresCedidos/{id}', 'ServidoresCedidosController@cadastroSE')->name('cadastroSE');
		Route::get('servidoresCedidos/{id}/servidoresNovo', 'ServidoresCedidosController@novoSE')->name('novoSE');
		Route::post('servidoresCedidos/{id}/servidoresNovo/', 'ServidoresCedidosController@storeSE')->name('storeSE');
		Route::get('servidoresCedidos/{id}/servidoresAlterar/{id_servidor}', 'ServidoresCedidosController@alterarSE')->name('alterarSE');
		Route::post('servidoresCedidos/{id}/servidoresAlterar/{id_servidor}/', 'ServidoresCedidosController@updateSE')->name('updateSE');
		Route::get('servidoresCedidos/{id}/servidoresExcluir/{id_servidor}', 'ServidoresCedidosController@excluirSE')->name('excluirSE');
		Route::post('servidoresCedidos/{id}/servidoresExcluir/{id_servidor}', 'ServidoresCedidosController@destroySE')->name('destroySE');
		Route::get('servidoresCedidos/{id}/servidoresInativar/{id_servidor}', 'ServidoresCedidosController@telaInativarSE')->name('telaInativarSE');
		Route::post('servidoresCedidos/{id}/servidoresInativar/{id_servidor}', 'ServidoresCedidosController@inativarSE')->name('inativarSE');
		////
		
		//RelatorioFinanceiro
		Route::get('relatorio_financeiro/{id}', 'RelatorioFinanceiroController@cadastroRF')->name('cadastroRF');
		Route::get('relatorio_financeiro/{id}/relatorioNovo', 'RelatorioFinanceiroController@novoRF')->name('novoRF');
		Route::post('relatorio_financeiro/{id}/relatorioNovo', 'RelatorioFinanceiroController@storeRF')->name('storeRF');
		Route::get('relatorio_financeiro/{id}/relatorioExcluir/{id_rel}', 'RelatorioFinanceiroController@excluirRF')->name('excluirRF');
		Route::post('relatorio_financeiro/{id}/relatorioExcluir/{id_rel}', 'RelatorioFinanceiroController@destroyRF')->name('destroyRF');
		Route::get('relatorio_financeiro/{id}/relatorioInativar/{id_rel}', 'RelatorioFinanceiroController@telaInativarRF')->name('telaInativarRF');
		Route::post('relatorio_financeiro/{id}/relatorioInativar/{id_rel}', 'RelatorioFinanceiroController@inativarRF')->name('inativarRF');
		////
		
		//Ouvidoria
		Route::get('ouvidoria/{id}', 'OuvidoriaController@cadastroOV')->name('cadastroOV');
		Route::get('ouvidoria/{id}/ouvidoriaNovo', 'OuvidoriaController@novoOV')->name('novoOV');
		Route::post('ouvidoria/{id}/ouvidoriaNovo', 'OuvidoriaController@storeOV')->name('storeOV');
		Route::get('ouvidoria/{id}/ouvidoriaAlterar/{id_ouvidoria}', 'OuvidoriaController@alterarOV')->name('alterarOV');
		Route::post('ouvidoria/{id}/ouvidoriaAlterar/{id_ouvidoria}', 'OuvidoriaController@updateOV')->name('updateOV');
		Route::get('ouvidoria/{id}/ouvidoriaExcluir/{id_ouvidoria}', 'OuvidoriaController@excluirOV')->name('excluirOV');
		Route::post('ouvidoria/{id}/ouvidoriaExcluir/{id_ouvidoria}', 'OuvidoriaController@destroyOV')->name('destroyOV');
		Route::get('ouvidoria/{id}/ouvidoriaInativar/{id_ouvidoria}', 'OuvidoriaController@telaInativarOV')->name('telaInativarOV');
		Route::post('ouvidoria/{id}/ouvidoriaInativar/{id_ouvidoria}', 'OuvidoriaController@inativarOV')->name('inativarOV');
		//Relatorios estatisticos
		Route::get('ouvidoria/relatorioEstatistico/{id}', 'OuvidoriaController@cadastroOVRelatorioES')->name('cadastroOVRelatorioES');
		Route::get('ouvidoria/relatorioEstatistico/novo/{id}', 'OuvidoriaController@novoOVRelatorioES')->name('novoOVRelatorioES');
		Route::get('ouvidoria/relatorioEstatistico/alterar/{id}/{id_doc}', 'OuvidoriaController@alterarOVRelatorioES')->name('alterarOVRelatorioES');
		Route::post('ouvidoria/relatorioEstatistico/alterar/{id}/{id_doc}', 'OuvidoriaController@updateOVRelatorioES')->name('updateOVRelatorioES');
		Route::post('ouvidoria/relatorioEstatistico/novo/{id}', 'OuvidoriaController@storeOVRelatorioES')->name('storeOVRelatorioES');
		Route::post('ouvidoria/relatorioEstatistico/status/{id}/{id_doc}', 'OuvidoriaController@statusOVRelatorioES')->name('statusOVRelatorioES');
		////	
		
		//Usuário
		Route::get('usuarios/cadastroUsuarios','UserController@cadastroUsuarios')->name('cadastroUsuarios');
		Route::get('usuarios/cadastroUsuarios/pesquisa','UserController@pesquisarUsuario')->name('pesquisarUsuario');
		Route::post('usuarios/cadastroUsuarios/pesquisa','UserController@pesquisarUsuario')->name('pesquisarUsuario');
		Route::get('usuarios/cadastroUsuarios/novo','UserController@cadastroNovoUsuario')->name('cadastroNovoUsuario');
		Route::post('usuarios/cadastroUsuarios/novo','UserController@storeUsuario')->name('storeUsuario');
		Route::get('usuarios/cadastroUsuarios/alterar/{id}','UserController@cadastroAlterarUsuario')->name('cadastroAlterarUsuario');
		Route::post('usuarios/cadastroUsuarios/alterar/{id}','UserController@updateUsuario')->name('updateUsuario');
		Route::get('usuarios/cadastroUsuarios/excluir/{id}','UserController@cadastroExcluirUsuario')->name('cadastroExcluirUsuario');
		Route::post('usuarios/cadastroUsuarios/excluir/{id}','UserController@destroyUsuario')->name('destroyUsuario');
		////
		
		//Relatórios
		Route::get('/relatorios/{id}', 'HomeController@relatorios')->name('relatorios');
    	Route::get('/relatorio_total_contratos/{id}', 'HomeController@relatorioTotalContratos')->name('relatorioTotalContratos');
    	Route::post('/relatorio_total_contratos/{id}', 'HomeController@relatorioPesqTotalContratos')->name('relatorioPesqTotalContratos');
    	Route::get('/relatorio_despesas/{id}', 'HomeController@relatorioDespesasAno')->name('relatorioDespesasAno');
    	Route::get('/relatorio_despesas_unidade/{id}', 'HomeController@relatorioDespesasUnidade')->name('relatorioDespesasUnidade');
    	Route::get('/relatorio_despesas_unidade/{id}/pesquisa', 'HomeController@relatorioPesquisaDespesas')->name('relatorioPesquisaDespesas');
    	Route::post('/relatorio_despesas_unidade/{id}/pesquisa', 'HomeController@relatorioPesquisaDespesas')->name('relatorioPesquisaDespesas');
    	Route::get('/relatorio_ultimas_atualizacoes/{id}/relatorio', 'HomeController@relatorioUltAtualizacoes')->name('relatorioUltAtualizacoes');
    	Route::post('/relatorio_ultimas_atualizacoes/{id}/relatorio', 'HomeController@relatorioPesqUltAtual')->name('relatorioPesqUltAtual');
    	////
		
		//Assistencial
		Route::get('assistencial/{id}/assistencialCadastro', 'AssistencialController@cadastroRA')->name('cadastroRA');
		Route::get('assistencial/{id}/assistencialCadastro/assistencialNovo', 'AssistencialController@novoRA')->name('novoRA');
		Route::post('assistencial/{id}/assistencialCadastro/assistencialNovo', 'AssistencialController@storeRA')->name('storeRA');
		Route::post('assistencial/{id}/assistencialCadastro/assistencialNovo/{id_escolha}', 'AssistencialController@storeRA')->name('storeRA');
		//Route::get('assistencial/visualizar/{id}', 'IndexController@visualizarAssistencial')->name('visualizarAssistencial');
		Route::get('assistencial/{id}/assistencialCadastro/assistencialAlterar/{id_item}', 'AssistencialController@alterarRA')->name('alterarRA');
		Route::post('assistencial/{id}/assistencialCadastro/assistencialAlterar/{id_item}', 'AssistencialController@updateRA')->name('updateRA');
		Route::get('assistencial/{id}/assistencialCadastro/assistencialExcluir/{id_item}', 'AssistencialController@excluirRA')->name('excluirRA');
		Route::post('assistencial/{id}/assistencialCadastro/assistencialExcluir/{id_item}', 'AssistencialController@destroyRA')->name('destroyRA');
		Route::get('assistencial/{id}/assistencialCadastro/assistencialInativar/{id_item}/{tp}', 'AssistencialController@telaInativarRA')->name('telaInativarRA');
		Route::post('assistencial/{id}/assistencialCadastro/assistencialInativar/{id_item}/{tp}', 'AssistencialController@inativarRA')->name('inativarRA');
		//Assistencial Covid
		Route::get('assistencial/{id}/cadastroAssistencialCovid', 'AssistencialCovidController@cadastroRAC')->name('cadastroRAC');
		Route::get('assistencial/{id}/cadastroAssistencialCovid/novo', 'AssistencialCovidController@novoRAC')->name('novoRAC');
		Route::post('assistencial/{id}/cadastroAssistencialCovid/novo', 'AssistencialCovidController@storeRAC')->name('storeRAC');
		Route::get('assistencial/pesquisarMesCovid/{mes}/{ano}', 'AssistencialCovidController@pesquisarRAC')->name('pesquisarRAC');
		Route::get('assistencial/{id}/excluirAssistencialCovid/{id_covid}', 'AssistencialCovidController@excluirRAC')->name('excluirRAC');
		////
		//Assistencial documentos
		Route::get('assistencialdocs/cadastro/{id_und}', 'AssistencialDocController@cadastroRADOC')->name('cadastroRADOC');
		Route::get('assistencialdocs/novo/{id_und}', 'AssistencialDocController@novoRADOC')->name('novoRADOC');
		Route::post('assistencialdocs/novo/{id_und}', 'AssistencialDocController@storeRADOC')->name('storeRADOC');
		Route::get('assistencialdocs/assistencialExcluir/{id_und}/{id_doc}', 'AssistencialDocController@excluirRADOC')->name('excluirRADOC');
		Route::post('assistencialdocs/assistencialExcluir/{id_und}/{id_doc}', 'AssistencialDocController@destroyRADOC')->name('destroyRADOC');
		Route::get('assistencialdocs/assistencialInativar/{id_und}/{id_doc}', 'AssistencialDocController@telaInativarRADOC')->name('telaInativarRADOC');
		Route::post('assistencialdocs/assistencialInativar/{id_und}/{id_doc}', 'AssistencialDocController@inativarRADOC')->name('inativarRADOC');
		
		//Stores
		Route::post('institucionalCadastro/{id}/institucionalNovo', 'InstitucionalController@store')->name('store');
		Route::post('contratacao/{id}/cadastroPrestador','ContratacaoController@storePrestador')->name('storePrestador');
		Route::post('contratacao/{id}/cadastroContratos','ContratacaoController@storeContratos')->name('storeContratos');
		Route::post('contratacao/{id}/cadastroContratos/{id_item}','ContratacaoController@storeContratos')->name('storeContratos');
		Route::post('contratacao/{id}/cadastroCotacoes/cotacoesNovo','ContratacaoController@storeCotacoes')->name('storeCotacoes');
		Route::post('contratacao/{id}/responsavelNovo/{id_contrato}','ContratacaoController@storeGestor')->name('storeGestor');
    	Route::post('covenio/{id}/covenioNovo', 'CoveniosController@store')->name('store');
		Route::post('permissao/{id}/permissaoNovo', 'PermissaoController@store')->name('store');
		Route::post('permissao/{id}/permissaoUsuarioNovo', 'PermissaoController@storePermissaoUsuario')->name('storePermissaoUsuario');
		Route::post('contratacao/{id}/cadastroCotacoes/addCotacao', 'ContratacaoController@storeExcelCotacao')->name('storeExcelCotacao');
		Route::post('contratacao/{id}/cadastroArquivosCotacoes/{id_processo}','ContratacaoController@storeArquivoCotacao')->name('storeArquivoCotacao');
		
		//Bens públicos
		Route::get('bens-publicos/cadastros/{id_und}', 'BensPublicosController@cadastroBP')->name('cadastroBP');
		Route::get('bens-publicos/novo/{id_und}', 'BensPublicosController@novoBP')->name('novoBP');
		Route::post('bens-publicos/store/{id_und}', 'BensPublicosController@storeBP')->name('storeBP');
		Route::get('bens-publicos/deletar/{id_und}/{id_bens}', 'BensPublicosController@excluirBP')->name('excluirBP');
		Route::post('bens-publicos/deletar/{id_und}/{id_bens}', 'BensPublicosController@destroyBP')->name('destroyBP');
		Route::get('bens-publicos/inativar/{id_und}/{id_bens}', 'BensPublicosController@telaInativarBP')->name('telaInativarBP');
		Route::post('bens-publicos/inativar/{id_und}/{id_bens}', 'BensPublicosController@inativarBP')->name('inativarBP');
		////
		
		//Processo de contratação de terceiros
		Route::get('contratacao/{id}/processContrataTerceiros/processoNovo', 'ContratacaoController@ProcessContrataTerceirosCreate')->name('ProcessContrataTerceirosCreate');
		Route::post('contratacao/{id}/processContrataTerceiros/processoNovo', 'ContratacaoController@storeProcessContrataTerceiros')->name('storeProcessContrataTerceiros');
		Route::get('contratacao/{id}/processContrataTerceiros/excluirProcesso/{id_cotacao}', 'ContratacaoController@excluirProcessos')->name('excluirProcessos');
		Route::post('contratacao/{id}/processContrataTerceiros/excluirProcesso/{id_cotacao}', 'ContratacaoController@destroyProcessos')->name('destroyProcessos');
		
	  });	
});

Route::get('/admin', function(){
    return 'You are an admin inside contracts';
})->middleware('auth','auth.admin');