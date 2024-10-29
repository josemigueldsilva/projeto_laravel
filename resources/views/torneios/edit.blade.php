<div class="container">
    <h1>Editar Torneio</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('torneios.update', $torneio->id) }}" method="POST" class="tournament-form">
        @csrf

        <label for="nome">Nome do Torneio:</label>
        <input type="text" id="nome" name="nome" value="{{ old('nome', $torneio->nome) }}" required>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" required>{{ old('descricao', $torneio->descricao) }}</textarea>

        <label for="quantidade-times">Quantidade de Times:</label>
        <input type="number" id="quantidade-times" name="quantidade_times" min="2" value="{{ old('quantidade_times', $torneio->quantidade_times) }}" required>

        <label for="times">Nome dos Times:</label>
        <div id="nomes-times">
            @php
                $times = json_decode($torneio->times); // Supondo que 'times' seja um campo JSON
            @endphp
            @if(is_array($times))
                @foreach($times as $index => $time)
                    <input type="text" name="times[]" value="{{ old('times.' . $index, $time) }}" placeholder="Nome do Time {{ $index + 1 }}" required>
                @endforeach
            @endif
        </div>

        <button type="submit">Atualizar Torneio</button>
    </form>
</div>

<style>
    /* Estilos do formulário */
    .tournament-form {
        max-width: 600px;
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

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #555;
    }

    input[type="text"],
    input[type="number"],
    textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    textarea {
        resize: vertical; /* Permite redimensionar verticalmente */
        height: 100px; /* Altura padrão para a textarea */
    }

    button {
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #0056b3;
    }

    .alert {
        margin-bottom: 20px;
        padding: 10px;
        border-radius: 4px;
        background-color: #f8d7da;
        color: #721c24;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const quantidadeTimesInput = document.getElementById('quantidade-times');
        const nomesTimesContainer = document.getElementById('nomes-times');

        quantidadeTimesInput.addEventListener('input', function () {
            const quantidadeTimes = parseInt(this.value) || 0;
            nomesTimesContainer.innerHTML = ''; // Limpa os campos de nomes dos times

            // Adiciona os campos de entrada para cada time
            for (let i = 0; i < quantidadeTimes; i++) {
                const input = document.createElement('input');
                input.type = 'text';
                input.name = 'times[]';
                input.placeholder = `Nome do Time ${i + 1}`;
                input.required = true;
                nomesTimesContainer.appendChild(input);
            }
        });
    });
</script>
