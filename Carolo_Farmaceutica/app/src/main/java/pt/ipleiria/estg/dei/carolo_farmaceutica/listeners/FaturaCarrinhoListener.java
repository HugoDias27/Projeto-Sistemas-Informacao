package pt.ipleiria.estg.dei.carolo_farmaceutica.listeners;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.LinhaCarrinhoCompra;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.LinhaCarrinhoCompraFatura;

public interface FaturaCarrinhoListener {

    void onLinhasCarrinhoCarregadas(ArrayList<LinhaCarrinhoCompraFatura> linhas);
}
