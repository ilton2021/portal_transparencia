<?php

namespace App\Http\Controllers;

use App\Model\Assistencial;
use App\Model\AssistencialDoc;
use App\Model\Unidade;
use App\Http\Controllers\PermissaoUsersController;
use App\Model\PermissaoUsers;
use App\Model\LoggerUsers;
use Auth;
use Validator;
use DB;

use Illuminate\Http\Request;

class AssistencialDocController extends Controller
{
    public function cadastroRADOC($id_und)
    {
        $validacao    = permissaoUsersController::Permissao($id_und);
		$unidades     = $unidadesMenu = Unidade::where('status_unidades', 1);
		$unidade      = Unidade::where('status_unidades',1)->find($id_und);
		$unidadesMenu = Unidade::where('status_unidades',1)->get();
		$anosRef      = Assistencial::where('unidade_id',$id_und)->where('status_assistencials',1)->orderBy('ano_ref','ASC')->pluck('ano_ref')->unique();
		$anosRefDocs  = AssistencialDoc::where('unidade_id',$id_und)->orderBy('ano','ASC')->get();
		$assistenDocs = AssistencialDoc::where('unidade_id',$id_und)->get();
		$lastUpdated  = $anosRefDocs->max('updated_at');
		if ($validacao == 'ok') {
			return view('transparencia/assistencialDocs/assistencial_cadastro', compact('unidade', 'unidades', 'unidadesMenu', 'assistenDocs', 'anosRef', 'anosRefDocs',  'lastUpdated'));
		} else {
			$validator = 'Você não tem permissão!!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
    }

    public function novoRADOC($id_und)
    {
        $unidadesMenu    = Unidade::where('status_unidades',1)->get();
        $unidade         = $unidadesMenu->where('status_unidades',1)->find($id_und);
        $permissao_users = PermissaoUsers::where('unidade_id', $id_und)->get();
        $validacao       = permissaoUsersController::Permissao($id_und);
        if ($validacao == "ok") {
            return view('transparencia.assistencialDocs.assistencial_novo', compact('unidade', 'unidadesMenu'));
        } else {
            $validator = "Você não tem permissão para acessar está página !";
            return view('transparencia.assistencial.assistencial_cadastro', compact('unidade', 'unidadesMenu', 'permissao_users', 'bens_pub'))
                ->withErrors($validator);
        }
    }

    public function storeRADOC($id_und, Request $request)
    {
        $input           = $request->all();
        $unidadesMenu    = Unidade::where('status_unidades',1)->get();
        $unidade         = $unidadesMenu->where('status_unidades',1)->find($id_und);
        $permissao_users = PermissaoUsers::where('unidade_id',$id_und)->get();
        $validacao       = permissaoUsersController::Permissao($id_und);
        if ($validacao == "ok") {
            $validator = Validator::make($request->all(), [
                'titulo' => 'required|max:255'
            ]);
            if ($validator->fails()) {
                return view('transparencia.assistencialDocs.assistencial_novo', compact('unidade', 'unidadesMenu', 'permissao_users'))
                    ->withInput(session()->flashInput($request->input()))
                    ->withErrors($validator);
            } else {
                if (isset($input['input-file']) == false) {
                    $validator = "Você precisa anexar o documento!";
                    return view('transparencia.assistencialDocs.assistencial_novo', compact('unidade', 'unidadesMenu', 'permissao_users'))
                        ->withInput(session()->flashInput($request->input()))
                        ->withErrors($validator);
                } else {
                    $nome = $_FILES['input-file']['name'];
                    $extensao = pathinfo($nome, PATHINFO_EXTENSION);
                    if ($extensao === 'pdf' || $extensao === 'PDF') {
                        $dthratual = rand(1, 99999) . "-";
                        $ano  = $input['ano'];
                        $nome = $_FILES['input-file']['name'];
                        $request->file('input-file')->move('../public/storage/assistencialDocs/' . $unidade->sigla . '/' . $ano . '/', $dthratual . $nome);
                        $input['file_path']  = 'storage/assistencialDocs/' . $unidade->sigla . '/' . $ano . '/' . $dthratual . $nome;
                        $input['name_arq']   = $dthratual . $nome;
                        $input['unidade_id'] = $id_und;
                        $input['status_ass_doc'] = 1;
                        $assist_doc = AssistencialDoc::create($input);
                        $id_assist_doc = DB::table('assitencials_docs')->max('id');
                        $input['tela'] = "AssistencialDocs";
                        $input['acao'] = "salvarAssistencialDocs";
                        $input['user_id']     = Auth::user()->id;
                        $input['unidade_id']  = $id_und;
                        $input['registro_id'] = $id_assist_doc;
                        $log       = LoggerUsers::create($input);
                        $sucesso   = "ok";
                        $validator = "Cadastro efetuado com sucesso !";
                        return  redirect()->route('cadastroRA', $id_und)
                            ->withErrors($validator);
                    } else {
                        $validator = "O arquivo inserido precisar ser no formato PDF !";
                        return view('transparencia.assistencialDocs.assistencial_novo', compact('unidade', 'unidadesMenu', 'permissao_users'))
                            ->withInput(session()->flashInput($request->input()))
                            ->withErrors($validator);
                    }
                }
            }
        } else {
            $validator = "Você não tem permissão para acessar está página !";
            return view('transparencia.assistencial.assistencial_cadastro', compact('unidade', 'unidadesMenu', 'permissao_users'))
                ->withErrors($validator);
        }
    }

    public function telaInativarRADOC($id_und, $id_doc)
    {
        $unidadesMenu    = Unidade::where('status_unidades',1)->get();
        $unidade         = $unidadesMenu->where('status_unidades',1)->find($id_und);
        $permissao_users = PermissaoUsers::where('unidade_id',$id_und)->get();
        $assistenDoc     = AssistencialDoc::where('unidade_id',$id_und)->where('id', $id_doc)->get();
        $validacao       = permissaoUsersController::Permissao($id_und);
        if ($validacao == "ok") {
            return view('transparencia.assistencialDocs.assistencial_inativar', compact('unidade', 'unidadesMenu', 'assistenDoc'));
        } else {
            $validator = "Você não tem permissão para acessar está página !";
            return view('transparencia.assistencial.assistencial_cadastro', compact('unidade', 'unidadesMenu', 'permissao_users', 'bens_pub'))
                ->withErrors($validator);
        }
    }

    public function excluirRADOC($id_und, $id_doc)
    {
        $unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$input        = $request->all();
		$assistenDoc    = AssistencialDoc::where('id',$id_escolha)->get();
		$image_path   = 'storage/'.$assistenDoc[0]->file_path;
        unlink($image_path);
        AssistencialDoc::find($id_escolha)->delete();
		$input['registro_id'] = $id_escolha;
		$log         = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$regimentos  = AssistencialDoc::where('status_ass_doc',1)->where('unidade_id',$id)->get();
		$validator   = 'Relatório Anual de Gestão Excluído com sucesso!';
		return  redirect()->route('cadastroRA', [$id])
			->withErrors($validator)
			->with('unidades', 'unidade', 'unidadesMenu', 'regimentos', 'lastUpdated');		
    }


    public function inativarRADOC($id_und, $id_doc, Request $request)
    {
        $input       = $request->all();
		$assistenDoc = AssistencialDoc::where('id',$id_doc)->get();
		if($assistenDoc[0]->status_ass_doc == 1) {
			$nomeArq    = explode($assistenDoc[0]->name_arq, $assistenDoc[0]->file_path);
			$nome       = "old_". $assistenDoc[0]->name_arq; 
			$image_path = $nomeArq[0].$nome; 
			DB::statement("UPDATE assitencials_docs SET `status_ass_doc` = 0, `file_path` = '$image_path', `name_arq` = '$nome' WHERE `id` = $id_doc");
			$caminho = $assistenDoc[0]->file_path;
			rename($caminho, $image_path);
		} else {
			$nomeArq    = explode($assistenDoc[0]->name_arq, $assistenDoc[0]->file_path);
            $nome       = explode("old_", $assistenDoc[0]->name_arq); 
			$image_path = $nomeArq[0].$nome[1];
			DB::statement("UPDATE assitencials_docs SET `status_ass_doc` = 1, `file_path` = '$image_path', `name_arq` = '$nome[1]' WHERE `id` = $id_doc");
			$caminho = $assistenDoc[0]->file_path;
			rename($caminho, $image_path);		
		}
		$input['registro_id'] = $assistenDoc[0]->id;
		$log          = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
        $unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = Unidade::where('status_unidades',1)->find($id_und);
		$assistenDoc  = AssistencialDoc::where('unidade_id',$id_und)->get();
		$validator    = 'Relatório Anual de Gestão inativado com sucesso!';
		return redirect()->route('cadastroRA', [$id_und])
				->withErrors($validator);
    }
}
