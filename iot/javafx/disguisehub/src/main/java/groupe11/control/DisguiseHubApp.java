package groupe11.control;

import groupe11.App;
import groupe11.view.DisguiseHubAppController;
import javafx.application.Application;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.layout.BorderPane;
import javafx.stage.Stage;

public class DisguiseHubApp extends Application {

    private Stage primaryStage;

    @Override
    public void start(Stage primaryStage) throws Exception {
        this.primaryStage = primaryStage;

        try {

            // Chargement du source fxml
            FXMLLoader loader = new FXMLLoader(
                    DisguiseHubAppController.class.getResource("DisguiseHubApp.fxml"));
            BorderPane root = loader.load();

            // Paramétrage du Stage : feuille de style, titre
            Scene scene = new Scene(root, root.getPrefWidth() + 20, root.getPrefHeight()
                    + 10);
            scene.getStylesheets().add(App.class.getResource("application.css").toExternalForm());

            primaryStage.setScene(scene);
            primaryStage.setTitle("Menu Principal");
            primaryStage.setResizable(false);

            DisguiseHubAppController control = loader.getController();
            control.initContext(this, primaryStage);

            control.displayDialog();

        } catch (Exception e) {
            e.printStackTrace();
            System.exit(-1);
        }
    }

    public static void launch() {
        Application.launch();
    }
}
