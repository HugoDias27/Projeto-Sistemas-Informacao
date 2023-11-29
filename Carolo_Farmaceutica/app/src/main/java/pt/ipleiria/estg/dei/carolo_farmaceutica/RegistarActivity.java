package pt.ipleiria.estg.dei.carolo_farmaceutica;

import android.os.Bundle;
import android.widget.EditText;

import androidx.appcompat.app.AppCompatActivity;

public class RegistarActivity extends AppCompatActivity {

    //declaração
    public static final String EMAIL = "email";
    private EditText etUsername, etPassword;
    private final int MIN_PASS = 4;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_registar);
        setTitle("Registar");
    }
}
