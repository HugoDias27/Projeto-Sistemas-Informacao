package pt.ipleiria.estg.dei.carolo_farmaceutica;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

public class LoginActivity extends AppCompatActivity {

    //declaração
    public static final String EMAIL = "email";
    private EditText etUsername, etPassword;
    private final int MIN_PASS = 4;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        setTitle("Login");
        onClickRegistar();


        //inicialização
        etUsername = findViewById(R.id.etUsername);
        etPassword = findViewById(R.id.etPassword);
        etUsername.setText("teste@teste.pt");
        etPassword.setText("12345678");
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
}
