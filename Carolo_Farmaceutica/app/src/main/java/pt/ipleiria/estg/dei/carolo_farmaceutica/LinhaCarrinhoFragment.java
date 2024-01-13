package pt.ipleiria.estg.dei.carolo_farmaceutica;

import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
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
import android.widget.TextView;
import android.widget.Toast;


import java.text.DecimalFormat;
import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.adaptadores.ListaCarrinhoAdaptador;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.CheckoutListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.LinhaCarrinhoListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.QuantidadeAlteradaListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.QuantidadeListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.SubtotalListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.LinhaCarrinhoCompra;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.SingletonGestorFarmacia;


public class LinhaCarrinhoFragment extends Fragment implements LinhaCarrinhoListener, CheckoutListener, SubtotalListener, QuantidadeAlteradaListener {

    private ListView lvCarrinho;
    private Button btnCheckout;
    public static final String USERNAME = "USERNAME";
    private double subtotalValor = 0.0;
    private AlertDialog alertDialog;
    private ArrayList<LinhaCarrinhoCompra> listaCarrinho = new ArrayList<>();
    private boolean btnCheckoutClicked = false;

    public LinhaCarrinhoFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_carrinho, container, false);
        setHasOptionsMenu(true);
        lvCarrinho = view.findViewById(R.id.lvCarrinho);
        btnCheckout = view.findViewById(R.id.btCheckout);

        SingletonGestorFarmacia.getInstance(getContext()).setLinhaCarrinhoCompraListener(this);
        SingletonGestorFarmacia.getInstance(getContext()).getLinhasCarrinho(getContext());
        SingletonGestorFarmacia.getInstance(getContext()).setCheckoutListener(this);
        SingletonGestorFarmacia.getInstance(getContext()).setSubtotalListener(this);
        SingletonGestorFarmacia.getInstance(getContext()).getSubtotal(getContext());

        ListaCarrinhoAdaptador adaptador = new ListaCarrinhoAdaptador(getContext(), listaCarrinho);
        adaptador.setQuantidadeAlteradaListener(this);


        btnCheckout.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                btnCheckoutClicked = true;
                SingletonGestorFarmacia.getInstance(getContext()).getSubtotal(getContext());
            }
        });

        return view;
    }

    @Override
    public void onRefreshLinhaCarrinho(ArrayList<LinhaCarrinhoCompra> linhas) {
        if (linhas.size() != 0) {
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

    @Override
    public void onSubtotal(double subtotal) {
        subtotalValor = subtotal;

        if (btnCheckoutClicked && subtotalValor > 0) {
            exibirDialogoConfirmacao();
        } else if (btnCheckoutClicked) {
            Toast.makeText(getContext(), "Não tem produtos no carrinho", Toast.LENGTH_LONG).show();
        }
    }

    private void exibirDialogoConfirmacao() {
        String subtotalText = String.format("%.2f€", subtotalValor);

        AlertDialog.Builder builder = new AlertDialog.Builder(getContext());
        builder.setTitle("Confirmação de Compra");

        builder.setMessage("Subtotal: " + subtotalText + "\nDeseja confirmar a compra?");

        builder.setPositiveButton("Sim", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                SingletonGestorFarmacia.getInstance(getContext()).fazFatura(getContext());
            }
        });

        builder.setNegativeButton("Não", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                dialog.dismiss();
            }
        });

        alertDialog = builder.create();
        alertDialog.show();
    }
    @Override
    public void onQuantidadeAlterada() {
        SingletonGestorFarmacia.getInstance(getContext()).getSubtotal(getContext());
    }
}