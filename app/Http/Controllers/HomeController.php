<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Unidade;

class HomeController extends Controller
{
	protected $unidade;
	
    public function __construct(Unidade $unidade)
    {
		$this->unidade = $unidade;
    }

    public function index()
    {
		$unidades = $this->unidade->all();
		$text = false;
		return view('home', compact('unidades','text'));
    }
	
	public function trasparenciaHome($id)
    {
        $unidadesMenu = $this->unidade->all();
		$unidades = $unidadesMenu;
		$unidade  = Unidade::where('id', $id)->get(); 
        $lastUpdated  = $unidade->max('updated_at');
		$text = false;
		return view('transparencia.institucional', compact('unidade','unidades','unidadesMenu','lastUpdated','text'));
    }
}
