package pt.ipleiria.estg.dei.carolo_farmaceutica;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.ListView;
import android.widget.Toast;


import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.adaptadores.ListaCarrinhoAdaptador;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.CheckoutListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.LinhaCarrinhoListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.LinhaCarrinhoCompra;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.SingletonGestorFarmacia;


public class LinhaCarrinhoFragment extends Fragment implements LinhaCarrinhoListener, CheckoutListener {

    private ListView lvCarrinho;
    private Button btnCheckout;
    private ImageButton btRemover;
    private ImageButton btnAdicionar;
    private ImageButton btReduzir;
    public static final String USERNAME = "USERNAME";



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
        SingletonGestorFarmacia.getInstance(getContext()).setCheckoutListener(this);

        btnCheckout = view.findViewById(R.id.btCheckout);

        btnCheckout.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                SingletonGestorFarmacia.getInstance(getContext()).fazFatura(getContext());
            }
        });

        return view;
    }


    @Override
    public void onRefreshLinhaCarrinho(ArrayList<LinhaCarrinhoCompra> linhas) {
        if (linhas != null) {
            lvCarrinho.setAdapter(new ListaCarrinhoAdaptador(getContext(), linhas));
        }
    }


    @Override
    public void onRefreshCheckout(boolean resposta) {
        if (resposta) {
            Toast.makeText(getContext(), "Compra efetuada com sucesso", Toast.LENGTH_LONG).show();
            SharedPreferences preferences = getActivity().getSharedPreferences("LOGIN", Context.MODE_PRIVATE);
            String username = preferences.getString("USERNAME", "");
            Intent intent = new Intent(getContext(), MenuMainActivity.class);
            intent.putExtra(USERNAME, username);
            startActivity(intent);
        } else {
            Toast.makeText(getContext(), "Erro ao efetuar a compra", Toast.LENGTH_LONG).show();
        }
    }
}