package pt.ipleiria.estg.dei.carolo_farmaceutica.utils;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;

import org.json.JSONObject;

import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.CarrinhoCompra;

public class CarrinhoJsonParser {

    // Método que vai buscar a resposta se o carrinho foi criado ou não
    public static Boolean parserJsonCarrinho(String response) {
        Boolean resposta = null;
        try {
            JSONObject CarrinhoJson = new JSONObject(response);
            resposta = CarrinhoJson.getBoolean("resposta");
        } catch (Exception e) {
            throw new RuntimeException(e);
        }
        return resposta;
    }

    // Método que verifica o estado da ligação à internet
    public static boolean isConnectionInternet(Context context) {
        ConnectivityManager cm = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo ni = cm.getActiveNetworkInfo();
        return ni != null && ni.isConnected();
    }
}
