<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Torneio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login'); // View para o login do admin
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if ($admin && Hash::check($request->senha, $admin->senha)) {
            Auth::guard('admin')->login($admin);
            return redirect()->route('admin.torneios.index');
        }

        return back()->withErrors(['email' => 'As credenciais fornecidas estão incorretas.']);
    }

    public function index()
    {
        $torneios = Torneio::all();
        return view('admin.torneios.index', compact('torneios')); // View para listar torneios
    }

    public function destroy($id)
    {
        $torneio = Torneio::findOrFail($id);
        $torneio->delete();
        return redirect()->back()->with('success', 'Torneio excluído com sucesso!');
    }

    // Funções de gerenciamento de usuários
    public function usuariosIndex()
    {
        $usuarios = User::all(); // Lista todos os usuários
        return view('admin.usuarios.index', compact('usuarios')); // Crie uma view para listar usuários
    }

    public function editUsuario($id)
    {
        $usuario = User::findOrFail($id);
        return view('admin.usuarios.edit', compact('usuario')); // View para editar usuário
    }

    public function updateUsuario(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'senha' => 'nullable|min:1|confirmed'
        ]);

        $usuario->email = $request->email;
        if ($request->filled('senha')) {
            $usuario->password = Hash::make($request->senha);
        }

        $usuario->save();

        return redirect()->route('admin.usuarios.index')->with('status', 'Usuário atualizado com sucesso!');
    }

    public function destroyUsuario($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('admin.usuarios.index')->with('status', 'Usuário excluído com sucesso!');
    }
}