package view;

import tools.AlertUtilities;
import tools.SceneController;
import control.SceneBuilder;
import javafx.animation.ScaleTransition;
import javafx.fxml.FXML;
import javafx.scene.control.Button;
import javafx.scene.control.Alert.AlertType;
import javafx.stage.Stage;
import javafx.util.Duration;

/**
 * Contrôleur de la vue d'accueil.
 * 
 * @see SceneController
 * @author BABELA Guychel
 * @version 2.0
 */
public class Accueil implements SceneController {

    private Stage primaryStage;

    @FXML
    private Button buttDonneesParSalle;

    @FXML
    private Button buttFichierDeConfig;

    @FXML
    private Button buttVoirLesAlerte;

    @FXML
    private Button buttQuitter;

    /**
     * Initialise le contexte de la vue.
     * 
     * @param controller   Le controller de la vue.
     * @param primaryStage La fenêtre principale de l'application.
     */
    public void initContext(SceneBuilder controller, Stage primaryStage) {
        this.primaryStage = primaryStage;

        this.primaryStage.setOnCloseRequest(e -> {
            if (AlertUtilities.confirmYesCancel(this.primaryStage, "confirmation",
                "Voulez-vous fermer l'application ?", "", AlertType.CONFIRMATION)) {
                this.primaryStage.close();
            } else {
                e.consume();
            }
        });

        ajouterTransition(buttDonneesParSalle, 1.1, 150);
        ajouterTransition(buttFichierDeConfig, 1.1, 150);
        ajouterTransition(buttVoirLesAlerte, 1.1, 150);
        ajouterTransition(buttQuitter, 1.1, 150);

    }

    /**
     * Ajoute une transition sur un bouton.
     * 
     * @param bouton  Le bouton sur lequel ajouter la transition.
     * @param echelle L'échelle de la transition.
     * @param duree   La durée de la transition.
     */
    private void ajouterTransition(Button bouton, double echelle, int duree) {
        ScaleTransition scaleInTransition = new ScaleTransition(Duration.millis(duree), bouton);
        scaleInTransition.setToX(echelle);
        scaleInTransition.setToY(echelle);
        bouton.setOnMouseEntered(event -> {
            scaleInTransition.playFromStart();
        });

        ScaleTransition scaleOutTransition = new ScaleTransition(Duration.millis(duree),
                bouton);
        scaleOutTransition.setToX(1);
        scaleOutTransition.setToY(1);

        bouton.setOnMouseExited(event -> {
            scaleOutTransition.play();
        });

    }

    /**
     * Affiche la vue.
     */
    public void displayDialog() {
        this.primaryStage.show();
    }

    /**
     * Ferme la vue (avec confirmation)
     */
    @FXML
    private void doQuitter() {
        if (AlertUtilities.confirmYesCancel(this.primaryStage, "confirmation",
            "Voulez-vous fermer l'application ?", "", AlertType.CONFIRMATION)) {
            this.primaryStage.close();
        }
    }

    /**
     * Affiche la vue des données.
     */
    @FXML
    private void ouvrirDonnees() {
        new SceneBuilder().change(this.primaryStage, "donnees");
    }

    /**
     * Affiche la vue de configuration.
     */
    @FXML
    private void ouvrirConfig() {
        new SceneBuilder().change(this.primaryStage, "config");
    }

    /**
     * Affiche la vue des alertes.
     */
    @FXML
    private void ouvrirAlertes() {
        new SceneBuilder().change(this.primaryStage, "alertes");
    }
}
