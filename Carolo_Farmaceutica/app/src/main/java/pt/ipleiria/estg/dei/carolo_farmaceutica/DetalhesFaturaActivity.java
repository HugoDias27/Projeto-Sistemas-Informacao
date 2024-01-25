package pt.ipleiria.estg.dei.carolo_farmaceutica;

import android.graphics.Color;
import android.os.Bundle;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentTransaction;

import java.util.ArrayList;


public class DetalhesFaturaActivity extends AppCompatActivity {

    // Declaração de variáveis
    public static final String ID_FATURA = "id";

    // Método para carregar a atividade dos detalhes da fatura
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detalhes_fatura);

        carregarFragmentoDetalhesFatura();
    }

    // Método para carregar o fragmento dos detalhes da fatura
    private void carregarFragmentoDetalhesFatura() {
        FaturaLinhasFragment faturaLinhasFragment = new FaturaLinhasFragment();

        int id = getIntent().getIntExtra(ID_FATURA, 0);

        faturaLinhasFragment.setIdFatura(id);

        FragmentManager fragmentManager = getSupportFragmentManager();
        FragmentTransaction fragmentTransaction = fragmentManager.beginTransaction();

        fragmentTransaction.replace(R.id.fragmentContainer, faturaLinhasFragment);

        fragmentTransaction.commit();
    }
}

