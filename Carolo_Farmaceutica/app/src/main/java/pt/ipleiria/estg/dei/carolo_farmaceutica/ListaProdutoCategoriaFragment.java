package pt.ipleiria.estg.dei.carolo_farmaceutica;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.SearchView;

import androidx.fragment.app.Fragment;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.adaptadores.ListaMedicamentoAdaptador;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.MedicamentosListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.Medicamento;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.SingletonGestorFarmacia;

public class ListaProdutoCategoriaFragment extends Fragment implements MedicamentosListener {

    private ListView lvMedicamentos;
    private SearchView searchView;

    public ListaProdutoCategoriaFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_lista_medicamento, container, false);
        setHasOptionsMenu(true);
        lvMedicamentos = view.findViewById(R.id.lvMedicamentos);

        if (getArguments() != null) {
            String nomeCategoria = getArguments().getString("nome_categoria");
            getActivity().setTitle(nomeCategoria);
        }

        SharedPreferences sharedPreferences = getActivity().getSharedPreferences("NOME_CATEGORIA", Context.MODE_PRIVATE);
        String nomeCategoria = sharedPreferences.getString("nome_categoria", "");

        SingletonGestorFarmacia.getInstance(getContext()).setMedicamentosListener(this);
        SingletonGestorFarmacia.getInstance(getContext()).getMedicamentoCategoria(getContext(), nomeCategoria);

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
    public void onRefreshListaMedicamento(ArrayList<Medicamento> listaMedicamentos) {
        if(listaMedicamentos != null) {
            lvMedicamentos.setAdapter(new ListaMedicamentoAdaptador(getContext(), listaMedicamentos));
        }
    }
}
