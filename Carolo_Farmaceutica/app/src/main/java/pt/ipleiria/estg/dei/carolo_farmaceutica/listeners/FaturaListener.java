package pt.ipleiria.estg.dei.carolo_farmaceutica.listeners;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.Fatura;

public interface FaturaListener {
    void onRefreshListaFatura(ArrayList<Fatura> listaFatura);
}
