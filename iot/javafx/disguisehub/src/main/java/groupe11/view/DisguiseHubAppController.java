package groupe11.view;

import groupe11.control.DisguiseHubApp;
import groupe11.control.DonneesParSalle;
import groupe11.control.FichierDeConfig;
import groupe11.control.VoirLesAlertes;
import groupe11.tools.AlertUtilities;
import javafx.animation.ScaleTransition;
import javafx.fxml.FXML;
import javafx.scene.control.Button;
import javafx.scene.control.Alert.AlertType;
import javafx.stage.Stage;
import javafx.util.Duration;

public class DisguiseHubAppController {

    private DisguiseHubApp disguisehubApp;
    private Stage primaryStage;

    @FXML
    private Button buttDonneesParSalle;

    @FXML
    private Button buttFichierDeConfig;

    @FXML
    private Button buttVoirLesAlerte;

    @FXML
    private Button buttQuitter;

    public void initContext(DisguiseHubApp disguisehubApp, Stage primaryStage) {
        this.disguisehubApp = disguisehubApp;
        this.primaryStage = primaryStage;

        this.primaryStage.setOnCloseRequest(e -> {
            if (AlertUtilities.confirmYesCancel(this.primaryStage, "confirmation",
                    "Voulez vous vraiment fermer la fenetre", "", AlertType.CONFIRMATION)) {
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

    private void ajouterTransition(Button bouton, double echelle, int duree) {
        ScaleTransition scaleInTransition = new ScaleTransition(Duration.millis(duree),
                bouton);
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
                "Voulez vous vraiment fermer la fenetre", "", AlertType.CONFIRMATION)) {
            this.primaryStage.close();
        }
    }

    @FXML
    private void doDonneesParSalle() {
        DonneesParSalle controller1 = new DonneesParSalle(primaryStage);
    }

    @FXML
    private void doFichierDeConfig() {
        FichierDeConfig controller2 = new FichierDeConfig(primaryStage);
    }

    @FXML
    private void doVoirLesAlerte() {
        VoirLesAlertes controller3 = new VoirLesAlertes(primaryStage);
    }
}
