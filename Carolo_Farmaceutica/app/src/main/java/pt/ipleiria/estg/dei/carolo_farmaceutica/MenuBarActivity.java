package pt.ipleiria.estg.dei.carolo_farmaceutica;

import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.fragment.app.Fragment;

public class MenuBarActivity extends AppCompatActivity {



    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        Log.d("MenuBarActivity", "Inflating menu_app_bar.xml");
        getMenuInflater().inflate(R.menu.menu_app_bar, menu);
        return true;
    }



    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        Fragment fragment = null;
        int itemId = item.getItemId();

        if (itemId == R.id.action_carrinho) {
            fragment = new LinhaCarrinhoFragment();
        }

        if (fragment != null) {
            getSupportFragmentManager().beginTransaction().replace(R.id.contentFragment, fragment).commit();
            return true; // Fragment replaced, return true
        } else {
            // Handle other menu items if needed
            return super.onOptionsItemSelected(item);
        }
    }
}


