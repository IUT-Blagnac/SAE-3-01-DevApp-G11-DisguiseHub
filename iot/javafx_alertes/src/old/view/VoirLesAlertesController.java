package view;

import control.DisguiseHubApp;
import control.DonneesParSalle;
import control.FichierDeConfig;
import control.VoirLesAlertes;
import tools.AlertUtilities;
import javafx.fxml.FXML;
import javafx.scene.control.Alert.AlertType;
import javafx.stage.Stage;

public class VoirLesAlertesController {
    private Stage alerte;

    public void initContext(VoirLesAlertes voirLesAlertes, Stage alerte) {
        this.alerte = alerte;

        this.alerte.setOnCloseRequest(e -> {
            if (AlertUtilities.confirmYesCancel(this.alerte, "confirmation",
                "Voulez-vous fermer l'application ?", "", AlertType.CONFIRMATION)) {
                this.alerte.close();
            } else {
                e.consume();
            }
        });
    }

    public void displayDialog() {
        this.alerte.show();
    }

    @FXML
    private void fichier() {
        new FichierDeConfig(alerte);
    }

    @FXML
    private void accueil() throws Exception {
        DisguiseHubApp cont = new DisguiseHubApp();
        cont.start(alerte);
    }

    @FXML
    private void salle() {
        new DonneesParSalle(alerte);
    }
}
