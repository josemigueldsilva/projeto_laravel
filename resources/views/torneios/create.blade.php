<h1>Criar Novo Torneio</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('torneios.store') }}" method="POST">
        @csrf

        <label for="nome">Nome do Torneio:</label>
        <input type="text" id="nome" name="nome" value="{{ old('nome') }}" required>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao">{{ old('descricao') }}</textarea>

        <label for="quantidade-times">Quantidade de Times:</label>
        <input type="number" id="quantidade-times" name="quantidade_times" min="2" required>

        <label for="formato">Formato:</label>
        <select id="formato" name="formato" required>
            <option value="eliminacao_simples">Eliminação Simples</option>
            <option value="fase_grupos">Fase de Grupos</option>
        </select>

        <div id="grupos-config" style="display: none;">
            <label for="times-por-grupo">Times por Grupo:</label>
            <input type="number" id="times-por-grupo" name="times_por_grupo" min="1">
        </div>

        <label for="times">Nome dos Times:</label>
        <div id="nomes-times">
            <!-- Os campos de nomes dos times serão adicionados dinamicamente aqui pelo JS -->
        </div>

        <button type="submit">Criar Torneio</button>
    </form>
    
    <!-- Adicione o JavaScript para manipular os campos dinâmicos -->
    <script src="{{ asset('js/torneio.js') }}"></script>