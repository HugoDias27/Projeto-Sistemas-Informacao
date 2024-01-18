package pt.ipleiria.estg.dei.carolo_farmaceutica.listeners;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.Medicamento;

public interface MedicamentosListener {

    // Metódo quando é acedido mostra a lista de medicamentos
    void onRefreshListaMedicamento(ArrayList<Medicamento> listaMedicamentos);
}
