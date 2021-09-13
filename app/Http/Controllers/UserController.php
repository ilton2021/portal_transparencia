<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Model\User;
use App\Model\Auth;
use App\Model\Unidade;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Validator;

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
		return view('auth.login');
	}

	public function telaRegistro()
	{
		return view('auth.register');
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
		$validator = Validator::make($request->all(), [
			'email'    => 'required|email',
            'password' => 'required'
		]);		
		if ($validator->fails()) {
			return view('auth.login')
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 
		} else {
			$email = $input['email'];
			$senha = $input['password'];		
			$user = User::where('email', $email)->get();
			$qtd = sizeof($user); 			
			if ( empty($qtd) ) {
				$validator = 'Login Inválido!';
				return view('auth.login')
					->withErrors($validator)
					->withInput(session()->flashInput($request->input())); 	
			} else {
				$unidades = $this->unidade->all();
				Auth::login($user);
				return view('home', compact('unidades','user'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input())); 						
			}
		}
	}
	
	public function resetarSenha(Request $request)
	{
		$input = $request->all();		
		$validator = Validator::make($request->all(), [
			'email'    => 'required|email',
            'password' => 'required|same:password_confirmation',
			'password_confirmation' => 'required'
    	]);		
		if ($validator->fails()) {
			return view('auth.passwords/reset')
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			if(!empty($input['password'])){ 
				$input['password'] = Hash::make($input['password']);
			}else{
				$input = array_except($input,array('password'));    
			}
			$email = $input['email'];
			$user = User::find(5);
			$user->update($input);
			$validator = 'Senha alterado com sucesso!';
			return view('auth.login')
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}
	
    public function store(Request $request)
    {
		$input = $request->all();
		$validator = Validator::make($request->all(), [
			'name'     		   => 'required',
            'email'    		   => 'required|email|unique:users,email',
            'password' 		   => 'required|same:password_confirmation',
			'password_confirmation' => 'required'
    	]);			 
		if ($validator->fails()) {
			return view('auth.register')
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$input['password'] = Hash::make($input['password']);
			$user = User::create($input);
			$user->assignRole($request->input('roles'));				
			return view('auth.login')
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
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

	public function emailReset(Request $request){

		$input = $request->all(); 
		$email = $input['email'];
		$usuarios = User::where('email',$email)->get();
		$validator = Validator::make($request->all(), [
			'email' => 'required|email',
		]);	
		$email2 = 'ilton.albuquerque@hcpgestao.org.br';
		if(!empty($usuarios)){
			Mail::send('transparencia.email.emailReset', [], function($m) use ($email,$email2) {
				$m->from('portal@hcpgestao.org.br', 'PORTAL DA TRANSPARENCIA');
				$m->subject('Solicitação de Alteração de Senha');
				$m->to($email);
				$m->cc($email2);
			});		
			$validator = 'E-mail enviado com sucesso! Verifique sua caixa de mensagens';
			return view('auth.passwords.email', compact('email','usuarios'))
		    	->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	  
		}else{
			$validator = 'Verifique o E-mail digitado e preencha novamente.';
			return view('auth.passwords.email', compact('email','usuarios'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}
}