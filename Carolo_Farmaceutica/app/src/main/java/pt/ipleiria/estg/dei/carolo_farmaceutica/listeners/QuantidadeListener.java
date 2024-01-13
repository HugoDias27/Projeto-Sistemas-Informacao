package pt.ipleiria.estg.dei.carolo_farmaceutica.listeners;

public interface QuantidadeListener {
    void onRefreshQuantidade(double[] quantidade);
    void onRefreshDeleteLinhaCarrinho(boolean resposta);

}
