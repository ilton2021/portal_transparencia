<?php

namespace App\Http\Controllers;

use App\Model\Unidade;
use App\Model\BensPublicos;
use App\Model\LoggerUsers;
use App\Model\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BensPublicosController extends Controller
{
    public function cadastroBP($id_und)
    {
        $unidadesMenu    = Unidade::where('status_unidades', 1)->get();
        $unidade         = $unidadesMenu->where('status_unidades',1)->find($id_und);
        $permissao_users = PermissaoUsers::where('unidade_id', $id_und)->get();
        $bens_pub        = BensPublicos::where('unidade_id', $id_und)->orderBy('ano','ASC')->orderBy('mes','ASC')->get();
        $validacao       = permissaoUsersController::Permissao($id_und);
        if ($validacao == "ok") {
            return view('transparencia.bensPublicos.benspub_cadastro', compact('unidade', 'unidadesMenu', 'permissao_users', 'bens_pub'));
        } else {
            $validator = "Você não tem permissão para acessar está página !";
            return view('transparencia.bens-publicos/benspub_cadastro', compact('unidade', 'unidadesMenu', 'permissao_users', 'bens_pub'))
                ->withErrors($validator);
        }
    }

    public function novoBP($id_und)
    {
        $unidadesMenu    = Unidade::where('status_unidades', 1)->get();
        $unidade         = $unidadesMenu->where('status_unidades',1)->find($id_und);
        $permissao_users = PermissaoUsers::where('unidade_id', $id_und)->get();
        $bens_pub        = BensPublicos::where('unidade_id', $id_und)->orderBy('ano','ASC')->orderBy('mes','ASC')->get();
        $validacao       = permissaoUsersController::Permissao($id_und);
        if ($validacao == "ok") {
            return view('transparencia.bensPublicos.benspub_novo', compact('unidade', 'unidadesMenu'));
        } else {
            $validator = "Você não tem permissão para acessar está página !";
            return view('transparencia.bens-publicos', compact('unidade', 'unidadesMenu', 'permissao_users', 'bens_pub'))
                ->withErrors($validator);
        }
    }

    public function storeBP($id_und, Request $request)
    {
        $input        = $request->all();
        $unidadesMenu = Unidade::where('status_unidades', 1)->get();
        $unidade      = $unidadesMenu->where('status_unidades',1)->find($id_und);
        $permissao_users = PermissaoUsers::where('unidade_id', $id_und)->get();
        $validacao    = permissaoUsersController::Permissao($id_und);
        if ($validacao == "ok") {
            if (isset($input['input-file']) == false) {
                $validator = "Você precisa anexar o documento !";
                return view('transparencia.bensPublicos.benspub_novo', compact('unidade', 'unidadesMenu', 'permissao_users'))
                    ->withInput(session()->flashInput($request->input()))
                    ->withErrors($validator);
            } else {
                $nome = $_FILES['input-file']['name'];
               
                $extensao = pathinfo($nome, PATHINFO_EXTENSION);
                if ($extensao === 'pdf') {
                    $nome = $_FILES['input-file']['name'];
                    $request->file('input-file')->move('../public/storage/bens_publicos/' . $unidade->sigla . '/', $nome);
                    $input['file_path']   = 'storage/bens_publicos/' . $unidade->sigla . '/' . $nome;
                    $input['unidade_id']  = $id_und;
                    $input['status_bens'] = 1;
                    $input['name_arq']    = $nome;
                    $bem_publico = BensPublicos::create($input);
                    $id_bem_publico = DB::table('bens_publicos')->max('id');
                    $input['tela'] = "bensPublicos";
                    $input['acao'] = "salvarBensPublicos";
                    $input['user_id'] = Auth::user()->id;
                    $input['unidade_id'] = $id_und;
                    $input['registro_id'] = $id_bem_publico;
                    $log = LoggerUsers::create($input);
                    $sucesso = "ok";
                    $validator = "Cadastro efetuado com sucesso !";
                    return redirect()->route('cadastroBP', [$id_und])
                        ->withErrors($validator);
                } else {
                    $validator = "O arquivo inserido precisar ser no formato PDF !";
                    return view('transparencia.bensPublicos.benspub_novo', compact('unidade', 'unidadesMenu', 'permissao_users'))
                        ->withInput(session()->flashInput($request->input()))
                        ->withErrors($validator);
                }
            }
        } else {
            $validator = "Você não tem permissão para acessar está página !";
            return view('transparencia.bens-publicos', compact('unidade', 'unidadesMenu', 'permissao_users', 'bens_pub'))
                ->withErrors($validator);
        }
    }

    public function telaInativarBP($id_und, $id_bens)
    {
        $unidadesMenu    = Unidade::where('status_unidades', 1)->get();
        $unidade         = $unidadesMenu->where('status_unidades',1)->find($id_und);
        $permissao_users = PermissaoUsers::where('unidade_id', $id_und)->get();
        $validacao       = permissaoUsersController::Permissao($id_und);
        if ($validacao == "ok") {
            $bens_pub = BensPublicos::where('id', $id_bens)->get();
            if (sizeof($bens_pub) == 0) {
                return  redirect()->route('cadastroBP', [$id_und]);
            } else {
                return view('transparencia.bensPublicos.benspub_inativar', compact('unidade', 'unidadesMenu', 'permissao_users', 'bens_pub'));
            }
        } else {
            $validator = "Você não tem permissão para acessar está página !";
            return view('transparencia.bens-publicos', compact('unidade', 'unidadesMenu', 'permissao_users', 'bens_pub'))
                ->withErrors($validator);
        }
    }

    public function excluirBP($id_und, $id_bens)
    {
        $unidadesMenu    = Unidade::where('status_unidades', 1)->get();
        $unidade         = $unidadesMenu->where('status_unidades',1)->find($id_und);
        $permissao_users = PermissaoUsers::where('unidade_id', $id_und)->get();
        $validacao       = permissaoUsersController::Permissao($id_und);
        if ($validacao == "ok") {
            $bens_pub = BensPublicos::where('id', $id_bens)->get();
            if (sizeof($bens_pub) == 0) {
                return  redirect()->route('cadastroBP', [$id_und]);
            } else {
                return view('transparencia.bensPublicos.benspub_excluir', compact('unidade', 'unidadesMenu', 'permissao_users', 'bens_pub'));
            }
        } else {
            $validator = "Você não tem permissão para acessar está página !";
            return view('transparencia.bens-publicos', compact('unidade', 'unidadesMenu', 'permissao_users', 'bens_pub'))
                ->withErrors($validator);
        }
    }

    public function destroyBP($id, $id_escolha, Request $request)
    {
		$unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = Unidade::where('status_unidades',1)->find($id);
		$input        = $request->all();
		$bens_pub     = BensPublicos::where('id',$id_escolha)->get();
		$image_path   = $bens_pub[0]->file_path;
        unlink($image_path);
        BensPublicos::find($id_escolha)->delete();
		$input['registro_id'] = $id_escolha;
        $input['unidade_id']  = $id;
		$log         = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$bens_pub    = BensPublicos::where('unidade_id',$id)->get();
		$validator   = 'Bens Públicos Excluído com sucesso!';
		return redirect()->route('cadastroBP', [$id])
			->withErrors($validator)
			->with('unidades', 'unidade', 'unidadesMenu', 'regimentos', 'lastUpdated');			
    }

    public function inativarBP($id_und, $id_bens, Request $request)
    {
        $input    = $request->all();
		$bens_pub = BensPublicos::where('id',$id_bens)->get(); 
		if($bens_pub[0]->status_bens == 1) { 
			$nomeArq    = explode($bens_pub[0]->name_arq, $bens_pub[0]->file_path); 
			$nome       = "old_".$bens_pub[0]->name_arq; 
			$image_path = $nomeArq[0].$nome;  
			DB::statement("UPDATE bens_publicos SET `status_bens` = 0, `file_path` = '$image_path', `name_arq` = '$nome' WHERE `id` = $id_bens");
			$caminho    = $bens_pub[0]->file_path; 
			rename($caminho, $image_path);
		} else {
			$nomeArq = explode($bens_pub[0]->name_arq, $bens_pub[0]->file_path); 
			$nome    = explode("old_", $bens_pub[0]->name_arq);     
            $image_path = $nomeArq[0].$nome[1];   
			DB::statement("UPDATE bens_publicos SET `status_bens` = 1, `file_path` = '$image_path', `name_arq` = '$nome[1]' WHERE `id` = $id_bens");
			$caminho    = $bens_pub[0]->file_path;
			rename($caminho, $image_path);		
		}
		$input['registro_id'] = $bens_pub[0]->id;
        $input['unidade_id']  = $id_und;
		$log          = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
        $unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = Unidade::where('status_unidades',1)->find($id_und);
		$bens_pub     = BensPublicos::where('unidade_id',$id_und)->get();
		$validator    = 'Bens Públicos inativado com sucesso!';
		return redirect()->route('cadastroBP', [$id_und])
				->withErrors($validator);
    }
}
