package pt.ipleiria.estg.dei.carolo_farmaceutica;

import android.content.Intent;
import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.SearchView;
import android.widget.Toast;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.adaptadores.ListaMedicamentoAdaptador;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.MedicamentosListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.Medicamento;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.SingletonGestorFarmacia;


public class ListaMedicamentoFragment extends Fragment implements MedicamentosListener {


    private ListView lvMedicamentos;
    private ArrayList<Medicamento> medicamentos;
    private SearchView searchView;
    public ListaMedicamentoFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {

        View view = inflater.inflate(R.layout.fragment_lista_medicamento, container, false);
        setHasOptionsMenu(true);
        lvMedicamentos = view.findViewById(R.id.lvMedicamentos);

        SingletonGestorFarmacia.getInstance(getContext()).setMedicamentosListener(this);
        SingletonGestorFarmacia.getInstance(getContext()).getAllMedicamentosAPI(getContext());

        lvMedicamentos.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int position, long id) {
                Toast.makeText(getContext(), medicamentos.get(position).getNome(), Toast.LENGTH_LONG).show();
            }
        });
        return view;
    }
    @Override
    public void onRefreshListaMedicamento(ArrayList<Medicamento> listaMedicamentos) {
        if(listaMedicamentos != null) {
            lvMedicamentos.setAdapter(new ListaMedicamentoAdaptador(getContext(), listaMedicamentos));
        }
    }
}