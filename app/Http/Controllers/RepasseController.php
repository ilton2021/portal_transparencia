<?php

namespace App\Http\Controllers;

use App\Model\Repasse;
use App\Model\Unidade;
use Illuminate\Http\Request;
use App\Model\LoggerUsers;
use App\Model\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Auth;
use Validator;
use DB;

class RepasseController extends Controller
{
	public function __construct(Unidade $unidade, Repasse $repasse, LoggerUsers $logger_users)
    {
        $this->unidade 		= $unidade;
		$this->repasse 		= $repasse;
		$this->logger_users = $logger_users;
    }

    public function index()
    {
		$unidades = $this->unidade->all();
		return view ('repasses', compact('unidades'));
    }

    public function cadastroRP($id, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);		
		$repasses = Repasse::where('unidade_id', $id)->orderBy('ano', 'ASC')->get();
        $anoRepasses = $repasses->pluck('ano')->unique();
        $mesRepasses = $repasses->pluck('mes')->unique();
        $mesUpdate = $repasses->where('ano', $anoRepasses->last())->pluck('mes')->last();
        function valorMes($month){
            $monthArray = array(
                "1" => "janeiro",
                "2" => "fevereiro",
				"3" => "março",
                "4" => "abril",
                "5" => "maio",
                "6" => "junho",
                "7" => "julho",
                "8" => "agosto",
                "9" => "setembro",
                "10" => "outubro",
                "11" => "novembro",
                "12" => "dezembro",
            );
            return array_search($month, $monthArray);
        };
		$lastUpdated = valorMes($mesUpdate)."/"."1/".$anoRepasses->last();
		$somContratado = $repasses->sum('contratado');
		$somRecebido = $repasses->sum('recebido');
        if($validacao == 'ok') {
			return view('transparencia/repasses/repasses_cadastro', compact('unidade','unidadesMenu','repasses','somContratado','somRecebido','anoRepasses','mesRepasses','lastUpdated'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));			
		}
	}
	

	public function novoRP($id, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id);
		$repasses     = Repasse::where('unidade_id', $id)->orderBy('ano', 'ASC')->get();
        $anoRepasses  = $repasses->pluck('ano')->unique();
        $mesRepasses  = $repasses->pluck('mes')->unique();
        $mesUpdate    = $repasses->where('ano', $anoRepasses->last())->pluck('mes')->last();
        function valorMes($month){
            $monthArray = array(
                "1" => "janeiro",
                "2" => "fevereiro",
                "3" => "março",
                "4" => "abril",
                "5" => "maio",
				"6" => "junho",
				"7" => "julho",
                "8" => "agosto",
                "9" => "setembro",
                "10" => "outubro",
                "11" => "novembro",
                "12" => "dezembro",
            );
            return array_search($month, $monthArray);
        };
        $lastUpdated = valorMes($mesUpdate)."/"."1/".$anoRepasses->last();
        if($validacao == 'ok') {
			return view('transparencia/repasses/repasses_novo', compact('unidade','unidadesMenu','repasses','anoRepasses','mesRepasses','lastUpdated'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}

	public function alterarRP($id_unidade, $id_item, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);	
		$repasses     = Repasse::where('id', $id_item)->get();
        $anoRepasses  = $repasses->pluck('ano')->unique();
        $mesRepasses  = $repasses->pluck('mes')->unique();
        $mesUpdate    = $repasses->where('ano', $anoRepasses->last())->pluck('mes')->last();
        function valorMes($month){
            $monthArray = array(
                "1" => "janeiro",
                "2" => "fevereiro",
                "3" => "março",
                "4" => "abril",
                "5" => "maio",
                "6" => "junho",
                "7" => "julho",
                "8" => "agosto",
				"9" => "setembro",
                "10" => "outubro",
                "11" => "novembro",
                "12" => "dezembro",
            );
            return array_search($month, $monthArray);
        };
        $lastUpdated = valorMes($mesUpdate)."/"."1/".$anoRepasses->last();
        if($validacao == 'ok') {
			return view('transparencia/repasses/repasses_alterar', compact('unidade','unidadesMenu','repasses','anoRepasses','mesRepasses','lastUpdated'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input())); 		
		}
	}

	public function telaInativarRP($id_unidade, $id_item, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);	
		$repasses     = Repasse::where('id', $id_item)->get();
        $anoRepasses  = $repasses->pluck('ano')->unique();
        $mesRepasses  = $repasses->pluck('mes')->unique();
        $mesUpdate    = $repasses->where('ano', $anoRepasses->last())->pluck('mes')->last();
        function valorMes($month){
            $monthArray = array(
                "1" => "janeiro",
                "2" => "fevereiro",
                "3" => "março",
                "4" => "abril",
                "5" => "maio",
                "6" => "junho",
                "7" => "julho",
                "8" => "agosto",
				"9" => "setembro",
                "10" => "outubro",
                "11" => "novembro",
                "12" => "dezembro",
            );
            return array_search($month, $monthArray);
        };
        $lastUpdated = valorMes($mesUpdate)."/"."1/".$anoRepasses->last();
        if($validacao == 'ok') {
			return view('transparencia/repasses/repasses_inativar', compact('unidade','unidadesMenu','repasses','anoRepasses','mesRepasses','lastUpdated'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input())); 		
		}
	}

	public function excluirRP($id_unidade, $id_item, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);	
		$repasses     = Repasse::where('id', $id_item)->get();
        $anoRepasses  = $repasses->pluck('ano')->unique();
        $mesRepasses  = $repasses->pluck('mes')->unique();
        $mesUpdate    = $repasses->where('ano', $anoRepasses->last())->pluck('mes')->last();
        function valorMes($month){
            $monthArray = array(
                "1" => "janeiro",
                "2" => "fevereiro",
                "3" => "março",
                "4" => "abril",
                "5" => "maio",
                "6" => "junho",
                "7" => "julho",
                "8" => "agosto",
                "9" => "setembro",
                "10" => "outubro",
                "11" => "novembro",
                "12" => "dezembro",
           );
            return array_search($month, $monthArray);
        };
        $lastUpdated = valorMes($mesUpdate)."/"."1/".$anoRepasses->last();
        if($validacao == 'ok') {
			return view('transparencia/repasses/repasses_excluir', compact('unidade','unidadesMenu','repasses','anoRepasses','mesRepasses','lastUpdated'));
		} else {
			$validator = 'Você não tem Permissão!!';		
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		}
	}

    public function storeRP($id_unidade, Request $request)
    {
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$input        = $request->all();
		$repasses     = Repasse::where('unidade_id', $id_unidade)->orderBy('ano', 'ASC')->get();
		$anoRepasses  = $repasses->pluck('ano')->unique();
		$mesRepasses  = $repasses->pluck('mes')->unique();
		$mesUpdate    = $repasses->where('ano', $anoRepasses->last())->pluck('mes')->last();
		function valorMes($month){
				$monthArray = array(
					"1" => "janeiro",
					"2" => "fevereiro",
					"3" => "março",
					"4" => "abril",
					"5" => "maio",
					"6" => "junho",
					"7" => "julho",
					"8" => "agosto",
					"9" => "setembro",
					"10" => "outubro",
					"11" => "novembro",
					"12" => "dezembro",
				);
				return array_search($month, $monthArray);
			};
		$lastUpdated = valorMes($mesUpdate)."/"."1/".$anoRepasses->last();
		$validator = Validator::make($request->all(), [
				'mes' 		 => 'required',
				'ano' 		 => 'required',
				'contratado' => 'required',
				'recebido'   => 'required',
				'desconto'   => 'required'
		]);
		if ($input['ano'] < 1800 || $input['ano'] > 2500) {
			$validator = 'O campo contratado não pode ser negativo!';
			return view('transparencia/repasses/repasses_novo', compact('unidades','unidade','unidadesMenu','repasses','lastUpdated'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));

		} else if ( $input['contratado'] < 0 ) {
			$validator = 'O campo contratado não pode ser negativo!';
			return view('transparencia/repasses/repasses_novo', compact('unidades','unidade','unidadesMenu','repasses','lastUpdated'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));

		} else if ( $input['recebido'] < 0 ) {
			$validator = 'O campo Recebido não pode ser negativo!';
			return view('transparencia/repasses/repasses_novo', compact('unidades','unidade','unidadesMenu','repasses','lastUpdated'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));
	
		} else if ( $input['desconto'] < 0 ) {
			$validator = 'O campo Desconto não pode ser negativo!';
			return view('transparencia/repasses/repasses_novo', compact('unidades','unidade','unidadesMenu','repasses','lastUpdated'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));
	
		}
		$mes = $input['mes'];
		$ano = $input['ano'];
		$repass = Repasse::where('mes', $mes)->where('ano', $ano)->where('unidade_id',$id_unidade)->get(); 
		$qtd = sizeof($repass);
	
		if( $qtd !== 0 ) {	
			$validator = 'Este mês e ano já foram cadastrados!';
			return view('transparencia/repasses/repasses_novo', compact('unidades','unidade','unidadesMenu','repasses','lastUpdated'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));
		}
		if ($validator->fails()) {
			$failed = $validator->failed();
			$validator = 'Algo de errado aconteceu, verifique os campos!';
			return view('transparencia/repasses/repasses_novo', compact('unidades','unidade','unidadesMenu','repasses','lastUpdated'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));
		} else {
			$input['status_repasse'] = 1;
			$repasse 	   = Repasse::create($input);
			$id_registro   = DB::table('repasses')->max('id');
			$input['registro_id'] = $id_registro;
			$log 		   = LoggerUsers::create($input);			
			$repasses 	   = Repasse::where('unidade_id', $id_unidade)->orderBy('ano', 'ASC')->get();
			$anoRepasses   = $repasses->pluck('ano')->unique();
			$mesRepasses   = $repasses->pluck('mes')->unique();
			$mesUpdate	   = $repasses->where('ano', $anoRepasses->last())->pluck('mes')->last();
			$lastUpdated   = $log->max('updated_at');
			$somContratado = $repasses->sum('contratado');
        	$somRecebido   = $repasses->sum('recebido');
			$validator     = 'Repasses recebidos, cadastrados com sucesso!';
			return view('transparencia/repasses/repasses_cadastro', compact('unidades','unidade','unidadesMenu','repasses','somContratado','somRecebido','anoRepasses','mesRepasses','mesUpdate','lastUpdated'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));
		}

    }

    public function updateRP($id_unidade, $id_item, Request $request)
    {
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$input        = $request->all();
		$repasses     = Repasse::where('unidade_id', $id_unidade)->orderBy('ano', 'ASC')->get();
		$anoRepasses  = $repasses->pluck('ano')->unique();
		$mesRepasses  = $repasses->pluck('mes')->unique();
		$mesUpdate    = $repasses->where('ano', $anoRepasses->last())->pluck('mes')->last();
		function valorMes($month){
				$monthArray = array(
					"1" => "janeiro",
					"2" => "fevereiro",
					"3" => "março",
					"4" => "abril",
					"5" => "maio",
					"6" => "junho",
					"7" => "julho",
					"8" => "agosto",
					"9" => "setembro",
					"10" => "outubro",
					"11" => "novembro",
					"12" => "dezembro",
				);
				return array_search($month, $monthArray);
			};
		$lastUpdated = valorMes($mesUpdate)."/"."1/".$anoRepasses->last();		
		$validator = Validator::make($request->all(), [
			'mes' 		 => 'required',
			'ano' 		 => 'required|digits:4',
			'contratado' => 'required',
			'recebido'   => 'required',
			'desconto'   => 'required'
		]);		
		if ($input['ano'] < 1800 || $input['ano'] > 2500) {
			$validator = 'O campo ano é inválido!';
			return view('transparencia/repasses/repasses_novo', compact('unidades','unidade','unidadesMenu','repasses','lastUpdated'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));
		} else if ( $input['contratado'] < 0 ) {
			$validator = 'O campo contratado não pode ser negativo!';
			return view('transparencia/repasses/repasses_novo', compact('unidades','unidade','unidadesMenu','repasses','lastUpdated'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));
		} else if ( $input['recebido'] < 0 ) {
			$validator = 'O campo recebido não pode ser ngativo!';
			return view('transparencia/repasses/repasses_novo', compact('unidades','unidade','unidadesMenu','repasses','lastUpdated'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));
		} else if ( $input['desconto'] < 0 ) {
			$validator = 'O campo desconto não pode ser negativo!';
			return view('transparencia/repasses/repasses_alterar', compact('unidades','unidade','unidadesMenu','repasses','lastUpdated'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));
		}
		if ($validator->fails()) {
			$failed = $validator->failed();

			$validator = 'Algo de errado aconteceu, verifique os campos e preencha novamente!';
			return view('transparencia/repasses/repasses_alterar', compact('unidades','unidade','unidadesMenu','repasses','lastUpdated'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));
		} else {
			$repasse = Repasse::find($id_item);
			$repasse->update($input);
			$input['registro_id'] = $id_item;			
			$log           = LoggerUsers::create($input);
			$repasses      = Repasse::where('unidade_id', $id_unidade)->orderBy('ano', 'ASC')->get();
			$anoRepasses   = $repasses->pluck('ano')->unique();
			$mesRepasses   = $repasses->pluck('mes')->unique();
			$mesUpdate     = $repasses->where('ano', $anoRepasses->last())->pluck('mes')->last();
			$lastUpdated   = $log->max('updated_at');
			$somContratado = $repasses->sum('contratado');
        	$somRecebido   = $repasses->sum('recebido');
			$validator     = 'Repasses recebidos, alterados com sucesso!';
			return view('transparencia/repasses/repasses_cadastro', compact('unidades','unidade','unidadesMenu','repasses','somContratado','somRecebido','anoRepasses','mesRepasses','mesUpdate','lastUpdated'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));
		}
    }

    public function destroyRP($id_unidade, $id_item, Repasse $repasse, Request $request)
    {
		Repasse::find($id_item)->delete();		
		$input        = $request->all();
		$input['registro_id'] = $id_item;
		$log      	  = LoggerUsers::create($input);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$repasses     = Repasse::where('unidade_id', $id_unidade)->orderBy('ano', 'ASC')->get();
		$anoRepasses  = $repasses->pluck('ano')->unique();
        $mesRepasses  = $repasses->pluck('mes')->unique();
        $mesUpdate	  = $repasses->where('ano', $anoRepasses->last())->pluck('mes')->last();
        function valorMes($month){
            $monthArray = array(
                "1" => "janeiro",
                "2" => "fevereiro",
                "3" => "março",
                "4" => "abril",
                "5" => "maio",
                "6" => "junho",
                "7" => "julho",
                "8" => "agosto",
                "9" => "setembro",
                "10" => "outubro",
                "11" => "novembro",
                "12" => "dezembro",
            );
            return array_search($month, $monthArray);
        };
        $lastUpdated   = $log->max('updated_at');
		$somContratado = $repasses->sum('contratado');
        $somRecebido   = $repasses->sum('recebido');
		$validator     = 'Repasses recebidos excluídos com sucesso!';
		return view('transparencia/repasses/repasses_cadastro', compact('unidades','unidade','unidadesMenu','repasses','somContratado','somRecebido','anoRepasses','mesRepasses','mesUpdate','lastUpdated'))
		->withErrors($validator)
			->withInput(session()->flashInput($request->input()));
    }

	public function inativarRP($id_unidade, $id_item, Repasse $repasse, Request $request)
    {
		$input        = $request->all();
		$repasse = Repasse::where('id',$id_item)->get();
		if($repasse[0]->status_repasse == 1) {
			DB::statement('UPDATE repasses SET status_repasse = 0 WHERE id = '.$id_item.';');
		} else {
			DB::statement('UPDATE repasses SET status_repasse = 1 WHERE id = '.$id_item.';');
		}
		$input['registro_id'] = $id_item;
		$log      	  = LoggerUsers::create($input);
		$unidadesMenu = $this->unidade->where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = $this->unidade->where('status_unidades',1)->find($id_unidade);
		$repasses     = Repasse::where('unidade_id', $id_unidade)->orderBy('ano', 'ASC')->get();
		$anoRepasses  = $repasses->pluck('ano')->unique();
        $mesRepasses  = $repasses->pluck('mes')->unique();
        $mesUpdate	  = $repasses->where('ano', $anoRepasses->last())->pluck('mes')->last();
        function valorMes($month){
            $monthArray = array(
                "1" => "janeiro",
                "2" => "fevereiro",
                "3" => "março",
                "4" => "abril",
                "5" => "maio",
                "6" => "junho",
                "7" => "julho",
                "8" => "agosto",
                "9" => "setembro",
                "10" => "outubro",
                "11" => "novembro",
                "12" => "dezembro",
            );
            return array_search($month, $monthArray);
        };
        $lastUpdated   = $log->max('updated_at');
		$somContratado = $repasses->sum('contratado');
        $somRecebido   = $repasses->sum('recebido');
		$validator     = 'Repasses recebidos inativado com sucesso!';
		return view('transparencia/repasses/repasses_cadastro', compact('unidades','unidade','unidadesMenu','repasses','somContratado','somRecebido','anoRepasses','mesRepasses','mesUpdate','lastUpdated'))
		->withErrors($validator)
			->withInput(session()->flashInput($request->input()));
    }
}