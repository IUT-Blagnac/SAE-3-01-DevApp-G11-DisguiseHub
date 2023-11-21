package groupe11.view;

import groupe11.control.VoirLesAlertes;
import groupe11.tools.AlertUtilities;
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

}
