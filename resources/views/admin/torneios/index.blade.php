<h1>Lista de Torneios</h1>

<table>
    <thead>
        <tr>
            <th>Nome</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($torneios as $torneio)
            <tr>
                <td>{{ $torneio->nome }}</td>
                <td>
                    <a href="{{ route('torneios.edit', $torneio->id) }}">Editar</a>
                    <form action="{{ route('admin.torneios.destroy', $torneio->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Excluir</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>