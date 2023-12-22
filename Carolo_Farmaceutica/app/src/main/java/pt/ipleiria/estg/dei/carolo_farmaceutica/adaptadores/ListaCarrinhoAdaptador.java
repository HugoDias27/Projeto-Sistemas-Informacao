package pt.ipleiria.estg.dei.carolo_farmaceutica.adaptadores;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import androidx.recyclerview.widget.RecyclerView;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.R;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.CarrinhoCompra;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.LinhaCarrinhoCompra;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.Medicamento;

public class ListaCarrinhoAdaptador extends BaseAdapter {

    private Context context;
    private LayoutInflater inflater;
    private ArrayList<LinhaCarrinhoCompra> linhacarrinhoCompras;

    public ListaCarrinhoAdaptador(Context context, ArrayList<LinhaCarrinhoCompra> linhacarrinhoCompras) {
        this.context = context;
        this.linhacarrinhoCompras = linhacarrinhoCompras;
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
    public View getView(int i, View view, ViewGroup viewGroup) {

        if (inflater == null)
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        if (view == null)
            view = inflater.inflate(R.layout.item_lista_carrinho, null);

        //otimização
        ViewHolderLista viewHolder = (ViewHolderLista) view.getTag();

        if (viewHolder == null) {
            viewHolder = new ViewHolderLista(view);
            view.setTag(viewHolder);
        }
        viewHolder.update(linhacarrinhoCompras.get(i));

        return view;
    }

    private class ViewHolderLista {

        private TextView tvProduto,tvPreco;

        public ViewHolderLista(View view) {
            tvProduto = view.findViewById(R.id.tvProduto);
            tvPreco = view.findViewById(R.id.tvPreco);

        }

        public void update(LinhaCarrinhoCompra linhacarrinhoCompras) {
            tvProduto.setText(linhacarrinhoCompras.getProduto_id() + "");
            tvPreco.setText(linhacarrinhoCompras.getPrecounit() + "");

        }
    }
}
