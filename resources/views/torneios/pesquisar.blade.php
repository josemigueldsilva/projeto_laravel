<div class="container">
    <h1>Resultados da Pesquisa para "{{ $query }}"</h1>

    @if($torneios->isEmpty())
        <p>Nenhum torneio encontrado.</p>
    @else
        <ul class="list-group">
            @foreach($torneios as $torneio)
                <li class="list-group-item">
                    <a href="{{ route('torneios.show', $torneio->id) }}">{{ $torneio->nome }}</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>