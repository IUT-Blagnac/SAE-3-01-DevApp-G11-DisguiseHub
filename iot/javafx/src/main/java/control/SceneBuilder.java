package control;

import tools.AlertUtilities;
import tools.SceneController;

import java.net.URL;

import javafx.application.Application;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.control.Alert.AlertType;
import javafx.scene.layout.BorderPane;
import javafx.stage.Stage;

/**
 * Classe principale de l'application DisguiseHubApp, étendant Application.
 * Permet la gestion de la fenêtre affichée par l'application.
 *
 * @author KRILL Maxence, BABELA Guychel
 * @version 1.0
 */
public class SceneBuilder extends Application {

    public URL appFile = getClass().getClassLoader().getResource("python/main.py");
    public URL configFile = getClass().getClassLoader().getResource("python/config.yaml");

    /**
     * Point d'entrée principal de l'application JavaFX.
     * Charge l'application et lance la fenêtre de démarrage (accueil).
     *
     * @param primaryStage Stage principal de l'application.
     * @author KRILL Maxence, BABELA Guychel
     */
    @Override
    public void start(Stage primaryStage) {
        this.change(primaryStage, "accueil");
    }

    /**
     * Point d'entrée principal de l'application JavaFX.
     * Charge l'interface utilisateur depuis le fichier FXML, applique la feuille de style, initialise le contrôleur associé et affiche la fenêtre principale.
     *
     * @param primaryStage Stage principal de l'application.
     * @param fenetre Fenêtre à afficher.
     * @author KRILL Maxence, BABELA Guychel
     */
    public void change(Stage primaryStage, String fenetre) {
        String fxml, titre, css = null;
        switch (fenetre) {
            case "accueil":
                fxml = "Accueil.fxml";
                titre = "CaptOS - Menu principal";
                css = "accueil.css";
                break;
            case "donnees":
                fxml = "Donnees.fxml";
                titre = "CaptOS - Données";
                break;
            case "alertes":
                fxml = "Alertes.fxml";
                titre = "CaptOS - Alertes";
                break;
            case "config":
                fxml = "Config.fxml";
                titre = "CaptOS - Configuration";
                break;
            default:
                AlertUtilities.showAlert(primaryStage, "Erreur", "Une erreur est survenue", "Fenêtre invalide : " + fenetre, AlertType.ERROR);
                throw new IllegalArgumentException("/!\\ Fenêtre invalide : " + fenetre);
        }

        try {
            // Chargement du source fxml
            FXMLLoader loader = new FXMLLoader(getClass().getResource("../view/" + fxml));
            BorderPane root = loader.load();

            // Paramétrage du Stage : feuille de style, titre
            Scene scene = new Scene(root, root.getPrefWidth() + 20, root.getPrefHeight() + 10);
            if (css != null) {
                scene.getStylesheets().add(getClass().getResource("../styles/" + css).toExternalForm());
            }

            primaryStage.setScene(scene);
            primaryStage.setTitle(titre);
            primaryStage.setResizable(false);

            SceneController control = loader.getController();
            control.initContext(this, primaryStage);

            control.displayDialog();

            checkFiles();

        } catch (Exception e) {
            e.printStackTrace();
            AlertUtilities.showAlert(primaryStage, "Erreur", "Une erreur est survenue", e.getMessage(), AlertType.ERROR);
            System.exit(-1);
        }
    }

    /**
     * Méthode statique pour lancer l'application JavaFX.
     * Cette méthode invoque la méthode start de la classe DisguiseHubApp.
     * 
     * @author BABELA Guychel
     */
    public static void launch() {
        Application.launch();
    }

    /**
     * Vérifie l'existence des fichiers de configuration et de données.
     * Si l'un des fichiers n'existe pas, l'application affiche une alerte et se ferme.
     * Cette méthode est appelée à l'affichage d'une fenêtre.
     * 
     * @author KRILL Maxence
     */
    private void checkFiles() {
        
        if (appFile == null) {
            AlertUtilities.showAlert(null, "Erreur", "Application Python introuvable", "L'application Python est introuvable. Par conséquent, cette application ne peut pas démarrer.", AlertType.ERROR);
            System.exit(-1);
        }

        if (configFile == null) {
            AlertUtilities.showAlert(null, "Erreur", "Fichier de configuration introuvable", "Le fichier de configuration est introuvable. Par conséquent, cette application ne peut pas démarrer.", AlertType.ERROR);
            System.exit(-1);
        }
    }

    
    /** 
     * Obtenir l'URL de l'application Python. (main.py)
     * 
     * @return URL L'URL de l'application Python.
     * @author KRILL Maxence
     */
    public URL getApp() {
        return appFile;
    }

    /**
     * Obtenir l'URL du fichier de configuration. (config.yaml)
     * 
     * @return URL L'URL du fichier de configuration.
     * @author KRILL Maxence
     */
    public URL getConfig() {
        return configFile;
    }
}
