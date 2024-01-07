package pt.ipleiria.estg.dei.carolo_farmaceutica.modelo;

public class Fatura {

    private int id;
    private String dta_emissao;
    private double valortotal, ivatotal;

    public Fatura(int id, String dta_emissao, double valortotal, double ivatotal) {
        this.id = id;
        this.dta_emissao = dta_emissao;
        this.valortotal = valortotal;
        this.ivatotal = ivatotal;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getDtaEmissao() {
        return dta_emissao;
    }

    public void setDtaEmissao(String dta_emissao) {
        this.dta_emissao = dta_emissao;
    }

    public double getValortotal() {
        return valortotal;
    }

    public void setValortotal(double valortotal) {
        this.valortotal = valortotal;
    }

    public double getIvatotal() {
        return ivatotal;
    }

    public void setIvatotal(double ivatotal) {
        this.ivatotal = ivatotal;
    }
}
