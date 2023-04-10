<?php

namespace App\Http\Controllers;

use App\Model\DemonstrativoFinanceiro;
use App\Model\Unidade;
use App\Model\LoggerUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Model\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Auth;
use Validator;
use DB;

class DemonstrativoFinanceiroController extends Controller
{
    public function __construct(Unidade $unidade, DemonstrativoFinanceiro $demonstrativoFinanceiro, LoggerUsers $logger_users)
    {
        $this->unidade                 = $unidade;
        $this->demonstrativoFinanceiro = $demonstrativoFinanceiro;
        $this->logger_users            = $logger_users;
    }

    public function index()
    {
        $unidades = $this->unidade->all();
        return view('demonstrativoFinanceiro', compact('unidades'));
    }

    public function cadastroDF($id, Request $request)
    {
        $validacao    = permissaoUsersController::Permissao($id);
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
        $financialReports = DemonstrativoFinanceiro::where('unidade_id', $id)->orderBy('ano', 'ASC')->orderBy('mes', 'ASC')->get();
        $lastUpdated  = $financialReports->max('updated_at');
        if ($validacao == 'ok') {
            return view('transparencia/demonstrativo-financeiro/demonstrativo_cadastro', compact('unidade', 'unidades', 'unidadesMenu', 'financialReports', 'lastUpdated'));
        } else {
            $validator = 'Você não tem Permissão!!';
            return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        }
    }

    public function novoDF($id, Request $request)
    {
        $validacao    = permissaoUsersController::Permissao($id);
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
        $financialReports = DemonstrativoFinanceiro::where('unidade_id', $id)->get();
        $lastUpdated  = $financialReports->max('updated_at');
        if ($validacao == 'ok') {
            return view('transparencia/demonstrativo-financeiro/demonstrativo_novo', compact('unidade', 'unidades', 'unidadesMenu', 'financialReports', 'lastUpdated'));
        } else {
            $validator = 'Você não tem Permissão!!';
            return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        }
    }

    public function alterarDF($id_unidade, $id_item, Request $request)
    {
        $validacao    = permissaoUsersController::Permissao($id_unidade);
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
        $financialReports = DemonstrativoFinanceiro::where('id', $id_item)->get();
        $lastUpdated  = $financialReports->max('updated_at');
        if ($validacao == 'ok') {
            return view('transparencia/demonstrativo-financeiro/demonstrativo_alterar', compact('unidade', 'unidades', 'unidadesMenu', 'financialReports', 'lastUpdated'));
        } else {
            $validator = "Você não tem Permissão!!";
            return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        }
    }

    public function excluirDF($id_unidade, $id_item, Request $request)
    {
        $validacao    = permissaoUsersController::Permissao($id_unidade);
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
        $financialReports = DemonstrativoFinanceiro::where('id', $id_item)->get();
        $lastUpdated  = $financialReports->max('updated_at');
        if ($validacao == 'ok') {
            return view('transparencia/demonstrativo-financeiro/demonstrativo_excluir', compact('unidade', 'unidades', 'unidadesMenu', 'financialReports', 'lastUpdated'));
        } else {
            $validator = 'Você não tem Permissão!!';
            return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        }
    }

    public function telaInativarDF($id_unidade, $id_item, Request $request)
    {
        $validacao    = permissaoUsersController::Permissao($id_unidade);
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
        $financialReports = DemonstrativoFinanceiro::where('id', $id_item)->get();
        $lastUpdated  = $financialReports->max('updated_at');
        if ($validacao == 'ok') {
            return view('transparencia/demonstrativo-financeiro/demonstrativo_inativar', compact('unidade', 'unidades', 'unidadesMenu', 'financialReports', 'lastUpdated'));
        } else {
            $validator = 'Você não tem Permissão!!';
            return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        }
    }

    public function storeDF($id_unidade, Request $request)
    {
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
        $financialReports = DemonstrativoFinanceiro::where('unidade_id', $id_unidade)->get();
        $input        = $request->all();
        if ($input['tipoarq'] == 3) {
            $input['file_path'] = "";
        } else {
            $nome = $_FILES['file_path']['name'];
            $extensao = pathinfo($nome, PATHINFO_EXTENSION);
            $input['file_link'] = "";
        }
        $mes = $input['mes'];
        $ano = $input['ano'];
        $financialR = DemonstrativoFinanceiro::where('unidade_id',$id_unidade)->where('mes',$mes)->where('ano',$ano)->where('tipodoc', $input['tipodoc'])->where('tipoarq',$input['tipoarq'])->get();
        $qtd = sizeof($financialR);
        if ($qtd > 0) {
            $validator = 'O Relatório correspondente a este mês e ao ano já foi cadastrado';
            return view('transparencia/demonstrativo-financeiro/demonstrativo_novo', compact('unidades', 'unidade', 'unidadesMenu', 'financialReports'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        } else {
            if ($input['tipoarq'] == 1 || $input['tipoarq'] == 2) {
                if ($request->file('file_path') === NULL) {
                    $validator = 'Informe o arquivo do demonstrativo.';
                    return view('transparencia/demonstrativo-financeiro/demonstrativo_novo', compact('unidades', 'unidade', 'unidadesMenu', 'financialReports'))
                        ->withErrors($validator)
                        ->withInput(session()->flashInput($request->input()));
                } else {
                    $extensao = strtolower($extensao);
                    if ($extensao === 'pdf' || $extensao === 'rar') {
                        $validator = Validator::make($request->all(), [
                            'title' => 'required',
                            'mes'    => 'required',
                            'ano'    => 'required'
                        ]);
                        if ($validator->fails()) {
                            return view('transparencia/demonstrativo-financeiro/demonstrativo_novo', compact('unidades', 'unidade', 'unidadesMenu', 'financialReports'))
                                ->withErrors($validator)
                                ->withInput(session()->flashInput($request->input()));
                        } else {
                            $qtdUnidades = sizeof($unidades);
                            for ($i = 1; $i <= $qtdUnidades; $i++) {
                                if ($unidade['id'] === $i) {
                                    $txt1 = $unidades[$i - 1]['path_img'];
                                    $txt1 = explode(".jpg", $txt1);
                                    $txt2 = strtoupper($txt1[0]);
                                    
                                    if ($input['title'] == 1) {
                                        $input['title'] = "Relátorio Mensal";
                                        $title = '.relat-mensal-finan-';
                                    } else {
                                        $title = '.prest-contas-mensal-finan-';
                                        $input['title'] = "Prestação de contas";
                                    }
                                    if ($input['tipodoc'] == 2) {
                                        $input['title'] = $input['title'] . '- Maternidade';
                                        $tipodoc = "Maternidade-";
                                    } elseif ($input['tipodoc'] == 3) {
                                        $input['title'] = $input['title'] . '- COVID';
                                        $tipodoc = "COVID-";
                                    } elseif ($input['tipodoc'] == 4) {
                                        $input['title'] = $input['title'] . '- Prefeitura';
                                        $tipodoc = "Prefeitura-";
                                    } else {
                                        $tipodoc = "";
                                    }
                                    $dthoje = $DateAndTime = date('mdYhis', time());
                                    $nome   = $mes . $title . $tipodoc . $ano . '-' . $txt2 . '-' . $dthoje . '.' . $extensao;
                                    $upload = $request->file('file_path')->move('../public/storage/relatorio-mensal-financeiro/' . $txt1[0] . '/' . $ano . '/', $nome);
                                    $input['file_path'] = 'relatorio-mensal-financeiro/' . $txt1[0] . '/' . $ano . '/' . $nome;
                                    $input['name_arq']  = $nome; 
                                }
                            }
                            $input['status_financeiro'] = 1;
                            $demonstrativo = DemonstrativoFinanceiro::create($input);
                            $id_registro   = DB::table('financial_reports')->max('id');
				            $input['registro_id'] = $id_registro;	
                            $log           = LoggerUsers::create($input);
                            $lastUpdated   = $log->max('updated_at');
                            $financialReports = DemonstrativoFinanceiro::where('unidade_id', $id_unidade)->orderBy('ano', 'ASC')->orderBy('mes', 'ASC')->orderBy('title', 'ASC')->get();
                            $validator     = 'Demonstrativo Financeiro cadastrado com sucesso!';
                            return redirect()->route('cadastroDF', [$id_unidade])
                                ->withErrors($validator);
                        }
                    } else {
                        $validator = 'Só suporta arquivos do tipo: PDF ou RAR!';
                        return view('transparencia/demonstrativo-financeiro/demonstrativo_novo', compact('unidades', 'unidade', 'unidadesMenu', 'financialReports', 'lastUpdated'))
                            ->withErrors($validator)
                            ->withInput(session()->flashInput($request->input()));
                    }
                }
            } else {
                $validator = Validator::make($request->all(), [
                    'title' => 'required',
                    'mes'    => 'required',
                    'ano'    => 'required'
                ]);
                if ($validator->fails()) {
                    return view('transparencia/demonstrativo-financeiro/demonstrativo_novo', compact('unidades', 'unidade', 'unidadesMenu', 'financialReports', 'lastUpdated'))
                        ->withErrors($validator)
                        ->withInput(session()->flashInput($request->input()));
                } else {
                    if ($input['title'] == 1) {
                        $input['title'] = "Relátorio Mensal";
                    } else {
                        $input['title'] = "Prestação de contas";
                    }
                    if ($input['tipodoc'] == 2) {
                        $input['title'] = $input['title'] . '- Maternidade';
                    } elseif ($input['tipodoc'] == 3) {
                        $input['title'] = $input['title'] . '- COVID';
                    } elseif ($input['tipodoc'] == 4) {
                        $input['title'] = $input['title'] . '- Prefeitura';
                    }
                    $input['status_financeiro'] = 1;
                    $demonstrativo = DemonstrativoFinanceiro::create($input);
                    $id_registro   = DB::table('financial_reports')->max('id');
                    $input['registro_id'] = $id_registro;
                    $log           = LoggerUsers::create($input);
                    $lastUpdated   = $log->max('updated_at');
                    $financialReports = DemonstrativoFinanceiro::where('unidade_id', $id_unidade)->orderBy('ano', 'ASC')->get();
                    $validator     = 'Demonstrativo Financeiro cadastrado com sucesso!';
                    return redirect()->route('cadastroDF', [$id_unidade])
                        ->withErrors($validator);
                }
            }
        }
    }

    public function updateDF($id_unidade, $id_item, Request $request)
    {
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
        $financialReports = DemonstrativoFinanceiro::where('id', $id_item)->get();
        $input        = $request->all();
        if ($input['tipoarq'] == 1 || $input['tipoarq'] == 2) {
            if (isset($input['file_path'])) {
                if ($financialReports[0]->file_link == NULL) {
                    $input['file_link'] = "";
                } else {
                    $input['file_link'] = $financialReports[0]->file_link;
                }
                $nome = $_FILES['file_path']['name'];
                $extensao = pathinfo($nome, PATHINFO_EXTENSION);
                $extensao = strtolower($extensao);
                if ($extensao === 'pdf' || $extensao === 'rar') {
                    $mes = $input['mes'];
                    $ano = $input['ano'];
                    $dthoje = $DateAndTime = date('mdYhis', time());
                    $qtdUnidades = sizeof($unidades);
                    for ($i = 1; $i <= $qtdUnidades; $i++) {
                        if ($unidade['id'] === $i) {
                            $txt1 = $unidades[$i - 1]['path_img'];
                            $txt1 = explode(".jpg", $txt1);
                            $txt2 = strtoupper($txt1[0]);
                            if ($input['title'] == 1) {
                                $input['title'] = "Relátorio Mensal";
                                $title = '.relat-mensal-finan-';
                            } else {
                                $input['title'] = "Prestação de contas";
                                $title = '.prest-contas-mensal-finan-';
                            }
                            if ($input['tipodoc'] == 2) {
                                $input['title'] = $input['title'] . '- Maternidade';
                                $tipodoc = "Maternidade-";
                            } elseif ($input['tipodoc'] == 3) {
                                $input['title'] = $input['title'] . '- COVID';
                                $tipodoc = "COVID-";
                            } elseif ($input['tipodoc'] == 4) {
                                $input['title'] = $input['title'] . '- Prefeitura';
                                $tipodoc = "Prefeitura-";
                            } else {
                                $tipodoc = "";
                            }
                            if ($extensao == "pdf") {
                                $input['tipoarq'] = 1;
                            } elseif ($extensao == "rar") {
                                $input['tipoarq'] = 2;
                            } else {
                                $input['tipoarq'] = 3;
                            }
                            $nome   = $mes . $title . $tipodoc . $ano . '-' . $txt2 . '-' . $dthoje . '.' . $extensao;
                            $upload = $request->file('file_path')->move('../public/storage/relatorio-mensal-financeiro/' . $txt1[0] . '/' . $ano . '/', $nome);
                            $input['file_path'] = 'relatorio-mensal-financeiro/' . $txt1[0] . '/' . $ano . '/' . $nome;
                        }
                    }
                    $financialReport = DemonstrativoFinanceiro::find($id_item);
                    $financialReport->update($input);
                    $input['registro_id'] = $id_item;
                    $log         = LoggerUsers::create($input);
                    $lastUpdated = $log->max('updated_at');
                    $financialReports = DemonstrativoFinanceiro::where('unidade_id', $id_unidade)->orderBy('ano', 'ASC')->orderBy('mes', 'ASC')->orderBy('title', 'ASC')->get();
                    $validator   = "Desmonstrativo financeiro alterado com sucesso !";
                    return redirect()->route('cadastroDF', [$id_unidade])
                        ->withErrors($validator);
                } else {
                    $validator = 'Só suporta arquivos do tipo: PDF ou RAR!';
                    return view('transparencia/demonstrativo-financeiro/demonstrativo_alterar', compact('unidades', 'unidade', 'unidadesMenu', 'financialReports', 'lastUpdated'))
                        ->withErrors($validator)
                        ->withInput(session()->flashInput($request->input()));
                }
            } else {
                if ($financialReports[0]->file_link == NULL) {
                    $input['file_link'] = "";
                } else {
                    $input['file_link'] = $financialReports[0]->file_link;
                }
                $input['tipoarq'] = $financialReports[0]->tipoarq;
                $mes    = $input['mes'];
                $ano    = $input['ano'];
                $dthoje = $DateAndTime = date('mdYhis', time());
                $qtdUnidades = sizeof($unidades);
                $dthoje   = substr($financialReports[0]->file_path, -18, -4);
                $extensao = substr($financialReports[0]->file_path, -3);
                for ($i = 1; $i <= $qtdUnidades; $i++) {
                    if ($unidade['id'] === $i) {
                        $txt1 = $unidades[$i - 1]['path_img'];
                        $txt1 = explode(".jpg", $txt1);
                        $txt2 = strtoupper($txt1[0]);
                        if ($input['title'] == 1) {
                            $input['title'] = "Relátorio Mensal";
                            $title = '.relat-mensal-finan-';
                        } else {
                            $input['title'] = "Prestação de contas";
                            $title = '.prest-contas-mensal-finan-';
                        }
                        if ($input['tipodoc'] == 2) {
                            $input['title'] = $input['title'] . '- Maternidade';
                            $tipodoc = "Maternidade-";
                        } elseif ($input['tipodoc'] == 3) {
                            $input['title'] = $input['title'] . '- COVID';
                            $tipodoc = "COVID-";
                        } elseif ($input['tipodoc'] == 4) {
                            $input['title'] = $input['title'] . '- Prefeitura';
                            $tipodoc = "Prefeitura-";
                        } else {
                            $tipodoc = "";
                        }
                        $nome = $mes . $title . $tipodoc . $ano . '-' . $txt2 . '-' . $dthoje . '.' . $extensao;
                        $novoFile_path = 'relatorio-mensal-financeiro/' . $txt1[0] . '/' . $ano . '/' . $nome;
                    }
                }
                if ($novoFile_path !== $financialReports[0]->file_path) {
                    rename("../public/storage/" . $financialReports[0]->file_path, "../public/storage/" . $novoFile_path);
                    $input['file_path'] = $novoFile_path;
                } else {
                    $input['file_path'] = $financialReports[0]->file_path;
                }
                $financialReport  = DemonstrativoFinanceiro::find($id_item);
                $financialReport->update($input);
                $input['registro_id'] = $id_item;
                $log              = LoggerUsers::create($input);
                $lastUpdated      = $log->max('updated_at');
                $financialReports = DemonstrativoFinanceiro::where('unidade_id', $id_unidade)->orderBy('ano', 'ASC')->orderBy('mes', 'ASC')->orderBy('title', 'ASC')->get();
                $validator        = "Desmonstrativo financeiro alterado com sucesso !";
                return redirect()->route('cadastroDF', [$id_unidade])
                    ->withErrors($validator);
            }
        } elseif ($input['tipoarq'] == 3) {
            if (isset($input['file_link'])) {
                if ($financialReports[0]->file_path == NULL) {
                    $input['file_path'] = "";
                } else {
                    $input['file_path'] = $financialReports[0]->file_path;
                }
                if ($input['title'] == 1) {
                    $input['title'] = "Relátorio Mensal";
                } else {
                    $input['title'] = "Prestação de contas";
                }
                if ($input['tipodoc'] == 2) {
                    $input['title'] = $input['title'] . '- Maternidade';
                } elseif ($input['tipodoc'] == 3) {
                    $input['title'] = $input['title'] . '- COVID';
                } elseif ($input['tipodoc'] == 4) {
                    $input['title'] = $input['title'] . '- Prefeitura';
                } else {
                    $input['title'] = $input['title'];
                }
                $input['tipoarq'] = 3;
                $financialReport  = DemonstrativoFinanceiro::find($id_item);
                $financialReport->update($input);
                $input['registro_id'] = $id_item;
                $log              = LoggerUsers::create($input);
                $lastUpdated      = $log->max('updated_at');
                $financialReports = DemonstrativoFinanceiro::where('unidade_id', $id_unidade)->orderBy('ano', 'ASC')->orderBy('mes', 'ASC')->orderBy('title', 'ASC')->get();
                $validator        = "Desmonstrativo financeiro alterado com sucesso !";
                return redirect()->route('cadastroDF', [$id_unidade])
                    ->withErrors($validator);
            } else {
                if ($financialReports[0]->file_link == NULL) {
                    if (isset($input['file_link']) == FALSE) {
                        $input['file_link'] = "";
                    }
                } else {
                    $input['file_link'] = $financialReports[0]->file_link;
                }
                if ($financialReports[0]->file_path == NULL) {
                    if (isset($input['file_link']) == FALSE) {
                        $input['file_link'] = "";
                    }
                } else {
                    $mes = $input['mes'];
                    $ano = $input['ano'];
                    $dthoje = $DateAndTime = date('mdYhis', time());
                    $qtdUnidades = sizeof($unidades);
                    $dthoje = substr($financialReports[0]->file_path, -18, -4);
                    $extensao = substr($financialReports[0]->file_path, -3);
                    for ($i = 1; $i <= $qtdUnidades; $i++) {
                        if ($unidade['id'] === $i) {
                            $txt1 = $unidades[$i - 1]['path_img'];
                            $txt1 = explode(".jpg", $txt1);
                            $txt2 = strtoupper($txt1[0]);
                            if ($input['title'] == 1) {
                                $input['title'] = "Relátorio Mensal";
                                $title = '.relat-mensal-finan-';
                            } else {
                                $input['title'] = "Prestação de contas";
                                $title = '.prest-contas-mensal-finan-';
                            }
                            if ($input['tipodoc'] == 2) {
                                $input['title'] = $input['title'] . '- Maternidade';
                                $tipodoc = "Maternidade-";
                            } elseif ($input['tipodoc'] == 3) {
                                $input['title'] = $input['title'] . '- COVID';
                                $tipodoc = "COVID-";
                            } elseif ($input['tipodoc'] == 4) {
                                $input['title'] = $input['title'] . '- Prefeitura';
                                $tipodoc = "Prefeitura-";
                            } else {
                                $tipodoc = "";
                            }
                            $nome = $mes . $title . $tipodoc . $ano . '-' . $txt2 . '-' . $dthoje . '.' . $extensao;
                            $novoFile_path = 'relatorio-mensal-financeiro/' . $txt1[0] . '/' . $ano . '/' . $nome;
                        }
                    }
                    if ($novoFile_path !== $financialReports[0]->file_path) {
                        rename("../public/storage/" . $financialReports[0]->file_path, "../public/storage/" . $novoFile_path);
                        $input['file_path'] = $novoFile_path;
                    } else {
                        $input['file_path'] = $financialReports[0]->file_path;
                    }
                }
                $input['tipoarq'] = $financialReports[0]->tipoarq;
                $financialReport  = DemonstrativoFinanceiro::find($id_item);
                $financialReport->update($input);
                $input['registro_id'] = $id_item;
                $log              = LoggerUsers::create($input);
                $lastUpdated      = $log->max('updated_at');
                $financialReports = DemonstrativoFinanceiro::where('unidade_id', $id_unidade)->orderBy('ano', 'ASC')->orderBy('mes', 'ASC')->orderBy('title', 'ASC')->get();
                $validator        = "Desmonstrativo financeiro alterado com sucesso !";
                return  redirect()->route('cadastroDF', [$id_unidade])
                    ->withErrors($validator);
            }
        }
    }
    public function destroyDF($id_unidade, $id_item, Request $request)
    {
        $input = $request->all();
        $financialReports = DemonstrativoFinanceiro::where('id',$id_item)->get();
        $image_path 	  = 'storage/'.$financialReports[0]->file_path;
        unlink($image_path);
        DemonstrativoFinanceiro::find($id_item)->delete();
        $input['registro_id'] = $id_item;
        $log          = LoggerUsers::create($input);
        $lastUpdated  = $log->max('updated_at');
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
        $financialReports = DemonstrativoFinanceiro::where('unidade_id', $id_unidade)->orderBy('ano', 'ASC')->get();
        $validator    = 'Demonstrativo Financeiro Excluído com sucesso!';
        return  redirect()->route('cadastroDF', [$id_unidade])
            ->withErrors($validator);
    }

    public function inativarDF($id_unidade, $id_item, Request $request)
    {
        $input = $request->all();
		$financialReports = DemonstrativoFinanceiro::where('id',$id_item)->get(); 
		if($financialReports[0]->status_financeiro == 1) {
		    $delimitador = $financialReports[0]->name_arq;
			$nomeArq    = explode($delimitador, $financialReports[0]->file_path);
			$nome       = "old_".$financialReports[0]->name_arq;
			$image_path = $nomeArq[0].$nome; 
			DB::statement("UPDATE financial_reports SET `status_financeiro` = 0, `file_path` = '$image_path', `name_arq` = '$nome' WHERE `id` = $id_item");
			$image_path = 'storage/'.$image_path;
			$caminho    = 'storage/'.$financialReports[0]->file_path;
			rename($caminho, $image_path);
		} else {
		    $delimitador = $financialReports[0]->name_arq;
			$nomeArq    = explode($delimitador, $financialReports[0]->file_path);
			$nome       = explode("old_", $financialReports[0]->name_arq); 
			$image_path = $nomeArq[0].$nome[1]; 
			DB::statement("UPDATE financial_reports SET `status_financeiro` = 1, `file_path` = '$image_path', `name_arq` = '$nome[1]' WHERE `id` = $id_item");
			$image_path = 'storage/'.$image_path; 
			$caminho    = 'storage/'.$financialReports[0]->file_path; 
			rename($caminho, $image_path);		
		}
		$input['registro_id'] = $id_item;
		$logger       = LoggerUsers::create($input);
		$lastUpdated  = $logger->max('updated_at');
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$financialReports = DemonstrativoFinanceiro::where('unidade_id',$id_unidade)->get();
		$validator    = 'Demonstrativo Financeiro inativado com sucesso!';
		return redirect()->route('cadastroDF', [$id_unidade])
				->withErrors($validator);
    }
}