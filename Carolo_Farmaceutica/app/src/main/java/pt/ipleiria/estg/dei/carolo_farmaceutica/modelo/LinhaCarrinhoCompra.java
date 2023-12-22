package pt.ipleiria.estg.dei.carolo_farmaceutica.modelo;

public class LinhaCarrinhoCompra {

    private int id, quantidade, carrinho_compra_id, produto_id;
    private double precounit, valoriva, valorcomiva, subtotal;

    public LinhaCarrinhoCompra(int id, int quantidade, double precounit, double valoriva, double valorcomiva, double subtotal, int carrinho_compra_id, int produto_id) {
        this.id = id;
        this.quantidade = quantidade;
        this.precounit = precounit;
        this.valoriva = valoriva;
        this.valorcomiva = valorcomiva;
        this.subtotal = subtotal;
        this.carrinho_compra_id = carrinho_compra_id;
        this.produto_id = produto_id;
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

    public int getCarrinho_compra_id() {
        return carrinho_compra_id;
    }

    public void setCarrinho_compra_id(int carrinho_compra_id) {
        this.carrinho_compra_id = carrinho_compra_id;
    }

    public int getProduto_id() {
        return produto_id;
    }

    public void setProduto_id(int produto_id) {
        this.produto_id = produto_id;
    }

    public double getPrecounit() {
        return precounit;
    }

    public void setPrecounit(double precounit) {
        this.precounit = precounit;
    }

    public double getValoriva() {
        return valoriva;
    }

    public void setValoriva(double valoriva) {
        this.valoriva = valoriva;
    }

    public double getValorcomiva() {
        return valorcomiva;
    }

    public void setValorcomiva(double valorcomiva) {
        this.valorcomiva = valorcomiva;
    }

    public double getSubtotal() {
        return subtotal;
    }

    public void setSubtotal(double subtotal) {
        this.subtotal = subtotal;
    }
}
