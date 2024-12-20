package view;

import java.io.IOException;
import java.net.URISyntaxException;
import java.nio.charset.StandardCharsets;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.util.Map;
import org.yaml.snakeyaml.DumperOptions;
import org.yaml.snakeyaml.Yaml;
import org.yaml.snakeyaml.error.YAMLException;

import control.SceneBuilder;

import java.util.List;
import java.util.ArrayList;
import java.util.LinkedHashMap;
import tools.AlertUtilities;
import tools.SceneController;
import javafx.fxml.FXML;
import javafx.scene.control.Button;
import javafx.scene.control.CheckBox;
import javafx.scene.control.TextField;
import javafx.scene.control.Alert.AlertType;
import javafx.stage.Stage;

/**
 * Contrôleur pour la configuration du fichier de configuration.
 * Gère l'interface utilisateur et les opérations liées à la configuration.
 * Utilise la bibliothèque JavaFX pour la gestion de l'interface graphique.
 *
 * @author BABELA Guychel
 * @version 1.0
 */
public class Config implements SceneController {
    private SceneBuilder controller;

    private Stage primaryStage;

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
    private Button validerButton;

    @FXML
    private Button reinitialiserButton;

    private String host;
    private int port;
    private String topic;
    private String fichierData;
    private String fichierAlerte;
    private int intervalle;
    private double co2Min;
    private double co2Max;
    private double humidityMin;
    private double humidityMax;
    private double pressureMin;
    private double pressureMax;
    private double temperatureMin;
    private double temperatureMax;
    private boolean humidity;
    private boolean co2;
    private boolean pressure;
    private boolean temperature;
    private boolean activity;

    /**
     * Initialise le contexte du contrôleur avec le fichier de configuration et la
     * scène associée.
     *
     * @param SceneBuilder L'objet SceneBuilder pour gérer la configuration.
     * @param Stage        La scène (Stage) associée à ce contrôleur.
     */
    public void initContext(SceneBuilder controller, Stage primaryStage) {
        this.controller = controller;
        this.primaryStage = primaryStage;

        this.primaryStage.setOnCloseRequest(e -> {
            if (AlertUtilities.confirmYesCancel(this.primaryStage, "Quitter ?",
                "Voulez-vous fermer l'application ?", "", AlertType.CONFIRMATION)) {
                this.primaryStage.close();
            } else {
                e.consume();
            }
        });
        initFromConfigFile();
    }

    /**
     * Affiche la fenêtre de configuration.
     */
    public void displayDialog() {
        this.primaryStage.show();
    }

    /**
     * Affiche la vue des alertes.
     */
    @FXML
    private void ouvrirAlertes() {
        new SceneBuilder().change(this.primaryStage, "alertes");
    }

    /**
     * Affiche la vue de l'accueil.
     */
    @FXML
    private void ouvrirAccueil() {
        new SceneBuilder().change(this.primaryStage, "accueil");
    }

    /**
     * Affiche la vue des données.
     */
    @FXML
    private void ouvrirDonnees() {
        new SceneBuilder().change(this.primaryStage, "donnees");
    }

    /**
     * Convertit une chaîne en entier.
     *
     * @param _val La chaîne à convertir.
     * @return L'entier résultant ou 0 en cas d'erreur de conversion.
     */
    public int entierDeString(String _val) {
        try {
            int i = Integer.parseInt(_val.trim());
            return i;
        } catch (Exception e) {
            return 0;
        }
    }

    /**
     * Convertit une chaîne en double.
     *
     * @param _val La chaîne à convertir.
     * @return Le double résultant ou 0.0 en cas d'erreur de conversion.
     */
    public double doubleDeString(String _val) {
        try {
            double i = Double.parseDouble(_val.trim());
            return i;
        } catch (Exception e) {
            return 0;
        }
    }

    /**
     * Gère l'événement du bouton de validation.
     * Collecte les valeurs des champs, les organise dans une structure YAML et écrit dans un fichier.
     */
    @FXML
    private void validerButton() {
        // Récupérer les valeurs des champs
        host = hostTextField.getText().trim();
        port = entierDeString(portTextField.getText().trim());
        topic = topicTextField.getText().trim();
        fichierData = fichierDataTextField.getText().trim();
        fichierAlerte = fichierAlerteTextField.getText().trim();
        intervalle = entierDeString(intervalleTextField.getText());
        co2Min = doubleDeString(co2MinTextField.getText());
        co2Max = doubleDeString(co2MaxTextField.getText().trim());
        humidityMin = doubleDeString(humidityMinTextField.getText().trim());
        humidityMax = doubleDeString(humidityMaxTextField.getText().trim());
        pressureMin = doubleDeString(pressureMinTextField.getText().trim());
        pressureMax = doubleDeString(pressureMaxTextField.getText().trim());
        temperatureMin = doubleDeString(temperatureMinTextField.getText().trim());
        temperatureMax = doubleDeString(temperatureMaxTextField.getText().trim());
        humidity = humidityCheckBox.isSelected();
        co2 = co2CheckBox.isSelected();
        pressure = pressureCheckBox.isSelected();
        temperature = temperatureCheckBox.isSelected();
        activity = activityCheckBox.isSelected();

        // Créer une structure de données pour représenter la configuration
        Map<String, Object> connectionConfig = new LinkedHashMap<>();
        Map<String, Object> connectionDetails = new LinkedHashMap<>();
        connectionDetails.put("host", host);
        connectionDetails.put("port", port);
        connectionDetails.put("topic", topic);
        connectionConfig.put("connection", connectionDetails);

        // Structure pour la section "ecriture"
        Map<String, Object> config = new LinkedHashMap<>();
        Map<String, Object> ecritureConfig = new LinkedHashMap<>();
        Map<String, Object> fichiers = new LinkedHashMap<>();
        fichiers.put("data", fichierData);
        fichiers.put("alerte", fichierAlerte);
        ecritureConfig.put("fichiers", fichiers);
        ecritureConfig.put("intervale", intervalle);
        config.put("ecriture", ecritureConfig);

        // Créer une structure de données pour représenter la configuration
        Map<String, Object> collecteConfig = new LinkedHashMap<>();
        List<String> collecteList = new ArrayList<>();

        if (temperature)
            collecteList.add("temperature");
        if (activity)
            collecteList.add("activity");
        if (co2)
            collecteList.add("co2");
        if (pressure)
            collecteList.add("pressure");
        if (humidity)
            collecteList.add("humidity");

        collecteConfig.put("collecte", collecteList);

        // Créer une structure de données pour représenter la configuration
        Map<String, Map<String, Map<String, Double>>> alerteConfig = new LinkedHashMap<>();
        Map<String, Map<String, Double>> alerteDetails = new LinkedHashMap<>();

        // Configuration pour chaque type d'alerte
        Map<String, Double> co2 = new LinkedHashMap<>();
        co2.put("min", co2Min);
        co2.put("max", co2Max);
        Map<String, Double> humidity = new LinkedHashMap<>();
        humidity.put("min", humidityMin);
        humidity.put("max", humidityMax);
        Map<String, Double> pressure = new LinkedHashMap<>();
        pressure.put("min", pressureMin);
        pressure.put("max", pressureMax);
        Map<String, Double> temperature = new LinkedHashMap<>();
        temperature.put("min", temperatureMin);
        temperature.put("max", temperatureMax);
        // Ajout des configurations d'alerte
        alerteDetails.put("co2", co2);
        alerteDetails.put("humidity", humidity);
        alerteDetails.put("pressure", pressure);
        alerteDetails.put("temperature", temperature);

        alerteConfig.put("alerte", alerteDetails);

        // Configurer les options de dumping pour conserver l'ordre des propriétés
        DumperOptions options = new DumperOptions();
        options.setAllowReadOnlyProperties(true);
        options.setDefaultFlowStyle(DumperOptions.FlowStyle.BLOCK);
        options.setIndent(2);

        // Créer un Yaml avec les options personnalisées
        Yaml yaml = new Yaml(options);

        // Écrire les valeurs dans le fichier YAML
        try {
            Map<String, Object> allConfig = new LinkedHashMap<>();
            allConfig.putAll(connectionConfig);
            allConfig.putAll(config);
            allConfig.putAll(collecteConfig);
            allConfig.putAll(alerteConfig);
        
            String configString = yaml.dump(allConfig);
            byte[] configBytes = configString.getBytes(StandardCharsets.UTF_8);
            Files.write(Paths.get(this.controller.getConfig().toURI()), configBytes);
        
            System.out.println("La configuration a été écrite dans le fichier YAML avec succès.");
            AlertUtilities.showAlert(this.primaryStage, "Succès", "Configuration enregistrée", "La configuration a été enregistrée avec succès.", AlertType.INFORMATION);
        } catch (YAMLException e) {
            e.printStackTrace();
            AlertUtilities.showAlert(this.primaryStage, "Erreur", "Erreur lors de la conversion de la configuration en YAML", e.getMessage(), AlertType.ERROR);
            System.exit(1);
        } catch (IOException | URISyntaxException e) {
            e.printStackTrace();
            AlertUtilities.showAlert(this.primaryStage, "Erreur", "Erreur d'écriture du fichier de configuration", e.getMessage(), AlertType.ERROR);
            System.exit(1);
        }
    }

    /**
     * Initialise les champs de la fenêtre de configuration à partir du fichier de
     * configuration.
     */
    private void initFromConfigFile() {

        try {
            Yaml yaml = new Yaml();
            byte[] configBytes = Files.readAllBytes(Paths.get(this.controller.getConfig().toURI()));
            String configString = new String(configBytes, StandardCharsets.UTF_8);
            Map<String, Object> config = yaml.load(configString);
            
            // Extraction des données de la section connection
            Map<String, Object> connection = (Map<String, Object>) config.get("connection");
            hostTextField.setText(String.valueOf(connection.get("host")));
            portTextField.setText(String.valueOf(connection.get("port")));
            topicTextField.setText(String.valueOf(connection.get("topic")));

            // Extraction des données de la section ecriture
            Map<String, Object> ecriture = (Map<String, Object>) config.get("ecriture");
            Map<String, Object> fichiers = (Map<String, Object>) ecriture.get("fichiers");
            fichierDataTextField.setText(String.valueOf(fichiers.get("data")));
            fichierAlerteTextField.setText(String.valueOf(fichiers.get("alerte")));
            intervalleTextField.setText(String.valueOf(ecriture.get("intervale")));

            // Extraction des données de la section collecte
            List<String> collecteList = (List<String>) config.get("collecte");
            if (collecteList.contains("temperature")) {
                this.temperatureCheckBox.setSelected(true);
            }
            if (collecteList.contains("co2")) {
                this.co2CheckBox.setSelected(true);
            }
            if (collecteList.contains("humiditty")) {
                this.humidityCheckBox.setSelected(true);
            }

            if (collecteList.contains("activity")) {
                this.activityCheckBox.setSelected(true);
            }

            if (collecteList.contains("pressure")) {
                this.pressureCheckBox.setSelected(true);
            }

            // Extraction des données de la section alerte
            Map<String, Map<String, Double>> alerte = (Map<String, Map<String, Double>>) config.get("alerte");
            Map<String, Double> co2Alerte = alerte.get("co2");
            co2MinTextField.setText(String.valueOf(co2Alerte.get("min")));
            co2MaxTextField.setText(String.valueOf(co2Alerte.get("max")));
            Map<String, Double> pressureAlerte = alerte.get("co2");
            pressureMinTextField.setText(String.valueOf(pressureAlerte.get("min")));
            pressureMaxTextField.setText(String.valueOf(pressureAlerte.get("max")));
            Map<String, Double> humidityAlerte = alerte.get("co2");
            humidityMinTextField.setText(String.valueOf(humidityAlerte.get("min")));
            humidityMaxTextField.setText(String.valueOf(humidityAlerte.get("max")));
            Map<String, Double> temperatureAlerte = alerte.get("co2");
            temperatureMinTextField.setText(String.valueOf(temperatureAlerte.get("min")));
            temperatureMaxTextField.setText(String.valueOf(temperatureAlerte.get("max")));

        } catch (YAMLException e) {
            e.printStackTrace();
            AlertUtilities.showAlert(this.primaryStage, "Erreur", "Erreur de l'analyse du fichier de configuration", e.getMessage(), AlertType.ERROR);
            System.exit(1);
        } catch (IOException e) {
            e.printStackTrace();
            AlertUtilities.showAlert(this.primaryStage, "Erreur", "Erreur de lecture du fichier de configuration", e.getMessage(), AlertType.ERROR);
            System.exit(1);
        } catch (URISyntaxException e) {
            e.printStackTrace();
            AlertUtilities.showAlert(this.primaryStage, "Erreur", "Erreur de lecture du fichier de configuration", e.getMessage(), AlertType.ERROR);
            System.exit(1);
        }
    }

    /**
     * Réinitialise tous les champs de la fenêtre de configuration.
     */
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
    }
}
