// Função para atualizar a hora a cada segundo
function atualizarHora() {
    // Obtém o elemento com o ID "hora-atual"
    var elementoHora = document.getElementById('horaAtual');

    // Obtém a hora atual em JavaScript
    var agora = new Date();
    var horas = agora.getHours();
    var minutos = agora.getMinutes();
    var segundos = agora.getSeconds();

    // Formata a hora como desejado
    var horaFormatada = horas + ':' + (minutos < 10 ? '0' : '') + minutos + ':' + (segundos < 10 ? '0' : '') + segundos;

    // Atualiza o conteúdo do elemento com a nova hora
    elementoHora.innerHTML = '<br><br><br><br><img src="../web/img/relogio.png" width="30dp"> ' + horaFormatada;
}

// Atualiza a hora a cada segundo
setInterval(atualizarHora, 1000);
