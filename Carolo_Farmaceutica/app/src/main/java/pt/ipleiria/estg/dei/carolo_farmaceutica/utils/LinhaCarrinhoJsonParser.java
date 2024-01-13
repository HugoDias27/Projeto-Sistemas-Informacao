package pt.ipleiria.estg.dei.carolo_farmaceutica.utils;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.LinhaCarrinhoCompra;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.Medicamento;

public class LinhaCarrinhoJsonParser {

    public static Boolean parserJsonLinhaCarrinho(String response) {
        Boolean resposta = null;
        try {
            JSONObject linhaCarrinhoJson = new JSONObject(response);
            resposta = linhaCarrinhoJson.getBoolean("resposta");
        } catch (Exception e) {
            throw new RuntimeException(e);
        }
        return resposta;
    }

    public static boolean isConnectionInternet(Context context) {
        if (context == null) {
            // Handle null context, return false or take appropriate action
            return false;
        }

        ConnectivityManager cm = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo ni = cm.getActiveNetworkInfo();
        return ni != null && ni.isConnected();
    }



    public static ArrayList<LinhaCarrinhoCompra> parserJsonLinhaCarrinhoUpdate(String response) {
        ArrayList<LinhaCarrinhoCompra> linhasCarrinho = new ArrayList<>();
        try {
            JSONArray linhasCarrinhoJsonArray = new JSONArray(response);

            for (int i = 0; i < linhasCarrinhoJsonArray.length(); i++) {
                JSONObject linhaCarrinhoJson = linhasCarrinhoJsonArray.getJSONObject(i);

                int id = linhaCarrinhoJson.getInt("id");
                int quantidade = linhaCarrinhoJson.getInt("quantidade");
                double precounit = linhaCarrinhoJson.getDouble("precounit");
                double valoriva = linhaCarrinhoJson.getDouble("valoriva");
                double valorcomiva = linhaCarrinhoJson.getDouble("valorcomiva");
                double subtotal = linhaCarrinhoJson.getDouble("subtotal");
                int carrinho_compra_id = linhaCarrinhoJson.getInt("carrinho_compra_id");
                String produto_id = linhaCarrinhoJson.getString("produto_id");
                String imagem = linhaCarrinhoJson.getString("imagem");

                LinhaCarrinhoCompra linhaCarrinho = new LinhaCarrinhoCompra(id, quantidade, precounit, valoriva, valorcomiva, subtotal, carrinho_compra_id, produto_id, imagem);
                linhasCarrinho.add(linhaCarrinho);
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
        return linhasCarrinho;
    }

    public static double[] parserJsonQuantidadeProduto(String response) {
        double[] quantidades = new double[3];
        try {
            JSONObject quantidadeProdutoJson = new JSONObject(response);
            quantidades[0] = quantidadeProdutoJson.getDouble("quantidade");
            quantidades[1] = quantidadeProdutoJson.getDouble("quantidadelinha");
            quantidades[2] = quantidadeProdutoJson.getDouble("preco");
        } catch (Exception e) {
            throw new RuntimeException(e);
        }
        return quantidades;
    }

    public static double parserJsonSubtotal(String response) {
        double subtotal = 0;
        try {
                JSONObject subtotalJson = new JSONObject(response);
                subtotal += subtotalJson.getDouble("subtotal");

        } catch (Exception e) {
            throw new RuntimeException(e);
        }
        return subtotal;
    }

    public static boolean parserJsonLinhaCarrinhoDelete(String response) {
        Boolean resposta = null;
        try {
            JSONObject linhaCarrinhoJson = new JSONObject(response);
            resposta = linhaCarrinhoJson.getBoolean("resposta");
        } catch (Exception e) {
            throw new RuntimeException(e);
        }
        return resposta;
    }
}
