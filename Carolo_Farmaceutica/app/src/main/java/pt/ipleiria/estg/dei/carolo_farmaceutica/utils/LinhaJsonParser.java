package pt.ipleiria.estg.dei.carolo_farmaceutica.utils;


import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.LinhaCarrinhoCompra;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.Medicamento;

public class LinhaJsonParser {

    public static ArrayList<LinhaCarrinhoCompra> parserJsonLinha(JSONArray response) {
        ArrayList<LinhaCarrinhoCompra> listaCarrinhoCompras = new ArrayList<>();
        try {
            for (int i = 0;i < response.length(); i++)
            {
                JSONObject CarrinhoJSON = (JSONObject) response.get(i);
                int id = CarrinhoJSON.getInt("id");
                int quantidade = CarrinhoJSON.getInt("quantidade");
                double precounit = CarrinhoJSON.getDouble("precounit");
                double valoriva = CarrinhoJSON.getDouble("valoriva");
                double valorcomiva = CarrinhoJSON.getDouble("valorcomiva");
                double subtotal = CarrinhoJSON.getDouble("subtotal");
                int carrinho_compra_id = CarrinhoJSON.getInt("carrinho_compra_id");
                String produto_id = CarrinhoJSON.getString("produto_id");
                String imagem = CarrinhoJSON.getString("imagens");

                LinhaCarrinhoCompra m = new LinhaCarrinhoCompra(id, quantidade, precounit, valoriva, valorcomiva, subtotal, carrinho_compra_id, produto_id, imagem);
                listaCarrinhoCompras.add(m);

            }

        }catch (Exception e){
            throw new RuntimeException(e);
        }

        return listaCarrinhoCompras;
    }

    public static boolean isConnectionInternet(Context context) {
        ConnectivityManager cm = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo ni = cm.getActiveNetworkInfo();
        return ni != null && ni.isConnected();
    }
}
