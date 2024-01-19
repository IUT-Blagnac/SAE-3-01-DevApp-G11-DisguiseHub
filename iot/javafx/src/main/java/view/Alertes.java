package view;

import control.SceneBuilder;
import tools.AlertUtilities;
import tools.SceneController;
import javafx.fxml.FXML;
import javafx.scene.control.Alert.AlertType;
import javafx.stage.Stage;

/**
 * Contrôleur de la vue des alertes.
 * 
 * @see SceneController
 * @author BABELA Guychel
 * @version 2.0
 */
public class Alertes implements SceneController {
    private Stage alerte;

    /**
     * Initialise le contexte de la vue.
     * 
     * @param controller   Le controller de la vue.
     * @param primaryStage La fenêtre principale de l'application.
     */
    public void initContext(SceneBuilder controller, Stage primaryStage) {
        this.alerte = primaryStage;

        this.alerte.setOnCloseRequest(e -> {
            if (AlertUtilities.confirmYesCancel(this.alerte, "Quitter ?",
                "Voulez-vous fermer l'application ?", "", AlertType.CONFIRMATION)) {
                this.alerte.close();
            } else {
                e.consume();
            }
        });
    }

    /**
     * Affiche la vue.
     */
    public void displayDialog() {
        this.alerte.show();
    }

    /**
     * Affiche la vue de configuration.
     */
    @FXML
    private void ouvrirConfig() {
        new SceneBuilder().change(this.alerte, "config");
    }

    /**
     * Affiche la vue d'accueil.
     */
    @FXML
    private void ouvrirAccueil() {
        new SceneBuilder().change(this.alerte, "accueil");
    }

    /**
     * Affiche la vue des données.
     */
    @FXML
    private void ouvrirDonnees() {
        new SceneBuilder().change(this.alerte, "donnees");
    }
}
