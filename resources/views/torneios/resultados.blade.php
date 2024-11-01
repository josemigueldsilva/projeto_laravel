<div class="container">
    <h1>Resultados da Pesquisa</h1>

    @if($torneios->isEmpty())
        <p>Nenhum torneio encontrado para a sua busca.</p>
    @else
        <ul class="list-group">
            @foreach($torneios as $torneio)
                <li class="list-group-item">
                    <a href="{{ route('torneio.show', $torneio->id) }}">{{ $torneio->nome }}</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection