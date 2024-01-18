package pt.ipleiria.estg.dei.carolo_farmaceutica.listeners;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.carolo_farmaceutica.modelo.User;

public interface LoginListener {

    // Método quando é realizado o login
    void onRefreshLogin(String token);
}
