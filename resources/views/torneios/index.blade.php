<style>
    /* Estilos do contêiner do torneio */
    .tournament-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
        font-size: 24px;
        font-weight: 600;
    }

    p {
        text-align: center;
        color: #666;
        margin-bottom: 20px;
    }

    ul {
        list-style: none;
        padding: 0;
    }

    li {
        margin-bottom: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        transition: background-color 0.2s;
    }

    li:hover {
        background-color: #f8f8f8;
    }

    a {
        color: #007bff;
        text-decoration: none;
        font-weight: 500;
    }

    a:hover {
        text-decoration: underline;
    }

    button {
        padding: 5px 10px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #0056b3;
    }

    .delete-button {
        background-color: #dc3545;
    }

    .delete-button:hover {
        background-color: #c82333;
    }

    .tournament-button {
        background-color: #007bff;
        border: none;
        border-radius: 4px;
        padding: 10px 15px;
        color: white;
        font-size: 14px;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .tournament-button:hover {
        background-color: #0056b3;
    }
</style>

<div class="tournament-container">
    <h1>Meus Torneios</h1>

    @if($torneios->isEmpty())
        <p>Nenhum torneio encontrado.</p>
    @else
        <ul>
            @foreach($torneios as $torneio)
                <li>
                    <a href="{{ route('torneios.show', $torneio->id) }}">{{ $torneio->nome }}</a>

                    {{-- Verifica se o usuário autenticado é o criador do torneio --}}
                    @if(auth()->id() === $torneio->user_id)
                        <div>
                            <a href="{{ route('torneios.edit', $torneio->id) }}" class="tournament-button">Editar</a>
                            
                            <form action="{{ route('torneios.destroy', $torneio->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-button" onclick="return confirm('Tem certeza que deseja excluir este torneio?');">Excluir</button>
                            </form>
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('torneios.create') }}" class="tournament-button" style="margin-top: 20px; display: block; text-align: center;">Criar Novo Torneio</a>
</div>