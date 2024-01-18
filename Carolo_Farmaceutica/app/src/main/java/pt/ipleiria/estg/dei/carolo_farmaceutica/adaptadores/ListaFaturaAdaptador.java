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
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.Fatura;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.LinhaCarrinhoCompra;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.Medicamento;

public class ListaFaturaAdaptador extends BaseAdapter {

    // Declaração de variáveis
    private Context context;
    private LayoutInflater inflater;
    private ArrayList<Fatura> faturas;

    // Construtor
    public ListaFaturaAdaptador(Context context, ArrayList<Fatura> faturas) {
        this.context = context;
        this.faturas = faturas;
    }

    // Método que retorna o número de faturas
    @Override
    public int getCount() {
        return faturas.size();
    }

    // Método que retorna o item da fatura
    @Override
    public Object getItem(int i) {
        return faturas.get(i);
    }

    // Método que retorna o item da fatura pelo seu id
    @Override
    public long getItemId(int i) {
        return faturas.get(i).getId();
    }

    // Método que retorna a view da fatura
    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        if (inflater == null)
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        if (view == null)
            view = inflater.inflate(R.layout.item_lista_fatura, null);

        ViewHolderLista viewHolder = (ViewHolderLista) view.getTag();

        if (viewHolder == null) {
            viewHolder = new ViewHolderLista(view);
            view.setTag(viewHolder);
        }
        viewHolder.update(faturas.get(i));

        return view;
    }

    // Método que apresenta os dados na view da fatura
    private class ViewHolderLista {

        private TextView tvNumeroFatura, tvDataFatura, tvValorTotal, tvIVA;

        public ViewHolderLista(View view) {
            tvNumeroFatura = view.findViewById(R.id.tvNumeroFatura);
            tvDataFatura = view.findViewById(R.id.tvDataFatura);
            tvValorTotal = view.findViewById(R.id.tvValorTotal);
            tvIVA = view.findViewById(R.id.tvIVA);
        }

        public void update(Fatura fatura) {
            tvNumeroFatura.setText(fatura.getId() + "");
            tvDataFatura.setText(fatura.getDtaEmissao());
            tvValorTotal.setText(fatura.getValortotal() + "");
            tvIVA.setText(fatura.getIvatotal() + "");
        }
    }
}
