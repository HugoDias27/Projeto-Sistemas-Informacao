function atualizarData() {
    // Obtém o elemento com o ID "DataAtual"
    var elementoData = document.getElementById('DataAtual');

    // Obtém a data atual em JavaScript
    var agora = new Date();
    var ano = agora.getFullYear();
    var mes = agora.getMonth() + 1; // Lembre-se que os meses começam do zero
    var dia = agora.getDate();

    // Formata a data como desejado
    var dataFormatada = dia + '/' + mes + '/' + ano;

    // Adiciona uma imagem ao lado do texto
    var conteudo = '<br><br><br><br><img src="../web/img/calendario.png" width="30dp"> ' + dataFormatada;

    // Atualiza o conteúdo do elemento com a nova data e imagem
    elementoData.innerHTML = conteudo;
}

// Atualiza a data a cada segundo
setInterval(atualizarData, 1000);