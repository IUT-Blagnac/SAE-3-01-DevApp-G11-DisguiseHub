package groupe11.view;

import groupe11.control.DisguiseHubApp;
import groupe11.control.DonneesParSalle;
import groupe11.control.FichierDeConfig;
import groupe11.control.VoirLesAlertes;
import groupe11.tools.AlertUtilities;
import javafx.fxml.FXML;
import javafx.scene.control.Alert.AlertType;
import javafx.stage.Stage;

public class VoirLesAlertesController {
    private VoirLesAlertes voirLesAlertes;
    private Stage alerte;

    public void initContext(VoirLesAlertes voirLesAlertes, Stage alerte) {
        this.voirLesAlertes = voirLesAlertes;
        this.alerte = alerte;

        this.alerte.setOnCloseRequest(e -> {
            if (AlertUtilities.confirmYesCancel(this.alerte, "confirmation",
                    "Voulez vous vraiment fermer la fenetre", "", AlertType.CONFIRMATION)) {
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
        FichierDeConfig controller = new FichierDeConfig(alerte);
    }

    @FXML
    private void accueil() throws Exception {
        DisguiseHubApp cont = new DisguiseHubApp();
        cont.start(alerte);
    }

    @FXML
    private void salle() {
        DonneesParSalle controller = new DonneesParSalle(alerte);
    }
}
