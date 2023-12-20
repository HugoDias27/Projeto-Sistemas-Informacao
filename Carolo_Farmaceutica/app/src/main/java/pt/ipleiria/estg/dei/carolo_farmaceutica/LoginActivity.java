package pt.ipleiria.estg.dei.carolo_farmaceutica;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.LoginListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.SingletonGestorFarmacia;

public class LoginActivity extends AppCompatActivity implements LoginListener {

    //declaração
    private EditText etUsername, etPassword;

    public static final String USERNAME = "USERNAME";


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        setTitle("Login");

        //inicialização
        etUsername = findViewById(R.id.etUsername);
        etPassword = findViewById(R.id.etPassword);


        onClickRegistar();
    }

    public void onClickLogin(View view) {

        String username=etUsername.getText().toString();
        String password=etPassword.getText().toString();

        SingletonGestorFarmacia.getInstance(getApplicationContext()).setLoginListener(this);
        SingletonGestorFarmacia.getInstance(getApplicationContext()).login(username, password, getApplicationContext());
    }

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

    @Override
    public void onRefreshLogin(String token) {
        if(token!=null){
            String username=etUsername.getText().toString();
            Intent intent= new Intent(getApplicationContext(), MenuMainActivity.class);
            intent.putExtra(USERNAME, username);
            startActivity(intent);
            finish();
        }
    }
}
