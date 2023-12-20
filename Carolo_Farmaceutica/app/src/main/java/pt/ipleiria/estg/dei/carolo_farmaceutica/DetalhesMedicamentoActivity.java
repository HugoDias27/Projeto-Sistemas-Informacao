package pt.ipleiria.estg.dei.carolo_farmaceutica;

import android.content.Context;
import android.os.Bundle;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;

import com.google.android.material.floatingactionbutton.FloatingActionButton;

import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.Medicamento;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.SingletonGestorFarmacia;

public class DetalhesMedicamentoActivity extends AppCompatActivity {

    public static final String ID_MEDICAMENTO = "id";
    private TextView tvNomeMedicamento, tvPrescricaoMedica, tvPreco, tvQuantidadeMedicamento, tvCategoriaMedicamento, tvIvaMedicamento;
    private Medicamento medicamento;
    private FloatingActionButton fabAdicionarProdutoCarrinho;
    final Context context = this; // Armazena a referência da atividade na variável context

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detalhes_medicamento);

        tvNomeMedicamento = findViewById(R.id.tvNomeMedicamento);
        tvPrescricaoMedica = findViewById(R.id.tvPrescricaoMedica);
        tvPreco = findViewById(R.id.tvPreco);
        tvQuantidadeMedicamento = findViewById(R.id.tvQuantidadeMedicamento);
        tvCategoriaMedicamento = findViewById(R.id.tvCategoriaMedicamento);
        tvIvaMedicamento = findViewById(R.id.tvIvaMedicamento);
        fabAdicionarProdutoCarrinho = findViewById(R.id.fabAdicionarProdutoCarrinho);

        // SingletonGestorFarmacia.getInstance(getApplicationContext()).setMedicamentosListener(this);

        int id = getIntent().getIntExtra(ID_MEDICAMENTO, 0);
        if (id != 0) {
            medicamento = SingletonGestorFarmacia.getInstance(getApplicationContext()).getMedicamento(id);
            if (medicamento != null) {
                carregarMedicamento();
            } else
                finish();
        }

        fabAdicionarProdutoCarrinho.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
               // if (medicamento != null) {
                    // SingletonGestorFarmacia.getInstance(getApplicationContext()).adicionarProdutoCarrinho(medicamento);
                    Toast.makeText(context, "Botao adicionar ao carrinho.", Toast.LENGTH_SHORT).show();
               // }
            }
        });
    }

    private void carregarMedicamento() {
        tvNomeMedicamento.setText(medicamento.getNome());
        tvPrescricaoMedica.setText(medicamento.getPrescricaoMedica());
        tvPreco.setText(medicamento.getPreco() + "");
        tvQuantidadeMedicamento.setText(medicamento.getQuantidade() + "");
        tvCategoriaMedicamento.setText(medicamento.getCategoriaId());
        tvIvaMedicamento.setText(medicamento.getIvaId() + "");
    }
}
