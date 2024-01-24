package pt.ipleiria.estg.dei.carolo_farmaceutica;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.LoginListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.ReceitaMedicaListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.ReceitaMedica;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.SingletonGestorFarmacia;
import pt.ipleiria.estg.dei.carolo_farmaceutica.utils.LoginJsonParser;

public class LoginActivity extends AppCompatActivity implements LoginListener {

    // Declaração de variáveis
    private EditText etUsername, etPassword;
    public static final String USERNAME = "USERNAME";


    // Método para carregar a atividade do login
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        setTitle("Login");

        etUsername = findViewById(R.id.etUsername);
        etPassword = findViewById(R.id.etPassword);

        onClickRegistar();
    }

    // Método que é utilizado quando o utilizador clica no botão de login
    public void onClickLogin(View view) {
        String username = etUsername.getText().toString();
        String password = etPassword.getText().toString();

        if(username.isEmpty() || password.isEmpty()){
            Toast.makeText(this, R.string.txt_preencha_campos, Toast.LENGTH_SHORT).show();
            return;
        }

        SingletonGestorFarmacia singletonGestorFarmacia = SingletonGestorFarmacia.getInstance(getApplicationContext());
        singletonGestorFarmacia.setLoginListener(this);

        singletonGestorFarmacia.login(username, password, getApplicationContext());
    }


    // Método que é utilizado quando o utilizador clica no botão de registar
    public void onClickRegistar() {
        TextView textViewRegistar = findViewById(R.id.textViewRegistar);
        textViewRegistar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(getApplicationContext(), RegistarActivity.class);
                startActivity(intent);
                finish();
            }
        });
    }

    // Método que é utilizado após o login ser efetuado com sucesso
    @Override
    public void onRefreshLogin(String token) {
        if(token!=null){
            String username=etUsername.getText().toString();
            Intent intent= new Intent(getApplicationContext(), MenuMainActivity.class);
            intent.putExtra(USERNAME, username);
            SharedPreferences sharedAuthKey = getSharedPreferences("LOGIN", Context.MODE_PRIVATE);
            SharedPreferences.Editor editor = sharedAuthKey.edit();
            editor.putString("USERNAME", username);
            editor.apply();
            startActivity(intent);
            finish();
        }
    }
}
