package tools;

import control.SceneBuilder;
import javafx.stage.Stage;

public interface SceneController {
    public void initContext(SceneBuilder controller, Stage primaryStage);
    public void displayDialog();
}