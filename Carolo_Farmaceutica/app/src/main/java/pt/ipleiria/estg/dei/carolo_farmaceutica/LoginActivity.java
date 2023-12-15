package pt.ipleiria.estg.dei.carolo_farmaceutica;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.LoginListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.SingletonGestorFarmacia;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.User;

public class LoginActivity extends AppCompatActivity implements LoginListener {

    //declaração
    private EditText etUsername, etPassword;

    public static final String USERNAME = "USERNAME";


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        setTitle("Login");
        SingletonGestorFarmacia.getInstance(getApplicationContext()).setLoginListener(this);

        //inicialização
        etUsername = findViewById(R.id.etUsername);
        etPassword = findViewById(R.id.etPassword);
    }

    public void onClickLogin(View view) {

        String username=etUsername.getText().toString();
        String password=etPassword.getText().toString();
        Intent intent=new Intent(getApplicationContext(), MenuMainActivty.class);
        intent.putExtra(USERNAME, username);
        startActivity(intent);
        finish();
        SingletonGestorFarmacia.getInstance(getApplicationContext()).login(username, password, getApplicationContext());
    }

    public void onClickRegistar() {
        TextView textView2 = findViewById(R.id.textView2);
        textView2.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                // Código para iniciar uma nova atividade aqui
                Intent intent = new Intent(getApplicationContext(), RegistarActivity.class);
                startActivity(intent);
            }
        });
    }

    @Override
    public void onRefreshLogin(String token) {
        if(token!=null){
            Intent intent = new Intent(getApplicationContext(), MenuMainActivty.class);
            startActivity(intent);
        }
    }
}
