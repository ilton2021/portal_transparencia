<?php

namespace App\Http\Controllers;

use App\Model\Ouvidoria;
use App\Model\OuvidoriaRelEstatis;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use App\Model\Unidade;
use Illuminate\Support\Facades\Storage;
use App\Model\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Auth;
use Validator;
use DB;

class OuvidoriaController extends Controller
{
    public function __construct(Unidade $unidade, Ouvidoria $ouvidoria)
    {
        $this->unidade 	 = $unidade;
		$this->ouvidoria = $ouvidoria;
    }
    
    public function cadastroOV($id, Request $request)
    {
        $validacao    = permissaoUsersController::Permissao($id);
		$unidade      = $this->unidade->find($id);
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		if($id == 1){
            $ouvidorias = Ouvidoria::all();
        } else {
            $ouvidorias = Ouvidoria::where('unidade_id', $id)->get();
        }
		if($validacao == 'ok') {
			return view('transparencia/ouvidoria/ouvidoria_cadastro', compact('unidades','unidadesMenu','unidade','ouvidorias'));
		} else {
			$validator = 'Você não tem Permissão!!';		
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
    }

    public function novoOV($id, Request $request)
    {
        $validacao 	  = permissaoUsersController::Permissao($id);
		$unidade      = $this->unidade->find($id);
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		if($validacao == 'ok') {
			return view('transparencia/ouvidoria/ouvidoria_novo', compact('unidades','unidadesMenu','unidade'));
		} else {
			$validator = 'Você não tem Permissão!!';		
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
    }

    public function alterarOV($id, $id_ouvidoria, Request $request)
    {
        $validacao 	  = permissaoUsersController::Permissao($id);
		$unidade      = $this->unidade->find($id);
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
        $ouvidoria 	  = $this->ouvidoria->where('status_ouvidoria', 1)->find($id_ouvidoria);
		if($validacao == 'ok') {
			return view('transparencia/ouvidoria/ouvidoria_alterar', compact('unidades','unidadesMenu','unidade','ouvidoria'));
		} else {
			$validator = "Você não tem Permissão!!";		
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
    }

    public function excluirOV($id, $id_ouvidoria, Request $request)
    {
        $validacao = permissaoUsersController::Permissao($id);
		$unidade      = $this->unidade->find($id);
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = Unidade::all();
        $ouvidoria    = $this->ouvidoria->find($id_ouvidoria);
		if($validacao == 'ok') {
			return view('transparencia/ouvidoria/ouvidoria_excluir', compact('unidades','unidadesMenu','unidade','ouvidoria'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
    }

	public function telaInativarOV($id, $id_ouvidoria, Request $request)
    {
        $validacao = permissaoUsersController::Permissao($id);
		$unidade      = $this->unidade->find($id);
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
        $ouvidoria    = $this->ouvidoria->find($id_ouvidoria);
		if($validacao == 'ok') {
			return view('transparencia/ouvidoria/ouvidoria_inativar', compact('unidades','unidadesMenu','unidade','ouvidoria'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
    }

    public function storeOV($id, Request $request)
    {
        $unidade      = $this->unidade->find($id);
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$input        = $request->all();
		$validator = Validator::make($request->all(), [
            'email'       => 'required|max:255|email',
            'telefone'    => 'required|max:15'		
		]);
		if ($validator->fails()) {
			return view('transparencia/ouvidoria/ouvidoria_novo', compact('unidade','unidades','unidadesMenu'))
			  ->withErrors($validator)
			  ->withInput(session()->flashInput($request->input()));
		} else {
			$input['status_ouvidoria'] = 1;
			$ouvidoria   = Ouvidoria::create($input);
			$id_registro = DB::table('ouvidoria')->max('id');
			$input['registro_id'] = $id_registro;
			$log         = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$ouvidorias  = $this->ouvidoria->where('status_ouvidoria',1);
			$validator   = 'Ouvidoria cadastrada com sucesso!';	
			return redirect()->route('cadastroOV', [$id])
					->withErrors($validator);	
		}
    }

    public function updateOV($id, $id_ouvidoria, Request $request)
    {
        $unidade      = $this->unidade->find($id);
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$ouvidoria 	  = $this->ouvidoria->where('status_ouvidoria', 1)->find($id_ouvidoria);
		$input        = $request->all();
		$validator = Validator::make($request->all(), [
            'email'       => 'required|max:255|email',
            'telefone'    => 'required|max:40'		
		]);
		if ($validator->fails()) {
			return view('transparencia/ouvidoria/ouvidoria_alterar', compact('unidade','unidades','unidadesMenu','ouvidoria'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$ouvidoria = $this->ouvidoria->find($id_ouvidoria);
            $ouvidoria->update($input);	
			$input['registro_id'] = $id_ouvidoria;
			$log         = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$ouvidoria  = Ouvidoria::where('status_ouvidoria',1)->where('id',$id_ouvidoria)->get();
			$validator   = 'Ouvidoria alterada com sucesso!';		
			return redirect()->route('cadastroOV', [$id])
				->withErrors($validator);	
		}
    }

    public function destroyOV($id, $id_ouvidoria, Request $request)
    {
		Ouvidoria::find($id_ouvidoria)->delete();
		$input        = $request->all();
		$input['registro_id'] = $id_ouvidoria;
		$log          = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
        $unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades', 1)->find($id);
		$ouvidorias  = Ouvidoria::where('status_ouvidoria',1)->where('id',$id_ouvidoria)->get();
		$validator = 'Ouvidoria excluída com sucesso!';
		return redirect()->route('cadastroOV', [$id])
				->withErrors($validator);
    }

	public function inativarOV($id, $id_ouvidoria, Request $request)
    {
		$input = $request->all();
		$ouvidoria = Ouvidoria::where('id',$id_ouvidoria)->get();
		if($ouvidoria[0]->status_ouvidoria == 1) {
			DB::statement('UPDATE ouvidoria SET status_ouvidoria = 0 WHERE id = '.$id_ouvidoria.';');
		} else {
			DB::statement('UPDATE ouvidoria SET status_ouvidoria = 1 WHERE id = '.$id_ouvidoria.';');
		}
		$input['registro_id'] = $id_ouvidoria;
		$log          = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
        $unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades', 1)->find($id);
		$ouvidorias  = Ouvidoria::where('status_ouvidoria',1)->where('id',$id_ouvidoria)->get();
		$validator = 'Ouvidoria inativada com sucesso!';
		return redirect()->route('cadastroOV', [$id])
				->withErrors($validator);
    }
    public function cadastroOVRelatorioES($id)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidade      = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		if ($validacao == 'ok') {
			$relatoriosEs = OuvidoriaRelEstatis::where('unidade_id', $id)->orderBy('ano', 'ASC')->orderBy('mes', 'ASC')->get();
			return view('transparencia/ouvidoria/ouvidoria_rel_estatis_cadastro', compact('unidades', 'unidadesMenu', 'unidade', 'relatoriosEs'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function novoOVRelatorioES($id)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidade      = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		if ($validacao == 'ok') {
			return view('transparencia/ouvidoria/ouvidoria_rel_estatis_novo', compact('unidades', 'unidadesMenu', 'unidade'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}
	public function storeOVRelatorioES($id, Request $request)
	{
		$unidade      = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		$input        = $request->all();
		$validacao = permissaoUsersController::Permissao($id);
		if ($validacao == 'ok') {
			$validator = Validator::make($request->all(), [
				'file_path'       => 'required',
				'mes'    => 'required',
				'ano'    => 'required'
			]);
			if ($validator->fails()) {
				return view('transparencia/ouvidoria/ouvidoria_rel_estatis_novo', compact('unidades', 'unidadesMenu', 'unidade'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			} else {
				$Relatorio = OuvidoriaRelEstatis::where('mes', $input['mes'])->where('ano', $input['ano'])->where('status_ouvi_rel_estas', 1)->get();
				if (sizeof($Relatorio) > 0) {
					$validator = "Já existe um relatorio estastico ativo cadastrado neste mês e ano";
					return view('transparencia/ouvidoria/ouvidoria_rel_estatis_novo', compact('unidades', 'unidadesMenu', 'unidade'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				} else {
					$nome = $_FILES['file_path']['name'];
					$extensao = pathinfo($nome, PATHINFO_EXTENSION);
					$extensao = strtolower($extensao);
					if ($extensao !== 'pdf') {
						$validator = "O arquivo precisa ser no formato PDF";
						return view('transparencia/ouvidoria/ouvidoria_rel_estatis_novo', compact('unidades', 'unidadesMenu', 'unidade'))
							->withErrors($validator)
							->withInput(session()->flashInput($request->input()));
					} else {
						$dthoje = $DateAndTime = date('mdYhis', time());
						$mes = $input['mes'];
						$ano = $input['ano'];
						$nome   = "$mes-$ano-$dthoje-$nome";
						$siglaUnd = ($this->unidade->where('id', $id)->get())[0]->sigla;
						$caminho = "../public/storage/ouvidoriaRelEstastic/$siglaUnd/$ano/";
						$upload = $request->file('file_path')->move($caminho, $nome);
						$input['file_path'] = "ouvidoriaRelEstastic/$siglaUnd/$ano/$nome";
						$input['name_arq'] = $nome;
						$demonstrativo = OuvidoriaRelEstatis::create($input);
						$id_registro   = DB::table('ouvidoria_rel_estatis')->max('id');
						$input['registro_id'] = $id_registro;
						$log           = LoggerUsers::create($input);
						$validator     = 'Relatório estastico - Pai cadastrado com sucesso!';
						return redirect()->route('cadastroOVRelatorioES', [$id])
							->withErrors($validator);
					}
				}
			}
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function alterarOVRelatorioES($id, $id_doc)
	{
		$unidade      = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		$validacao = permissaoUsersController::Permissao($id);
		if ($validacao == 'ok') {
			$relEstatisc = OuvidoriaRelEstatis::find($id_doc);
			return view('transparencia/ouvidoria/ouvidoria_rel_estatis_alterar', compact('unidades', 'unidadesMenu', 'unidade', 'relEstatisc'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function updateOVRelatorioES($id, $id_doc, Request $request)
	{
		$input        = $request->all();
		$unidade      = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		$validacao = permissaoUsersController::Permissao($id);
		if ($validacao == 'ok') {
			$relEstatisc = OuvidoriaRelEstatis::find($id_doc);
			$validator = Validator::make($request->all(), [
				'arquivo' => 'required',
				'mes'    => 'required',
				'ano'    => 'required'
			]);
			if ($validator->fails()) {
				return view('transparencia/ouvidoria/ouvidoria_rel_estatis_alterar', compact('unidades', 'unidadesMenu', 'unidade', 'relEstatisc'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			} else {
				$nome = $_FILES['arquivo']['name'];
				$extensao = pathinfo($nome, PATHINFO_EXTENSION);
				$extensao = strtolower($extensao);
				if ($extensao !== 'pdf') {
					$validator = "O arquivo precisa ser no formato PDF";
					return view('transparencia/ouvidoria/ouvidoria_rel_estatis_novo', compact('unidades', 'unidadesMenu', 'unidade'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				} else {
					$dthoje = $DateAndTime = date('mdYhis', time());
					$mes = $input['mes'];
					$ano = $input['ano'];
					$nome   = "$mes-$ano-$dthoje-$nome";
					$siglaUnd = ($this->unidade->where('id', $id)->get())[0]->sigla;
					$caminho = "../public/storage/ouvidoriaRelEstastic/$siglaUnd/$ano/";
					$upload = $request->file('arquivo')->move($caminho, $nome);
					$input['file_path'] = "ouvidoriaRelEstastic/$siglaUnd/$ano/$nome";
					$input['name_arq'] = $nome;
					$relEstatisc = OuvidoriaRelEstatis::find($id_doc);
					$relEstatisc->update($input);
					$input['registro_id'] = $id_doc;
					$log         = LoggerUsers::create($input);
					$validator = 'Relatório estastico - Pai alterado com sucesso!';
					return redirect()->route('cadastroOVRelatorioES', [$id])
						->withErrors($validator);
				}
			}
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function statusOVRelatorioES($id, $id_doc, Request $request)
	{
		$unidade      = $this->unidade->find($id);
		$unidadesMenu = $this->unidade->where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		$validacao = permissaoUsersController::Permissao($id);
		if ($validacao == 'ok') {
			$input = $request->all();
			$relEstatisc = OuvidoriaRelEstatis::find($id_doc);
			if ($relEstatisc->status_ouvi_rel_estas == 0) {
				$relatorio = OuvidoriaRelEstatis::where('id', '<>', $id_doc)->where('mes', $relEstatisc->mes)->where('ano', $relEstatisc->ano)->where('status_ouvi_rel_estas', 1)->get();
				if (sizeof($relatorio) > 0) {
					$validator = "Não foi possivel reativar, pois já existe um relatorio estastico ativo cadastrado mês e ano";
					return redirect()->route('cadastroOVRelatorioES', [$id])
						->withErrors($validator);
				} else {
					$delimitador = $relEstatisc->name_arq;
					$nomeArq    = explode($delimitador, $relEstatisc->file_path);
					$nome       = explode("old_", $relEstatisc->name_arq);
					$image_path = $nomeArq[0] . $nome[1];
					DB::statement("UPDATE ouvidoria_rel_estatis SET `status_ouvi_rel_estas` = 1, `file_path` = '$image_path', `name_arq` = '$nome[1]' WHERE `id` = $id_doc");
					$image_path = 'storage/' . $image_path;
					$caminho    = 'storage/' . $relEstatisc->file_path;
					rename($caminho, $image_path);
					$validator   = "Relatório Estatístico Pai reativado com sucesso !";
				}
			} else {
				$delimitador = $relEstatisc->name_arq;
				$nomeArq    = explode($delimitador, $relEstatisc->file_path);
				$nome       = "old_" . $relEstatisc->name_arq;
				$image_path = $nomeArq[0] . $nome;
				DB::statement("UPDATE ouvidoria_rel_estatis SET `status_ouvi_rel_estas` = 0, `file_path` = '$image_path', `name_arq` = '$nome' WHERE `id` = $id_doc");
				$image_path = 'storage/' . $image_path;
				$caminho    = 'storage/' . $relEstatisc->file_path;
				rename($caminho, $image_path);
				$validator   = "Relatório Estatístico Pai inativado com sucesso !";
			}
			$relEstatisc->update($input);
			$input['registro_id'] = $id_doc;
			$log         = LoggerUsers::create($input);
			return redirect()->route('cadastroOVRelatorioES', [$id])
				->withErrors($validator);
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}
}