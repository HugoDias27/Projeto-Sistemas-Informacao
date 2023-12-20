package pt.ipleiria.estg.dei.carolo_farmaceutica;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.RegistarListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.SingletonGestorFarmacia;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.User;

public class RegistarActivity extends AppCompatActivity implements RegistarListener {

    //declaração
    private EditText etUsername, etPassword, etEmail;
    private final int MIN_PASS = 4;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_registar);

        Toolbar toolbar = findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        ImageButton btnBack = findViewById(R.id.btnBack);
        btnBack.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(getApplicationContext(), LoginActivity.class);
                startActivity(intent);
                finish();
            }
        });

        etUsername = findViewById(R.id.etUsername);
        etPassword = findViewById(R.id.etPassword);
        etEmail = findViewById(R.id.etEmail);
    }

    public void onClickRegistar(View view) {
        String username=etUsername.getText().toString();
        String password=etPassword.getText().toString();
        String email=etEmail.getText().toString();

        SingletonGestorFarmacia.getInstance(getApplicationContext()).setRegistarListener(this);
        SingletonGestorFarmacia.getInstance(getApplicationContext()).registar(username, password, email, getApplicationContext());
    }

    @Override
    public void onRefreshRegistar(boolean resposta) {
        if(resposta){
            Toast.makeText(this, "Registo efetuado com sucesso.", Toast.LENGTH_SHORT).show();
            Intent intent = new Intent(getApplicationContext(), LoginActivity.class);
            startActivity(intent);
            finish();
        }
    }
}
