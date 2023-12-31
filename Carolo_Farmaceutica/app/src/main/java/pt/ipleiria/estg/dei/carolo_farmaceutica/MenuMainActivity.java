package pt.ipleiria.estg.dei.carolo_farmaceutica;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;


import androidx.annotation.NonNull;
import androidx.appcompat.app.ActionBarDrawerToggle;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;
import android.widget.Button;



import com.google.android.material.navigation.NavigationView;

public class MenuMainActivity extends AppCompatActivity implements NavigationView.OnNavigationItemSelectedListener {

    private NavigationView navigationView;
    private DrawerLayout drawer;
    private String username;

    private FragmentManager fragmentManager;

    private static final String USERNAME = "USERNAME";

    public static final int ADD=100, EDIT=200, DELETE=300;
    public static final String OP_CODE = "op_detalhes";


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_menu_main);

        Toolbar toolbar = findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        drawer = findViewById(R.id.drawerLayout);
        navigationView = findViewById(R.id.navView);

        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(this, drawer, toolbar, R.string.open, R.string.close);
        toggle.syncState();
        drawer.addDrawerListener(toggle);

        carregarCabecalho();


        navigationView.setNavigationItemSelectedListener(this);

        fragmentManager = getSupportFragmentManager();
        carregarFragmentoInicial();

    }

      private void openSettingsFragment() {
        getSupportFragmentManager().beginTransaction().replace(R.id.contentFragment, new SettingsFragment()).addToBackStack(null).commit();
    }

    private boolean carregarFragmentoInicial() {
        Menu menu = navigationView.getMenu();

        MenuItem menuItem = menu.getItem(0);
        menuItem.setChecked(true);
        return onNavigationItemSelected(menuItem);
    }

    private void carregarCabecalho() {
        Intent intent = getIntent();
        username = intent.getStringExtra(LoginActivity.USERNAME);
        SharedPreferences sharedPreferences = getSharedPreferences("DADOS_USER", Context.MODE_PRIVATE);

        if (username != null) {
            SharedPreferences.Editor editUser = sharedPreferences.edit();
            editUser.putString(USERNAME, username);
            editUser.apply();

            View hview = navigationView.getHeaderView(0);
            TextView tvUsername = hview.findViewById(R.id.tvUsername);
            tvUsername.setText(username);
        } else {
            username = sharedPreferences.getString(USERNAME, "Sem username");
        }
    }


    @Override
    public boolean onNavigationItemSelected(@NonNull MenuItem item) {
        Fragment fragment = null;
        if (item.getItemId() == R.id.navProduto) {
            fragment = new ListaMedicamentoFragment();
            setTitle(item.getTitle());
        } else if (item.getItemId() == R.id.navLocalizacao) {
            Toast.makeText(this, "Localização", Toast.LENGTH_SHORT).show();
        } else if (item.getItemId() == R.id.navReceitaMedica) {
            fragment = new ListaReceitaFragment();
            setTitle(item.getTitle());
        } else if (item.getItemId() == R.id.navDesconto) {
            fragment = new DescontosFragment();
        }
          else if (item.getItemId() == R.id.navSettings){
            fragment = new SettingsFragment();
        }
          else if (item.getItemId() == R.id.navCarrinho){
            fragment = new LinhaCarrinhoFragment();
            setTitle(item.getTitle());
        }

        if (fragment != null)
            fragmentManager.beginTransaction().replace(R.id.contentFragment, fragment).commit();

        drawer.closeDrawer(GravityCompat.START);
        return true;
    }
}
