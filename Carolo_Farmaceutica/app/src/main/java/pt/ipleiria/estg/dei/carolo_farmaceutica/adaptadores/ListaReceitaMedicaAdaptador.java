package pt.ipleiria.estg.dei.carolo_farmaceutica.adaptadores;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.R;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.ReceitaMedica;

public class ListaReceitaMedicaAdaptador extends BaseAdapter {

    // Declaração de variáveis
    private Context context;
    private LayoutInflater inflater;
    private ArrayList<ReceitaMedica> receitaMedicas;

    // Construtor
    public ListaReceitaMedicaAdaptador(Context context, ArrayList<ReceitaMedica> receitaMedicas) {
        this.context = context;
        this.receitaMedicas = receitaMedicas;
    }

    // Método que retorna o número de receitas médicas
    @Override
    public int getCount() {
        return receitaMedicas.size();
    }

    // Método que retorna o item da receita médica
    @Override
    public Object getItem(int i) {
        return receitaMedicas.get(i);
    }

    // Método que retorna o item da receita médica pelo seu id
    @Override
    public long getItemId(int i) {
        return receitaMedicas.get(i).getId();
    }

    // Método que retorna a view da receita médica
    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        if (inflater == null)
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        if (view == null)
            view = inflater.inflate(R.layout.item_lista_receita, null);

        ViewHolderLista viewHolder = (ViewHolderLista) view.getTag();

        if (viewHolder == null) {
            viewHolder = new ViewHolderLista(view);
            view.setTag(viewHolder);
        }
        viewHolder.update(receitaMedicas.get(i));

        return view;
    }

    // Método que apresenta os dados na view da receita médica
    private class ViewHolderLista {
        private TextView tvCodigo, tvDosagem, tvDataValidade, tvValido, tvPosologia;

        public ViewHolderLista(View view) {
            tvCodigo = view.findViewById(R.id.tvCodigo);
            tvDosagem = view.findViewById(R.id.tvDosagem);
            tvDataValidade = view.findViewById(R.id.tvDataValidade);
            tvValido = view.findViewById(R.id.tvValido);
            tvPosologia = view.findViewById(R.id.tvPosologia);
        }

        public void update(ReceitaMedica receitaMedica) {
            tvCodigo.setText(receitaMedica.getCodigo() + "");
            tvDosagem.setText(receitaMedica.getDosagem() + "");
            tvDataValidade.setText(receitaMedica.getDataValidade() + "");
            tvValido.setText(receitaMedica.getValido());
            tvPosologia.setText(receitaMedica.getPosologia());
        }
    }
}
