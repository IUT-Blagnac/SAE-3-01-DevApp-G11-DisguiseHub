package groupe11.view;

import groupe11.control.DisguiseHubApp;
import groupe11.control.DonneesParSalle;
import groupe11.control.FichierDeConfig;
import groupe11.control.VoirLesAlertes;
import groupe11.tools.AlertUtilities;
import javafx.fxml.FXML;
import javafx.scene.control.Alert.AlertType;
import javafx.stage.Stage;

public class FichierDeConfigController {
    private FichierDeConfig fichierDeConfig;
    private Stage config;

    public void initContext(FichierDeConfig fichierDeConfig, Stage config) {
        this.fichierDeConfig = fichierDeConfig;
        this.config = config;

        this.config.setOnCloseRequest(e -> {
            if (AlertUtilities.confirmYesCancel(this.config, "confirmation",
                    "Voulez vous vraiment fermer la fenetre", "", AlertType.CONFIRMATION)) {
                this.config.close();
            } else {
                e.consume();
            }
        });

    }

    public void displayDialog() {
        this.config.show();
    }

    @FXML
    private void salle() {
        DonneesParSalle controller = new DonneesParSalle(config);
    }

    @FXML
    private void alerte() {
        VoirLesAlertes controller = new VoirLesAlertes(config);
    }

    @FXML
    private void accueil() throws Exception {
        DisguiseHubApp cont = new DisguiseHubApp();
        cont.start(config);
    }
}
