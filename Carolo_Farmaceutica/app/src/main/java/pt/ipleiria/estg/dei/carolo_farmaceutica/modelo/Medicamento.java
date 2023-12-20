package pt.ipleiria.estg.dei.carolo_farmaceutica.modelo;

public class Medicamento {

    private int id, quantidade, iva_id;
    private String nome, categoria_id, prescricao_medica;
    private double preco;


    public Medicamento(int id, String nome, String prescricao_medica, double preco, int quantidade, String categoria_id, int iva_id) {
        this.id = id;
        this.nome = nome;
        this.prescricao_medica = prescricao_medica;
        this.preco = preco;
        this.quantidade = quantidade;
        this.categoria_id = categoria_id;
        this.iva_id = iva_id;

    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getNome() {
        return nome;
    }

    public void setNome(String nome) {
        this.nome = nome;
    }

    public String getPrescricaoMedica() {
        return prescricao_medica;
    }

    public void setPrescricaoMedica(String prescricao_medica) {
        this.prescricao_medica = prescricao_medica;
    }

    public double getPreco() {
        return preco;
    }

    public void setPreco(double preco) {
        this.preco = preco;
    }

    public int getQuantidade() {
        return quantidade;
    }

    public void setQuantidade(int quantidade) {
        this.quantidade = quantidade;
    }

    public String getCategoriaId() {
        return categoria_id;
    }

    public void setCategoriaId(String categoria_id) {
        this.categoria_id = categoria_id;
    }

    public int getIvaId() {
        return iva_id;
    }

    public void setIvaId(int iva_id) {
        this.iva_id = iva_id;
    }

}