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

import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.CarrinhoListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.CheckoutListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.LinhaCarrinhoListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.LoginListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.MedicamentosListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.ReceitaMedicaListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.RegistarListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.utils.CarrinhoJsonParser;
import pt.ipleiria.estg.dei.carolo_farmaceutica.utils.LinhaCarrinhoJsonParser;
import pt.ipleiria.estg.dei.carolo_farmaceutica.utils.LinhaJsonParser;
import pt.ipleiria.estg.dei.carolo_farmaceutica.utils.LoginJsonParser;
import pt.ipleiria.estg.dei.carolo_farmaceutica.utils.MedicamentosJsonParser;
import pt.ipleiria.estg.dei.carolo_farmaceutica.utils.ReceitaMedicaJsonParser;
import pt.ipleiria.estg.dei.carolo_farmaceutica.utils.RegistarJsonParser;


public class SingletonGestorFarmacia {

    private String login;
    private User dadosLogin;
    private ArrayList<User> users;
    private ArrayList<ReceitaMedica> receitasUser;
    private boolean user;
    private ArrayList<Medicamento> medicamentos;
    private ArrayList<ReceitaMedica> receitaMedicas;
    private ArrayList<LinhaCarrinhoCompra> linhacarrinhoCompras;
    private ArrayList<LinhaCarrinhoCompra> linhaCarrinhoCompra;
    private boolean CarrinhoCompras;
    private static SingletonGestorFarmacia instance = null;
    private static RequestQueue volleyQueue = null;
    private LoginListener loginListener;
    private MedicamentosListener medicamentosListener;
    private ReceitaMedicaListener receitaMedicaListener;
    private RegistarListener registarListener;
    private CarrinhoListener carrinhoListener;
    private LinhaCarrinhoListener linhaCarrinhoListener;
    private CheckoutListener CheckoutListener;
    private String ipAddress;
    private String mURLAPIMedicamentos;
    private String mURLAPILogin;
    private String mURLAPIReceitaMedica;
    private String mURLAPIRegistar;
    private String mURLAPICarrinho;
    private String mURLAPILinhaCarrinho;
    private String mURLAPIFatura;
    private String mURLAPIAtualizaQuantidade;
    private String mURLAPIRemoveLinhaCarrinho;
    private String mURLAPIQuantidadeProduto;
    private FarmaciaBDHelper farmaciaBDHelper;

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
        receitasUser = new ArrayList<>();
        farmaciaBDHelper = new FarmaciaBDHelper(context);
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
        mURLAPICarrinho = "http://" + ipAddress + "/projetoSIS/backend/web/api/carrinhocompras/carrinho";
        mURLAPILinhaCarrinho = "http://" + ipAddress + "/projetoSIS/backend/web/api/linhacarrinhos/ultimocarrinho";
        mURLAPIFatura = "http://" + ipAddress + "/projetoSIS/backend/web/api/faturas/carrinhofatura";
        mURLAPIAtualizaQuantidade = "http://" + ipAddress + "/projetoSIS/backend/web/api/linhacarrinhos/updatequantidade";
        mURLAPIRemoveLinhaCarrinho = "http://" + ipAddress + "/projetoSIS/backend/web/api/linhacarrinhos/removerlinhacarrinho";
        mURLAPIQuantidadeProduto = "http://" + ipAddress + "/projetoSIS/backend/web/api/linhacarrinhos/quantidadeproduto";
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

    public void setCarrinhoCompraListener(CarrinhoListener carrinhoListener) {
        this.carrinhoListener = carrinhoListener;
    }

    public void setLinhaCarrinhoCompraListener(LinhaCarrinhoListener linhaCarrinhoListener) {
        this.linhaCarrinhoListener = linhaCarrinhoListener;

    }

    public void setCheckoutListener(CheckoutListener checkoutListener) {
        this.CheckoutListener = checkoutListener;
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

    public User getUserBD(int id) {
        for (User user : users) {
            if (user.getId() == id) {
                return user;
            }
        }
        return null;
    }

    public ArrayList<Medicamento> getMedicamentosBD() {
        medicamentos = farmaciaBDHelper.getAllMedicamentosBD();
        return new ArrayList<>(medicamentos);
    }

    public ArrayList<ReceitaMedica> getReceitaMedicasBD() {
        receitaMedicas = farmaciaBDHelper.getAllReceitaMedicaBD();
        return new ArrayList<>(receitaMedicas);
    }


    public void AdicionarAllMedicamentosBD(ArrayList<Medicamento> medicamentos) {
        farmaciaBDHelper.removerAllMedicamentosBD();
        for (Medicamento m : medicamentos) {
            farmaciaBDHelper.adicionarMedicamentoBD(m);
        }
    }

    public ArrayList<ReceitaMedica> getReceitaMedicaBD(int id) {
        ArrayList<ReceitaMedica> receitasUser = new ArrayList<>();
        receitaMedicas = farmaciaBDHelper.getAllReceitaMedicaBD();

        for (ReceitaMedica receita : receitaMedicas) {
            if (receita.getUserId() == id) {
                receitasUser.add(receita);
            }
        }

        return receitasUser;
    }


    public void AdicionarReceitaMedicaBD(ArrayList<ReceitaMedica> receitaMedica) {
        // farmaciaBDHelper.removerAllReceitaMedicaBD();
        for (ReceitaMedica r : receitaMedica) {
            farmaciaBDHelper.adicionarReceitaMedicaBD(r);
        }
    }

    public User getUserBD(String username) {
        users = farmaciaBDHelper.getAllUserBD();

        for (User user : users) {
            if (user.getUsername().equals(username)) {
                return user;
            }
        }
        return null;
    }


    public void AdicionarUserBD(User user) {
        farmaciaBDHelper.adicionarUserBD(user);
    }

    public void getAllMedicamentosAPI(final Context context) {
        if (!MedicamentosJsonParser.isConnectionInternet(context)) {
            medicamentos = farmaciaBDHelper.getAllMedicamentosBD();
            if (medicamentosListener != null) {
                medicamentosListener.onRefreshListaMedicamento(medicamentos);
            }
        } else {
            SharedPreferences preferences = context.getSharedPreferences("DADOS_PESQUISA", Context.MODE_PRIVATE);
            String authKey = preferences.getString("authKey", "");
            String mURLAPIMedicamentosFinal = mURLAPIMedicamentos + "?auth_key=" + authKey;

            JsonArrayRequest request = new JsonArrayRequest(Request.Method.GET, mURLAPIMedicamentosFinal, null, new Response.Listener<JSONArray>() {
                @Override
                public void onResponse(JSONArray response) {
                    medicamentos = MedicamentosJsonParser.parserJsonMedicamentos(response);
                    AdicionarAllMedicamentosBD(medicamentos);
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
            SharedPreferences preferences = context.getSharedPreferences("DADOS_PESQUISA", Context.MODE_PRIVATE);
            String username = preferences.getString("username", "");

            User user = getUserBD(username);
            receitaMedicas = getReceitaMedicaBD(user.getId());
            if (receitaMedicaListener != null) {
                receitaMedicaListener.onRefreshReceitaMedica(receitaMedicas);
            }
        } else {
            SharedPreferences preferences = context.getSharedPreferences("DADOS_PESQUISA", Context.MODE_PRIVATE);
            String authKey = preferences.getString("authKey", "");
            int id = preferences.getInt("id", 0);

            String mURLAPIReceitaMedicaFinal = mURLAPIReceitaMedica + "/" + id + "?auth_key=" + authKey;

            JsonArrayRequest request = new JsonArrayRequest(Request.Method.GET, mURLAPIReceitaMedicaFinal, null, new Response.Listener<JSONArray>() {
                @Override
                public void onResponse(JSONArray response) {
                    receitaMedicas = ReceitaMedicaJsonParser.parserJsonReceitaMedica(response);
                    AdicionarReceitaMedicaBD(receitaMedicas);
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
        if (!LoginJsonParser.isConnectionInternet(context)) {

        } else {
            StringRequest request = new StringRequest(Request.Method.POST, mURLAPILogin, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    try {
                        JSONObject jsonResponse = new JSONObject(response);

                        int id = jsonResponse.getInt("id");
                        String authKey = jsonResponse.getString("auth_key");
                        String username = jsonResponse.getString("username");


                        login = LoginJsonParser.parserJsonLogin(response);
                        dadosLogin = LoginJsonParser.parserJsonDadosLogin(response);

                        // Adicione os dados do usuário na base de dados local
                        AdicionarUserBD(dadosLogin);

                        SharedPreferences sharedAuthKey = context.getSharedPreferences("DADOS_PESQUISA", Context.MODE_PRIVATE);
                        SharedPreferences.Editor editor = sharedAuthKey.edit();
                        editor.putInt("id", id);
                        editor.putString("authKey", authKey);
                        editor.putString("username", username);
                        editor.apply();

                        if (loginListener != null) {
                            loginListener.onRefreshLogin(login); // Notifica o loginListener após o login ser concluído
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

    public void adicionarProdutoCarrinho(int id, int quantidade, final Context context) {
        if (!CarrinhoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            SharedPreferences preferences = context.getSharedPreferences("DADOS_PESQUISA", Context.MODE_PRIVATE);
            String authKey = preferences.getString("authKey", "");
            int idUser = preferences.getInt("id", 0);

            String mURLAPICarrinhoFinal = mURLAPICarrinho + "/" + idUser + "?auth_key=" + authKey;
            StringRequest request = new StringRequest(Request.Method.POST, mURLAPICarrinhoFinal, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    CarrinhoCompras = CarrinhoJsonParser.parserJsonCarrinho(response);
                    if (carrinhoListener != null) {
                        carrinhoListener.onRefreshCarrinho(CarrinhoCompras);
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
                    params.put("produto", id + "");
                    params.put("quantidade", quantidade + "");
                    return params;
                }
            };

            volleyQueue.add(request);
        }
    }

    public void getLinhasCarrinho(final Context context) {

        if (!MedicamentosJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            SharedPreferences preferences = context.getSharedPreferences("DADOS_PESQUISA", Context.MODE_PRIVATE);
            String authKey = preferences.getString("authKey", "");
            int id = preferences.getInt("id", 0);
            String mURLAPICarrinhoFinal = mURLAPILinhaCarrinho + "/" + id + "?auth_key=" + authKey;

            JsonArrayRequest request = new JsonArrayRequest(Request.Method.GET, mURLAPICarrinhoFinal, null, new Response.Listener<JSONArray>() {
                @Override
                public void onResponse(JSONArray response) {
                    linhacarrinhoCompras = LinhaJsonParser.parserJsonLinha(response);
                    if (linhaCarrinhoListener != null) {
                        linhaCarrinhoListener.onRefreshLinhaCarrinho(linhacarrinhoCompras);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, "Erro ao obter as linhas.", Toast.LENGTH_SHORT).show();
                }
            }) {
            };
            volleyQueue.add(request);
        }
    }

    public void fazFatura(final Context context) {
        if (!LinhaCarrinhoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            SharedPreferences preferences = context.getSharedPreferences("DADOS_PESQUISA", Context.MODE_PRIVATE);
            String authKey = preferences.getString("authKey", "");
            int idUser = preferences.getInt("id", 0);

            String mURLAPIFaturaFinal = mURLAPIFatura + "/" + idUser + "?auth_key=" + authKey;
            StringRequest request = new StringRequest(Request.Method.POST, mURLAPIFaturaFinal, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    CarrinhoCompras = LinhaCarrinhoJsonParser.parserJsonLinhaCarrinho(response);
                    if (CheckoutListener != null) {
                        CheckoutListener.onRefreshCheckout(CarrinhoCompras);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, "Erro ao registar.", Toast.LENGTH_SHORT).show();
                }
            }) {
            };
            volleyQueue.add(request);
        }
    }

    public void updateQuantidadeProdutoCarrinho(int quantidade, int linhaid, final Context context) {
        if (!CarrinhoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            SharedPreferences preferences = context.getSharedPreferences("DADOS_PESQUISA", Context.MODE_PRIVATE);
            String authKey = preferences.getString("authKey", "");

            String mURLAPICarrinhoFinal = mURLAPIAtualizaQuantidade + "/" + linhaid + "?auth_key=" + authKey;
            StringRequest request = new StringRequest(Request.Method.PUT, mURLAPICarrinhoFinal, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    linhaCarrinhoCompra = LinhaCarrinhoJsonParser.parserJsonLinhaCarrinhoUpdate(response);
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, "Erro ao atualizar a quantidade do produto.", Toast.LENGTH_SHORT).show();
                }
            }) {
                @Override
                protected Map<String, String> getParams() {
                    Map<String, String> params = new HashMap<>();
                    params.put("quantidade", quantidade + "");
                    return params;
                }
            };
            volleyQueue.add(request);
        }
    }


    public void deleleLinhaCarrinho(int linhaid, Context context) {
        if (!CarrinhoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            SharedPreferences preferences = context.getSharedPreferences("DADOS_PESQUISA", Context.MODE_PRIVATE);
            String authKey = preferences.getString("authKey", "");

            String mURLAPIRemoveLinhaCarrinhoFinal = mURLAPIRemoveLinhaCarrinho + "/" + linhaid + "?auth_key=" + authKey;
            StringRequest request = new StringRequest(Request.Method.DELETE, mURLAPIRemoveLinhaCarrinhoFinal, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    linhaCarrinhoCompra = LinhaCarrinhoJsonParser.parserJsonLinhaCarrinhoUpdate(response);
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, "Erro ao apagar a linha do carrinho.", Toast.LENGTH_SHORT).show();
                }
            }) {
            };
            volleyQueue.add(request);
        }
    }

    public void QuantidadeProduto(int linhaid, Context context) {
        if (!CarrinhoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            SharedPreferences preferences = context.getSharedPreferences("DADOS_PESQUISA", Context.MODE_PRIVATE);
            String authKey = preferences.getString("authKey", "");

            String mURLAPIQuantidadeProdutoFinal = mURLAPIQuantidadeProduto + "/" + linhaid + "?auth_key=" + authKey;

            StringRequest request = new StringRequest(Request.Method.GET, mURLAPIQuantidadeProdutoFinal, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    try {
                        int[] quantidades = LinhaCarrinhoJsonParser.parserJsonQuantidadeProduto(response);

                        // Acessando os valores do array de quantidades
                        int quantidadeProduto = quantidades[0];
                        int quantidadeLinha = quantidades[1];

                        // Salvando as quantidades no SharedPreferences
                        SharedPreferences sharedAuthKey = context.getSharedPreferences("QUANTIDADE_PRODUTO", Context.MODE_PRIVATE);
                        SharedPreferences.Editor editor = sharedAuthKey.edit();
                        editor.putInt("quantidade", quantidadeProduto);
                        editor.putInt("quantidadelinha", quantidadeLinha);
                        editor.apply();

                    } catch (Exception e) {
                        e.printStackTrace();
                        Toast.makeText(context, "Erro ao processar a resposta JSON", Toast.LENGTH_SHORT).show();
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, "Erro ao apagar a linha do carrinho.", Toast.LENGTH_SHORT).show();
                }
            }) {
            };
            volleyQueue.add(request);
        }
    }
}


