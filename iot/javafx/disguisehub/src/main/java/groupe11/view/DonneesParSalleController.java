package groupe11.view;

import groupe11.control.DisguiseHubApp;
import groupe11.control.DonneesParSalle;
import groupe11.control.FichierDeConfig;
import groupe11.control.VoirLesAlertes;
import groupe11.tools.AlertUtilities;
import javafx.application.Platform;
import javafx.fxml.FXML;
import javafx.scene.chart.LineChart;
import javafx.scene.chart.XYChart;
import javafx.scene.control.ChoiceBox;
import javafx.scene.control.Alert.AlertType;
import javafx.stage.Stage;
import java.util.ArrayList;
import com.fasterxml.jackson.databind.ObjectMapper;

import java.io.File;
import com.fasterxml.jackson.databind.JsonNode;
import java.util.Iterator;
import java.util.Map;
import java.util.List;

public class DonneesParSalleController {
    private DonneesParSalle donneesParSalle;
    private Stage stage;

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

    public void initContext(DonneesParSalle donneesParSalle, Stage stage) {

        this.donneesParSalle = donneesParSalle;
        this.stage = stage;

        this.stage.setOnCloseRequest(e -> {
            if (AlertUtilities.confirmYesCancel(this.stage, "confirmation",
                    "Voulez vous vraiment fermer la fenetre", "", AlertType.CONFIRMATION)) {
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

    private void startPython() {
        thread = new Thread(() -> {
            try {
                ProcessBuilder p = new ProcessBuilder("python", "main.py");

                // Redirection de la sortie vers INHERIT
                p.redirectOutput(ProcessBuilder.Redirect.INHERIT);

                // Redirection de l'erreur vers INHERIT
                p.redirectError(ProcessBuilder.Redirect.INHERIT);

                // Démarrer le processus Python
                python = p.start();
            } catch (Exception e) {
                AlertUtilities.showAlert(stage, "Erruer", "Erruer lors du lancement du script Python", null,
                        AlertType.ERROR);
            }
        });
        thread.start();
    }

    private void startUpdate() {
        update = new Thread(() -> {
            long checkLast = 0;
            while (update != null && update.isAlive()) {
                long actually;
                try {
                    actually = new File("data.json").lastModified();
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

    private void stopPython() {
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

    private void updateData() {
        updateGraphData(chartTemp, "temp");
        updateGraphData(chartCO2, "co2");
        updateGraphData(chartPression, "pres");
        updateGraphData(chartAct, "act");
        updateGraphData(chartHumidity, "hum");
    }

    private void getdata(String salleChoisie) {
        try {
            // Charger les données à partir du fichier JSON
            ObjectMapper mapper = new ObjectMapper();
            File file = new File("data.json");
            JsonNode jsonNode = mapper.readTree(file);
            sensorDataList.clear();
            Iterator<Map.Entry<String, JsonNode>> fieldsIterator = jsonNode.fields();
            while (fieldsIterator.hasNext()) {
                Map.Entry<String, JsonNode> entry = fieldsIterator.next();
                String salle = entry.getKey();
                if (!choiceBoxSalles.getItems().contains(salle)) {
                    choiceBoxSalles.getItems().add(salle);
                }
                // Vérifier si la salle correspond à celle choisie ou si aucune salle n'est
                // spécifiée
                if (salle.equals(salleChoisie) || salleChoisie == null) {
                    JsonNode sensorDataArray = entry.getValue();

                    // Parcourir les données des capteurs pour la salle actuelle
                    for (JsonNode sensorDataNode : sensorDataArray) {
                        // Extraire les données du nœud du capteur
                        String date = sensorDataNode.get("date").asText();
                        Double temperature = sensorDataNode.get("temperature").asDouble();
                        Double humidity = sensorDataNode.get("humidity").asDouble();
                        Double activity = sensorDataNode.get("activity").asDouble();
                        Double co2 = sensorDataNode.get("co2").asDouble();
                        Double pressure = sensorDataNode.get("pressure").asDouble();

                        // Créer une instance de SensorData et l'ajouter à la liste
                        SensorData sensorData = new SensorData(salle, date, temperature, humidity, activity, co2,
                                pressure);
                        if (!sensorDataList.contains(sensorData)) {
                            sensorDataList.add(sensorData);
                        }
                    }
                }
            }
        } catch (Exception e) {
            // Gérer les erreurs de lecture du fichier JSON
            System.err.println("Erreur lors de la lecture du fichier JSON : " + e.getMessage());
        }
    }

    private class SensorData {
        String salle;
        String date;
        Double temperature;
        Double humidity;
        Double activity;
        Double co2;
        Double pressure;

        public SensorData(String salle, String date, Double temperature, Double humidity, Double activity, Double co2,
                Double pressure) {
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

    private void getSalleDatas(String salle) {
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

    private void updateGraphData(LineChart<String, Number> _graph, String type) {
        _graph.getData().clear();

        for (SensorData sensorData : sensorDataBySalle) {
            String id = sensorData.salle;

            XYChart.Series<String, Number> series = new XYChart.Series<>();
            series.setName(id);
            Double value = getData(sensorData, type);
            if (value != null) {
                XYChart.Data<String, Number> chartData = new XYChart.Data<>(sensorData.date, value);
                series.getData().add(chartData);

                _graph.setLegendVisible(false);
                _graph.getData().add(series);
            }
        }
    }

    private Double getData(SensorData data, String type) {
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

    public void displayDialog() {
        this.stage.show();
    }

    @FXML
    private void fichier() {
        FichierDeConfig controller = new FichierDeConfig(stage);
    }

    @FXML
    private void alerte() {
        VoirLesAlertes controller = new VoirLesAlertes(stage);
    }

    @FXML
    private void accueil() throws Exception {
        DisguiseHubApp cont = new DisguiseHubApp();
        cont.start(stage);
    }
}