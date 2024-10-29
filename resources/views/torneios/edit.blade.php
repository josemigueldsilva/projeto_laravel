<div class="container">
    <h1>Editar Torneio</h1>
    <form action="{{ route('torneio.update', $torneio->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" value="{{ $torneio->nome }}" required>
        </div>
        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea name="descricao" id="descricao" class="form-control">{{ $torneio->descricao }}</textarea>
        </div>
        <div class="form-group">
            <label for="quantidade_times">Quantidade de Times</label>
            <input type="number" name="quantidade_times" id="quantidade_times" class="form-control" value="{{ $torneio->quantidade_times }}" required>
        </div>
        <div class="form-group">
            <label for="formato">Formato</label>
            <select name="formato" id="formato" class="form-control" required>
                <option value="eliminatorio" {{ $torneio->formato == 'eliminatorio' ? 'selected' : '' }}>Eliminatório</option>
                <option value="fase_grupos" {{ $torneio->formato == 'fase_grupos' ? 'selected' : '' }}>Fase de Grupos</option>
            </select>
        </div>
        <div class="form-group">
            <label for="times_por_grupo">Times por Grupo (se aplicável)</label>
            <input type="number" name="times_por_grupo" id="times_por_grupo" class="form-control" value="{{ $torneio->times_por_grupo }}">
        </div>
        <button type="submit" class="btn btn-success">Atualizar Torneio</button>
    </form>
</div>