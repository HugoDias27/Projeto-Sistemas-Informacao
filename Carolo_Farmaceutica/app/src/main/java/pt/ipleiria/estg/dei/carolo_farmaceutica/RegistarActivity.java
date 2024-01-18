package pt.ipleiria.estg.dei.carolo_farmaceutica;

import android.content.Intent;
import android.os.Bundle;
import android.util.Patterns;
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

    // Declaração de variáveis
    private EditText etUsername, etPassword, etEmail, etNUtente, etMorada, etNIF, etTelefone;
    private final int MIN_CHAR = 9;

    // Método para carregar a atividade de registar um novo utilizador
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
        etNUtente = findViewById(R.id.etnUtente);
        etMorada = findViewById(R.id.etMorada);
        etNIF = findViewById(R.id.etNif);
        etTelefone = findViewById(R.id.etTelefone);
    }

    // Método onde verifica se o email inserido é válido
    private boolean isEmailValido(String email) {
        if (email == null)
            return false;

        return Patterns.EMAIL_ADDRESS.matcher(email).matches();
    }

    // Método onde verifica se os dados inseridos são válidos
    private boolean isdadosValido(String dado) {
        if (dado == null)
            return false;

        return dado.length() <= MIN_CHAR;
    }

    // Método que é utilizado quando o utilizador clica no botão de registar
    public void onClickRegistar(View view) {
        String username = etUsername.getText().toString();
        String password = etPassword.getText().toString();
        String email = etEmail.getText().toString();
        String nUtente = etNUtente.getText().toString();
        String morada = etMorada.getText().toString();
        String nif = etNIF.getText().toString();
        String telefone = etTelefone.getText().toString();

        if (username.isEmpty() || password.isEmpty() || email.isEmpty() || nUtente.isEmpty() || morada.isEmpty() || nif.isEmpty() || telefone.isEmpty()) {
            Toast.makeText(this, "Preencha todos os campos!", Toast.LENGTH_SHORT).show();
            return;
        }

        if (!isEmailValido(email)) {
            etEmail.setError("O email é inválido!");
            return;
        }

        if (!isdadosValido(nUtente)) {
            etNUtente.setError("O número de utente é inválido!");
            return;
        }

        if (!isdadosValido(nif)) {
            etNIF.setError("O número de identificação fiscal é inválido!");
            return;
        }

        if (!isdadosValido(telefone)) {
            etTelefone.setError("O número de telefone é inválido!");
            return;
        }

        SingletonGestorFarmacia.getInstance(getApplicationContext()).setRegistarListener(this);
        SingletonGestorFarmacia.getInstance(getApplicationContext()).registar(username, password, email, nUtente, morada, nif, telefone, getApplicationContext());
    }

    // Método que é utilizado após o registo ser efetuado com sucesso
    @Override
    public void onRefreshRegistar(boolean resposta) {
        if (resposta) {
            Toast.makeText(this, "Registo efetuado com sucesso.", Toast.LENGTH_SHORT).show();
            Intent intent = new Intent(getApplicationContext(), LoginActivity.class);
            startActivity(intent);
            finish();
        }
    }
}
