package groupe11.view;

import groupe11.control.DisguiseHubApp;
import groupe11.control.DonneesParSalle;
import groupe11.control.FichierDeConfig;
import groupe11.control.VoirLesAlertes;
import groupe11.tools.AlertUtilities;
import javafx.fxml.FXML;
import javafx.scene.control.Alert.AlertType;
import javafx.stage.Stage;

public class DonneesParSalleController {
    private DonneesParSalle donneesParSalle;
    private Stage stage;

    public void initContext(DonneesParSalle donneesParSalle, Stage stage) {
        this.donneesParSalle = donneesParSalle;
        this.stage = stage;

        this.stage.setOnCloseRequest(e -> {
            if (AlertUtilities.confirmYesCancel(this.stage, "confirmation",
                    "Voulez vous vraiment fermer la fenetre", "", AlertType.CONFIRMATION)) {
                this.stage.close();
            } else {
                e.consume();
            }
        });

    }

    public void displayDialog() {
        this.stage.show();
    }

    @FXML
    private void fichier() {
        FichierDeConfig controller = new FichierDeConfig(stage);
    }

    @FXML
    private void alerte() {
        VoirLesAlertes controller = new VoirLesAlertes(stage);
    }

    @FXML
    private void accueil() throws Exception {
        DisguiseHubApp cont = new DisguiseHubApp();
        cont.start(stage);
    }

}