package pt.ipleiria.estg.dei.carolo_farmaceutica.utils;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;

import org.json.JSONObject;

public class RegistarJsonParser {

    public static Boolean parserJsonRegistar(String response) {
        Boolean resposta = null;
        try {
            JSONObject RegistarJson = new JSONObject(response);
            resposta = RegistarJson.getBoolean("resposta");

        } catch (Exception e) {
            throw new RuntimeException(e);
        }
        return resposta;
    }

    public static boolean isConnectionInternet(Context context) {
        ConnectivityManager cm = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo ni = cm.getActiveNetworkInfo();
        return ni != null && ni.isConnected();
    }
}
