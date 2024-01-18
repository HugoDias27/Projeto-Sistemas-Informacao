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
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.Medicamento;

public class ListaMedicamentoAdaptador extends BaseAdapter {

    // Declaração de variáveis
    private Context context;
    private LayoutInflater inflater;
    private ArrayList<Medicamento> medicamentos;

    // Construtor
    public ListaMedicamentoAdaptador(Context context, ArrayList<Medicamento> medicamentos) {
        this.context = context;
        this.medicamentos = medicamentos;
    }

    // Método que retorna o número de medicamentos
    @Override
    public int getCount() {
        return medicamentos.size();
    }

    // Método que retorna o item do medicamento
    @Override
    public Object getItem(int i) {
        return medicamentos.get(i);
    }

    // Método que retorna o item do medicamento pelo seu id
    @Override
    public long getItemId(int i) {
        return medicamentos.get(i).getId();
    }

    // Método que retorna a view do medicamento
    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        if (inflater == null)
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        if (view == null)
            view = inflater.inflate(R.layout.item_lista_medicamento, null);

        ViewHolderLista viewHolder = (ViewHolderLista) view.getTag();

        if (viewHolder == null) {
            viewHolder = new ViewHolderLista(view);
            view.setTag(viewHolder);
        }
        viewHolder.update(medicamentos.get(i));

        return view;
    }

    // Método que apresenta os dados na view do medicamento
    private class ViewHolderLista {
        private TextView tvNome, tvPrescricao, tvPreco, tvQuantidade, tvCategoria, tvIVA;
        private ImageView imgProduto;

        public ViewHolderLista(View view) {
            tvNome = view.findViewById(R.id.tvNome);
            tvPrescricao = view.findViewById(R.id.tvPrescricao);
            tvPreco = view.findViewById(R.id.tvPreco);
            tvQuantidade = view.findViewById(R.id.tvQuantidade);
            tvCategoria = view.findViewById(R.id.tvCategoria);
            tvIVA = view.findViewById(R.id.tvIVA);
            imgProduto = view.findViewById(R.id.imgProduto);
        }

        public void update(Medicamento medicamento) {
            tvNome.setText(medicamento.getNome());
            tvPrescricao.setText(medicamento.getPrescricaoMedica());
            tvPreco.setText(medicamento.getPreco() + "");
            tvQuantidade.setText(medicamento.getQuantidade() + "");
            tvCategoria.setText(medicamento.getCategoriaId());
            tvIVA.setText(medicamento.getIvaId() + "");
            Glide.with(context)
                    .load(medicamento.getImagem())
                    .placeholder(R.drawable.medicamento_stock)
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .into(imgProduto);
        }
    }
}
