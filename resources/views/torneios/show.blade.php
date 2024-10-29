<div>
    <h1>{{ $torneio->nome }}</h1>
    <p>{{ $torneio->descricao }}</p>

    <h2>Grupos:</h2>
    @if (!empty($grupos))
        @foreach ($grupos as $grupo => $times)
            <h3>Grupo {{ $grupo }}</h3>
            <ul>
                @foreach ($times as $time)
                    <li>{{ $time }}</li>
                @endforeach
            </ul>
        @endforeach
    @endif

    <h2>Partidas:</h2>
    @if (!empty($confrontos))
        <ul>
            @foreach ($confrontos as $partida)
                <li>{{ $partida[0] }} x {{ $partida[1] }}</li>
            @endforeach
        </ul>
    @endif

    <h2>Resultados:</h2>
    <form action="{{ route('torneios.salvarResultados', $torneio->id) }}" method="POST">
        @csrf
        @foreach ($confrontos as $partida)
            <div>
                <label>{{ $partida[0] }} x {{ $partida[1] }}</label>
                <input type="number" name="resultados[{{ $partida[0] }}][]" placeholder="Gols {{ $partida[0] }}" required>
                <input type="number" name="resultados[{{ $partida[1] }}][]" placeholder="Gols {{ $partida[1] }}" required>
            </div>
        @endforeach
        <button type="submit">Salvar Resultados</button>
    </form>

    <h2>Pontuações:</h2>
    <ul>
        @php
            $pontuacoes = json_decode($torneio->pontuacoes, true) ?? []; // Decodifica para um array
        @endphp
        @if (!empty($pontuacoes))
            @foreach ($pontuacoes as $time => $pontos)
                <li>{{ $time }}: {{ $pontos }} pontos</li>
            @endforeach
        @else
            <li>Nenhuma pontuação registrada.</li>
        @endif
    </ul>
</div>
