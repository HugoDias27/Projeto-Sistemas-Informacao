package pt.ipleiria.estg.dei.carolo_farmaceutica.modelo;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

import androidx.annotation.Nullable;

import java.util.ArrayList;

public class FarmaciaBDHelper extends SQLiteOpenHelper {
    private static final int DB_VERSION = 1;
    private static final String DB_NAME = "BDCaroloFarmaceutica", TABLE_PRODUTO = "produtos", TABLE_RECEITA = "receitamedica", TABLE_USER = "user";
    private static final String ID = "id", NOME = "nome", PRESCRICAO_MEDICA = "prescricao_medica", PRECO = "preco", QUANTIDADE = "quantidade", CATEGORIA_ID = "categoria_id", IVA_ID = "iva_id";
    private static final String CODIGO = "codigo", LOCAL_PRESCRICAO = "local_prescricao", MEDICO_PRESCRICAO = "medico_prescricao", DOSAGEM = "dosagem", DATA_VALIDADE = "data_validade", TELEFONE = "telefone", VALIDO = "valido", POSOLOGIA = "posologia", USER_ID = "user_id";
    private static final String USERNAME = "username", EMAIL = "email", IMAGENS = "imagens";

    private final SQLiteDatabase db;

    public FarmaciaBDHelper(@Nullable Context context) {
        super(context, DB_NAME, null, DB_VERSION);

        this.db = getWritableDatabase();
    }

    @Override
    public void onCreate(SQLiteDatabase sqLiteDatabase) {
        String sqlCreateTableProduto = "CREATE TABLE " + TABLE_PRODUTO + "(" +
                ID + " INTEGER PRIMARY KEY, " +
                NOME + " TEXT NOT NULL, " +
                PRESCRICAO_MEDICA + " TEXT, " +
                PRECO + " REAL NOT NULL, " +
                QUANTIDADE + " INTEGER NOT NULL, " +
                CATEGORIA_ID + " TEXT, " +
                IVA_ID + " INTEGER NOT NULL, " +
                IMAGENS + " TEXT NOT NULL);";
        sqLiteDatabase.execSQL(sqlCreateTableProduto);

        String sqlCreateTableReceita = "CREATE TABLE " + TABLE_RECEITA + "(" +
                ID + " INTEGER PRIMARY KEY, " +
                CODIGO + " INTEGER NOT NULL, " +
                LOCAL_PRESCRICAO + " TEXT NOT NULL, " +
                MEDICO_PRESCRICAO + " TEXT NOT NULL, " +
                DOSAGEM + " INTEGER NOT NULL, " +
                DATA_VALIDADE + " TEXT NOT NULL, " +
                TELEFONE + " INTEGER NOT NULL, " +
                VALIDO + " TEXT NOT NULL, " +
                POSOLOGIA + " TEXT NOT NULL, " +
                USER_ID + " INTEGER NOT NULL);";
        sqLiteDatabase.execSQL(sqlCreateTableReceita);

        String sqlCreateTableUser = "CREATE TABLE " + TABLE_USER + "(" +
                ID + " INTEGER PRIMARY KEY, " +
                USERNAME + " TEXT NOT NULL, " +
                EMAIL + " TEXT NOT NULL);";
        sqLiteDatabase.execSQL(sqlCreateTableUser);

    }

    @Override
    public void onUpgrade(SQLiteDatabase sqLiteDatabase, int i, int i1) {
        sqLiteDatabase.execSQL("DROP TABLE IF EXISTS " + TABLE_PRODUTO);
        this.onCreate(sqLiteDatabase);
    }

    public void adicionarMedicamentoBD(Medicamento medicamento) {
        ContentValues values = new ContentValues();
        values.put(ID, medicamento.getId());
        values.put(NOME, medicamento.getNome());
        values.put(PRESCRICAO_MEDICA, medicamento.getPrescricaoMedica());
        values.put(PRECO, medicamento.getPreco());
        values.put(QUANTIDADE, medicamento.getQuantidade());
        values.put(CATEGORIA_ID, medicamento.getCategoriaId());
        values.put(IVA_ID, medicamento.getIvaId());
        values.put(IMAGENS, medicamento.getImagem());


        this.db.insert(TABLE_PRODUTO, null, values);

    }

    public void editarMedicamentoBD(Medicamento medicamento) {
        ContentValues values = new ContentValues();
        values.put(NOME, medicamento.getNome());
        values.put(PRESCRICAO_MEDICA, medicamento.getPrescricaoMedica());
        values.put(PRECO, medicamento.getPreco());
        values.put(QUANTIDADE, medicamento.getQuantidade());
        values.put(CATEGORIA_ID, medicamento.getCategoriaId());
        values.put(IVA_ID, medicamento.getIvaId());


        this.db.update(TABLE_PRODUTO, values, ID + " = ?", new String[]{String.valueOf(medicamento.getId())});
    }

    public void removerMedicamentoBD(Medicamento medicamento) {
        this.db.delete(TABLE_PRODUTO, ID + " = ?", new String[]{String.valueOf(medicamento.getId())});
    }

    public ArrayList<Medicamento> getAllMedicamentosBD() {
        ArrayList<Medicamento> medicamentos = new ArrayList<>();
        Cursor cursor = this.db.query(TABLE_PRODUTO, new String[]{ID, NOME, PRESCRICAO_MEDICA, PRECO, QUANTIDADE, CATEGORIA_ID, IVA_ID, IMAGENS}, null, null, null, null, null);

        if (cursor.moveToFirst()) {
            do {
                int id = cursor.getInt(0);
                String nome = cursor.getString(1);
                String prescricaoMedica = cursor.getString(2);
                double preco = cursor.getDouble(3);
                int quantidade = cursor.getInt(4);
                String categoriaId = cursor.getString(5);
                int ivaId = cursor.getInt(6);
                String imagens = cursor.getString(7);

                // Cria o objeto Medicamento com os dados e a lista de imagens
                Medicamento medicamento = new Medicamento(id, nome, prescricaoMedica, preco, quantidade, categoriaId, ivaId, imagens);
                medicamentos.add(medicamento);
            } while (cursor.moveToNext());
        }

        cursor.close();
        return medicamentos;
    }


    public void removerAllMedicamentosBD() {
        this.db.delete(TABLE_PRODUTO, null, null);
    }

    public void adicionarReceitaMedicaBD(ReceitaMedica receita) {
        ContentValues values = new ContentValues();
        values.put(ID, receita.getId());
        values.put(CODIGO, receita.getCodigo());
        values.put(LOCAL_PRESCRICAO, receita.getLocalPrescricao());
        values.put(MEDICO_PRESCRICAO, receita.getMedicoPrescricao());
        values.put(DOSAGEM, receita.getDosagem());
        values.put(DATA_VALIDADE, receita.getDataValidade());
        values.put(TELEFONE, receita.getTelefone());
        values.put(VALIDO, receita.getValido());
        values.put(POSOLOGIA, receita.getPosologia());
        values.put(USER_ID, receita.getUserId());

        this.db.insert(TABLE_RECEITA, null, values);
    }

    public ArrayList<ReceitaMedica> getAllReceitaMedicaBD() {
        ArrayList<ReceitaMedica> receitas = new ArrayList<>();
        Cursor cursor = this.db.query(TABLE_RECEITA, new String[]{ID, CODIGO, LOCAL_PRESCRICAO, MEDICO_PRESCRICAO, DOSAGEM, DATA_VALIDADE, TELEFONE, VALIDO, POSOLOGIA, USER_ID}, null, null, null, null, null);
        if (cursor.moveToFirst()) {
            do {
                ReceitaMedica receita = new ReceitaMedica(cursor.getInt(0), cursor.getInt(1), cursor.getString(2), cursor.getString(3), cursor.getInt(4), cursor.getString(5), cursor.getInt(6), cursor.getString(7), cursor.getString(8), cursor.getInt(9));
                receitas.add(receita);
            } while (cursor.moveToNext());
        }
        cursor.close();
        return receitas;
    }


    public void removerAllReceitaMedicaBD() {
        this.db.delete(TABLE_RECEITA, null, null);
    }

    public ArrayList<User> getAllUserBD() {
        ArrayList<User> users = new ArrayList<>();
        Cursor cursor = this.db.query(TABLE_USER, new String[]{ID, USERNAME, EMAIL}, null, null, null, null, null);
        if (cursor.moveToFirst()) {
            do {
                User user = new User(cursor.getInt(0), cursor.getString(1), cursor.getString(2));
                users.add(user);
            } while (cursor.moveToNext());
        }
        cursor.close();
        return users;
    }

    public void adicionarUserBD(User user) {
        ContentValues values = new ContentValues();
        values.put(ID, user.getId());
        values.put(USERNAME, user.getUsername());
        values.put(EMAIL, user.getEmail());

        this.db.insert(TABLE_USER, null, values);
    }

    public ArrayList<Medicamento> getMedicamentosCategoriaBD(String nomeCategoria) {
        ArrayList<Medicamento> medicamentos = new ArrayList<>();

        String query = "SELECT * FROM " + TABLE_PRODUTO + " WHERE " + NOME + " LIKE ? AND " + CATEGORIA_ID + " = ?";
        String[] selectionArgs = {"%", nomeCategoria};

        Cursor cursor = db.rawQuery(query, selectionArgs);

        if (cursor.moveToFirst()) {
            do {
                int id = cursor.getInt(0);
                String nome = cursor.getString(1);
                String prescricaoMedica = cursor.getString(2);
                double preco = cursor.getDouble(3);
                int quantidade = cursor.getInt(4);
                String categoriaId = cursor.getString(5);
                int ivaId = cursor.getInt(6);
                String imagens = cursor.getString(7);

                Medicamento medicamento = new Medicamento(id, nome, prescricaoMedica, preco, quantidade, categoriaId, ivaId, imagens);
                medicamentos.add(medicamento);
            } while (cursor.moveToNext());
        }

        cursor.close();
        return medicamentos;
    }
}
