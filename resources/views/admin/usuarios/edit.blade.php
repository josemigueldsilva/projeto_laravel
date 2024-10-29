<h1>Editar Usuário</h1>

    <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST">
        @csrf

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ old('email', $usuario->email) }}" required>
        @error('email')
            <div>{{ $message }}</div>
        @enderror

        <label for="senha">Nova Senha:</label>
        <input type="password" id="senha" name="senha">
        @error('senha')
            <div>{{ $message }}</div>
        @enderror

        <label for="senha_confirmation">Confirme a Nova Senha:</label>
        <input type="password" id="senha_confirmation" name="senha_confirmation">

        <button type="submit">Salvar Alterações</button>
    </form>