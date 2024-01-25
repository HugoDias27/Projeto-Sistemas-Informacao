package pt.ipleiria.estg.dei.carolo_farmaceutica;

import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import com.google.android.material.floatingactionbutton.FloatingActionButton;

import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.ReceitaMedica;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.SingletonGestorFarmacia;

public class DetalhesReceitaActivity extends AppCompatActivity {

    // Declaração de variáveis
    public static final String ID_RECEITA = "id";
    private TextView tvCodigo, tvLocalPrescricao, tvMedicoPrescricao, tvDosagem, tvDataValidade, tvTelefone, tvValido, tvPosologia;
    private ReceitaMedica receitaMedica;

    // Método para carregar a atividade dos detalhes da receita médica
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detalhes_receita);

        tvCodigo = findViewById(R.id.tvCodigo);
        tvLocalPrescricao = findViewById(R.id.tvLocalPrescricao);
        tvMedicoPrescricao = findViewById(R.id.tvMedicoPrescricao);
        tvDosagem = findViewById(R.id.tvDosagem);
        tvDataValidade = findViewById(R.id.tvDataValidade);
        tvTelefone = findViewById(R.id.tvTelefone);
        tvValido = findViewById(R.id.tvValido);
        tvPosologia = findViewById(R.id.tvPosologia);

        int id = getIntent().getIntExtra(ID_RECEITA, 0);
        if (id != 0) {
            receitaMedica = SingletonGestorFarmacia.getInstance(getApplicationContext()).getReceitaMedica(id);
            if (receitaMedica != null) {
                carregarReceitaMedica();
            } else
                finish();
        }
    }

    // Método para carregar os detalhes da receita médica
    private void carregarReceitaMedica() {
        tvCodigo.setText(receitaMedica.getCodigo() + "");
        tvLocalPrescricao.setText(receitaMedica.getLocalPrescricao());
        tvMedicoPrescricao.setText(receitaMedica.getMedicoPrescricao());
        tvDosagem.setText(receitaMedica.getDosagem() + "");
        tvDataValidade.setText(receitaMedica.getDataValidade() + "");
        tvTelefone.setText(receitaMedica.getTelefone() + "");
        tvValido.setText(receitaMedica.getValido() + "");
        tvPosologia.setText(receitaMedica.getPosologia());
    }
}
