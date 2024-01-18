package pt.ipleiria.estg.dei.carolo_farmaceutica.listeners;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.Fatura;

public interface FaturaListener {

    // Metódo quando é acedido mostra a lista de faturas
    void onRefreshListaFatura(ArrayList<Fatura> listaFatura);
}
