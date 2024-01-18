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
import android.widget.EditText;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;


import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.adaptadores.ListaCarrinhoAdaptador;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.CheckoutListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.LinhaCarrinhoListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.QuantidadeAlteradaListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.SubtotalListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.LinhaCarrinhoCompra;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.SingletonGestorFarmacia;
import pt.ipleiria.estg.dei.carolo_farmaceutica.utils.LinhaCarrinhoJsonParser;


public class LinhaCarrinhoFragment extends Fragment implements LinhaCarrinhoListener, CheckoutListener, SubtotalListener, QuantidadeAlteradaListener {

    // Declaração de variáveis
    private ListView lvCarrinho;
    private Button btnCheckout;
    public static final String USERNAME = "USERNAME";
    private double subtotalValor = 0.0;
    private AlertDialog alertDialog;
    private ArrayList<LinhaCarrinhoCompra> listaCarrinho = new ArrayList<>();
    private boolean btnCheckoutClicked = false;
    private EditText numeroCartao, dataValidade, CVV;
    private TextView tvTotal, tvEntidade, tvReferencia;
    private boolean cartaoCreditoSelecionado = false;
    private boolean multibancoSelecionado = false;

    // Construtor
    public LinhaCarrinhoFragment() {
        // Required empty public constructor
    }

    // Método para carregar o fragmento do carrinho de compras
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

        ListaCarrinhoAdaptador adaptador = new ListaCarrinhoAdaptador(getContext(), listaCarrinho);
        adaptador.setQuantidadeAlteradaListener(this);

        if (LinhaCarrinhoJsonParser.isConnectionInternet(getContext()))
            btnCheckout.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    btnCheckoutClicked = true;
                    SingletonGestorFarmacia.getInstance(getContext()).getSubtotal(getContext());
                }
            });
        else {
            btnCheckout.setVisibility(View.INVISIBLE);
        }
        return view;
    }

    // Método para carregar as linhas do carrinho de compras
    @Override
    public void onRefreshLinhaCarrinho(ArrayList<LinhaCarrinhoCompra> linhas) {
        if (linhas.size() != 0) {
            lvCarrinho.setAdapter(new ListaCarrinhoAdaptador(getContext(), linhas));
        }
    }

    // Método que finaliza a compra quando o checkout é efetuado
    @Override
    public void onRefreshCheckout(boolean resposta) {
        if (resposta) {
            Toast.makeText(getContext(), R.string.txt_compra_sucesso, Toast.LENGTH_LONG).show();
            SharedPreferences preferences = getActivity().getSharedPreferences("LOGIN", Context.MODE_PRIVATE);
            String username = preferences.getString("USERNAME", "");
            Intent intent = new Intent(getContext(), MenuMainActivity.class);
            intent.putExtra(USERNAME, username);
            startActivity(intent);
        } else {
            Toast.makeText(getContext(), R.string.txt_erro_checkout, Toast.LENGTH_SHORT).show();
        }
    }

    // Método que recebe o subtotal do carrinho de compras
    @Override
    public void onSubtotal(double subtotal) {
        subtotalValor = subtotal;

        if (btnCheckoutClicked && subtotalValor > 0) {
            exibirDialogoConfirmacao();
        } else if (btnCheckoutClicked) {
            Toast.makeText(getContext(), R.string.txt_carrinho_vazio, Toast.LENGTH_LONG).show();
        }
    }

    // Método que mostra a confirmação da compra
    private void exibirDialogoConfirmacao() {
        String subtotalText = String.format("%.2f€", subtotalValor);

        View pagamentoView = LayoutInflater.from(getContext()).inflate(R.layout.layout_pagamento, null);

        AlertDialog.Builder builder = new AlertDialog.Builder(getContext());
        builder.setTitle(R.string.txt_confirmar_compra);
        builder.setMessage("Subtotal:" + subtotalText + "\n" + "Deseja confirmar a compra?");
        builder.setView(pagamentoView);

        Button btnCartaoCredito = pagamentoView.findViewById(R.id.btnCartaoCredito);
        Button btnMultibanco = pagamentoView.findViewById(R.id.btnMultibanco);

        numeroCartao = pagamentoView.findViewById(R.id.edtNumeroCartao);
        dataValidade = pagamentoView.findViewById(R.id.edtDataValidade);
        CVV = pagamentoView.findViewById(R.id.etCVV);
        tvEntidade = pagamentoView.findViewById(R.id.tvEntidade);
        tvReferencia = pagamentoView.findViewById(R.id.tvReferencia);
        tvTotal = pagamentoView.findViewById(R.id.tvValorTotal);

        numeroCartao.setVisibility(View.GONE);
        dataValidade.setVisibility(View.GONE);
        CVV.setVisibility(View.GONE);
        tvEntidade.setVisibility(View.GONE);
        tvReferencia.setVisibility(View.GONE);
        tvTotal.setVisibility(View.GONE);

        btnCartaoCredito.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                numeroCartao.setVisibility(View.VISIBLE);
                dataValidade.setVisibility(View.VISIBLE);
                CVV.setVisibility(View.VISIBLE);

                tvEntidade.setVisibility(View.GONE);
                tvReferencia.setVisibility(View.GONE);
                tvTotal.setVisibility(View.GONE);

                cartaoCreditoSelecionado = true;
                multibancoSelecionado = false;
            }
        });

        btnMultibanco.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                tvEntidade.setVisibility(View.VISIBLE);
                tvReferencia.setVisibility(View.VISIBLE);
                tvTotal.setText("Subtotal: " + subtotalText);
                tvTotal.setVisibility(View.VISIBLE);

                numeroCartao.setVisibility(View.GONE);
                dataValidade.setVisibility(View.GONE);
                CVV.setVisibility(View.GONE);

                cartaoCreditoSelecionado = false;
                multibancoSelecionado = true;
            }
        });


        builder.setPositiveButton("Sim", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                if (cartaoCreditoSelecionado || multibancoSelecionado) {
                    if (cartaoCreditoSelecionado && (numeroCartao.getText().toString().isEmpty() || dataValidade.getText().toString().isEmpty() || CVV.getText().toString().isEmpty())) {
                        Toast.makeText(getContext(), R.string.txt_dados_cartao_vazios, Toast.LENGTH_SHORT).show();
                    } else {
                        SingletonGestorFarmacia.getInstance(getContext()).fazFatura(getContext());
                    }
                } else {
                    Toast.makeText(getContext(), R.string.txt_metodo_pagamento_vazio, Toast.LENGTH_SHORT).show();
                }
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


    // Método que atualiza o subtotal quando a quantidade é alterada
    @Override
    public void onQuantidadeAlterada() {
        SingletonGestorFarmacia.getInstance(getContext()).getSubtotal(getContext());
    }
}