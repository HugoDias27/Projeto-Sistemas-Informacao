package pt.ipleiria.estg.dei.carolo_farmaceutica.listeners;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.Medicamento;

public interface MedicamentosListener {

        void onRefreshListaMedicamento(ArrayList<Medicamento> listaMedicamentos);
}
