package pt.ipleiria.estg.dei.carolo_farmaceutica.listeners;

public interface SubtotalListener {

    // Metódo quando é atualizado a quantidade do produto na linha do carrinho mostra o subtotal
    void onSubtotal(double subtotal);
}
