package pt.ipleiria.estg.dei.carolo_farmaceutica.listeners;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.ReceitaMedica;

public interface ReceitaMedicaListener {

    // Método quando é acedido mostra a lista de receitas médicas
    void onRefreshReceitaMedica(ArrayList<ReceitaMedica> listaReceitaMedica);

}
