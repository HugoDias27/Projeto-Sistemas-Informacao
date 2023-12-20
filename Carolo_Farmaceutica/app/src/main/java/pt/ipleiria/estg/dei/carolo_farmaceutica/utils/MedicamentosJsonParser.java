package pt.ipleiria.estg.dei.carolo_farmaceutica.utils;


import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.Medicamento;

public class MedicamentosJsonParser {
    public static ArrayList<Medicamento> parserJsonMedicamentos(JSONArray response) {
        ArrayList<Medicamento> listaMedicamentos = new ArrayList<>();
        try {
            for (int i = 0;i < response.length(); i++)
            {
                JSONObject medicamentoJSON = (JSONObject) response.get(i);
                int id = medicamentoJSON.getInt("id");
                String nome = medicamentoJSON.getString("nome");
                int prescricao_medica = medicamentoJSON.getInt("prescricao_medica");
                double preco = medicamentoJSON.getDouble("preco");
                int quantidade = medicamentoJSON.getInt("quantidade");
                String categoria_id = medicamentoJSON.getString("categoria");
                int iva_id = medicamentoJSON.getInt("iva");

                Medicamento m = new Medicamento(id, nome, prescricao_medica, preco, quantidade, categoria_id, iva_id);
                listaMedicamentos.add(m);

            }

        }catch (Exception e){
            throw new RuntimeException(e);
        }

        return listaMedicamentos;
    }


}