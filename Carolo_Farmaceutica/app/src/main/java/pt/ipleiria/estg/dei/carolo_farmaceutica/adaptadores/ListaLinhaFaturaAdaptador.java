package pt.ipleiria.estg.dei.carolo_farmaceutica.adaptadores;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;


import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.R;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.LinhaCarrinhoCompra;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.LinhaCarrinhoCompraFatura;


public class ListaLinhaFaturaAdaptador extends BaseAdapter {

    // Declaração de variáveis
    private Context context;
    private LayoutInflater inflater;
    private ArrayList<LinhaCarrinhoCompraFatura> linhacarrinhoComprasFatura;

    // Construtor
    public ListaLinhaFaturaAdaptador(Context context, ArrayList<LinhaCarrinhoCompraFatura> linhacarrinhoComprasFatura) {
        this.context = context;
        this.linhacarrinhoComprasFatura = linhacarrinhoComprasFatura;
    }

    // Método que retorna o número de linhas de carrinho de compras
    @Override
    public int getCount() {
        return linhacarrinhoComprasFatura.size();
    }

    // Método que retorna o item da linha de carrinho de compras
    @Override
    public Object getItem(int i) {
        return linhacarrinhoComprasFatura.get(i);
    }

    // Método que retorna o item da linha de carrinho de compras pelo seu id
    @Override
    public long getItemId(int i) {
        return linhacarrinhoComprasFatura.get(i).getId();
    }

    // Método que retorna a view da fatura
    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        if (inflater == null)
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        if (view == null)
            view = inflater.inflate(R.layout.item_lista_fatura_linhas, null);

        ViewHolderLista viewHolder = (ViewHolderLista) view.getTag();

        if (viewHolder == null) {
            viewHolder = new ViewHolderLista(view);
            view.setTag(viewHolder);
        }
        viewHolder.update(linhacarrinhoComprasFatura.get(i));

        return view;
    }

    // Método que apresenta os dados na view da fatura
    private class ViewHolderLista {
        private TextView tvNomeProduto, tvQuantidade, tvPrecoUnitario, tvIVA, tvValorComIVA, tvSubTotal;
        private ImageView imgProduto;

        public ViewHolderLista(View view) {
            tvNomeProduto = view.findViewById(R.id.tvNomeProduto);
            tvQuantidade = view.findViewById(R.id.tvQuantidade);
            tvPrecoUnitario = view.findViewById(R.id.tvPrecoUnitario);
            tvIVA = view.findViewById(R.id.tvIVA);
            tvValorComIVA = view.findViewById(R.id.tvValorComIVA);
            tvSubTotal = view.findViewById(R.id.tvSubTotal);
            imgProduto = view.findViewById(R.id.imgProdutoFatura);
        }

        public void update(LinhaCarrinhoCompraFatura linhaCarrinhoCompra) {
            tvNomeProduto.setText(linhaCarrinhoCompra.getProduto_id());
            tvQuantidade.setText(linhaCarrinhoCompra.getQuantidade() + "");
            tvPrecoUnitario.setText(linhaCarrinhoCompra.getPrecounit() + "");
            tvIVA.setText(linhaCarrinhoCompra.getValoriva() + "");
            tvValorComIVA.setText(linhaCarrinhoCompra.getValorcomiva() + "");
            tvSubTotal.setText(linhaCarrinhoCompra.getSubtotal() + "");
            Glide.with(context)
                    .load(linhaCarrinhoCompra.getImagem())
                    .placeholder(R.drawable.medicamento_stock)
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(imgProduto);
        }
    }
}
