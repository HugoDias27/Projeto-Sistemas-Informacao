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


    // Método que faz o parse do JSON para um Array de Linhas de Carrinho de Compra
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

    // Método que faz o parse do JSON dos dados do produto para podever verificar a alteração da quantidade na linha do carrinho
    public static double[] parserJsonDadosProduto(String response) {
        double[] dadosProduto = new double[3];
        try {
            JSONObject quantidadeProdutoJson = new JSONObject(response);
            dadosProduto[0] = quantidadeProdutoJson.getDouble("quantidade");
            dadosProduto[1] = quantidadeProdutoJson.getDouble("quantidadelinha");
            dadosProduto[2] = quantidadeProdutoJson.getDouble("preco");
        } catch (Exception e) {
            throw new RuntimeException(e);
        }
        return dadosProduto;
    }

    // Método que faz o parse do JSON do subtotal das linhas do carrinho de compras
    public static double parserJsonSubtotal(String response) {
        double subtotal = 0;
        try {
            JSONObject subtotalJson = new JSONObject(response);
            subtotal = subtotalJson.getDouble("subtotal");

        } catch (Exception e) {
            throw new RuntimeException(e);
        }
        return subtotal;
    }

    // Método que faz o parse do JSON que recebe a resposta de quando é apagado uma linha do carrinho de compras
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

    // Método que verifica o estado da ligação à internet
    public static boolean isConnectionInternet(Context context) {
        if (context == null) {
            return false;
        }

        ConnectivityManager cm = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo ni = cm.getActiveNetworkInfo();
        return ni != null && ni.isConnected();
    }
}
