package control;

import view.DisguiseHubAppController;
import view.VoirLesAlertesController;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.layout.BorderPane;
import javafx.stage.Stage;

/**
 * Contrôleur responsable de la gestion des alertes dans l'application
 * DisguiseHub.
 * Cette classe charge l'interface utilisateur associée à la gestion des alertes
 * depuis un fichier FXML,
 * initialise les composants nécessaires, et affiche la fenêtre de gestion des
 * alertes.
 */
public class VoirLesAlertes {
    /**
     * Constructeur de la classe VoirLesAlertes.
     * Charge l'interface utilisateur depuis le fichier FXML, applique la feuille de
     * style,
     * initialise le contrôleur associé, et affiche la fenêtre de gestion des
     * alertes.
     *
     * @param alerte Stage dans lequel afficher la fenêtre de gestion des alertes.
     */
    public VoirLesAlertes(Stage alerte) {
        try {

            // Chargement du source fxml
            FXMLLoader loader = new FXMLLoader(DisguiseHubAppController.class.getResource("VoirLesAlertes.fxml"));
            BorderPane root = loader.load();

            // Paramétrage du Stage : feuille de style, titre
            Scene scene = new Scene(root, root.getPrefWidth() + 20, root.getPrefHeight() + 10);

            alerte.setScene(scene);
            alerte.setTitle("CaptOS - Alertes");
            alerte.setResizable(false);

            VoirLesAlertesController control = loader.getController();
            control.initContext(this, alerte);

            control.displayDialog();

        } catch (Exception e) {
            e.printStackTrace();
            System.exit(-1);
        }

    }
}
