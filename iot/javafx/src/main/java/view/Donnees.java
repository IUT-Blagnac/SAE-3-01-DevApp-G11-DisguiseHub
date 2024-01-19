package view;

import control.SceneBuilder;
import tools.AlertUtilities;
import tools.SceneController;
import javafx.application.Platform;
import javafx.fxml.FXML;
import javafx.scene.chart.CategoryAxis;
import javafx.scene.chart.LineChart;
import javafx.scene.chart.XYChart;
import javafx.scene.control.ChoiceBox;
import javafx.scene.control.Alert.AlertType;
import javafx.scene.layout.VBox;
import javafx.stage.Stage;
import java.util.ArrayList;
import java.util.HashMap;

import com.fasterxml.jackson.databind.ObjectMapper;

import java.io.BufferedReader;
import java.io.File;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.URISyntaxException;
import java.nio.charset.StandardCharsets;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.sql.Date;
import java.text.SimpleDateFormat;

import com.fasterxml.jackson.databind.JsonNode;
import java.util.Iterator;
import java.util.Map;

import org.yaml.snakeyaml.Yaml;

import java.util.List;

/**
 * Contrôleur pour l'affichage des données par salle.
 * Gère les graphiques en temps réel des capteurs de température, humidité, activité, CO2 et pression.
 *
 * @see SceneController
 * @author KRILL Maxence, BABELA Guychel
 * @version 1.0
 */
public class Donnees implements SceneController {
    private SceneBuilder controller;
    private Stage stage;
    private JsonNode dataFile;
    private JsonNode alerteFile;

    @FXML
    private LineChart<String, Number> chartTemp;
    @FXML
    private LineChart<String, Number> chartHumidity;
    @FXML
    private LineChart<String, Number> chartAct;
    @FXML
    private LineChart<String, Number> chartCO2;
    @FXML
    private LineChart<String, Number> chartPression;

    @FXML
    private ChoiceBox<String> choiceBoxSalles;

    @FXML
    private VBox alertes;

    /**
     * Initialise le contexte du contrôleur avec les données par salle et la scène associée.
     * Initialise également les graphiques et les mises à jour en temps réel.
     *
     * @param controller   Le contrôleur de la vue.
     * @param primaryStage La fenêtre principale de l'application.
     */
    @Override
    public void initContext(SceneBuilder controller, Stage primaryStage) {
        this.controller = controller;
        this.stage = primaryStage;

        this.dataFile = openJson("data");
        this.alerteFile = openJson("alerte");

        this.stage.setOnCloseRequest(e -> {
            if (AlertUtilities.confirmYesCancel(this.stage, "confirmation",
                "Voulez-vous fermer l'application ?", "", AlertType.CONFIRMATION)) {
                stopPython();

                this.stage.close();
                System.exit(0);
            } else {
                e.consume();
            }
        });
        startPython();
        startUpdate();
        choiceBoxSalles.getSelectionModel().selectedItemProperty().addListener((observable, oldValue, newValue) -> {
            if (newValue != null) {
                if (newValue.equals("Toutes les salles")) {
                    getSalleDatas(null);
                } else {
                    getSalleDatas(newValue);
                }
                updateData();
            }
        });
        choiceBoxSalles.getItems().add("Toutes les salles");
        choiceBoxSalles.setValue("Toutes les salles");

        getdata(null);
        getSalleDatas(null);
        updateData();
    }

    Thread thread;
    Thread update;
    Process python;

    /**
     * Démarre le script Python en tant que processus séparé.
     */
    private void startPython() {
        try {
            // Lire les sorties du processus dans un thread séparé
            Thread thread = new Thread(() -> {
                try {    
                    if (this.controller.getApp() == null) {
                        System.err.println("Le script Python n'a pas été trouvé dans les ressources.");
                        AlertUtilities.showAlert(stage, "Erreur", "Le script Python n'a pas été trouvé dans les ressources.", "", AlertType.ERROR);
                        System.exit(1);
                    }
    
                    // Obtenez le chemin absolu du fichier à partir de l'URL
                    String scriptPath = new File(this.controller.getApp().toURI()).getAbsolutePath();
    
                    // Commande pour exécuter le script Python
                    String command = "python \"" + scriptPath + "\"";
                    System.out.println("Commande : " + command);
    
                    // Créer le process builder
                    ProcessBuilder processBuilder = new ProcessBuilder(command.split("\\s+"));

                    // Définir le répertoire de travail
                    processBuilder.directory(new File(this.controller.getApp().toURI()).getParentFile());

                    // Définir l'encodage de la console Python
                    processBuilder.environment().put("PYTHONIOENCODING", "UTF-8");

                    // Rediriger la sortie du processus Python
                    processBuilder.redirectErrorStream(true);

                    // Démarrer le processus
                    Process process = processBuilder.start();
    
                    // Lire la sortie du processus Python
                    try (InputStream inputStream = process.getInputStream();
                         BufferedReader reader = new BufferedReader(new InputStreamReader(inputStream))) {
    
                        String line;
                        while ((line = reader.readLine()) != null) {
                            // Afficher la sortie du script Python dans la console Java
                            System.out.println(line);
                        }
    
                    } catch (IOException e) {
                        e.printStackTrace();
                    }
    
                    // Attendre que le processus se termine
                    int exitCode = process.waitFor();
    
                    // Afficher le code de sortie
                    System.out.println("Le script Python s'est terminé avec le code de sortie : " + exitCode);
    
                } catch (Exception e) {
                    e.printStackTrace();
                }
            });

            thread.start();
        } catch (Exception e) {
            e.printStackTrace();
            AlertUtilities.showAlert(stage, "Erreur", "Erreur lors de l'exécution du script Python", e.getMessage(), AlertType.ERROR);
            System.exit(1);
        }
    }

    /**
     * Démarre la mise à jour en temps réel des données.
     */
    private void startUpdate() {
        // Démarrage de la mise à jour
        update = new Thread(() -> {
            long checkLast = 0;
            while (update != null && update.isAlive()) {
                long actually;
                try {
                    File file = new File(getClass().getResource("/python/" + getFileName("data") + ".json").toURI());
                    actually = file.lastModified();
                } catch (Exception e) {
                    actually = 0;
                }
                if (actually > checkLast) {
                    Platform.runLater(() -> {
                        getdata(null);
                        getSalleDatas(choiceBoxSalles.getValue());
                        updateData();
                    });
                }
                checkLast = actually;
            }
        });
        update.start();
    }

    /**
     * Arrête le script Python et les threads associés.
     */
    private void stopPython() {
        // Arrêt du script Python
        if (python != null && python.isAlive()) {
            python.destroy();
        }
        if (thread != null && thread.isAlive()) {
            thread.interrupt();
        }
        if (update != null && update.isAlive()) {
            update.interrupt();
        }
    }

    /**
     * Met à jour les données affichées sur les graphiques.
     */
    private void updateData() {
        // Mise à jour des graphiques
        updateGraphData(chartTemp, "temp");
        updateGraphData(chartCO2, "co2");
        updateGraphData(chartPression, "pres");
        updateGraphData(chartAct, "act");
        updateGraphData(chartHumidity, "hum");
    }

    /**
     * Récupère les données des capteurs à partir du fichier JSON.
     *
     * @param salleChoisie Le nom de la salle choisie ou null pour toutes les salles.
     */
    private void getdata(String salleChoisie) {
        // Récupération des données depuis le fichier JSON
        try {
            // Charger les données à partir du fichier JSON
            this.dataFile = openJson("data");
            sensorDataList.clear();
            Iterator<Map.Entry<String, JsonNode>> fieldsIterator = this.dataFile.fields();
            while (fieldsIterator.hasNext()) {
                Map.Entry<String, JsonNode> entry = fieldsIterator.next();
                String salle = entry.getKey();
                if (!choiceBoxSalles.getItems().contains(salle)) {
                    choiceBoxSalles.getItems().add(salle);
                }
                // Vérifier si la salle correspond à celle choisie ou si aucune salle n'est spécifiée
                if (salle.equals(salleChoisie) || salleChoisie == null) {
                    JsonNode sensorDataArray = entry.getValue();

                    // Parcourir les données des capteurs pour la salle actuelle
                    for (JsonNode sensorDataNode : sensorDataArray) {
                        if (sensorDataNode == null) {
                            continue;
                        }
                        // Extraire les données du nœud du capteur
                        String date = sensorDataNode.get("date").asText();

                        JsonNode temperatureNode = sensorDataNode.get("temperature");
                        Double temperature = temperatureNode != null ? temperatureNode.asDouble() : null;

                        JsonNode humidityNode = sensorDataNode.get("humidity");
                        Double humidity = humidityNode != null ? humidityNode.asDouble() : null;

                        JsonNode activityNode = sensorDataNode.get("activity");
                        Double activity = activityNode != null ? activityNode.asDouble() : null;

                        JsonNode co2Node = sensorDataNode.get("co2");
                        Double co2 = co2Node != null ? co2Node.asDouble() : null;

                        JsonNode pressureNode = sensorDataNode.get("pressure");
                        Double pressure = pressureNode != null ? pressureNode.asDouble() : null;

                        // Créer une instance de SensorData et l'ajouter à la liste
                        SensorData sensorData = new SensorData(salle, date, temperature, humidity, activity, co2, pressure);
                        if (!sensorDataList.contains(sensorData)) {
                            sensorDataList.add(sensorData);
                        }
                    }
                }
            }
        } catch (Exception e) {
            // Gérer les erreurs de lecture du fichier JSON
            System.err.println("Erreur lors de la lecture du fichier JSON : " + e.getMessage());
            AlertUtilities.showAlert(stage, "Erreur", "Erreur lors de la lecture du fichier JSON", e.getMessage(), AlertType.ERROR);
        }
    }

    /**
     * Classe interne pour représenter les données d'un capteur.
     */
    private class SensorData {
        // Définition de la classe SensorData
        String salle;
        String date;
        Double temperature;
        Double humidity;
        Double activity;
        Double co2;
        Double pressure;

        public SensorData(String salle, String date, Double temperature, Double humidity, Double activity, Double co2, Double pressure) {
            this.salle = salle;
            this.date = date;
            this.temperature = temperature;
            this.humidity = humidity;
            this.activity = activity;
            this.co2 = co2;
            this.pressure = pressure;
        }
    }

    private List<SensorData> sensorDataList = new ArrayList<>();
    private List<SensorData> sensorDataBySalle = new ArrayList<>();

    /**
     * Récupère les données spécifiques à une salle choisie.
     *
     * @param salle Le nom de la salle choisie ou "Toutes les salles".
     */
    private void getSalleDatas(String salle) {
        // Récupération des données spécifiques à la salle
        sensorDataBySalle.clear();
        if (salle == null || salle.equals("Toutes les salles")) {
            sensorDataBySalle.addAll(sensorDataList);
        } else {
            for (SensorData room : sensorDataList) {
                if (salle.equals(room.salle)) {
                    sensorDataBySalle.add(room);
                }
            }
        }
    }

    /**
     * Met à jour les données des graphiques pour un type de capteur spécifié.
     *
     * @param _graph Le graphique à mettre à jour.
     * @param type   Le type de capteur (temp, co2, pres, act, hum).
     */
    private void updateGraphData(LineChart<String, Number> _graph, String type) {
        _graph.getData().clear();
        CategoryAxis xAxis = (CategoryAxis) _graph.getXAxis();
        xAxis.setTickLength(10);

        // Créer une série pour chaque salle
        Map<String, XYChart.Series<String, Number>> seriesBySalle = new HashMap<>();
        for (SensorData sensorData : sensorDataBySalle) {
            String id = sensorData.salle;
            seriesBySalle.putIfAbsent(id, new XYChart.Series<>());
            seriesBySalle.get(id).setName(id);

            Date date = new Date(Long.parseLong(sensorData.date) * 1000);
            SimpleDateFormat dateFormat = new SimpleDateFormat("dd/MM/yyyy HH:mm:ss");
            String formattedDate = dateFormat.format(date);

            Double value = getData(sensorData, type);
            if (value != null) {
                XYChart.Data<String, Number> chartData = new XYChart.Data<>(formattedDate, value);
                seriesBySalle.get(id).getData().add(chartData);
            }
        }

        // Ajouter toutes les séries au graphique
        _graph.setLegendVisible(false);
        for (XYChart.Series<String, Number> series : seriesBySalle.values()) {
            _graph.getData().add(series);
        }
    }

    /**
     * Récupère la valeur spécifiée du capteur.
     *
     * @param data Les données du capteur.
     * @param type Le type de capteur (temp, co2, pres, act, hum).
     * @return La valeur du capteur ou null si le type est inconnu.
     * @author BABELA Guychel
     */
    private Double getData(SensorData data, String type) {
        // Récupération des données spécifiques du capteur
        switch (type) {
            case "temp":
                return data.temperature;
            case "act":
                return data.activity;
            case "hum":
                return data.humidity;
            case "pres":
                return data.pressure;
            case "co2":
                return data.co2;
            default:
                return null;
        }
    }
    
    /**
     * Ouvre le fichier de configuration et retourne son contenu sous forme de JsonNode.
     * 
     * @return Le contenu du fichier de configuration.
     * @author KRILL Maxence
     */
    private JsonNode openJson(String jsonFile) {
        try {
            InputStream file = getClass().getResourceAsStream("/python/" + getFileName(jsonFile) + ".json");
            JsonNode ret = new ObjectMapper().readTree(file);
            return ret;
        } catch (IOException e) {
            AlertUtilities.showAlert(stage, "Erreur", "Erreur lors de la lecture du fichier de configuration", e.getMessage(), AlertType.ERROR);
            e.printStackTrace();
            System.exit(1);
        }
        return null;
    }

    /**
     * Récupère le nom du fichier de configuration.
     * 
     * @param file Le nom du fichier à récupérer.
     * @return Le nom du fichier de configuration ou null en cas d'erreur.
     * @author KRILL Maxence
     */
    private String getFileName(String file) {
        try {
            Yaml yaml = new Yaml();
            byte[] configBytes;
            configBytes = Files.readAllBytes(Paths.get(this.controller.getConfig().toURI()));
            String configString = new String(configBytes, StandardCharsets.UTF_8);
            Map<String, Object> config = yaml.load(configString);
            Map<String, Object> ecriture = (Map<String, Object>) config.get("ecriture");
            Map<String, Object> fichiers = (Map<String, Object>) ecriture.get("fichiers");
            return String.valueOf(fichiers.get(file));
        } catch (IOException | URISyntaxException e) {
            e.printStackTrace();
            AlertUtilities.showAlert(stage, "Erreur", "Erreur lors de la lecture du fichier de configuration", e.getMessage(), AlertType.ERROR);
            System.exit(1);
        }
        return null;
    }

    /**
     * Affiche la fenêtre associée à ce contrôleur.
     */
    public void displayDialog() {
        this.stage.show();
    }

    /**
     * Affiche la vue de configuration.
     */
    @FXML
    private void ouvrirConfig() {
        new SceneBuilder().change(this.stage, "config");
    }

    /**
     * Affiche la vue des alertes.
     */
    @FXML
    private void ouvrirAlertes() {
        new SceneBuilder().change(this.stage, "alertes");
    }

    /**
     * Affiche la vue d'accueil.
     */
    @FXML
    private void ouvrirAccueil() {
        new SceneBuilder().change(this.stage, "accueil");
    }
}
