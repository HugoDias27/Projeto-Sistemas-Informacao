package pt.ipleiria.estg.dei.carolo_farmaceutica;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.MenuInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.SearchView;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.adaptadores.ListaMedicamentoAdaptador;
import pt.ipleiria.estg.dei.carolo_farmaceutica.adaptadores.ListaReceitaMedicaAdaptador;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.ReceitaMedicaListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.Medicamento;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.ReceitaMedica;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.SingletonGestorFarmacia;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.User;


public class ListaReceitaFragment extends Fragment implements ReceitaMedicaListener {

    // Declaração de variáveis
    private ListView lvReceitas;
    private SearchView searchView;
    private Context context;

    // Construtor
    public ListaReceitaFragment() {
        // Required empty public constructor
    }

    // Método para carregar o fragmento da lista das receitas médicas
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_lista_receita, container, false);
        setHasOptionsMenu(true);
        lvReceitas = view.findViewById(R.id.lvReceitas);

        SingletonGestorFarmacia.getInstance(getContext()).setReceitaMedicaListener(this);
        SingletonGestorFarmacia.getInstance(getContext()).getMinhaReceitaAPI(getContext());

        context = getContext();

        lvReceitas.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int position, long id) {
                Intent intent = new Intent(getContext(), DetalhesReceitaActivity.class);
                intent.putExtra(DetalhesReceitaActivity.ID_RECEITA, (int) id);
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
        searchView = (SearchView) menu.findItem(R.id.itemPesquisa).getActionView();

        SharedPreferences preferences = context.getSharedPreferences("DADOS_PESQUISA", Context.MODE_PRIVATE);
        int id = preferences.getInt("id", 0);

        searchView.setOnQueryTextListener(new SearchView.OnQueryTextListener() {
            @Override
            public boolean onQueryTextSubmit(String newText) {
                return false;
            }

            @Override
            public boolean onQueryTextChange(String newText) {
                ArrayList<ReceitaMedica> listaReceitaMedicas = new ArrayList<>();
                for (ReceitaMedica receitaMedica : SingletonGestorFarmacia.getInstance(getContext()).getReceitaMedicaBD(id)) {
                    String codigoString = String.valueOf(receitaMedica.getCodigo());
                    if (codigoString.toLowerCase().contains(newText.toLowerCase())) {
                        listaReceitaMedicas.add(receitaMedica);
                    }
                }
                lvReceitas.setAdapter(new ListaReceitaMedicaAdaptador(getContext(), listaReceitaMedicas));
                return true;
            }
        });
    }

    // Método para carregar as receitas médicas
    @Override
    public void onRefreshReceitaMedica(ArrayList<ReceitaMedica> listaReceitaMedica) {
        if (listaReceitaMedica != null) {
            lvReceitas.setAdapter(new ListaReceitaMedicaAdaptador(getContext(), listaReceitaMedica));
        }
    }
}