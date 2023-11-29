package pt.ipleiria.estg.dei.carolo_farmaceutica;

import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

/**
 * A simple {@link Fragment} subclass.
 * Use the {@link DespesaFragment#newInstance} factory method to
 * create an instance of this fragment.
 */
public class DespesaFragment extends Fragment {

    public DespesaFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_despesa, container, false);
    }
}