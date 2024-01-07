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
import java.util.List;

import pt.ipleiria.estg.dei.carolo_farmaceutica.adaptadores.ListaFaturaAdaptador;
import pt.ipleiria.estg.dei.carolo_farmaceutica.adaptadores.ListaLinhaFaturaAdaptador;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.FaturaCarrinhoListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.LinhaCarrinhoCompra;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.LinhaCarrinhoCompraFatura;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.SingletonGestorFarmacia;

public class FaturaLinhasFragment extends Fragment implements FaturaCarrinhoListener {

    private ListView lvLinhasFatura;
    private int idFatura;

    public FaturaLinhasFragment() {
    }

    public void setIdFatura(int idFatura) {
        this.idFatura = idFatura;
    }

    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_lista_fatura_linhas, container, false);
        setHasOptionsMenu(true);
        lvLinhasFatura = view.findViewById(R.id.lvLinhasFatura);

        if (idFatura != 0) {
            SingletonGestorFarmacia.getInstance(getContext()).setFaturaCarrinhoListener(this);
            SingletonGestorFarmacia.getInstance(getContext()).getLinhasCarrinhoCompra(idFatura, getContext());
        }

        return view;
    }

    @Override
    public void onLinhasCarrinhoCarregadas(ArrayList<LinhaCarrinhoCompraFatura> linhas) {
        if (linhas != null) {
            lvLinhasFatura.setAdapter(new ListaLinhaFaturaAdaptador(getContext(), linhas));
        }
    }
}

