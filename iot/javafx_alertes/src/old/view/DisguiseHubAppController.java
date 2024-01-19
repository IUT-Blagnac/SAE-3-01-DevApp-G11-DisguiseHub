package view;

import control.DisguiseHubApp;
import control.DonneesParSalle;
import control.FichierDeConfig;
import control.VoirLesAlertes;
import tools.AlertUtilities;
import javafx.animation.ScaleTransition;
import javafx.fxml.FXML;
import javafx.scene.control.Button;
import javafx.scene.control.Alert.AlertType;
import javafx.stage.Stage;
import javafx.util.Duration;

public class DisguiseHubAppController {

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
     * Initialise le contexte de l'application.
     * 
     * @param disguisehubApp
     * @param primaryStage
     */
    public void initContext(DisguiseHubApp disguisehubApp, Stage primaryStage) {
        this.primaryStage = primaryStage;

        this.primaryStage.setOnCloseRequest(e -> {
            if (AlertUtilities.confirmYesCancel(this.primaryStage, "confirmation",
                "Voulez-vous fermer l'application ?", "", AlertType.CONFIRMATION)) {
                this.primaryStage.close();
            } else {
                e.consume();
            }
        });

        ajouterTransition(buttDonneesParSalle, 1.15, 150);
        ajouterTransition(buttFichierDeConfig, 1.15, 150);
        ajouterTransition(buttVoirLesAlerte, 1.15, 150);
        ajouterTransition(buttQuitter, 1.15, 150);

    }

    /**
     * Ajoute une transition sur un bouton.
     * 
     * @param bouton
     * @param echelle
     * @param duree
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

    public void displayDialog() {
        this.primaryStage.show();
    }

    @FXML
    private void doQuitter() {
        if (AlertUtilities.confirmYesCancel(this.primaryStage, "confirmation",
            "Voulez-vous fermer l'application ?", "", AlertType.CONFIRMATION)) {
            this.primaryStage.close();
        }
    }

    @FXML
    private void doDonneesParSalle() {
        new DonneesParSalle(primaryStage);
    }

    @FXML
    private void doFichierDeConfig() {
        new FichierDeConfig(primaryStage);
    }

    @FXML
    private void doVoirLesAlerte() {
        new VoirLesAlertes(primaryStage);
    }
}
