package pt.ipleiria.estg.dei.carolo_farmaceutica.listeners;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.CarrinhoCompra;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.LinhaCarrinhoCompra;

public interface LinhaCarrinhoListener {

    // Metódo quando é acedido mostra as linhas do carrinho de compras
    void onRefreshLinhaCarrinho(ArrayList<LinhaCarrinhoCompra> LinhaCarrinhocompra);

}
