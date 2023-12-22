package pt.ipleiria.estg.dei.carolo_farmaceutica.modelo;

public class CarrinhoCompra {

    private String dta_venda;
    private int id, quantidade, cliente_id, fatura_id;
    private double valortotal, ivatotal;


    public CarrinhoCompra(int id, String dta_venda, int quantidade, double valortotal, double ivatotal, int cliente_id, int fatura_id) {
        this.id = id;
        this.dta_venda = dta_venda;
        this.quantidade = quantidade;
        this.valortotal = valortotal;
        this.ivatotal = ivatotal;
        this.cliente_id = cliente_id;
        this.fatura_id = fatura_id;

    }

    public String getDta_venda() {
        return dta_venda;
    }

    public void setDta_venda(String dta_venda) {
        this.dta_venda = dta_venda;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getQuantidade() {
        return quantidade;
    }

    public void setQuantidade(int quantidade) {
        this.quantidade = quantidade;
    }

    public int getCliente_id() {
        return cliente_id;
    }

    public void setCliente_id(int cliente_id) {
        this.cliente_id = cliente_id;
    }

    public int getFatura_id() {
        return fatura_id;
    }

    public void setFatura_id(int fatura_id) {
        this.fatura_id = fatura_id;
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
