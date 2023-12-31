package pt.ipleiria.estg.dei.carolo_farmaceutica;

import android.content.Intent;
import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.MenuInflater;
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
                Intent intent = new Intent(getContext(), DetalhesMedicamentoActivity.class);
                intent.putExtra(DetalhesMedicamentoActivity.ID_MEDICAMENTO, (int) id);
                startActivity(intent);
            }
        });
        return view;
    }

    @Override
    public void onCreateOptionsMenu(android.view.Menu menu, MenuInflater inflater) {
        inflater.inflate(R.menu.menu_pesquisa, menu);
        super.onCreateOptionsMenu(menu, inflater);
        searchView = (SearchView) menu.findItem(R.id.itemPesquisa).getActionView();
        searchView.setOnQueryTextListener(new SearchView.OnQueryTextListener() {
            @Override
            public boolean onQueryTextSubmit(String newText) {
                return false;
            }

            @Override
            public boolean onQueryTextChange(String newText) {
                ArrayList<Medicamento> listaMedicamentos = new ArrayList<>();
                for (Medicamento medicamento : SingletonGestorFarmacia.getInstance(getContext()).getMedicamentosBD()) {
                    if (medicamento.getNome().toLowerCase().contains(newText.toLowerCase())) {
                        listaMedicamentos.add(medicamento);
                    }
                }
                lvMedicamentos.setAdapter(new ListaMedicamentoAdaptador(getContext(), listaMedicamentos));
                return true;
            }
        });

    }

    @Override
    public void onRefreshListaMedicamento(ArrayList<Medicamento> listaMedicamentos) {
        if(listaMedicamentos != null) {
            lvMedicamentos.setAdapter(new ListaMedicamentoAdaptador(getContext(), listaMedicamentos));
        }
    }
}