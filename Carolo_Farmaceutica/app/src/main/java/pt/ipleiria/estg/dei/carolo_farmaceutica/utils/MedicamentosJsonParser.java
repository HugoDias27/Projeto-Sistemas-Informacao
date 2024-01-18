package pt.ipleiria.estg.dei.carolo_farmaceutica.utils;


import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.Medicamento;

public class MedicamentosJsonParser {

    // Método que faz o parse do JSON para um Array de Medicamentos
    public static ArrayList<Medicamento> parserJsonMedicamentos(JSONArray response) {
        ArrayList<Medicamento> listaMedicamentos = new ArrayList<>();
        try {
            for (int i = 0; i < response.length(); i++) {
                JSONObject medicamentoJSON = response.getJSONObject(i);
                int id = medicamentoJSON.getInt("id");
                String nome = medicamentoJSON.getString("nome");
                String prescricao_medica = medicamentoJSON.getString("prescricao_medica");
                double preco = medicamentoJSON.getDouble("preco");
                int quantidade = medicamentoJSON.getInt("quantidade");
                String categoria_id = medicamentoJSON.getString("categoria");
                int iva_id = medicamentoJSON.getInt("iva");
                String imagens = medicamentoJSON.getString("imagens");

                Medicamento m = new Medicamento(id, nome, prescricao_medica, preco, quantidade, categoria_id, iva_id, imagens);
                listaMedicamentos.add(m);
            }
        } catch (Exception e) {
            throw new RuntimeException(e);
        }
        return listaMedicamentos;
    }

    // Método que verifica o estado da ligação à internet
    public static boolean isConnectionInternet(Context context) {
        ConnectivityManager cm = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo ni = cm.getActiveNetworkInfo();
        return ni != null && ni.isConnected();
    }

}