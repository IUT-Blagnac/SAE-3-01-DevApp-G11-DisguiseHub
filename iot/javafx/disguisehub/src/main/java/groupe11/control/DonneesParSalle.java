package groupe11.control;

import groupe11.App;
import groupe11.view.DisguiseHubAppController;
import groupe11.view.DonneesParSalleController;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.layout.BorderPane;
import javafx.stage.Stage;

public class DonneesParSalle {

    public DonneesParSalle(Stage stage) {
        try {

            // Chargement du source fxml
            FXMLLoader loader = new FXMLLoader(
                    DisguiseHubAppController.class.getResource("DonneesParSalle.fxml"));
            BorderPane root = loader.load();

            // Paramétrage du Stage : feuille de style, titre
            Scene scene = new Scene(root, root.getPrefWidth() + 20, root.getPrefHeight()
                    + 10);
            scene.getStylesheets().add(App.class.getResource("application.css").toExternalForm());

            stage.setScene(scene);
            stage.setTitle("Menu Principal");
            stage.setResizable(false);

            DonneesParSalleController control = loader.getController();
            control.initContext(this, stage);

            control.displayDialog();

        } catch (Exception e) {
            e.printStackTrace();
            System.exit(-1);
        }
    }
}
