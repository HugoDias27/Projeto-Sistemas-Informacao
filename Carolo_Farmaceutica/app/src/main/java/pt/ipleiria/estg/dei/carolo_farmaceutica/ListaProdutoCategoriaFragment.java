package pt.ipleiria.estg.dei.carolo_farmaceutica;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.MenuInflater;
import android.view.MenuItem;
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

    // Declaração de variáveis
    private ListView lvMedicamentos;
    private SearchView searchView;

    // Construtor
    public ListaProdutoCategoriaFragment() {
        // Required empty public constructor
    }

    // Método para carregar o fragmento da lista dos medicamentos
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

    // Método para carregar o menu de pesquisa
    @Override
    public void onCreateOptionsMenu(android.view.Menu menu, MenuInflater inflater) {
        inflater.inflate(R.menu.menu_pesquisa, menu);
        super.onCreateOptionsMenu(menu, inflater);

        MenuItem itemPesquisa = menu.findItem(R.id.itemPesquisa);
        searchView = (SearchView) itemPesquisa.getActionView();

        SharedPreferences sharedPreferences = getActivity().getSharedPreferences("NOME_CATEGORIA", Context.MODE_PRIVATE);
        String nomeCategoria = sharedPreferences.getString("nome_categoria", "");

        searchView.setOnQueryTextListener(new SearchView.OnQueryTextListener() {
            @Override
            public boolean onQueryTextSubmit(String newText) {
                return false;
            }

            @Override
            public boolean onQueryTextChange(String newText) {
                ArrayList<Medicamento> listaMedicamentos = new ArrayList<>();
                for (Medicamento medicamento : SingletonGestorFarmacia.getInstance(getContext()).getMedicamentosCategoriaBD(nomeCategoria)) {
                    if (medicamento.getNome().toLowerCase().contains(newText.toLowerCase())) {
                        listaMedicamentos.add(medicamento);
                    }
                }
                lvMedicamentos.setAdapter(new ListaMedicamentoAdaptador(getContext(), listaMedicamentos));
                return true;
            }
        });
    }

    // Método para carregar os medicamentos da categoria selecionada
    @Override
    public void onRefreshListaMedicamento(ArrayList<Medicamento> listaMedicamentos) {
        if (listaMedicamentos != null) {
            lvMedicamentos.setAdapter(new ListaMedicamentoAdaptador(getContext(), listaMedicamentos));
        }
    }
}
