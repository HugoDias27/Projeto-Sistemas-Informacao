package pt.ipleiria.estg.dei.carolo_farmaceutica;

import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ListView;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.adaptadores.ListaFaturaAdaptador;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.FaturaListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.Fatura;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.SingletonGestorFarmacia;

public class ListaFaturaFragment extends Fragment implements FaturaListener {

    private ListView lvFaturas;

    public ListaFaturaFragment() {
    }

    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_lista_fatura, container, false);
        setHasOptionsMenu(true);
        lvFaturas = view.findViewById(R.id.lvFaturas);

        SingletonGestorFarmacia.getInstance(getContext()).setFaturasListener(this);
        SingletonGestorFarmacia.getInstance(getContext()).getFaturasAPI(getContext());

        lvFaturas.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int position, long id) {
                Intent intent = new Intent(getContext(), DetalhesFaturaActivity.class);
                intent.putExtra(DetalhesFaturaActivity.ID_FATURA, (int) id);
                startActivity(intent);
            }
        });

        return view;
    }

    @Override
    public void onRefreshListaFatura(ArrayList<Fatura> listaFatura) {
        if(listaFatura != null){
            lvFaturas.setAdapter(new ListaFaturaAdaptador(getContext(), listaFatura));
        }
    }
}
