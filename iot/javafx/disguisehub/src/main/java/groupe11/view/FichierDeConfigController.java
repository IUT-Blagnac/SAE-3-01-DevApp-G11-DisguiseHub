package groupe11.view;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileWriter;
import java.io.IOException;
import java.io.InputStream;
import java.io.Writer;
import java.lang.module.Configuration;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.yaml.snakeyaml.DumperOptions;
import org.yaml.snakeyaml.Yaml;

import groupe11.control.DisguiseHubApp;
import groupe11.control.DonneesParSalle;
import groupe11.control.FichierDeConfig;
import groupe11.control.VoirLesAlertes;
import groupe11.tools.AlertUtilities;
import javafx.fxml.FXML;
import javafx.scene.control.Button;
import javafx.scene.control.CheckBox;
import javafx.scene.control.TextField;
import javafx.scene.control.Alert.AlertType;
import javafx.stage.Stage;

import javafx.scene.control.Alert.AlertType;

public class FichierDeConfigController {
    private FichierDeConfig fichierDeConfig;

    private Stage configue;

    @FXML
    private TextField hostTextField;

    @FXML
    private TextField portTextField;

    @FXML
    private TextField topicTextField;

    @FXML
    private TextField fichierDataTextField;

    @FXML
    private TextField fichierAlerteTextField;

    @FXML
    private TextField intervalleTextField;

    @FXML
    private TextField co2MinTextField;

    @FXML
    private TextField co2MaxTextField;

    @FXML
    private TextField humidityMinTextField;

    @FXML
    private TextField humidityMaxTextField;

    @FXML
    private TextField pressureMinTextField;

    @FXML
    private TextField pressureMaxTextField;

    @FXML
    private TextField temperatureMinTextField;

    @FXML
    private TextField temperatureMaxTextField;

    @FXML
    private CheckBox co2CheckBox;

    @FXML
    private CheckBox humidityCheckBox;

    @FXML
    private CheckBox pressureCheckBox;

    @FXML
    private CheckBox temperatureCheckBox;

    @FXML
    private CheckBox activityCheckBox;

    @FXML
    private CheckBox tvocCheckBox;

    @FXML
    private CheckBox illuminationCheckBox;

    @FXML
    private CheckBox infraredCheckBox;

    @FXML
    private CheckBox infrared_and_visibleCheckBox;

    @FXML
    private Button validerButton;

    @FXML
    private Button reinitialiserButton;

    private String host;
    private String port;
    private String topic;
    private String fichierData;
    private String fichierAlerte;
    private String intervalle;
    private String co2Min;
    private String co2Max;
    private String humidityMin;
    private String humidityMax;
    private String pressureMin;
    private String pressureMax;
    private String temperatureMin;
    private String temperatureMax;
    private boolean humidity;
    private boolean co2;
    private boolean pressure;
    private boolean temperature;
    private boolean activity;
    private boolean tvoc;
    private boolean illumination;
    private boolean infrared;
    private boolean infrared_and_visible;

    public void initContext(FichierDeConfig fichierDeConfig, Stage configue) {
        this.fichierDeConfig = fichierDeConfig;
        this.configue = configue;

        this.configue.setOnCloseRequest(e -> {
            if (AlertUtilities.confirmYesCancel(this.configue, "confirmation",
                    "Voulez vous vraiment fermer la fenetre", "", AlertType.CONFIRMATION)) {
                this.configue.close();
            } else {
                e.consume();
            }
        });

    }

    public void displayDialog() {
        this.configue.show();
    }

    @FXML
    private void salle() {
        DonneesParSalle controller = new DonneesParSalle(configue);
    }

    @FXML
    private void alerte() {
        VoirLesAlertes controller = new VoirLesAlertes(configue);
    }

    @FXML
    private void accueil() throws Exception {
        DisguiseHubApp cont = new DisguiseHubApp();
        cont.start(configue);
    }

    @FXML
    private void validerButton() {
        // Chemin du fichier YAML
        String filePath = "iot/python/config.yaml";

        // Création d'un objet Yaml
        Yaml yaml = new Yaml();

        // Création d'un objet InputStream pour lire le fichier YAML
        InputStream inputStream = null;
        try {
            inputStream = new FileInputStream(new File(filePath));
        } catch (FileNotFoundException e) {
            e.printStackTrace();
        }

        // Création d'un objet Map pour stocker les données lues
        Map<String, Object> data = new HashMap<>();
        try {
            data.put("host", this.hostTextField.getText());
            data.put("port", this.portTextField.getText());
            data.put("topic", this.topicTextField.getText());
            try {
                FileWriter writer = new FileWriter(filePath);
            } catch (IOException e) {
                e.printStackTrace();
            }
            data.put("co2Max", this.co2MaxTextField.getText());
            data.put("humidityMin", this.humidityMinTextField.getText());
            data.put("humidityMax", this.humidityMaxTextField.getText());
            data.put("pressureMin", this.pressureMinTextField.getText());
            data.put("pressureMax", this.pressureMaxTextField.getText());
            data.put("temperatureMin", this.temperatureMinTextField.getText());
            data.put("temperatureMax", this.temperatureMaxTextField.getText());
            data.put("humidity", this.humidityCheckBox.isSelected());
            data.put("co2", this.co2CheckBox.isSelected());
            data.put("pressure", this.pressureCheckBox.isSelected());
            data.put("temperature", this.temperatureCheckBox.isSelected());
            data.put("activity", this.activityCheckBox.isSelected());
            data.put("tvoc", this.tvocCheckBox.isSelected());
            data.put("illumination", this.illuminationCheckBox.isSelected());
            data.put("infrared", this.infraredCheckBox.isSelected());
            data.put("infrared_and_visible", this.infrared_and_visibleCheckBox.isSelected());

            // Affichage des données
            System.out.println(data);

            // Création d'un objet DumperOptions
            DumperOptions dumperOptions = new DumperOptions();

            // Modification des options de présentation
            dumperOptions.setDefaultFlowStyle(DumperOptions.FlowStyle.BLOCK);
            dumperOptions.setPrettyFlow(true);

            // Création d'un objet Yaml avec les options
            Yaml yaml2 = new Yaml(dumperOptions);

            // Création d'un objet Writer
            Writer writer = null;

            // Ecriture dans le fichier YAML
            try {
                writer = new FileWriter(filePath);
                yaml2.dump(data, writer);
            } catch (IOException e) {
                e.printStackTrace();
            }

            // Fermeture du fichier
            this.configue.close();
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    @FXML
    private void reinitialiserButton() {
        this.hostTextField.setText("");
        this.portTextField.setText("");
        this.topicTextField.setText("");
        this.fichierDataTextField.setText("");
        this.fichierAlerteTextField.setText("");
        this.intervalleTextField.setText("");
        this.co2MinTextField.setText("");
        this.co2MaxTextField.setText("");
        this.humidityMinTextField.setText("");
        this.humidityMaxTextField.setText("");
        this.pressureMinTextField.setText("");
        this.pressureMaxTextField.setText("");
        this.temperatureMinTextField.setText("");
        this.temperatureMaxTextField.setText("");
        this.co2CheckBox.setSelected(false);
        this.humidityCheckBox.setSelected(false);
        this.pressureCheckBox.setSelected(false);
        this.temperatureCheckBox.setSelected(false);
        this.activityCheckBox.setSelected(false);
        this.tvocCheckBox.setSelected(false);
        this.illuminationCheckBox.setSelected(false);
        this.infraredCheckBox.setSelected(false);
        this.infrared_and_visibleCheckBox.setSelected(false);
    }
}
