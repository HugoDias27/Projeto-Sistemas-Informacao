package pt.ipleiria.estg.dei.carolo_farmaceutica.modelo;

import android.content.Context;
import android.content.SharedPreferences;
import android.widget.Toast;


import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonArrayRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.LoginListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.MedicamentosListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.ReceitaMedicaListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.RegistarListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.utils.LoginJsonParser;
import pt.ipleiria.estg.dei.carolo_farmaceutica.utils.MedicamentosJsonParser;
import pt.ipleiria.estg.dei.carolo_farmaceutica.utils.ReceitaMedicaJsonParser;
import pt.ipleiria.estg.dei.carolo_farmaceutica.utils.RegistarJsonParser;


public class SingletonGestorFarmacia {

    private String login;
    private boolean user;
    private ArrayList<Medicamento> medicamentos;
    private ArrayList<ReceitaMedica> receitaMedicas;
    private static SingletonGestorFarmacia instance = null;
    private static RequestQueue volleyQueue = null;
    private LoginListener loginListener;
    private MedicamentosListener medicamentosListener;
    private ReceitaMedicaListener receitaMedicaListener;
    private RegistarListener registarListener;
    private  String ipAddress;
    private String mURLAPIMedicamentos;
    private  String mURLAPILogin;
    private  String mURLAPIReceitaMedica;
    private  String mURLAPIRegistar;



    public static synchronized SingletonGestorFarmacia getInstance(Context context) {
        if (instance == null) {
            instance = new SingletonGestorFarmacia(context);
            volleyQueue = Volley.newRequestQueue(context);
        }
        return instance;
    }

    public SingletonGestorFarmacia(Context context) {

        medicamentos = new ArrayList<>();
        receitaMedicas = new ArrayList<>();
    }

    public String getIpAddress() {

        return ipAddress;
    }

    public void setIpAddress(String ipAddress) {

        this.ipAddress = ipAddress;
        mURLAPIMedicamentos = "http://" + ipAddress + "/projetoSIS/backend/web/api/produtos/medicamentos";
        mURLAPILogin = "http://" + ipAddress + "/projetoSIS/backend/web/api/logins/loginuser";
        mURLAPIReceitaMedica = "http://" + ipAddress + "/projetoSIS/backend/web/api/receitamedicas/receitacliente";
        mURLAPIRegistar = "http://" + ipAddress + "/projetoSIS/backend/web/api/users/criarusers";
    }

    public void setLoginListener(LoginListener loginListener) {
        this.loginListener = loginListener;
    }

    public void setMedicamentosListener(MedicamentosListener medicamentosListener) {
        this.medicamentosListener = medicamentosListener;
    }


    public void setReceitaMedicaListener(ReceitaMedicaListener receitaMedicaListener) {
        this.receitaMedicaListener = receitaMedicaListener;
    }

    public void setRegistarListener(RegistarListener registarListener) {
        this.registarListener = registarListener;
    }

    public Medicamento getMedicamento(int id) {
        for (Medicamento medicamento : medicamentos) {
            if (medicamento.getId() == id) {
                return medicamento;
            }
        }
        return null;
    }

    public ReceitaMedica getReceitaMedica(int id) {
        for (ReceitaMedica receitaMedica : receitaMedicas) {
            if (receitaMedica.getId() == id) {
                return receitaMedica;
            }
        }
        return null;

    }

    public void getAllMedicamentosAPI(final Context context) {
        if (!MedicamentosJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            SharedPreferences preferences = context.getSharedPreferences("DADOS_PESQUISA", Context.MODE_PRIVATE);
            String authKey = preferences.getString("authKey", "");
            String mURLAPIMedicamentosFinal = mURLAPIMedicamentos + "?auth_key=" + authKey;

            JsonArrayRequest request = new JsonArrayRequest(Request.Method.GET, mURLAPIMedicamentosFinal, null, new Response.Listener<JSONArray>() {
                @Override
                public void onResponse(JSONArray response) {
                    medicamentos = MedicamentosJsonParser.parserJsonMedicamentos(response);
                    if (medicamentosListener != null) {
                        medicamentosListener.onRefreshListaMedicamento(medicamentos);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, "Erro ao obter os medicamentos.", Toast.LENGTH_SHORT).show();
                }
            }) {
            };
            volleyQueue.add(request);
        }
    }

    public void getMinhaReceitaAPI(final Context context) {
        if (!ReceitaMedicaJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            SharedPreferences preferences = context.getSharedPreferences("DADOS_PESQUISA", Context.MODE_PRIVATE);
            String authKey = preferences.getString("authKey", "");
            int id = preferences.getInt("id", 0);

            String mURLAPIReceitaMedicaFinal = mURLAPIReceitaMedica + "/" + id + "?auth_key=" + authKey;

            JsonArrayRequest request = new JsonArrayRequest(Request.Method.GET, mURLAPIReceitaMedicaFinal, null, new Response.Listener<JSONArray>() {
                @Override
                public void onResponse(JSONArray response) {
                    receitaMedicas = ReceitaMedicaJsonParser.parserJsonReceitaMedica(response);
                    if (receitaMedicaListener != null) {
                        receitaMedicaListener.onRefreshReceitaMedica(receitaMedicas);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, "Erro ao obter a sua(s) receitas médicas.", Toast.LENGTH_SHORT).show();
                }
            }) {
            };
            volleyQueue.add(request);
        }
    }

    public void login(String username, String password, final Context context) {
        StringRequest request = new StringRequest(Request.Method.POST, mURLAPILogin, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                try {
                    JSONObject jsonResponse = new JSONObject(response);

                    int id = jsonResponse.getInt("id");
                    String authKey = jsonResponse.getString("auth_key");

                    login = LoginJsonParser.parserJsonLogin(response);

                    SharedPreferences sharedAuthKey = context.getSharedPreferences("DADOS_PESQUISA", Context.MODE_PRIVATE);
                    SharedPreferences.Editor editor = sharedAuthKey.edit();
                    editor.putInt("id", id);
                    editor.putString("authKey", authKey);
                    editor.apply();

                    if (loginListener != null) {
                        loginListener.onRefreshLogin(login);
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                    Toast.makeText(context, "Erro ao processar a resposta JSON", Toast.LENGTH_SHORT).show();
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(context, "Erro na autenticação.", Toast.LENGTH_SHORT).show();
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

    public void registar(String username, String password, String email, final Context context) {
        StringRequest request = new StringRequest(Request.Method.POST, mURLAPIRegistar, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                    user = RegistarJsonParser.parserJsonRegistar(response);
                    if (registarListener != null) {
                        registarListener.onRefreshRegistar(user);
                    }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(context, "Erro ao registar.", Toast.LENGTH_SHORT).show();
            }
        }) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<>();
                params.put("username", username);
                params.put("password", password);
                params.put("email", email);
                return params;
            }
        };
        volleyQueue.add(request);
    }
}

