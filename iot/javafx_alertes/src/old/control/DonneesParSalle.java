package control;

import view.DisguiseHubAppController;
import view.DonneesParSalleController;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.layout.BorderPane;
import javafx.stage.Stage;

/**
 * Contrôleur pour la gestion des données par salle dans l'application
 * DisguiseHub.
 * Cette classe est responsable du chargement de l'interface utilisateur
 * associée
 * et de l'initialisation des composants nécessaires.
 */
public class DonneesParSalle {
    /**
     * Constructeur de la classe DonneesParSalle.
     * Charge l'interface utilisateur depuis le fichier FXML, applique la feuille de
     * style,
     * initialise le contrôleur associé et affiche la fenêtre de gestion des données
     * par salle.
     *
     * @param stage Stage dans lequel afficher la fenêtre de gestion des données par
     *              salle.
     */
    public DonneesParSalle(Stage stage) {
        try {

            // Chargement du source fxml
            FXMLLoader loader = new FXMLLoader(DisguiseHubAppController.class.getResource("DonneesParSalle.fxml"));
            BorderPane root = loader.load();

            // Paramétrage du Stage : feuille de style, titre
            Scene scene = new Scene(root, root.getPrefWidth() + 20, root.getPrefHeight() + 10);

            stage.setScene(scene);
            stage.setTitle("CaptOS - Données");
            stage.setResizable(false);

            DonneesParSalleController control = loader.getController();
            control.initContext(this, stage);

            control.displayDialog();

        } catch (Exception e) {
            e.printStackTrace();
            System.exit(-1);
        }
    }
}
