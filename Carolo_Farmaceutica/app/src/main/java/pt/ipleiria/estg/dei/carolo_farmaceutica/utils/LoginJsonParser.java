package pt.ipleiria.estg.dei.carolo_farmaceutica.utils;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;

import org.json.JSONObject;

public class LoginJsonParser {

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

    public static boolean isConnectionInternet(Context context) {
        ConnectivityManager cm = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo ni = cm.getActiveNetworkInfo();
        return ni != null && ni.isConnected();
    }
}
