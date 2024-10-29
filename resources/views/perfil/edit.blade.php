 <h1>Editar Perfil</h1>

    @if(session('status'))
        <div>{{ session('status') }}</div>
    @endif

    <form action="{{ route('perfil.update') }}" method="POST">
        @csrf

        <!-- Campo de Email -->
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        @error('email')
            <div>{{ $message }}</div>
        @enderror

        <!-- Campo de Senha Atual -->
        <label for="senha_atual">Senha Atual:</label>
        <input type="password" id="senha_atual" name="senha_atual" required>
        @error('senha_atual')
            <div>{{ $message }}</div>
        @enderror

        <!-- Campo para Nova Senha -->
        <label for="nova_senha">Nova Senha:</label>
        <input type="password" id="nova_senha" name="nova_senha">
        @error('nova_senha')
            <div>{{ $message }}</div>
        @enderror

        <!-- Confirmação da Nova Senha -->
        <label for="nova_senha_confirmation">Confirme a Nova Senha:</label>
        <input type="password" id="nova_senha_confirmation" name="nova_senha_confirmation">

        <button type="submit">Atualizar Perfil</button>
    </form>