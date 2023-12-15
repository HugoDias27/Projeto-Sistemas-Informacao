package pt.ipleiria.estg.dei.carolo_farmaceutica.modelo;

import android.content.Context;
import android.content.SharedPreferences;
import android.widget.Toast;


import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonArrayRequest;
import com.android.volley.toolbox.JsonRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.LoginListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.MedicamentosListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.utils.LoginJsonParser;
import pt.ipleiria.estg.dei.carolo_farmaceutica.utils.MedicamentosJsonParser;


public class SingletonGestorFarmacia {

    private String login;

    private ArrayList<Medicamento> medicamentos;
    private static SingletonGestorFarmacia instance = null;
    private static RequestQueue volleyQueue = null;

    private LoginListener loginListener;
    private MedicamentosListener medicamentosListener;
    private static final String mURLAPIMedicamentos = "http://10.0.2.2/projetoSIS/backend/web/api/produtos/medicamentos";
    private static final String mURLAPILogin = "http://10.0.2.2/projetoSIS/backend/web/api/logins/loginuser";


    public static synchronized SingletonGestorFarmacia getInstance(Context context) {
        if (instance == null) {
            instance = new SingletonGestorFarmacia(context);
            volleyQueue = Volley.newRequestQueue(context);
        }
        return instance;
    }

    public SingletonGestorFarmacia(Context context) {
        medicamentos = new ArrayList<>();

    }

    public void setLoginListener(LoginListener loginListener) {
        this.loginListener = loginListener;
    }

    public void setMedicamentosListener(MedicamentosListener medicamentosListener) {
        this.medicamentosListener = medicamentosListener;
    }

    public Medicamento getMedicamento(int id) {
        for (Medicamento medicamento : medicamentos) {
            if (medicamento.getId() == id) {
                return medicamento;
            }
        }
        return null;
    }
    public void getAllMedicamentosAPI(final Context context) {
        if (!LoginJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem ligação à internet", Toast.LENGTH_SHORT).show();
            if (medicamentosListener != null) {
                medicamentosListener.onRefreshListaMedicamento(medicamentos);
            }
            else {
                Toast.makeText(context, "Erro ao obter medicamentos da API", Toast.LENGTH_SHORT).show();
            }
        } else {
            SharedPreferences preferences = context.getSharedPreferences("DADOS_PESQUISA", Context.MODE_PRIVATE);
            String authKey = preferences.getString("authKey", "");
            String mURLAPIMedicamentosWithParams = mURLAPIMedicamentos + "?auth_key=" + authKey;

            JsonArrayRequest request = new JsonArrayRequest(Request.Method.GET, mURLAPIMedicamentosWithParams, null, new Response.Listener<JSONArray>() {
                @Override
                public void onResponse(JSONArray response) {

                    try {
                        medicamentos = MedicamentosJsonParser.parserJsonMedicamentos(response);
                       if (medicamentosListener != null) {
                           medicamentosListener.onRefreshListaMedicamento(medicamentos);

                       }
                   }catch (Exception e){
                       Toast.makeText(context, "Erro ao obter medicamentos da API", Toast.LENGTH_SHORT).show();
                   }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, "Erro ao obter medicamentos da API", Toast.LENGTH_SHORT).show();
                }
            }) {
            };


            volleyQueue.add(request);
        }
    }


    public void login(String username, String password, final Context context) {
        if (!LoginJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            StringRequest request = new StringRequest(Request.Method.POST, mURLAPILogin, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    login = LoginJsonParser.parserJsonLogin(response);
                    Toast.makeText(context, "Auth Key: " + login, Toast.LENGTH_LONG).show();

                    if (loginListener != null) {
                        SharedPreferences sharedAuthKey = context.getSharedPreferences("DADOS_PESQUISA", Context.MODE_PRIVATE);
                        SharedPreferences.Editor editor = sharedAuthKey.edit();
                        editor.putString("authKey", login);
                        editor.apply();
                        loginListener.onRefreshLogin(login);
                    }


                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_SHORT).show();
                }
            }) {
                @Override
                protected Map<String, String> getParams() {
                    Map<String, String> params = new HashMap<>();
                    params.put("username", username);
                    params.put("password", password);
                    return params;
                }
            };
            volleyQueue.add(request);
        }
    }
}

