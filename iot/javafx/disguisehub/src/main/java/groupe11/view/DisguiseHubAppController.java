package groupe11.view;

import groupe11.control.DisguiseHubApp;
import groupe11.tools.AlertUtilities;
import javafx.fxml.FXML;
import javafx.scene.control.Button;
import javafx.scene.control.Alert.AlertType;
import javafx.stage.Stage;

public class DisguiseHubAppController {

    private DisguiseHubApp disguisehubApp;
    private Stage primaryStage;

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

    }

    public void displayDialog() {
        this.primaryStage.show();
    }

    @FXML
    private void Quitter() {
        if (AlertUtilities.confirmYesCancel(this.primaryStage, "confirmation",
                "Voulez vous vraiment fermer la fenetre", "", AlertType.CONFIRMATION)) {
            this.primaryStage.close();
        }
    }
}
