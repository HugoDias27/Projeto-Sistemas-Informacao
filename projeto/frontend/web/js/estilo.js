document.addEventListener("DOMContentLoaded", function() {
    document.querySelector('.btn-cartao').addEventListener('click', mostrarCartao);

    document.querySelector('.btn-multibanco').addEventListener('click', mostrarMultibanco);
});

function mostrarCartao() {
    document.getElementById("dadosCartao").style.display = "block";
    document.getElementById("dadosMultibanco").style.display = "none";
}

function mostrarMultibanco() {
    document.getElementById("dadosCartao").style.display = "none";
    document.getElementById("dadosMultibanco").style.display = "block";
}
