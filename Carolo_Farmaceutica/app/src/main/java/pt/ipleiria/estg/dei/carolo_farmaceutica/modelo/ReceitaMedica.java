package pt.ipleiria.estg.dei.carolo_farmaceutica.modelo;

import java.util.Date;

public class ReceitaMedica {

    private int id, codigo, user_id, dosagem, telefone;
    private String local_prescricao, valido, medico_prescicao, posologia, data_validade;

    public ReceitaMedica(int id, int codigo, String valido, int user_id, int dosagem, int telefone, String local_prescricao, String medico_prescicao, String posologia, String data_validade) {
        this.id = id;
        this.codigo = codigo;
        this.valido = valido;
        this.user_id = user_id;
        this.dosagem = dosagem;
        this.telefone = telefone;
        this.local_prescricao = local_prescricao;
        this.medico_prescicao = medico_prescicao;
        this.posologia = posologia;
        this.data_validade = data_validade;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getCodigo() {
        return codigo;
    }

    public void setCodigo(int codigo) {
        this.codigo = codigo;
    }

    public String getValido() {
        return valido;
    }

    public void setValido(String valido) {
        this.valido = valido;
    }

    public int getUserId() {
        return user_id;
    }

    public void setUserId(int user_id) {
        this.user_id = user_id;
    }

    public int getDosagem() {
        return dosagem;
    }

    public void setDosagem(int dosagem) {
        this.dosagem = dosagem;
    }

    public int getTelefone() {
        return telefone;
    }

    public void setTelefone(int telefone) {
        this.telefone = telefone;
    }

    public String getLocalPrescricao() {
        return local_prescricao;
    }

    public void setLocalPrescricao(String local_prescricao) {
        this.local_prescricao = local_prescricao;
    }

    public String getMedicoPrescricao() {
        return medico_prescicao;
    }

    public void setMedicoPrescricao(String medico_prescicao) {
        this.medico_prescicao = medico_prescicao;
    }

    public String getPosologia() {
        return posologia;
    }

    public void setPosologia(String posologia) {
        this.posologia = posologia;
    }

    public String getDataValidade() {
        return data_validade;
    }

    public void setDataValidade(String data_validade) {
        this.data_validade = data_validade;
    }
}
