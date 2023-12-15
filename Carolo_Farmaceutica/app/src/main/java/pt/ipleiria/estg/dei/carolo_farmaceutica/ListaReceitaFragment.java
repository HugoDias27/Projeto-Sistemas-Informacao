package pt.ipleiria.estg.dei.carolo_farmaceutica;

import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

/**
 * A simple {@link Fragment} subclass.
 * Use the {@link ListaReceitaFragment#newInstance} factory method to
 * create an instance of this fragment.
 */
public class ListaReceitaFragment extends Fragment {

    public ListaReceitaFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_lista_receita, container, false);
    }
}