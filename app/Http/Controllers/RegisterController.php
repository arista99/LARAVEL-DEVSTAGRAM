<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index() 
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // dd($request); todos los valores
        // dd($request->get('username')); valor en especifico

        //Modificar el request
        $request->request->add(['username' => Str::slug($request->username)]);

        //Validacion
        $this->validate($request,[
            'name' => 'required|min:5',
            'username' => 'required|unique:users|min:3|max:20',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        //Autenticar usuario
        auth()->attempt([
            'email'=> $request->email,
            'password'=> $request->password
        ]);

        // Auth::attempt($request->only('email','passsword'));
        //redirecionar
        return redirect()->route('post.index', auth()->user()->username);
    }
}
