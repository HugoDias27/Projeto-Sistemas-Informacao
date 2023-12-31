package pt.ipleiria.estg.dei.carolo_farmaceutica.listeners;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.CarrinhoCompra;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.LinhaCarrinhoCompra;

public interface LinhaCarrinhoListener {
    void onRefreshLinhaCarrinho(ArrayList<LinhaCarrinhoCompra> LinhaCarrinhocompra);

}
