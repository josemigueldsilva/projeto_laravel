<div class="tournament-container">

    <h1>{{ $torneio->nome }}</h1>

    <p>{{ $torneio->descricao }}</p>

    <h2>Partidas:</h2>

    <form action="{{ route('torneios.salvarResultados', $torneio->id) }}" method="POST" class="results-form">
        @csrf

        @if ($confrontos && count($confrontos) > 0) <!-- Verifica se $confrontos não é nulo e se tem elementos -->
            @foreach ($confrontos as $partida)
                <div class="match-container">
                    <label>{{ $partida[0] }} x {{ $partida[1] }}</label>
                    <input type="number" name="resultados[{{ $partida[0] }}]" placeholder="Gols {{ $partida[0] }}" required>
                    <input type="number" name="resultados[{{ $partida[1] }}]" placeholder="Gols {{ $partida[1] }}" required>

                    <label>Escolher quem avança:</label>
                    <select name="avancam[]" required>
                        <option value="{{ $partida[0] }}">{{ $partida[0] }}</option>
                        <option value="{{ $partida[1] }}">{{ $partida[1] }}</option>
                    </select>
                </div>
            @endforeach
        @else
            <p>Nenhuma partida encontrada.</p> <!-- Mensagem se não houver partidas -->
        @endif

        <button type="submit">Salvar Resultados</button>
    </form>

    @if($torneio->campeao)
        <h2>Campeão: {{ $torneio->campeao }}</h2>
    @else
        <!-- Mostrar os confrontos atuais se o torneio ainda estiver em andamento -->
    @endif

</div>

<style>
    /* Estilos do contêiner do torneio */
    .tournament-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    h2 {
        color: #555;
        margin-top: 20px;
    }

    p {
        color: #666;
        margin-bottom: 20px;
        line-height: 1.5;
    }

    .results-form {
        margin-top: 20px;
    }

    .match-container {
        margin-bottom: 15px;
        padding: 10px;
        background-color: #e0f7e9; /* Fundo verde clarinho para as partidas */
        border-radius: 4px;
    }

    input[type="number"],
    select {
        width: calc(33.3% - 10px);
        padding: 10px;
        margin-right: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    input[type="number"]:last-child,
    select:last-child {
        margin-right: 0; /* Remove a margem do último input */
    }

    button {
        margin-top: 15px;
        padding: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
        width: 100%; /* Botão ocupa toda a largura */
    }

    button:hover {
        background-color: #0056b3;
    }
</style>
