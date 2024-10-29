<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('inicial.register'); // Ajuste o caminho se necessário
    }

    public function register(Request $request)
{
    // Validação dos dados
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:1|confirmed',
    ]);

    // Criação do usuário
    $user = User::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
    ]);

    // Autenticar o usuário
    Auth::login($user);

    // Redirecionar ou retornar uma resposta
    return redirect()->route('login')->with('success', 'Registro concluído com sucesso!');
}

    public function showLoginForm()
    {
        return view('inicial.login'); // Ajuste o caminho se necessário
    }
    public function login(Request $request)
        {
            // Validação dos dados
            $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            ]);

            // Verificar as credenciais e autenticar o usuário
            if (Auth::attempt($credentials)) {
            // Login bem-sucedido
            $request->session()->regenerate();
            return redirect()->intended('principal')->with('success', 'Login bem-sucedido!');
        }

    // Se as credenciais estiverem erradas
    return back()->withErrors([
        'email' => 'As credenciais fornecidas estão incorretas.',
    ]);
    }

    public function editProfile()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->withErrors('Por favor, faça login para acessar essa página.');
        }
        
        return view('perfil.edit', ['user' => $user]);
    }

public function updateProfile(Request $request)
{
    $user = Auth::user();

    // Validação dos dados
    $request->validate([
        'email' => 'required|email|unique:users,email,' . $user->id,
        'senha_atual' => 'required',
        'nova_senha' => 'nullable|min:1|confirmed'
    ]);

    // Verifica se a senha atual está correta
    if (!Hash::check($request->senha_atual, $user->password)) {
        return back()->withErrors(['senha_atual' => 'A senha atual está incorreta.']);
    }

    // Atualiza o email
    $user->email = $request->email;

    // Atualiza a senha, se fornecida
    if ($request->filled('nova_senha')) {
        $user->password = Hash::make($request->nova_senha);
    }

    $user->save();

    return redirect()->route('perfil.edit')->with('status', 'Perfil atualizado com sucesso!');
}
}