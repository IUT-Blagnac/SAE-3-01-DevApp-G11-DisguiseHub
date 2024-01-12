package groupe11.control;

import groupe11.App;
import groupe11.view.DisguiseHubAppController;
import groupe11.view.FichierDeConfigController;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.layout.BorderPane;
import javafx.stage.Stage;

public class FichierDeConfig {
    public FichierDeConfig(Stage config) {
        try {

            // Chargement du source fxml
            FXMLLoader loader = new FXMLLoader(
                    DisguiseHubAppController.class.getResource("FichierDeConfig.fxml"));
            BorderPane root = loader.load();

            // Paramétrage du Stage : feuille de style, titre
            Scene scene = new Scene(root, root.getPrefWidth() + 20, root.getPrefHeight()
                    + 10);
            scene.getStylesheets().add(App.class.getResource("application.css").toExternalForm());

            config.setScene(scene);
            config.setTitle("Menu Principal");
            config.setResizable(false);

            FichierDeConfigController control = loader.getController();
            control.initContext(this, config);

            control.displayDialog();

        } catch (Exception e) {
            e.printStackTrace();
            System.exit(-1);
        }

    }

}
