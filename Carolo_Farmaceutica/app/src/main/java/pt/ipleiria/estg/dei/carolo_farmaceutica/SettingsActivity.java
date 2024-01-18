package pt.ipleiria.estg.dei.carolo_farmaceutica;

import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;

public class SettingsActivity extends AppCompatActivity {

    // Método para carregar a atividade das definições
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_settings);

        if(savedInstanceState == null){
            getSupportFragmentManager().beginTransaction().replace(android.R.id.content, new SettingsFragment()).commit();
        }
    }
}
