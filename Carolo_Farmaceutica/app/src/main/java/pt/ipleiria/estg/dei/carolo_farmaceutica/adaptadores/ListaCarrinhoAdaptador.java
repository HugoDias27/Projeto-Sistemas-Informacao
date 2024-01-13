package pt.ipleiria.estg.dei.carolo_farmaceutica.adaptadores;

import android.content.Context;
import android.content.SharedPreferences;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;

import java.text.DecimalFormat;
import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.R;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.QuantidadeAlteradaListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.QuantidadeListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.SubtotalListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.LinhaCarrinhoCompra;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.Medicamento;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.SingletonGestorFarmacia;

public class ListaCarrinhoAdaptador extends BaseAdapter implements QuantidadeListener {

    private Context context;
    private LayoutInflater inflater;
    private ArrayList<LinhaCarrinhoCompra> linhacarrinhoCompras;
    private QuantidadeAlteradaListener quantidadeAlteradaListener;
    private EditText etQuantidade;
    private TextView tvPreco;
    private ArrayList<EditText> listaEditTextQuantidade = new ArrayList<>();
    private ArrayList<TextView> listaTextViewPreco = new ArrayList<>();

    private int posicaoAtual, novaQuantidade;
    private double novoPreco;

    public ListaCarrinhoAdaptador(Context context, ArrayList<LinhaCarrinhoCompra> linhacarrinhoCompras) {
        this.context = context;
        this.linhacarrinhoCompras = linhacarrinhoCompras;
    }

    public void setQuantidadeAlteradaListener(QuantidadeAlteradaListener quantidadeAlteradaListener) {
        this.quantidadeAlteradaListener = quantidadeAlteradaListener;
    }

    @Override
    public int getCount() {
        return linhacarrinhoCompras.size();
    }

    @Override
    public Object getItem(int i) {
        return linhacarrinhoCompras.get(i);
    }

    @Override
    public long getItemId(int i) {
        return linhacarrinhoCompras.get(i).getId();
    }

    @Override
    public View getView(int position, View view, ViewGroup viewGroup) {
        if (inflater == null)
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        if (view == null)
            view = inflater.inflate(R.layout.item_lista_carrinho, null);

        ViewHolderLista viewHolder = (ViewHolderLista) view.getTag();

        if (viewHolder == null) {
            viewHolder = new ViewHolderLista(view);
            view.setTag(viewHolder);
        }

        viewHolder.update(linhacarrinhoCompras.get(position));

        final ViewHolderLista finalViewHolder = viewHolder;

        tvPreco = view.findViewById(R.id.tvPreco);
        etQuantidade = view.findViewById(R.id.etQuantidade);

        if (listaEditTextQuantidade.size() <= position) {
            listaEditTextQuantidade.add(position, etQuantidade);
        } else {
            listaEditTextQuantidade.set(position, etQuantidade);
        }

        if (listaTextViewPreco.size() <= position) {
            listaTextViewPreco.add(position, tvPreco);
        } else {
            listaTextViewPreco.set(position, tvPreco);
        }

        SingletonGestorFarmacia.getInstance(context.getApplicationContext()).setQuantidadeListener(this);


        // Configurar o OnClickListener do botão "Adicionar"
        viewHolder.btAdicionar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                posicaoAtual = position;
                LinhaCarrinhoCompra linhaAtual = linhacarrinhoCompras.get(position);
                SingletonGestorFarmacia.getInstance(context.getApplicationContext()).QuantidadeProduto(linhaAtual.getId(), context);
                int quantidadeAtual = linhaAtual.getQuantidade();

                novaQuantidade = quantidadeAtual + 1;
                linhaAtual.setQuantidade(novaQuantidade);

                finalViewHolder.etQuantidade.setText(String.valueOf(novaQuantidade));
                SingletonGestorFarmacia.getInstance(context.getApplicationContext()).updateQuantidadeProdutoCarrinho(novaQuantidade, linhaAtual.getId(), context);

                novoPreco = linhaAtual.getValorcomiva() * novaQuantidade;
                String novoPrecoFormatado = String.format("%.2f€", novoPreco);

                linhaAtual.setSubtotal(novoPreco);

                finalViewHolder.tvPreco.setText(novoPrecoFormatado);

            }
        });

        viewHolder.btReduzir.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                LinhaCarrinhoCompra linhaAtual = linhacarrinhoCompras.get(position);
                SingletonGestorFarmacia.getInstance(context.getApplicationContext()).QuantidadeProduto(linhaAtual.getId(), context);
                int quantidadeAtual = linhaAtual.getQuantidade();

                novaQuantidade = quantidadeAtual - 1;

                linhaAtual.setQuantidade(novaQuantidade);

                finalViewHolder.etQuantidade.setText(String.valueOf(novaQuantidade));

                SingletonGestorFarmacia.getInstance(context.getApplicationContext()).updateQuantidadeProdutoCarrinho(novaQuantidade, linhacarrinhoCompras.get(position).getId(), context);

                novoPreco = linhacarrinhoCompras.get(position).getValorcomiva() * novaQuantidade;
                String novoPrecoFormatado = String.format("%.2f€", novoPreco);

                linhaAtual.setSubtotal(novoPreco);

                finalViewHolder.tvPreco.setText(novoPrecoFormatado);

            }
        });

        viewHolder.btRemover.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                int positionToRemove = position;

                if (positionToRemove >= 0 && positionToRemove < linhacarrinhoCompras.size()) {
                    int linhaIdToRemove = linhacarrinhoCompras.get(positionToRemove).getId();

                    linhacarrinhoCompras.remove(positionToRemove);

                    SingletonGestorFarmacia.getInstance(context.getApplicationContext()).deleleLinhaCarrinho(linhaIdToRemove, context);
                }
            }
        });
        return view;
    }

    @Override
    public void onRefreshQuantidade(double[] quantidade) {
        double quantidadeProduto = quantidade[0];
        double quantidadeLinha = quantidade[1];
        double preco = quantidade[2];

        double quantidadeFinal = quantidadeProduto + quantidadeLinha;

        if (quantidadeFinal < novaQuantidade && posicaoAtual < listaEditTextQuantidade.size()) {
            EditText etQuantidade = listaEditTextQuantidade.get(posicaoAtual);
            TextView tvPreco = listaTextViewPreco.get(posicaoAtual);

            String textoPersonalizado = String.valueOf((int) quantidadeLinha);
            String precotext = String.format("%.2f€", preco);

            LinhaCarrinhoCompra linhaAtual = linhacarrinhoCompras.get(posicaoAtual);
            linhaAtual.setQuantidade((int) quantidadeLinha);
            linhaAtual.setSubtotal(preco);

            etQuantidade.setText(textoPersonalizado);
            tvPreco.setText(precotext);
        } else if (novaQuantidade < 1 && posicaoAtual < listaEditTextQuantidade.size()) {
            EditText etQuantidade = listaEditTextQuantidade.get(posicaoAtual);
            LinhaCarrinhoCompra linhaAtual = linhacarrinhoCompras.get(posicaoAtual);

            linhaAtual.setQuantidade(1);
            etQuantidade.setText(String.valueOf(1));

            String precotext = String.format("%.2f€", preco);
            linhaAtual.setSubtotal(preco);

            tvPreco.setText(precotext);

            Toast.makeText(context, "Não é possível reduzir mais a quantidade!", Toast.LENGTH_SHORT).show();
        }
    }


    @Override
    public void onRefreshDeleteLinhaCarrinho(boolean resposta) {
        if (resposta) {
            notifyDataSetChanged();
            Toast.makeText(context, "Item removido do carrinho com sucesso!", Toast.LENGTH_SHORT).show();
        } else {
            Toast.makeText(context, "Não foi possível remover o item do carrinho!", Toast.LENGTH_SHORT).show();
        }
    }

    private class ViewHolderLista {

        private TextView tvProduto, tvPreco;
        private EditText etQuantidade;
        private ImageButton btReduzir, btAdicionar, btRemover;
        private ImageView imgProduto;

        public ViewHolderLista(View view) {
            tvProduto = view.findViewById(R.id.tvProduto);
            tvPreco = view.findViewById(R.id.tvPreco);
            etQuantidade = view.findViewById(R.id.etQuantidade);
            btReduzir = view.findViewById(R.id.btReduzir);
            btAdicionar = view.findViewById(R.id.btAdicionar);
            btRemover = view.findViewById(R.id.btRemover);
            imgProduto = view.findViewById(R.id.imgProduto);
        }

        public void update(LinhaCarrinhoCompra linhaCarrinhoCompra) {
            tvProduto.setText(linhaCarrinhoCompra.getProduto_id());
            tvPreco.setText(String.format("%.2f€", linhaCarrinhoCompra.getSubtotal()));
            etQuantidade.setText(linhaCarrinhoCompra.getQuantidade() + "");
            Glide.with(context)
                    .load(linhaCarrinhoCompra.getImagem())
                    .placeholder(R.drawable.medicamento_stock)
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(imgProduto);
        }
    }
}