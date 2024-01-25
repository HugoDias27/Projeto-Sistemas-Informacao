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
import pt.ipleiria.estg.dei.carolo_farmaceutica.utils.LinhaCarrinhoJsonParser;
import pt.ipleiria.estg.dei.carolo_farmaceutica.utils.MedicamentosJsonParser;

public class ListaCarrinhoAdaptador extends BaseAdapter implements QuantidadeListener {

    // Declaração de variáveis
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

    // Construtor
    public ListaCarrinhoAdaptador(Context context, ArrayList<LinhaCarrinhoCompra> linhacarrinhoCompras) {
        this.context = context;
        this.linhacarrinhoCompras = linhacarrinhoCompras;
    }

    // Set do listener da quantidade, para atualizar a quantidade do produto na linha do carrinho
    public void setQuantidadeAlteradaListener(QuantidadeAlteradaListener quantidadeAlteradaListener) {
        this.quantidadeAlteradaListener = quantidadeAlteradaListener;
    }

    // Método que retorna o número de linhas do carrinho
    @Override
    public int getCount() {
        return linhacarrinhoCompras.size();
    }

    // Método que retorna o item da linha do carrinho
    @Override
    public Object getItem(int i) {
        return linhacarrinhoCompras.get(i);
    }

    // Método que retorna o item da linha do carrinho pelo seu id
    @Override
    public long getItemId(int i) {
        return linhacarrinhoCompras.get(i).getId();
    }

    // Método que retorna a view da linha do carrinho
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

        // Busca a posição da edit Text da quantidade que é pretendido atualizar a quantidade
        if (listaEditTextQuantidade.size() <= position) {
            listaEditTextQuantidade.add(position, etQuantidade);
        } else {
            listaEditTextQuantidade.set(position, etQuantidade);
        }

        // Busca a posição da Text View do preço que é pretendido atualizar a quantidade
        if (listaTextViewPreco.size() <= position) {
            listaTextViewPreco.add(position, tvPreco);
        } else {
            listaTextViewPreco.set(position, tvPreco);
        }

        SingletonGestorFarmacia.getInstance(context.getApplicationContext()).setQuantidadeListener(this);

        // Botão para adicionar a quantidade à linha do carrinho do respetivo produto
        viewHolder.btAdicionar.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                if (LinhaCarrinhoJsonParser.isConnectionInternet(context)) {
                    posicaoAtual = position;
                    LinhaCarrinhoCompra linhaAtual = linhacarrinhoCompras.get(position);

                    // Verifica se a quantidade pode ser aumentar
                    SingletonGestorFarmacia.getInstance(context.getApplicationContext()).QuantidadeProduto(linhaAtual.getId(), context);
                    int quantidadeAtual = linhaAtual.getQuantidade();

                    novaQuantidade = quantidadeAtual + 1;
                    linhaAtual.setQuantidade(novaQuantidade);
                    finalViewHolder.etQuantidade.setText(novaQuantidade + "");

                    // Atualiza a quantidade do produto na linha do carrinho na base de dados
                    SingletonGestorFarmacia.getInstance(context.getApplicationContext()).updateQuantidadeProdutoCarrinho(novaQuantidade, linhaAtual.getId(), context);

                    novoPreco = linhaAtual.getValorcomiva() * novaQuantidade;
                    String novoPrecoFormatado = String.format("%.2f€", novoPreco);
                    linhaAtual.setSubtotal(novoPreco);
                    finalViewHolder.tvPreco.setText(novoPrecoFormatado);

                }
                else {
                    Toast.makeText(context, R.string.txt_sem_conexao, Toast.LENGTH_SHORT).show();
                }
            }
        });

        // Botão para reduzir a quantidade à linha do carrinho do respetivo produto
        viewHolder.btReduzir.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (LinhaCarrinhoJsonParser.isConnectionInternet(context)) {
                    posicaoAtual = position;
                    LinhaCarrinhoCompra linhaAtual = linhacarrinhoCompras.get(position);
                    // Verifica se a quantidade pode ser reduzida
                    SingletonGestorFarmacia.getInstance(context.getApplicationContext()).QuantidadeProduto(linhaAtual.getId(), context);
                    int quantidadeAtual = linhaAtual.getQuantidade();

                    novaQuantidade = quantidadeAtual - 1;
                    linhaAtual.setQuantidade(novaQuantidade);
                    finalViewHolder.etQuantidade.setText(novaQuantidade + "");

                    // Atualiza a quantidade do produto na linha do carrinho na base de dados
                    SingletonGestorFarmacia.getInstance(context.getApplicationContext()).updateQuantidadeProdutoCarrinho(novaQuantidade, linhaAtual.getId(), context);

                    novoPreco = linhacarrinhoCompras.get(position).getValorcomiva() * novaQuantidade;
                    String novoPrecoFormatado = String.format("%.2f€", novoPreco);
                    linhaAtual.setSubtotal(novoPreco);
                    finalViewHolder.tvPreco.setText(novoPrecoFormatado);
                }
                else {
                    Toast.makeText(context, R.string.txt_sem_conexao, Toast.LENGTH_SHORT).show();
                }
            }
        });

        // Botão para remover o produto da respetiva linha do carrinho
        viewHolder.btRemover.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (LinhaCarrinhoJsonParser.isConnectionInternet(context)) {
                    int posicaoRemover = position;

                    if (posicaoRemover >= 0 && posicaoRemover < linhacarrinhoCompras.size()) {
                        int apagarLinha = linhacarrinhoCompras.get(posicaoRemover).getId();
                        linhacarrinhoCompras.remove(posicaoRemover);

                        SingletonGestorFarmacia.getInstance(context.getApplicationContext()).deleleLinhaCarrinho(apagarLinha, context);
                    }
                }
                else {
                    Toast.makeText(context, R.string.txt_sem_conexao, Toast.LENGTH_SHORT).show();
                }
            }
        });
        return view;
    }

    // Método que verifica se a quantidade que o utilizador está a inserir é válida
    @Override
    public void onRefreshProduto(double[] dadosProduto) {
        double quantidadeProduto = dadosProduto[0];
        double quantidadeLinha = dadosProduto[1];
        double preco = dadosProduto[2];

        double quantidadeFinal = quantidadeProduto + quantidadeLinha;

        // Se a nova quantidade que o utilizador está a inserir for maior que o stock existente produto
        if (quantidadeFinal < novaQuantidade && posicaoAtual < listaEditTextQuantidade.size()) {
            EditText etQuantidade = listaEditTextQuantidade.get(posicaoAtual);
            TextView tvPreco = listaTextViewPreco.get(posicaoAtual);

            LinhaCarrinhoCompra linhaAtual = linhacarrinhoCompras.get(posicaoAtual);

            linhaAtual.setQuantidade((int) quantidadeLinha);
            String novaQuantidade = String.valueOf((int) quantidadeLinha);
            etQuantidade.setText(novaQuantidade);

            linhaAtual.setSubtotal(preco);
            String precotext = String.format("%.2f€", preco);
            tvPreco.setText(precotext);

            Toast.makeText(context, R.string.txt_quantidade_add_check, Toast.LENGTH_SHORT).show();

        }
        // Se a nova quantidade que o utilizador está a inserir for menor que a quantidade de compra mínima
        else if (novaQuantidade < 1 && posicaoAtual < listaEditTextQuantidade.size()) {
            EditText etQuantidade = listaEditTextQuantidade.get(posicaoAtual);
            TextView tvPreco = listaTextViewPreco.get(posicaoAtual);

            LinhaCarrinhoCompra linhaAtual = linhacarrinhoCompras.get(posicaoAtual);

            linhaAtual.setQuantidade(1);
            etQuantidade.setText(1 + "");

            linhaAtual.setSubtotal(preco);
            String precotext = String.format("%.2f€", preco);
            tvPreco.setText(precotext);

            Toast.makeText(context, R.string.txt_quantidade_reduce_check, Toast.LENGTH_SHORT).show();
        }
    }

    // Método onRefresh quando a linha do carrinho é removida
    @Override
    public void onRefreshDeleteLinhaCarrinho(boolean resposta) {
        if (resposta) {
            notifyDataSetChanged();
            Toast.makeText(context, R.string.txt_remover_sucesso, Toast.LENGTH_SHORT).show();
        } else {
            Toast.makeText(context, R.string.text_remover_fail, Toast.LENGTH_SHORT).show();
        }
    }

    // Método que apresenta os dados na view da linha do carrinho
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