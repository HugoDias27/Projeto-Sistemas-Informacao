package pt.ipleiria.estg.dei.carolo_farmaceutica;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentTransaction;

import android.view.LayoutInflater;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.SearchView;
import android.widget.Toast;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.adaptadores.ListaMedicamentoAdaptador;
import pt.ipleiria.estg.dei.carolo_farmaceutica.listeners.MedicamentosListener;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.Medicamento;
import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.SingletonGestorFarmacia;


public class ListaMedicamentoFragment extends Fragment implements MedicamentosListener {

    // Declaração de variáveis
    private ListView lvMedicamentos;
    private SearchView searchView;
    private FragmentManager fragmentManager;

    // Construtor
    public ListaMedicamentoFragment() {
        // Required empty public constructor
    }

    // Método para carregar o fragmento da lista dos medicamentos
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {

        View view = inflater.inflate(R.layout.fragment_lista_medicamento, container, false);
        setHasOptionsMenu(true);
        lvMedicamentos = view.findViewById(R.id.lvMedicamentos);

        SingletonGestorFarmacia.getInstance(getContext()).setMedicamentosListener(this);
        SingletonGestorFarmacia.getInstance(getContext()).getAllMedicamentosAPI(getContext());

        lvMedicamentos.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int position, long id) {
                Intent intent = new Intent(getContext(), DetalhesMedicamentoActivity.class);
                intent.putExtra(DetalhesMedicamentoActivity.ID_MEDICAMENTO, (int) id);
                startActivity(intent);
            }
        });

        fragmentManager = requireActivity().getSupportFragmentManager();

        return view;
    }

    // Método para carregar o menu de pesquisa e o menu de categorias
    @Override
    public void onCreateOptionsMenu(android.view.Menu menu, MenuInflater inflater) {
        inflater.inflate(R.menu.menu_pesquisa, menu);
        inflater.inflate(R.menu.menu_categoria, menu);
        super.onCreateOptionsMenu(menu, inflater);

        MenuItem itemPesquisa = menu.findItem(R.id.itemPesquisa);
        searchView = (SearchView) itemPesquisa.getActionView();
        searchView.setOnQueryTextListener(new SearchView.OnQueryTextListener() {
            @Override
            public boolean onQueryTextSubmit(String newText) {
                return false;
            }

            @Override
            public boolean onQueryTextChange(String newText) {
                ArrayList<Medicamento> listaMedicamentos = new ArrayList<>();
                for (Medicamento medicamento : SingletonGestorFarmacia.getInstance(getContext()).getMedicamentosBD()) {
                    if (medicamento.getNome().toLowerCase().contains(newText.toLowerCase())) {
                        listaMedicamentos.add(medicamento);
                    }
                }
                lvMedicamentos.setAdapter(new ListaMedicamentoAdaptador(getContext(), listaMedicamentos));
                return true;
            }
        });

        MenuItem categoriaOral = menu.findItem(R.id.categoriaOral);
        MenuItem categoriaBeleza = menu.findItem(R.id.categoriaBeleza);
        MenuItem categoriaHigiene = menu.findItem(R.id.categoriaHigiene);

        categoriaOral.setOnMenuItemClickListener(new MenuItem.OnMenuItemClickListener() {
            @Override
            public boolean onMenuItemClick(MenuItem menuItem) {
                String nomeCategoria = getString(R.string.txt_titulo_saude_oral);
                String nomeCategoriaTitulo = getString(R.string.txt_saude_oral);

                SharedPreferences sharedPreferences = getActivity().getSharedPreferences("NOME_CATEGORIA", Context.MODE_PRIVATE);
                SharedPreferences.Editor editor = sharedPreferences.edit();
                editor.putString("nome_categoria", nomeCategoria);
                editor.apply();

                Fragment fragment = new ListaProdutoCategoriaFragment();
                Bundle args = new Bundle();
                args.putString("nome_categoria", nomeCategoriaTitulo);
                fragment.setArguments(args);
                fragmentManager.beginTransaction().replace(R.id.contentFragment, fragment).commit();
                return true;
            }
        });

        categoriaBeleza.setOnMenuItemClickListener(new MenuItem.OnMenuItemClickListener() {
            @Override
            public boolean onMenuItemClick(MenuItem menuItem) {
                String nomeCategoria = getString(R.string.txt_titulo_bens_beleza);
                String nomeCategoriaTitulo = getString(R.string.txt_bens_beleza);

                SharedPreferences sharedPreferences = getActivity().getSharedPreferences("NOME_CATEGORIA", Context.MODE_PRIVATE);
                SharedPreferences.Editor editor = sharedPreferences.edit();
                editor.putString("nome_categoria", nomeCategoria);
                editor.apply();

                Fragment fragment = new ListaProdutoCategoriaFragment();
                Bundle args = new Bundle();
                args.putString("nome_categoria", nomeCategoriaTitulo);
                fragment.setArguments(args);
                fragmentManager.beginTransaction().replace(R.id.contentFragment, fragment).commit();
                return true;
            }
        });

        categoriaHigiene.setOnMenuItemClickListener(new MenuItem.OnMenuItemClickListener() {
            @Override
            public boolean onMenuItemClick(MenuItem menuItem) {
                String nomeCategoria = getString(R.string.txt_titulo_higiene);
                String nomeCategoriaTitulo = getString(R.string.txt_higiene);;

                SharedPreferences sharedPreferences = getActivity().getSharedPreferences("NOME_CATEGORIA", Context.MODE_PRIVATE);
                SharedPreferences.Editor editor = sharedPreferences.edit();
                editor.putString("nome_categoria", nomeCategoria);
                editor.apply();

                Fragment fragment = new ListaProdutoCategoriaFragment();
                Bundle args = new Bundle();
                args.putString("nome_categoria", nomeCategoriaTitulo);
                fragment.setArguments(args);
                fragmentManager.beginTransaction().replace(R.id.contentFragment, fragment).commit();
                return true;
            }
        });
    }

    // Método para carregar os medicamentos
    @Override
    public void onRefreshListaMedicamento(ArrayList<Medicamento> listaMedicamentos) {
        if(listaMedicamentos != null) {
            lvMedicamentos.setAdapter(new ListaMedicamentoAdaptador(getContext(), listaMedicamentos));
        }
    }
}