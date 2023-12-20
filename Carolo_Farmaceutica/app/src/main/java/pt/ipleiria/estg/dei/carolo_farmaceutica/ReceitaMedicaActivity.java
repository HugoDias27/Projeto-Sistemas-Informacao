package pt.ipleiria.estg.dei.carolo_farmaceutica;

import android.os.Bundle;
import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentTransaction;

public class ReceitaMedicaActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_receita_medica);

        carregarFragmentoReceitaMedica();
    }

    private void carregarFragmentoReceitaMedica() {
        ListaReceitaFragment receitaMedicaFragment = new ListaReceitaFragment();

        FragmentManager fragmentManager = getSupportFragmentManager();
        FragmentTransaction fragmentTransaction = fragmentManager.beginTransaction();
        fragmentTransaction.replace(R.id.lvReceitas, receitaMedicaFragment);
        fragmentTransaction.commit();
    }
}
