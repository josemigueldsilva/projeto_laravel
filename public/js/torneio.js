// Seleciona os elementos necessários
const quantidadeTimesInput = document.getElementById('quantidade-times');
const nomesTimesContainer = document.getElementById('nomes-times');

// Atualiza os campos de "Nome dos Times" conforme a quantidade inserida
quantidadeTimesInput.addEventListener('input', function() {
    const quantidade = parseInt(this.value);
    nomesTimesContainer.innerHTML = ''; // Limpa campos anteriores

    for (let i = 0; i < quantidade; i++) {
        const input = document.createElement('input');
        input.type = 'text';
        input.name = `times[]`;
        input.placeholder = `Nome do Time ${i + 1}`;
        input.required = true;
        nomesTimesContainer.appendChild(input);
    }
});
