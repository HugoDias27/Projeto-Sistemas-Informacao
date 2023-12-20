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

import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.adaptadores.ListaReceitaMedicaAdaptador;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.ReceitaMedicaListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.ReceitaMedica;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.SingletonGestorFarmacia;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.User;


public class ListaReceitaFragment extends Fragment implements ReceitaMedicaListener {

    private ListView lvReceitas;
    private ArrayList<ReceitaMedica> receitaMedica;
    private SearchView searchView;


    public ListaReceitaFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_lista_receita, container, false);
        setHasOptionsMenu(true);
        lvReceitas = view.findViewById(R.id.lvReceitas);

        SingletonGestorFarmacia.getInstance(getContext()).setReceitaMedicaListener(this);
        SingletonGestorFarmacia.getInstance(getContext()).getMinhaReceitaAPI(getContext());

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

    @Override
    public void onRefreshReceitaMedica(ArrayList<ReceitaMedica> listaReceitaMedica) {
        if (listaReceitaMedica != null) {
            lvReceitas.setAdapter(new ListaReceitaMedicaAdaptador(getContext(), listaReceitaMedica));
        }
    }
}