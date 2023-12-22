package pt.ipleiria.estg.dei.carolo_farmaceutica;

import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;


import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.LinhaCarrinhoListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.CarrinhoCompra;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.LinhaCarrinhoCompra;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.SingletonGestorFarmacia;


public class LinhaCarrinhoFragment extends Fragment implements LinhaCarrinhoListener {

    private ListView lvCarrinho;

    public LinhaCarrinhoFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_carrinho, container, false);
        setHasOptionsMenu(true);
        lvCarrinho = view.findViewById(R.id.lvCarrinho);

        SingletonGestorFarmacia.getInstance(getContext()).setLinhaCarrinhoCompraListener(this);
        SingletonGestorFarmacia.getInstance(getContext()).getLinhasCarrinho(getContext());

        /*
        lvCarrinho.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int position, long id) {
                //  Toast.makeText(getContext(), medicamentos.get(position).getNome(), Toast.LENGTH_LONG).show();

                Intent intent = new Intent(getContext(), DetalhesMedicamentoActivity.class);
                intent.putExtra(DetalhesMedicamentoActivity.ID_MEDICAMENTO, (int) id);
                startActivity(intent);
            }
        });
        */

        return view;
    }


    @Override
    public void onRefreshLinhaCarrinho(LinhaCarrinhoCompra LinhaCarrinhocompra) {

    }
}