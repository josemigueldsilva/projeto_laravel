<div class="container">
    <h2>Editar Torneio</h2>
    
    <form action="{{ route('torneios.atualizar', $torneio->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nome" class="form-label">Nome do Torneio</label>
            <input type="text" class="form-control" id="nome" name="nome" value="{{ $torneio->nome }}" required>
        </div>

        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao" required>{{ $torneio->descricao }}</textarea>
        </div>

        <div class="mb-3">
            <label for="quantidade_times" class="form-label">Quantidade de Times</label>
            <input type="number" class="form-control" id="quantidade_times" name="quantidade_times" value="{{ $torneio->quantidade_times }}" required>
        </div>

        <div class="mb-3">
            <label for="formato" class="form-label">Formato do Torneio</label>
            <select class="form-select" id="formato" name="formato" required>
                <option value="Eliminatorio" {{ $torneio->formato === 'Eliminatorio' ? 'selected' : '' }}>Eliminatório</option>
                <option value="Fase de Grupos" {{ $torneio->formato === 'Fase de Grupos' ? 'selected' : '' }}>Fase de Grupos</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>

    <form action="{{ route('torneios.excluir', $torneio->id) }}" method="POST" class="mt-3">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Excluir Torneio</button>
    </form>
</div>