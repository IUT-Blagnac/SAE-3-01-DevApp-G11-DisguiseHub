package groupe11.view;

import groupe11.control.FichierDeConfig;
import groupe11.tools.AlertUtilities;
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

}
