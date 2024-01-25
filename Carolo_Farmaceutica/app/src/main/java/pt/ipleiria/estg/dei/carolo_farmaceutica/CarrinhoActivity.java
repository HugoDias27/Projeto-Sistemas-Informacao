package pt.ipleiria.estg.dei.carolo_farmaceutica;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentTransaction;

import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.CheckoutListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.SingletonGestorFarmacia;


public class CarrinhoActivity extends AppCompatActivity {

    // Método para carregar a atividade do carrinho de compras
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_carrinho);

        carregarFragmentoCarrinho();
    }

    // Método para carregar o fragmento do carrinho de compras
    private void carregarFragmentoCarrinho() {
        LinhaCarrinhoFragment linhacarrinhoFragment = new LinhaCarrinhoFragment();

        FragmentManager fragmentManager = getSupportFragmentManager();
        FragmentTransaction fragmentTransaction = fragmentManager.beginTransaction();

        fragmentTransaction.replace(R.id.fragmentContainer, linhacarrinhoFragment);

        fragmentTransaction.commit();
    }
}
