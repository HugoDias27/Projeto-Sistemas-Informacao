package pt.ipleiria.estg.dei.carolo_farmaceutica;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;

import com.google.android.material.floatingactionbutton.FloatingActionButton;

import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.CarrinhoListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.LinhaCarrinhoCompra;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.Medicamento;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.SingletonGestorFarmacia;
import pt.ipleiria.estg.dei.carolo_farmaceutica.utils.MedicamentosJsonParser;
import pt.ipleiria.estg.dei.carolo_farmaceutica.utils.ReceitaMedicaJsonParser;

public class DetalhesMedicamentoActivity extends AppCompatActivity implements CarrinhoListener {

    public static final String ID_MEDICAMENTO = "id";
    private TextView tvNomeMedicamento, tvPrescricaoMedica, tvPreco, tvQuantidadeMedicamento, tvCategoriaMedicamento, tvIvaMedicamento, tvQuantidadeCarrinho;
    private EditText etQuantidadeCarrinho;
    private Medicamento medicamento;
    private FloatingActionButton fabAdicionarProdutoCarrinho;
    public static final String USERNAME = "USERNAME";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detalhes_medicamento);

        tvQuantidadeCarrinho = findViewById(R.id.tvQuantidadeCarrinho);
        tvNomeMedicamento = findViewById(R.id.tvNomeMedicamento);
        tvPrescricaoMedica = findViewById(R.id.tvPrescricaoMedica);
        tvPreco = findViewById(R.id.tvPreco);
        tvQuantidadeMedicamento = findViewById(R.id.tvQuantidadeMedicamento);
        tvCategoriaMedicamento = findViewById(R.id.tvCategoriaMedicamento);
        tvIvaMedicamento = findViewById(R.id.tvIvaMedicamento);
        fabAdicionarProdutoCarrinho = findViewById(R.id.fabAdicionarProdutoCarrinho);
        etQuantidadeCarrinho = findViewById(R.id.etQuantidadeCarrinho);

        SingletonGestorFarmacia.getInstance(getApplicationContext()).setCarrinhoCompraListener(this);

        int id = getIntent().getIntExtra(ID_MEDICAMENTO, 0);
        if (id != 0) {
            medicamento = SingletonGestorFarmacia.getInstance(getApplicationContext()).getMedicamento(id);
            if (medicamento != null) {
                carregarMedicamento();
            } else
                finish();
        }

        if (MedicamentosJsonParser.isConnectionInternet(getApplicationContext())) {
            fabAdicionarProdutoCarrinho.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    if (medicamento != null && !etQuantidadeCarrinho.getText().toString().equals("0")) {
                        int quantidade = Integer.parseInt(etQuantidadeCarrinho.getText().toString());
                        SingletonGestorFarmacia.getInstance(getApplicationContext()).adicionarProdutoCarrinho(medicamento.getId(), quantidade, getApplicationContext());
                    } else {
                        Toast.makeText(getApplicationContext(), "A quantidade não pode ser igual ou inferior a 0!", Toast.LENGTH_SHORT).show();
                    }
                }
            });
        } else {
            fabAdicionarProdutoCarrinho.hide();
            etQuantidadeCarrinho.setVisibility(View.INVISIBLE);
            tvQuantidadeCarrinho.setVisibility(View.INVISIBLE);
            Toast.makeText(this, "Não tem ligação à internet. Ligue-se à internet para realizar compras", Toast.LENGTH_SHORT).show();
        }
    }

    private void carregarMedicamento() {
        tvNomeMedicamento.setText(medicamento.getNome());
        tvPrescricaoMedica.setText(medicamento.getPrescricaoMedica());
        tvPreco.setText(medicamento.getPreco() + "");
        tvQuantidadeMedicamento.setText(medicamento.getQuantidade() + "");
        tvCategoriaMedicamento.setText(medicamento.getCategoriaId());
        tvIvaMedicamento.setText(medicamento.getIvaId() + "");
    }

    @Override
    public void onRefreshCarrinho(boolean resposta) {
        if (resposta) {
            Toast.makeText(this, "Produto adicionado ao carrinho com sucesso!.", Toast.LENGTH_SHORT).show();
            SharedPreferences preferences = getSharedPreferences("LOGIN", Context.MODE_PRIVATE);
            String username = preferences.getString("USERNAME", "");
            Intent intent = new Intent(getApplicationContext(), MenuMainActivity.class);
            intent.putExtra(USERNAME, username);
            startActivity(intent);
        }
    }
}
