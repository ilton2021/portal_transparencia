<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\contratacao_servicos;
use App\Model\Unidade;
use App\Model\especialidades;
use App\Model\especialidade_contratacao;
use Illuminate\Support\Facades\Storage;
use DB;
use PhpParser\Node\Stmt\If_;
use Symfony\Component\VarDumper\VarDumper;
use Validator;

class contratacaoServicosController extends Controller
{
    public function paginaContratacaoServicos()
    {
        $unidades = Unidade::all();
        $contratacao_servicos = contratacao_servicos::all();
        $sucesso = ""; 
        return view('contratacao_servicos/contratacaoServicos_listagem', compact('contratacao_servicos', 'unidades','sucesso'));
    }

    public function novaContratacaoServicos(Request $request)
    {
        $sucesso = "";
        $Unidades = Unidade::all();
        $contratacao_servicos = contratacao_servicos::all();
        $especialidades = especialidades::all();
        

        return view('contratacao_servicos/contratacaoServicos_novo', compact('contratacao_servicos', 'Unidades', 'especialidades','sucesso'));
    }

    public function salvarContratacaoServicos(Request $request)
    {
        $sucesso = "";
        $Unidades = Unidade::all();
        $contratacao_servicos = contratacao_servicos::all();
        $especialidades = especialidades::all();
        $especialidade_contratacao = especialidade_contratacao::all();

        $input = $request->all();
        $unidade_id = $input['unidade_id'];
        $nome = $_FILES['nome_arq']['name'];
        $dtPrazoIni = $input['prazoInicial'];
        $dtPrazoFim = $input['prazoFinal'];
        $extensao = pathinfo($nome, PATHINFO_EXTENSION);

        //Vericação de inputs
        $validator = Validator::make($request->all(), [
            'texto' => 'required|max:255',
            'nome_arq' => 'required|max:2000',
            'unidade_id' => 'required|max:255',
            'prazoInicial' => 'required',
            'prazoFinal' => 'required'
        ]);
        //Verificação de escolha de especialidade
        $count = sizeof($especialidades);
        $qtdEspSelec = array();
        for ($i = 0; $i <= $count; $i++) {
            if (!empty($input['especialidade_' . $i])){
            $qtdEspSelec[$i] = $input['especialidade_' . $i];
            }
        }

        if ($validator->fails()) {
            return view('contratacao_servicos/contratacaoServicos_novo', compact('contratacao_servicos', 'Unidades', 'especialidades','sucesso'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        } elseif ($dtPrazoIni >= $dtPrazoFim) {
            $sucesso = "no";
            $validator = 'A data inicial do prazo não pode ser maior ou igual que a data final ! ';
            return view('contratacao_servicos/contratacaoServicos_novo', compact('contratacao_servicos', 'Unidades', 'especialidades','sucesso'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        } elseif((sizeof($qtdEspSelec)) == 0){
            $sucesso = "no";
            $validator = 'Escolha pelo menos um especialidade !';
            return view('contratacao_servicos/contratacaoServicos_novo', compact('contratacao_servicos', 'Unidades', 'especialidades','sucesso'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        }elseif ($request->file('nome_arq') === NULL) {
            $sucesso = "no";
            $validator = 'Você esqueceu de anexar o arquivo!';
            return view('contratacao_servicos/contratacaoServicos_novo', compact('contratacao_servicos', 'Unidades', 'especialidades','sucesso'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        } elseif ($extensao === 'pdf') {
            $nome = $_FILES['nome_arq']['name'];
            $request->file('nome_arq')->move('../public/storage/contratacao_servicos/', $nome);
            $input['arquivo'] = 'contratacao_servicos/' . $nome;
            $input['nome_arq'] = $nome;
            $input['titulo'] = 'Proposta de contratação' . '-' . $input['unidade_id'] . '-' . now();
            $contratacao_servicos = contratacao_servicos::create($input);
            $id_contratacao_servico = DB::table('contratacao_servicos')->max('id');
            $count = sizeof($especialidades);
            
            for ($i = 0; $i <= $count; $i++) {
                if (!empty($input['especialidade_' . $i])) {
                    
                    $especialidade_id = $input['especialidade_' . $i];
                    if ($especialidade_id == $i) {
                        $input['contratacao_servicos_id'] =  $id_contratacao_servico;
                        $input['especialidades_id'] = $especialidade_id;
                        $especialidade_contratacao = especialidade_contratacao::all();
                        $especialidade_contratacao = especialidade_contratacao::create($input);
                    }
                }
            }
            $contratacao_servicos = contratacao_servicos::all();
            $sucesso = "ok";
            $validator = 'Contratação de serviço cadastrada sucesso!';
            return view('contratacao_servicos/contratacaoServicos_novo', compact('contratacao_servicos', 'Unidades', 'especialidades','sucesso','validator'))
                ->withInput(session()->flashInput($request->input()));
        } else {
            $sucesso = "no";
            $validator = 'Só são permitidos os arquivos do tipo: PDF';
            return view('contratacao_servicos/contratacaoServicos_novo', compact('contratacao_servicos', 'Unidades', 'especialidades','sucesso'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        }
    }

    //Pesquisar contratação
    public function pesquisarContratacao(Request $request)
    {
        $input = $request->all();
        $unidades = Unidade::all();
        $pesq = $input['unidade_id'];
        if (!$pesq == "") {
            $contratacao_servicos = DB::table('contratacao_servicos')->where('unidade_id', $pesq)->get();
        } else {
            $contratacao_servicos = contratacao_servicos::all();
        }
        return view('contratacao_servicos/contratacaoServicos_listagem', compact('contratacao_servicos', 'unidades'));
    }
    //Pagina exclusão contratação
    public function pagExcluirContratacao($id){
        $sucesso = "";
        $contratacao_servicos  = contratacao_servicos::where('id', $id)->get();
        $unidade_id = $contratacao_servicos[0]->unidade_id;
        $Unidades = Unidade::where('id', $unidade_id)->get();
        $especialidades = especialidades::all();
        $especialidade_contratacao = especialidade_contratacao::where('contratacao_servicos_id', $id)->get('especialidades_id');
        return view('contratacao_servicos/contratacaoServicos_excluir', compact('contratacao_servicos','Unidades','sucesso','especialidades','especialidade_contratacao'));
    }
    //Excluir contratação
    public function excluirContratacao($id){
        especialidade_contratacao::where('contratacao_servicos_id', $id)->delete();
        contratacao_servicos::find($id)->delete();
        $unidades = Unidade::all();
        $contratacao_servicos = contratacao_servicos::all();
        $especialidades = especialidades::all();
        $unidades = Unidade::all();
        $validator = "Contratação de serviço exluida com sucesso";
        return redirect()->route('paginaContratacaoServicos', compact('contratacao_servicos','especialidades','unidades'));
    }
    //Excluir especialidade do contrato
    public function exclEspeContr($idContr,$idEsp){
        especialidade_contratacao::where('contratacao_servicos_id', $idContr)->where('especialidades_id', $idEsp)->delete();
        $sucesso = "";
        $contratacao_servicos  = contratacao_servicos::where('id',$idContr)->get();
        $unidade_id = $contratacao_servicos[0]->unidade_id;
        $Unidades = Unidade::where('id', $unidade_id)->get();
        $especialidades = especialidades::all();
        $especialidade_contratacao = especialidade_contratacao::where('contratacao_servicos_id', $idContr)->get('especialidades_id');
        return view('contratacao_servicos/contratacaoServicos_alterar', compact('contratacao_servicos','Unidades','sucesso','especialidades','especialidade_contratacao', 'unidade_id'));
    
    }

    //Excluir arquivo contratação

    public function exclArqContr($id, Request $request){
        
        $contratacao_servicos  = contratacao_servicos::where('id', $id)->get();
        $pasta = $contratacao_servicos[0]->arquivo;
        Storage::delete($pasta);
        //return $pasta;
        $input['arquivo'] = '';
        $input['nome_arq'] = '';
        $contratacao_servicos  = contratacao_servicos::find($id);
        $contratacao_servicos->update($input);
        $sucesso = "ok";
        $contratacao_servicos  = contratacao_servicos::where('id', $id)->get();
        $unidade_id = $contratacao_servicos[0]->unidade_id;
        $Unidades = Unidade::all();
        $especialidades = especialidades::all();
        $validator = "Arquivo excluido com sucesso !";
        $especialidade_contratacao = especialidade_contratacao::where('contratacao_servicos_id', $id)->get('especialidades_id');
        return  redirect()->route('pagAlteraContratacao',[$id])
            ->withErrors($validator);
    }


    //Pagina Alterar Contratacao

    public function pagAlteraContratacao($id){
        $sucesso = "";
        $contratacao_servicos  = contratacao_servicos::where('id', $id)->get();
        $unidade_id = $contratacao_servicos[0]->unidade_id;
        $Unidades = Unidade::all();
        $especialidades = especialidades::all();
        $especialidade_contratacao = especialidade_contratacao::where('contratacao_servicos_id', $id)->get('especialidades_id');
        
        return view('contratacao_servicos/contratacaoServicos_alterar', compact('contratacao_servicos','Unidades','sucesso','especialidades','especialidade_contratacao','unidade_id'));
    }
    //Alterar dados contratacao
    public function alteraContratacao($id,Request $request){
        
        $input = $request->all();
        $sucesso = "";
        $contratacao_servicos  = contratacao_servicos::where('id', $id)->get();
        $unidade_id = $contratacao_servicos[0]->unidade_id;
        $nome_arq = $contratacao_servicos[0]->arquivo;
        $Unidades = Unidade::all();
        $especialidades = especialidades::all();
        $especialidade_contratacao = especialidade_contratacao::where('contratacao_servicos_id', $id)->get('especialidades_id');
        $dtPrazoIni = $input['prazoInicial'];
        $dtPrazoFim = $input['prazoFinal'];
        
        $isTouch = isset($input['nome_arq']);
        if($isTouch == true){
            $nome = $_FILES['nome_arq']['name'];
            $extensao = pathinfo($nome, PATHINFO_EXTENSION);
        }
        $validator = Validator::make($request->all(), [
            'texto' => 'required|max:255',
            'unidade_id' => 'required|max:255',
            'prazoInicial' => 'required',
            'prazoFinal' => 'required'
        ]);
            if ($validator->fails()) {
                $sucesso = "no";
                return view('contratacao_servicos/contratacaoServicos_alterar', compact('contratacao_servicos','Unidades','sucesso','especialidades','especialidade_contratacao','unidade_id'))
                    ->withErrors($validator)
                    ->withInput(session()->flashInput($request->input()));
            }elseif ($dtPrazoIni >= $dtPrazoFim) {
                $sucesso = "no";
                $validator = 'A data inicial do prazo não pode ser maior ou igual que a data final !';
                return view('contratacao_servicos/contratacaoServicos_alterar', compact('contratacao_servicos', 'Unidades', 'especialidades','sucesso','especialidade_contratacao','unidade_id'))
                    ->withErrors($validator)
                    ->withInput(session()->flashInput($request->input()));              
            }elseif($nome_arq != ""){
                $contratacao_servicos= contratacao_servicos::find($id);
                $contratacao_servicos->update($input);
                $count = sizeof($especialidades);
                $id_contratacao_servico = DB::table('contratacao_servicos')->max('id');
                     
                for ($i = 0; $i <= $count; $i++) {
                    if (!empty($input['especialidade_' . $i])) {
                        $especialidade_id = $input['especialidade_' . $i];
                        $espContr = especialidade_contratacao::where('contratacao_servicos_id',$id)
                        ->where('especialidades_id',$especialidade_id)
                        ->get();
                        $espContr = sizeof($espContr);
                        if($espContr == 0)
                            if ($especialidade_id == $i) {
                                $input['contratacao_servicos_id'] =  $id_contratacao_servico;
                                $input['especialidades_id'] = $especialidade_id;
                                $especialidade_contratacao = especialidade_contratacao::all();          
                                $especialidade_contratacao = especialidade_contratacao::create($input);
                            }
                        }
                }
                $contratacao_servicos  = contratacao_servicos::where('id', $id)->get();
                $especialidade_contratacao = especialidade_contratacao::where('contratacao_servicos_id', $id)->get();
                $sucesso = "ok";
                $validator = 'Contratação de serviço alterada com sucesso!';
                return view('contratacao_servicos/contratacaoServicos_alterar', compact('contratacao_servicos', 'Unidades', 'especialidades','sucesso','validator','unidade_id','especialidade_contratacao'))
                    ->withInput(session()
                    ->flashInput($request->input()));

            }elseif ($request->file('nome_arq') === NULL) {
                $sucesso = "no";
                $validator = 'Você esqueceu de anexar o arquivo!';
                return view('contratacao_servicos/contratacaoServicos_alterar', compact('contratacao_servicos', 'Unidades', 'especialidades','sucesso','unidade_id','especialidade_contratacao'))
                    ->withErrors($validator)
                    ->withInput(session()->flashInput($request->input()));
            }elseif ($extensao === 'pdf') {
                $nome = $_FILES['nome_arq']['name'];
                $request->file('nome_arq')->move('../public/storage/contratacao_servicos/', $nome);
                $input['arquivo'] = 'contratacao_servicos/' . $nome;
                $input['nome_arq'] = $nome;
                $input['titulo'] = 'Proposta de contratação' . '-' . $input['unidade_id'] . '-' . now();
                $contratacao_servicos= contratacao_servicos::find($id);
                $contratacao_servicos->update($input);
                $count = sizeof($especialidades);
                $id_contratacao_servico = DB::table('contratacao_servicos')->max('id');  
                for ($i = 0; $i <= $count; $i++) {
                    if (!empty($input['especialidade_' . $i])){
                        $especialidade_id = $input['especialidade_' . $i];
                        $espContr = especialidade_contratacao::where('contratacao_servicos_id',$id)
                        ->where('especialidades_id',$especialidade_id)
                        ->get();
                        $espContr = sizeof($espContr);
                        if($espContr == 0)
                        if ($especialidade_id == $i) {
                            $input['contratacao_servicos_id'] =  $id_contratacao_servico;
                            $input['especialidades_id'] = $especialidade_id;
                            $especialidade_contratacao = especialidade_contratacao::all();    
                            $especialidade_contratacao = especialidade_contratacao::create($input);
                        }
                    }
                }
                $contratacao_servicos  = contratacao_servicos::where('id', $id)->get();
                $especialidade_contratacao = especialidade_contratacao::all(); 
                $sucesso = "ok";
                $validator = 'Contratação de serviço alterada com sucesso!';
                return view('contratacao_servicos/contratacaoServicos_alterar', compact('contratacao_servicos', 'Unidades', 'especialidades','sucesso','validator','unidade_id','especialidade_contratacao'))
                    ->withInput(session()
                    ->flashInput($request->input()));
            }else {
                $sucesso = "no";
                $validator = 'Só são permitidos os arquivos do tipo: PDF';
                return view('contratacao_servicos/contratacaoServicos_alterar', compact('contratacao_servicos', 'Unidades', 'especialidades','sucesso','unidade_id','especialidade_contratacao'))
                    ->withErrors($validator)
                    ->withInput(session()->flashInput($request->input()));
            }
        
    }
    //Pagina prorroga contrato

    public function pagProrrContr($id)
    {
        $sucesso = "";
        $contratacao_servicos  = contratacao_servicos::where('id',$id)->get();
        return view('contratacao_servicos/contratacaoServicos_prorroga', compact('contratacao_servicos','sucesso'));
    }

    //Prorrogação de contrato
    public function prorrContr($id,Request $request)
    {
        $input = $request->all();
        $contratacao_servicos  = contratacao_servicos::where('id',$id)->get();
        $dtPrazoFim = $contratacao_servicos[0]->prazoFinal;
        $PrazProAtual = $contratacao_servicos[0]->prazoProrroga;
        $dtProrrgac = $input['prazoProrroga'];
        
        if($dtProrrgac == ""){
            $sucesso = "no";
            $validator = "Você não digitou a nova data.";
            return view('contratacao_servicos/contratacaoServicos_prorroga', compact('contratacao_servicos','sucesso'))
            ->withErrors($validator);
        }elseif($dtProrrgac <= $PrazProAtual){
            $sucesso = "no";
            $validator = "Data prorroga menor ou igual a data de prorrogação Atual";
            return view('contratacao_servicos/contratacaoServicos_prorroga', compact('contratacao_servicos','sucesso'))
            ->withErrors($validator);
        }elseif($dtProrrgac <= $dtPrazoFim){
            $sucesso = "no";
            $validator = "Data prorroga menor ou igual a data final";
            return view('contratacao_servicos/contratacaoServicos_prorroga', compact('contratacao_servicos','sucesso'))
            ->withErrors($validator);
        }else{
            $sucesso = "ok";
            $contratacao_servicos= contratacao_servicos::find($id);
            $contratacao_servicos->update($input);
            $contratacao_servicos  = contratacao_servicos::where('id',$id)->get();
            $validator = 'Prorrogação efetuada com sucesso';
            return view('contratacao_servicos/contratacaoServicos_prorroga', compact('contratacao_servicos','sucesso'))
            ->withErrors($validator);
        }
    }

    //Pagina Especialidade
    public function paginaEspecialidade()
    {
        $Especialidades = especialidades::all();
        $sucesso = "";
        return view('contratacao_servicos/especialidades_listagem', compact('Especialidades', 'sucesso'));
    }
    //Pagina nova especialidade
    public function novaEspecialidade()
    {
        $Especialidades = especialidades::all();
        $sucesso = "";
        return view('contratacao_servicos/especialidades_novo', compact('Especialidades', 'sucesso'));
    }
    //Salvar especialidade
    public function salvarEspecialidade(Request $request)
    {
        $input = $request->all();
        $nome = $input['nome'];
        $Especialidades = especialidades::all();
        $EspecialiCad = especialidades::where('nome', $nome)->get('nome');
        if ($EspecialiCad == '[]') {
            $novaEspecialidade = especialidades::create($input);
            $sucesso = "ok";
            $validator = 'Especialidade cadastrada com sucesso';
            return view('contratacao_servicos/especialidades_novo', compact('Especialidades', 'sucesso'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        } else {
            $sucesso = "no";
            $validator = 'Especialidade Já está cadastrada !';
            return view('contratacao_servicos/especialidades_novo', compact('Especialidades', 'sucesso'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        }
    }
    //Pesquisar especialidade
    public function pesquisarEspecialidade(Request $request)
    {
        $sucesso = ""; 
        $input = $request->all();
        $pesq = $input['nomePesq'];
        if (!$pesq == "") {
            $Especialidades = DB::table('especialidades')->where('nome', 'like', '%' . $pesq . '%')->get();
        } else {
            $Especialidades = especialidades::all();
        }
        return view('contratacao_servicos/especialidades_listagem', compact('Especialidades','sucesso'));
    }

    //Pagina excluir especialidade
    public function pagExcluirEspeciali($id)
    {
        $sucesso = "";
        $Especialidades = especialidades::where('id', $id)->get();
        return view('contratacao_servicos/especialidades_excluir', compact('Especialidades', 'sucesso'));
    }

    //Excluir especialidade
    public function excluirEspecialidade($id)
    {
        especialidade_contratacao::where('especialidades_id', $id)->delete();
        especialidades::find($id)->delete();
        $Especialidades = especialidades::all();
        return redirect()->route('paginaEspecialidade', compact('Especialidades'));
    }

    //Pagina Altera especialidade
    public function pagAlteraEspeciali($id)
    {
        $sucesso = "";
        $Especialidades = especialidades::where('id', $id)->get();
        return view('contratacao_servicos/especialidades_alterar', compact('Especialidades', 'sucesso'));
    }

    public function AlteraEspeciali($id,Request $request)
    {
        $input = $request->all();
        $nome = $input['nome'];
        $validator = Validator::make($request->all(), [
            'nome' => 'required|max:255'
        ]);
        $EspecialiCad = especialidades::where('nome', $nome)->get('nome');
        if ($validator->fails()) {
            $sucesso = "no";
            $validator = 'Nome muito longo !';
            return view('contratacao_servicos/especialidades_alterar', compact('Especialidades', 'sucesso'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        }elseif($EspecialiCad == '[]'){
            $sucesso = "ok";
            $validator = 'Nome alterado com sucesso !';
            $Especialidades = especialidades::find($id);
            $Especialidades->update($input);
            $Especialidades = especialidades::where('id', $id)->get();
            return view('contratacao_servicos/especialidades_alterar', compact('Especialidades', 'sucesso'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        } else {
            $sucesso = "no";
            $validator = 'Não foi indetificado alteração no nome !';
            $Especialidades = especialidades::where('id', $id)->get();
            return view('contratacao_servicos/especialidades_alterar', compact('Especialidades', 'sucesso'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        }
    }
}