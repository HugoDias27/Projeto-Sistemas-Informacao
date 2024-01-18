package pt.ipleiria.estg.dei.carolo_farmaceutica.utils;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.Fatura;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.LinhaCarrinhoCompra;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.LinhaCarrinhoCompraFatura;

public class FaturaJsonParser {


    // Método que vai buscar a resposta se a fatura foi criada com sucesso ou não
    public static Boolean parserJsonFatura(String response) {
        Boolean resposta = null;
        try {
            JSONObject linhaCarrinhoJson = new JSONObject(response);
            resposta = linhaCarrinhoJson.getBoolean("resposta");
        } catch (Exception e) {
            throw new RuntimeException(e);
        }
        return resposta;
    }


    // Método que faz o parse do JSON com os dados da fatura
    public static ArrayList<Fatura> parserJsonFaturaCliente(JSONArray response) {
        ArrayList<Fatura> listaFaturas = new ArrayList<>();
        try {
            for (int i = 0; i < response.length(); i++) {
                JSONObject faturaJSON = response.getJSONObject(i);
                int id = faturaJSON.getInt("id");
                String dataEmissao = faturaJSON.getString("dta_emissao");
                double valorTotal = faturaJSON.getDouble("valortotal");
                double ivaTotal = faturaJSON.getDouble("ivatotal");

                Fatura f = new Fatura(id, dataEmissao, valorTotal, ivaTotal);
                listaFaturas.add(f);
            }
        } catch (Exception e) {
            throw new RuntimeException(e);
        }
        return listaFaturas;
    }

    // Método que faz o parse do JSON com os dados da(s) linha(s) da(s) fatura(s)
    public static ArrayList<LinhaCarrinhoCompraFatura> parserJsonLinhasCarrinho(JSONArray response) {
        ArrayList<LinhaCarrinhoCompraFatura> linhasCarrinho = new ArrayList<>();
        try {
            for (int i = 0; i < response.length(); i++) {
                JSONObject linhaCarrinhoJson = response.getJSONObject(i);
                int id = linhaCarrinhoJson.getInt("id");
                int quantidade = linhaCarrinhoJson.getInt("quantidade");
                double precounit = linhaCarrinhoJson.getDouble("precounit");
                double valoriva = linhaCarrinhoJson.getDouble("valoriva");
                double valorcomiva = linhaCarrinhoJson.getDouble("valorcomiva");
                double subtotal = linhaCarrinhoJson.getDouble("subtotal");
                int carrinho_compra_id = linhaCarrinhoJson.getInt("carrinho_compra_id");
                String produto_id = linhaCarrinhoJson.getString("produto_id");
                String imagens = linhaCarrinhoJson.getString("imagens");

                LinhaCarrinhoCompraFatura linhaCarrinho = new LinhaCarrinhoCompraFatura(id, quantidade, precounit, valoriva, valorcomiva, subtotal, carrinho_compra_id, produto_id, imagens);
                linhasCarrinho.add(linhaCarrinho);
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
        return linhasCarrinho;
    }

    // Método que verifica o estado da ligação à internet
    public static boolean isConnectionInternet(Context context) {
        ConnectivityManager cm = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo ni = cm.getActiveNetworkInfo();
        return ni != null && ni.isConnected();
    }

}
