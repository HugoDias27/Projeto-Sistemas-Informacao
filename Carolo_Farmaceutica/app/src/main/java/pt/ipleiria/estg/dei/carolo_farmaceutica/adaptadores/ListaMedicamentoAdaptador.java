package pt.ipleiria.estg.dei.carolo_farmaceutica.adaptadores;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.R;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.Medicamento;

public class ListaMedicamentoAdaptador extends BaseAdapter {

    private Context context;
    private LayoutInflater inflater;
    private ArrayList<Medicamento> medicamentos;

    public ListaMedicamentoAdaptador(Context context, ArrayList<Medicamento> medicamentos) {
        this.context = context;
        this.medicamentos = medicamentos;
    }

    @Override
    public int getCount() {
        return medicamentos.size();
    }

    @Override
    public Object getItem(int i) {
        return medicamentos.get(i);
    }

    @Override
    public long getItemId(int i) {
        return medicamentos.get(i).getId();
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        if (inflater == null)
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        if (view == null)
            view = inflater.inflate(R.layout.item_lista_medicamento, null);

        //otimização
        ViewHolderLista viewHolder = (ViewHolderLista) view.getTag();

        if (viewHolder == null) {
            viewHolder = new ViewHolderLista(view);
            view.setTag(viewHolder);
        }
        viewHolder.update(medicamentos.get(i));

        return view;
    }

    private class ViewHolderLista {

        private TextView tvNome, tvPrescricao, tvPreco, tvQuantidade, tvCategoria, tvIVA;

        public ViewHolderLista(View view) {
            tvNome = view.findViewById(R.id.tvNome);
            tvPrescricao = view.findViewById(R.id.tvPrescricao);
            tvPreco = view.findViewById(R.id.tvPreco);
            tvQuantidade = view.findViewById(R.id.tvQuantidade);
            tvCategoria = view.findViewById(R.id.tvCategoria);
            tvIVA = view.findViewById(R.id.tvIVA);
        }

       public void update(Medicamento medicamento) {
            tvNome.setText(medicamento.getNome());
           tvPrescricao.setText(String.valueOf(medicamento.getPrescricao_medica()));
           tvPreco.setText(String.valueOf(medicamento.getPreco()) + "€");
           tvQuantidade.setText(String.valueOf(medicamento.getQuantidade()) + "");
            tvCategoria.setText(medicamento.getCategoria_id());
            tvIVA.setText(String.valueOf(medicamento.getIva_id()) + "");
        }
    }
}
