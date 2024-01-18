package pt.ipleiria.estg.dei.carolo_farmaceutica.utils;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.LinhaCarrinhoCompra;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.User;

public class LoginJsonParser {

    // Método que faz o parse do JSON onde recebe a resposta do login
    public static String parserJsonLogin(String response) {
        String token = null;
        try {
            JSONObject loginJson = new JSONObject(response);
            token = loginJson.getString("auth_key");

        } catch (Exception e) {
            throw new RuntimeException(e);
        }
        return token;
    }

    // Método que faz o parse do JSON onde recebe alguns dados do utilizador
    public static User parserJsonDadosLogin(String response) {
        User user = null;
        try {
            JSONObject userData = new JSONObject(response);
            int id = userData.getInt("id");
            String username = userData.getString("username");
            String email = userData.getString("email");

            user = new User(id, username, email );
        } catch (Exception e) {
            e.printStackTrace();
        }
        return user;
    }

    // Método que verifica o estado da ligação à internet
    public static boolean isConnectionInternet(Context context) {
        ConnectivityManager cm = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo ni = cm.getActiveNetworkInfo();
        return ni != null && ni.isConnected();
    }

}
