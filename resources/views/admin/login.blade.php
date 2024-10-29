<h1>Login do Administrador</h1>

<form action="{{ route('admin.login') }}" method="POST">
    @csrf
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="senha">Senha:</label>
    <input type="password" id="senha" name="senha" required>

    <button type="submit">Entrar</button>
</form>
