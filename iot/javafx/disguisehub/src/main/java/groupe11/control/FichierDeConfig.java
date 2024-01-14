package groupe11.control;

import groupe11.App;
import groupe11.view.DisguiseHubAppController;
import groupe11.view.FichierDeConfigController;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.layout.BorderPane;
import javafx.stage.Stage;

/**
 * Contrôleur responsable de la gestion des fichiers de configuration dans
 * l'application DisguiseHub.
 * Cette classe charge l'interface utilisateur associée à la gestion des
 * fichiers de configuration depuis un fichier FXML,
 * initialise les composants nécessaires, et affiche la fenêtre de
 * configuration.
 */
public class FichierDeConfig {
    /**
     * Constructeur de la classe FichierDeConfig.
     * Charge l'interface utilisateur depuis le fichier FXML, applique la feuille de
     * style,
     * initialise le contrôleur associé, et affiche la fenêtre de configuration.
     *
     * @param config Stage dans lequel afficher la fenêtre de configuration.
     */
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
