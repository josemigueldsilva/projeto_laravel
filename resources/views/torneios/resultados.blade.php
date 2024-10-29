<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados da Pesquisa</title>
    <link href="/css/styles.css" rel="stylesheet" />
</head>
<body>
    <h1>Resultados da Pesquisa</h1>

    @if ($torneios->isEmpty())
        <p>Nenhum torneio encontrado.</p>
    @else
        <ul>
            @foreach ($torneios as $torneio)
                <li>
                    <a href="{{ route('torneios.show', $torneio->id) }}">{{ $torneio->nome }}</a>
                </li>
            @endforeach
        </ul>
    @endif

</body>
</html>