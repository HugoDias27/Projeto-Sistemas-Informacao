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

import pt.ipleiria.estg.dei.carolo_farmaceutica.LinhaCarrinhoFragment;
import pt.ipleiria.estg.dei.carolo_farmaceutica.R;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.CarrinhoListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.CheckoutListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.FaturaCarrinhoListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.FaturaListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.LinhaCarrinhoListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.LoginListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.MedicamentosListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.QuantidadeListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.ReceitaMedicaListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.RegistarListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.SubtotalListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.utils.CarrinhoJsonParser;
import pt.ipleiria.estg.dei.carolo_farmaceutica.utils.FaturaJsonParser;
import pt.ipleiria.estg.dei.carolo_farmaceutica.utils.LinhaCarrinhoJsonParser;
import pt.ipleiria.estg.dei.carolo_farmaceutica.utils.LinhaJsonParser;
import pt.ipleiria.estg.dei.carolo_farmaceutica.utils.LoginJsonParser;
import pt.ipleiria.estg.dei.carolo_farmaceutica.utils.MedicamentosJsonParser;
import pt.ipleiria.estg.dei.carolo_farmaceutica.utils.ReceitaMedicaJsonParser;
import pt.ipleiria.estg.dei.carolo_farmaceutica.utils.RegistarJsonParser;


public class SingletonGestorFarmacia {

    // Declaração de variáveis
    private String login;
    private User dadosLogin;
    private double subtotal;
    private ArrayList<User> users;
    private ArrayList<ReceitaMedica> receitasUser;
    private boolean user;
    private ArrayList<Medicamento> medicamentos;
    private ArrayList<ReceitaMedica> receitaMedicas;
    private ArrayList<LinhaCarrinhoCompra> linhacarrinhoCompras;
    private ArrayList<LinhaCarrinhoCompra> linhaCarrinhoCompra;
    private ArrayList<LinhaCarrinhoCompraFatura> linhaCarrinhoCompraFatura;
    private ArrayList<Fatura> faturas;
    private boolean CarrinhoCompras;
    private boolean fatura;
    private static SingletonGestorFarmacia instance = null;
    private static RequestQueue volleyQueue = null;
    private LoginListener loginListener;
    private MedicamentosListener medicamentosListener;
    private ReceitaMedicaListener receitaMedicaListener;
    private RegistarListener registarListener;
    private CarrinhoListener carrinhoListener;
    private LinhaCarrinhoListener linhaCarrinhoListener;
    private CheckoutListener CheckoutListener;
    private FaturaListener faturaListener;
    private FaturaCarrinhoListener faturaCarrinhoListener;
    private SubtotalListener subtotalListener;
    private QuantidadeListener quantidadeListener;
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
    private String mURLAPIFaturaCliente;
    private String mURLAPISubtotal;
    private String mURLAPILinhaCarrinhoPorFatura;
    private String mURLAPIMedicamentoCategoria;
    private FarmaciaBDHelper farmaciaBDHelper;

    // Método que permite o acesso ao Singleton por outras classes
    public static synchronized SingletonGestorFarmacia getInstance(Context context) {
        if (instance == null) {
            instance = new SingletonGestorFarmacia(context);
            volleyQueue = Volley.newRequestQueue(context);
        }
        return instance;
    }

    // Construtor
    public SingletonGestorFarmacia(Context context) {
        medicamentos = new ArrayList<>();
        receitaMedicas = new ArrayList<>();
        receitasUser = new ArrayList<>();
        linhaCarrinhoCompraFatura = new ArrayList<>();
        faturas = new ArrayList<>();
        farmaciaBDHelper = new FarmaciaBDHelper(context);
    }

    // Getter do ip inserido pelo utilizador
    public String getIpAddress() {
        return ipAddress;
    }

    // Método que recebe o ip inserido pelo utilizador e cria as urls para as apis
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
        mURLAPIFaturaCliente = "http://" + ipAddress + "/projetoSIS/backend/web/api/faturas/faturacliente";
        mURLAPILinhaCarrinhoPorFatura = "http://" + ipAddress + "/projetoSIS/backend/web/api/linhacarrinhos/linhascarrinho";
        mURLAPISubtotal = "http://" + ipAddress + "/projetoSIS/backend/web/api/linhacarrinhos/subtotal";
        mURLAPIMedicamentoCategoria = "http://" + ipAddress + "/projetoSIS/backend/web/api/produtos/categoria";
    }

    // region setters dos listeners

    // Método que permite a comunicação entre a classe Singleton e a classe LoginFragment
    public void setLoginListener(LoginListener loginListener) {
        this.loginListener = loginListener;
    }

    // Método que permite a comunicação entre a classe Singleton e a classe MedicamentosFragment
    public void setMedicamentosListener(MedicamentosListener medicamentosListener) {
        this.medicamentosListener = medicamentosListener;
    }

    // Método que permite a comunicação entre a classe Singleton e a classe ReceitaMedicaFragment
    public void setReceitaMedicaListener(ReceitaMedicaListener receitaMedicaListener) {
        this.receitaMedicaListener = receitaMedicaListener;
    }

    // Método que permite a comunicação entre a classe Singleton e a classe RegistarActivity
    public void setRegistarListener(RegistarListener registarListener) {
        this.registarListener = registarListener;
    }

    // Método que permite a comunicação entre a classe Singleton e a classe LinhaCarrinhoFragment
    public void setCarrinhoCompraListener(CarrinhoListener carrinhoListener) {
        this.carrinhoListener = carrinhoListener;
    }

    // Método que permite a comunicação entre a classe Singleton e a classe LinhaCarrinhoFragment
    public void setLinhaCarrinhoCompraListener(LinhaCarrinhoListener linhaCarrinhoListener) {
        this.linhaCarrinhoListener = linhaCarrinhoListener;
    }

    // Método que permite a comunicação entre a classe Singleton e a classe LinhaCarrinhoFragment
    public void setCheckoutListener(CheckoutListener checkoutListener) {
        this.CheckoutListener = checkoutListener;
    }

    // Método que permite a comunicação entre a classe Singleton e a classe ListaFaturaFragment
    public void setFaturasListener(FaturaListener faturaListener) {
        this.faturaListener = faturaListener;
    }

    // Método que permite a comunicação entre a classe Singleton e a classe FaturaLinhasFragment
    public void setFaturaCarrinhoListener(FaturaCarrinhoListener faturaCarrinhoListener) {
        this.faturaCarrinhoListener = faturaCarrinhoListener;
    }

    // Método que permite a comunicação entre a classe Singleton e a classe LinhaCarrinhoFragment
    public void setSubtotalListener(SubtotalListener subtotalListener) {
        this.subtotalListener = subtotalListener;
    }

    // Método que permite a comunicação entre a classe Singleton e a classe ListaCarrinhoAdapter
    public void setQuantidadeListener(QuantidadeListener quantidadeListener) {
        this.quantidadeListener = quantidadeListener;
    }
    //endregion


    // region dos getters dos detalhes dos medicamentos e das receitas médicas

    // Método que quando o utilizador seleciona um medicamento, vai buscar todos os seus dados
    public Medicamento getMedicamento(int id) {
        for (Medicamento medicamento : medicamentos) {
            if (medicamento.getId() == id) {
                return medicamento;
            }
        }
        return null;
    }

    // Método que quando o utilizador seleciona uma receita médica, vai buscar todos os seus dados
    public ReceitaMedica getReceitaMedica(int id) {
        for (ReceitaMedica receitaMedica : receitaMedicas) {
            if (receitaMedica.getId() == id) {
                return receitaMedica;
            }
        }
        return null;

    }
    // endregion

    // region métodos BD(SQLite)

    // Método que vai buscar todos os medicamentos à BD(SQLite)
    public ArrayList<Medicamento> getMedicamentosBD() {
        medicamentos = farmaciaBDHelper.getAllMedicamentosBD();
        return new ArrayList<>(medicamentos);
    }

    // Método que busca os produtos por categoria à BD(SQLite)
    public ArrayList<Medicamento> getMedicamentosCategoriaBD(String categoria) {
        ArrayList<Medicamento> medicamentosPorCategoria = new ArrayList<>();
        medicamentos = farmaciaBDHelper.getAllMedicamentosBD();

        for (Medicamento medicamento : medicamentos) {
            if (medicamento.getCategoriaId().equals(categoria)) {
                medicamentosPorCategoria.add(medicamento);
            }
        }
        return medicamentosPorCategoria;
    }


    // Método que adiciona todos os médicamentos à BD(SQLite)
    public void AdicionarAllMedicamentosBD(ArrayList<Medicamento> medicamentos) {
        farmaciaBDHelper.removerAllMedicamentosBD();
        for (Medicamento m : medicamentos) {
            farmaciaBDHelper.adicionarMedicamentoBD(m);
        }
    }

    // Método que vai buscar todas as receitas médicas do respetivo utilizador logado à BD(SQLite)
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

    // Método que adiciona todas as receitas médicas BD(SQLite)
    public void AdicionarReceitaMedicaBD(ArrayList<ReceitaMedica> receitaMedica) {
        farmaciaBDHelper.removerAllReceitaMedicaBD();
        for (ReceitaMedica r : receitaMedica) {
            farmaciaBDHelper.adicionarReceitaMedicaBD(r);
        }
    }


    // Método que adiciona o utilizador à BD(SQLite)
    public void AdicionarUserBD(User user) {
        farmaciaBDHelper.removerAllUsersBD();
        farmaciaBDHelper.adicionarUserBD(user);
    }
    //endregion

    // region acesso à aplicação

    // Método que permite o registo de um utilizador
    public void registar(String username, String password, String email, String nUtente, String morada, String nif, String telefone, final Context context) {
        if (!RegistarJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, R.string.txt_sem_conexao, Toast.LENGTH_SHORT).show();
        } else {
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
                    Toast.makeText(context, R.string.txt_erro_registar, Toast.LENGTH_SHORT).show();
                }
            }) {
                @Override
                protected Map<String, String> getParams() {
                    Map<String, String> params = new HashMap<>();
                    params.put("username", username);
                    params.put("password", password);
                    params.put("email", email);
                    params.put("nUtente", nUtente);
                    params.put("morada", morada);
                    params.put("nif", nif);
                    params.put("telefone", telefone);
                    return params;
                }
            };
            volleyQueue.add(request);
        }
    }

    // Método que permite o login de um utilizador
    public void login(String username, String password, final Context context) {
        if (!LoginJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, R.string.txt_sem_conexao, Toast.LENGTH_SHORT).show();
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
                        AdicionarUserBD(dadosLogin);

                        SharedPreferences sharedAuthKey = context.getSharedPreferences("DADOS_PESQUISA", Context.MODE_PRIVATE);
                        SharedPreferences.Editor editor = sharedAuthKey.edit();
                        editor.putInt("id", id);
                        editor.putString("authKey", authKey);
                        editor.putString("username", username);
                        editor.apply();

                        if (loginListener != null) {
                            loginListener.onRefreshLogin(login);
                        }
                    } catch (JSONException e) {
                        e.printStackTrace();
                        Toast.makeText(context, R.string.txt_erro_dados, Toast.LENGTH_SHORT).show();
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, R.string.txt_erro_auth, Toast.LENGTH_SHORT).show();
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
    //endregion

    // region dos medicamentos

    // Método para obter todos os medicamentos
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
                    Toast.makeText(context, R.string.txt_erro_medicamentos, Toast.LENGTH_SHORT).show();
                }
            }) {
            };
            volleyQueue.add(request);
        }
    }

    // Método para obter os medicamentos por categoria
    public void getMedicamentoCategoria(final Context context, String nomeCategoria) {
        if (!MedicamentosJsonParser.isConnectionInternet(context)) {
            medicamentos = farmaciaBDHelper.getMedicamentosCategoriaBD(nomeCategoria);
            if (medicamentosListener != null) {
                medicamentosListener.onRefreshListaMedicamento(medicamentos);
            }
        } else {
            SharedPreferences preferences = context.getSharedPreferences("DADOS_PESQUISA", Context.MODE_PRIVATE);
            String authKey = preferences.getString("authKey", "");

            String mURLAPIMedicamentoCategoriaFinal = mURLAPIMedicamentoCategoria + "/" + nomeCategoria + "?auth_key=" + authKey;

            JsonArrayRequest request = new JsonArrayRequest(Request.Method.GET, mURLAPIMedicamentoCategoriaFinal, null, new Response.Listener<JSONArray>() {
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
                    Toast.makeText(context, R.string.txt_erro_medicamentos, Toast.LENGTH_SHORT).show();
                }
            }) {
            };
            volleyQueue.add(request);
        }
    }
    //endregion

    // Método para obter as receitas médicas do utilizador logado
    public void getMinhaReceitaAPI(final Context context) {
        if (!ReceitaMedicaJsonParser.isConnectionInternet(context)) {
            SharedPreferences preferences = context.getSharedPreferences("DADOS_PESQUISA", Context.MODE_PRIVATE);
            int id = preferences.getInt("id", 0);

            receitaMedicas = getReceitaMedicaBD(id);
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
                    Toast.makeText(context, R.string.txt_erro_receitaMedica, Toast.LENGTH_SHORT).show();
                }
            }) {
            };
            volleyQueue.add(request);
        }
    }

    // region carrinho de compras

    // Método para obter o carrinho de compras e as respetivas linhas do carrinho do utilizador logado
    public void getLinhasCarrinho(final Context context) {
        if (!MedicamentosJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, R.string.txt_sem_conexao, Toast.LENGTH_SHORT).show();
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
                    Toast.makeText(context, R.string.txt_carrinho_vazio, Toast.LENGTH_SHORT).show();
                }
            }) {
            };
            volleyQueue.add(request);
        }
    }

    // Método para adicionar um produto ao carrinho de compras
    public void adicionarProdutoCarrinho(int id, int quantidade, final Context context) {
        if (!CarrinhoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, R.string.txt_sem_conexao, Toast.LENGTH_SHORT).show();
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
                    Toast.makeText(context, R.string.txt_adicionar_produto_carrinho, Toast.LENGTH_SHORT).show();
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

    // Método para atualizar a quantidade de um produto no carrinho de compras
    public void updateQuantidadeProdutoCarrinho(int quantidade, int linhaid, final Context context) {
        if (!LinhaCarrinhoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, R.string.txt_sem_conexao, Toast.LENGTH_SHORT).show();
        } else {
            SharedPreferences preferences = context.getSharedPreferences("DADOS_PESQUISA", Context.MODE_PRIVATE);
            String authKey = preferences.getString("authKey", "");

            String mURLAPICarrinhoFinal = mURLAPIAtualizaQuantidade + "/" + linhaid + "?auth_key=" + authKey;

            StringRequest request = new StringRequest(Request.Method.PUT, mURLAPICarrinhoFinal, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    //linhaCarrinhoCompra = LinhaCarrinhoJsonParser.parserJsonLinhaCarrinhoUpdate(response);
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, R.string.txt_erro_atualizar_quantidade_linha, Toast.LENGTH_SHORT).show();
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

    // Método para apagar uma linha do carrinho de compras
    public void deleleLinhaCarrinho(int linhaid, final Context context) {
        if (!LinhaCarrinhoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, R.string.txt_sem_conexao, Toast.LENGTH_SHORT).show();
        } else {
            SharedPreferences preferences = context.getSharedPreferences("DADOS_PESQUISA", Context.MODE_PRIVATE);
            String authKey = preferences.getString("authKey", "");

            String mURLAPIRemoveLinhaCarrinhoFinal = mURLAPIRemoveLinhaCarrinho + "/" + linhaid + "?auth_key=" + authKey;

            StringRequest request = new StringRequest(Request.Method.DELETE, mURLAPIRemoveLinhaCarrinhoFinal, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    boolean resposta = LinhaCarrinhoJsonParser.parserJsonLinhaCarrinhoDelete(response);
                    if (quantidadeListener != null) {
                        quantidadeListener.onRefreshDeleteLinhaCarrinho(resposta);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, R.string.txt_erro_remover_linha, Toast.LENGTH_SHORT).show();
                }
            }) {
            };
            volleyQueue.add(request);
        }
    }

    // Método para obter a quantidade de um produto que está no carrinho de compras
    public void QuantidadeProduto(int linhaid, final Context context) {
        if (!LinhaCarrinhoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, R.string.txt_sem_conexao, Toast.LENGTH_SHORT).show();
        } else {
            SharedPreferences preferences = context.getSharedPreferences("DADOS_PESQUISA", Context.MODE_PRIVATE);
            String authKey = preferences.getString("authKey", "");

            String mURLAPIQuantidadeProdutoFinal = mURLAPIQuantidadeProduto + "/" + linhaid + "?auth_key=" + authKey;

            StringRequest request = new StringRequest(Request.Method.GET, mURLAPIQuantidadeProdutoFinal, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    try {
                        double[] dadosProduto = LinhaCarrinhoJsonParser.parserJsonDadosProduto(response);
                        if (quantidadeListener != null) {
                            quantidadeListener.onRefreshProduto(dadosProduto);
                        }
                    } catch (Exception e) {
                        e.printStackTrace();
                        Toast.makeText(context, R.string.txt_erro_dados, Toast.LENGTH_SHORT).show();
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, R.string.txt_erro_dados, Toast.LENGTH_SHORT).show();
                }
            }) {
            };
            volleyQueue.add(request);
        }
    }

    // Método para obter o subtotal do carrinho de compras
    public void getSubtotal(final Context context) {
        if (!LinhaCarrinhoJsonParser.isConnectionInternet(context)) {
            // Toast.makeText(context, R.string.txt_sem_conexao, Toast.LENGTH_SHORT).show();
        } else {
            SharedPreferences preferences = context.getSharedPreferences("DADOS_PESQUISA", Context.MODE_PRIVATE);
            String authKey = preferences.getString("authKey", "");
            int id = preferences.getInt("id", 0);

            String mURLAPISubtotalFinal = mURLAPISubtotal + "/" + id + "?auth_key=" + authKey;

            StringRequest request = new StringRequest(Request.Method.GET, mURLAPISubtotalFinal, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    subtotal = LinhaCarrinhoJsonParser.parserJsonSubtotal(response);
                    if (subtotalListener != null) {
                        subtotalListener.onSubtotal(subtotal);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                   // Toast.makeText(context, R.string.txt_erro_subtotal, Toast.LENGTH_SHORT).show();
                }
            });
            volleyQueue.add(request);
        }
    }
    //endregion


    // region faturas

    // Método que cria a fatura
    public void fazFatura(final Context context) {
        if (!FaturaJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, R.string.txt_sem_conexao, Toast.LENGTH_SHORT).show();
        } else {
            SharedPreferences preferences = context.getSharedPreferences("DADOS_PESQUISA", Context.MODE_PRIVATE);
            String authKey = preferences.getString("authKey", "");
            int idUser = preferences.getInt("id", 0);

            String mURLAPIFaturaFinal = mURLAPIFatura + "/" + idUser + "?auth_key=" + authKey;
            StringRequest request = new StringRequest(Request.Method.POST, mURLAPIFaturaFinal, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    fatura = FaturaJsonParser.parserJsonFatura(response);
                    if (CheckoutListener != null) {
                        CheckoutListener.onRefreshCheckout(fatura);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, R.string.txt_erro_checkout, Toast.LENGTH_SHORT).show();
                }
            }) {
            };
            volleyQueue.add(request);
        }
    }

    // Método para obter as faturas do utilizador logado
    public void getFaturasAPI(final Context context) {
        if (!FaturaJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, R.string.txt_sem_conexao, Toast.LENGTH_SHORT).show();
        } else {
            SharedPreferences preferences = context.getSharedPreferences("DADOS_PESQUISA", Context.MODE_PRIVATE);
            String authKey = preferences.getString("authKey", "");
            int id = preferences.getInt("id", 0);

            String mURLAPIFaturaClienteFinal = mURLAPIFaturaCliente + "/" + id + "?auth_key=" + authKey;

            JsonArrayRequest request = new JsonArrayRequest(Request.Method.GET, mURLAPIFaturaClienteFinal, null, new Response.Listener<JSONArray>() {
                @Override
                public void onResponse(JSONArray response) {
                    faturas = FaturaJsonParser.parserJsonFaturaCliente(response);
                    if (faturaListener != null) {
                        faturaListener.onRefreshListaFatura(faturas);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, R.string.txt_erro_fatura, Toast.LENGTH_SHORT).show();
                }
            }) {
            };
            volleyQueue.add(request);
        }
    }

    // Método para obter as linhas da respetiva fatura
    public void getLinhasCarrinhoCompraFatura(int id, final Context context) {
        if (!FaturaJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, R.string.txt_sem_conexao, Toast.LENGTH_SHORT).show();
        } else {
            SharedPreferences preferences = context.getSharedPreferences("DADOS_PESQUISA", Context.MODE_PRIVATE);
            String authKey = preferences.getString("authKey", "");

            String mURLAPILinhaCarrinhoPorFaturaFinal = mURLAPILinhaCarrinhoPorFatura + "/" + id + "?auth_key=" + authKey;

            JsonArrayRequest request = new JsonArrayRequest(Request.Method.GET, mURLAPILinhaCarrinhoPorFaturaFinal, null, new Response.Listener<JSONArray>() {
                @Override
                public void onResponse(JSONArray response) {
                    linhaCarrinhoCompraFatura = FaturaJsonParser.parserJsonLinhasCarrinho(response);
                    if (faturaCarrinhoListener != null) {
                        faturaCarrinhoListener.onLinhasCarrinhoCarregadas(linhaCarrinhoCompraFatura);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, R.string.txt_erro_linhas_fatura, Toast.LENGTH_SHORT).show();
                }
            });
            volleyQueue.add(request);
        }
    }
    //endregion
}