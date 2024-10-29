// Seleciona os elementos necessários
const quantidadeTimesInput = document.getElementById('quantidade-times');
const formatoSelect = document.getElementById('formato');
const timesPorGrupoInput = document.getElementById('times-por-grupo');
const gruposConfig = document.getElementById('grupos-config');

// Atualiza os campos de "Nome dos Times" conforme a quantidade inserida
quantidadeTimesInput.addEventListener('input', function() {
    const quantidade = parseInt(this.value);
    const nomesTimesContainer = document.getElementById('nomes-times');
    nomesTimesContainer.innerHTML = ''; // Limpa campos anteriores

    for (let i = 0; i < quantidade; i++) {
        const input = document.createElement('input');
        input.type = 'text';
        input.name = `times[]`;
        input.placeholder = `Nome do Time ${i + 1}`;
        input.required = true;
        nomesTimesContainer.appendChild(input);
    }

    // Ajusta o valor máximo do campo "Times por Grupo" para a metade da quantidade de times
    if (formatoSelect.value === 'fase_grupos') {
        const maxTimesPorGrupo = Math.floor(quantidade / 2);
        timesPorGrupoInput.max = maxTimesPorGrupo;
        timesPorGrupoInput.value = ''; // Limpa valor anterior, se houver
    }
});

// Exibe ou oculta o campo "Times por Grupo" conforme o formato selecionado
formatoSelect.addEventListener('change', function() {
    if (this.value === 'fase_grupos') {
        const quantidade = parseInt(quantidadeTimesInput.value);
        const maxTimesPorGrupo = Math.floor(quantidade / 2);

        gruposConfig.style.display = 'block';
        timesPorGrupoInput.max = maxTimesPorGrupo;
        timesPorGrupoInput.value = ''; // Limpa valor anterior, se houver
    } else {
        gruposConfig.style.display = 'none';
    }
});
