package pt.ipleiria.estg.dei.carolo_farmaceutica.utils;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.Date;

import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.ReceitaMedica;

public class ReceitaMedicaJsonParser {

    // Método que faz o parse do JSON para um Array de Medicamentos
    public static ArrayList<ReceitaMedica> parserJsonReceitaMedica(JSONArray response) {
        ArrayList<ReceitaMedica> listareceitaMedica = new ArrayList<>();
        try {
            for (int i = 0;i < response.length(); i++) {
                JSONObject receitaMedicaJSON = (JSONObject) response.get(i);
                int id = receitaMedicaJSON.getInt("id");
                int codigo = receitaMedicaJSON.getInt("codigo");
                String valido = receitaMedicaJSON.getString("valido");
                int user_id = receitaMedicaJSON.getInt("user_id");
                int dosagem = receitaMedicaJSON.getInt("dosagem");
                int telefone = receitaMedicaJSON.getInt("telefone");
                String local_prescricao = receitaMedicaJSON.getString("local_prescricao");
                String medico_prescicao = receitaMedicaJSON.getString("medico_prescricao");
                String posologia = receitaMedicaJSON.getString("posologia");
                String data_validade = receitaMedicaJSON.getString("data_validade");

                ReceitaMedica receita = new ReceitaMedica(id, codigo, local_prescricao, medico_prescicao, dosagem, data_validade, telefone, valido, posologia, user_id);
                listareceitaMedica.add(receita);
            }
        } catch (Exception e) {
            throw new RuntimeException(e);
        }

        return listareceitaMedica;
    }

    // Método que verifica o estado da ligação à internet
    public static boolean isConnectionInternet(Context context) {
        ConnectivityManager cm = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo ni = cm.getActiveNetworkInfo();
        return ni != null && ni.isConnected();
    }
}
