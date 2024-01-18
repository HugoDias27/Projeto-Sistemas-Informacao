package pt.ipleiria.estg.dei.carolo_farmaceutica.listeners;

public interface QuantidadeListener {

    // Método quando é acedido recebe a quantidade do produto
    void onRefreshProduto(double[] dadosProduto);

    // Método quando é apagado uma linha do carrinho
    void onRefreshDeleteLinhaCarrinho(boolean resposta);

}
