package tools;

import control.SceneBuilder;
import javafx.stage.Stage;

/**
 * L'interface SceneController définit les méthodes nécessaires pour la gestion
 * des scènes dans une application JavaFX.
 */
public interface SceneController {
    
    /**
     * Initialise le contexte du contrôleur de scène.
     *
     * @param controller   Le constructeur de scène permettant la construction
     *                     des différentes scènes de l'application.
     * @param primaryStage La fenêtre principale de l'application.
     */
    public void initContext(SceneBuilder controller, Stage primaryStage);
    
    /**
     * Affiche une boîte de dialogue ou une fenêtre modale à l'utilisateur.
     * Cette méthode peut être implémentée pour afficher des informations,
     * des avertissements ou des demandes de l'utilisateur.
     */
    public void displayDialog();
}
