<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User;
use App\Model\Auth;
use App\Model\Unidade;
use Spatie\Permission\Models\Role;
use DB;
use Hash;


class UserController extends Controller
{
	public function __construct(Unidade $unidade)
	{
		$this->unidade = $unidade;
	}
	
    public function index(Request $request)
    {
        $data = User::orderBy('id','DESC')->paginate(5);
        return view('users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }
	
	public function telaLogin()
	{
		$text = false;
		return view('auth.login', compact('text'));
	}

	public function telaRegistro()
	{
		$text = false;
		return view('auth.register', compact('text'));
	}
	
	public function telaEmail()
	{
		return view('auth.passwords.email');
	}
	
	public function telaReset()
	{
		$token = '';
		return view('auth.passwords.reset', compact('token'));
	}
	
	public function Login(Request $request)
	{
		$input = $request->all(); 		
		$v = \Validator::make($request->all(), [
			'email'    => 'required|email',
            'password' => 'required'
		]);		
		if ($v->fails()) {
			$failed = $v->failed(); 
			if ( !empty($failed['email']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo e-mail é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['email']['Email']) ) {
				\Session::flash('mensagem', ['msg' => 'Este e-mail é inválido!','class'=>'green white-text']);
			} else if ( !empty($failed['password']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo nome é obrigatório!','class'=>'green white-text']);
			}
			$text = false;
			return view('auth.login', compact('text')); 
		} else {
			$email = $input['email'];
			$senha = $input['password'];		
			$user = User::where('email', $email)->get();
			$qtd = sizeof($user); 			
			if ( empty($qtd) ) {
				\Session::flash('mensagem', ['msg' => 'Login Inválido!','class'=>'green white-text']);
				$text = true;
				return view('auth.login', compact('text')); 	
			} else {
				$text = true;
				$unidades = $this->unidade->all();
				Auth::login($user);
				return view('home', compact('unidades','user')); 						
			}
		}
	}
	
	public function resetarSenha(Request $request)
	{
		$input = $request->all();		
		$v = \Validator::make($request->all(), [
			'email'    => 'required|email',
            'password' => 'required|same:password_confirmation',
			'password_confirmation' => 'required'
    	]);		
		if ($v->fails()) {
			$failed = $v->failed(); 
			if ( !empty($failed['email']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo e-mail é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['email']['Email']) ) {
				\Session::flash('mensagem', ['msg' => 'Este e-mail é inválido!','class'=>'green white-text']);
			} else if ( !empty($failed['password']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo nome é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['password']['Same']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo senha e confirmar senha não são iguais!','class'=>'green white-text']);
			} else if ( !empty($failed['password_confirmation']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo confirmar senha é obrigatório!','class'=>'green white-text']);
			}
			$text = true;
			return view('auth.passwords/reset', compact('text'));
		} else {
			if(!empty($input['password'])){ 
				$input['password'] = Hash::make($input['password']);
			}else{
				$input = array_except($input,array('password'));    
			}
			$email = $input['email'];
			$user = User::find(5);
			$user->update($input);
			$text = true;
			\Session::flash('mensagem', ['msg' => 'Senha alterado com sucesso!','class'=>'green white-text']);
			$unidades = $this->unidade->all();
			$text = false;
			return view('home', compact('unidades','user','text')); 						
		}
	}
	
    public function store(Request $request)
    {
		$input = $request->all();
		$v = \Validator::make($request->all(), [
			'name'     		   => 'required',
            'email'    		   => 'required|email|unique:users,email',
            'password' 		   => 'required|same:password_confirmation',
			'password_confirmation' => 'required'
    	]);			 
		if ($v->fails()) {
			$failed = $v->failed(); 
			if ( !empty($failed['name']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo nome é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['email']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo e-mail é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['email']['Email']) ) {
				\Session::flash('mensagem', ['msg' => 'Este e-mail é inválido!','class'=>'green white-text']);
			} else if ( !empty($failed['email']['Unique']) ) {
				\Session::flash('mensagem', ['msg' => 'Este e-mail já foi cadastrado!','class'=>'green white-text']);
			} else if ( !empty($failed['password']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo nome é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['password']['Same']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo senha e confirmar senha não são iguais!','class'=>'green white-text']);
			} else if ( !empty($failed['password_confirmation']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo confirmar senha é obrigatório!','class'=>'green white-text']);
			} else if ( !empty($failed['roles']['Required']) ) {
				\Session::flash('mensagem', ['msg' => 'O campo confirmar senha é obrigatório!','class'=>'green white-text']);
			}
			$text = true;
			return view('auth.register', compact('text'));
		} else {
			$input['password'] = Hash::make($input['password']);
			$user = User::create($input);
			\Session::flash('mensagem', ['msg' => 'Usuário cadastrado com sucesso!','class'=>'green white-text']);
			$unidades = $this->unidade->all();
			return view('welcome', compact('unidades')); 						
		}
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return view('users.edit',compact('user','roles','userRole'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));    
        }
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->input('roles'));
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }

	public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }
}