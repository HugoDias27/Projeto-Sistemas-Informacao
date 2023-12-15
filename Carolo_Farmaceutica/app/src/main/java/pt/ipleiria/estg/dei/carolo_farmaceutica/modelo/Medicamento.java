package pt.ipleiria.estg.dei.carolo_farmaceutica.modelo;

public class Medicamento {

    private int id, quantidade, iva_id;
    private String nome, categoria_id;
    private int prescricao_medica;
    private double preco;


public Medicamento(int id, String nome, int prescricao_medica, double preco, int quantidade, String categoria_id, int iva_id ) {
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
     public int getPrescricao_medica() {
        return prescricao_medica;
    }

    public void setPrescricao_medica(int prescricao_medica) {
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

     public String getCategoria_id() {
        return categoria_id;
    }

    public void setCategoria_id(String categoria_id) {
        this.categoria_id = categoria_id;
    }

     public int getIva_id() {
        return iva_id;
    }

    public void setIva_id(int iva_id) {
        this.iva_id = iva_id;
    }

}