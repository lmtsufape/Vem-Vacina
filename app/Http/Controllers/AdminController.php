<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function userForm(Request $request)
    {
        Gate::authorize('criar-user');
        return view('admin.criarUser');
    }

    public function createUser(Request $request)
    {
        Gate::authorize('criar-user');
        $data = $request->all();

        $data['password'] = Hash::make($data['password']);
        // dd($data);

        $user = User::create($data);

        return redirect()->route('dashboard')->with(['mensagem' => "Usuário criado!"]);
    }


}
