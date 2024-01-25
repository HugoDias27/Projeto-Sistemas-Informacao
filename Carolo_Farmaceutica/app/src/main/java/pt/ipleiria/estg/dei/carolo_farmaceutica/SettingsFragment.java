package pt.ipleiria.estg.dei.carolo_farmaceutica;

import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.SingletonGestorFarmacia;

public class SettingsFragment extends Fragment {

    // Declaração de variáveis
    private TextView tvIp;
    private EditText etIp;
    private Button btMudarIp;

    // Construtor
    public SettingsFragment() {
        // Required empty public constructor
    }

    // Método para carregar o fragmento das definições
    @Override
    public View onCreateView( LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_settings, container, false);

        etIp = view.findViewById(R.id.etIp);
        btMudarIp = view.findViewById(R.id.btMudarIp);

        btMudarIp.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                GuardarIp();
                Intent intent = new Intent(getContext(), LoginActivity.class);
                startActivity(intent);
                }
            });
            return view;
        }

    // Método para guardar o IP
    private void GuardarIp() {
        String ip = etIp.getText().toString();

        SingletonGestorFarmacia.getInstance(getContext()).setIpAddress(ip);
        Toast.makeText(getContext(), R.string.txt_ip_alterado, Toast.LENGTH_SHORT).show();
    }
}
