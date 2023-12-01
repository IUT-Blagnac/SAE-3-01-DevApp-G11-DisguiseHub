package groupe11.view;

import groupe11.control.DisguiseHubApp;
import groupe11.control.DonneesParSalle;
import groupe11.control.FichierDeConfig;
import groupe11.control.VoirLesAlertes;
import groupe11.tools.AlertUtilities;
import javafx.fxml.FXML;
import javafx.scene.control.Alert.AlertType;
import javafx.scene.shape.Path;
import javafx.stage.Stage;
import javafx.scene.chart.LineChart;
import javafx.scene.chart.XYChart;

import javafx.fxml.FXML;
import javafx.scene.chart.LineChart;
import javafx.scene.chart.XYChart;

import javafx.scene.control.Alert.AlertType;
import javafx.scene.control.Alert;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.nio.file.Files;

import java.nio.file.Paths;

public class DonneesParSalleController {
    private DonneesParSalle donneesParSalle;
    private Stage stage;

    @FXML
    private LineChart<String, Number> co2Chart;

    @FXML
    private LineChart<String, Number> humidityChart;

    @FXML
    private LineChart<String, Number> pressureChart;

    @FXML
    private LineChart<String, Number> temperatureChart;

    @FXML
    private LineChart<String, Number> activityChart;

    @FXML
    private LineChart<String, Number> infraredChart;

    @FXML
    private LineChart<String, Number> tvocChart;

    @FXML
    private LineChart<String, Number> illuminationChart;

    @FXML
    private LineChart<String, Number> infrared_and_visibleChart;

    public void initContext(DonneesParSalle donneesParSalle, Stage stage) {
        this.donneesParSalle = donneesParSalle;
        this.stage = stage;

        this.stage.setOnCloseRequest(e -> {
            if (AlertUtilities.confirmYesCancel(this.stage, "confirmation",
                    "Voulez vous vraiment fermer la fenetre", "", AlertType.CONFIRMATION)) {
                this.stage.close();
            } else {
                e.consume();
            }
        });

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

    private void loadDataFromJsonFile() {
        try {
            String jsonFilePath = "iot/python/data.json";

            // Lire le contenu JSON depuis le fichier
            String jsonContent = Files.readString(Paths.get(jsonFilePath));

            // Analyser le contenu JSON
            JSONObject jsonObject = new JSONObject(jsonContent);

            // Obtenir des tableaux de données de l’objet JSON
            JSONArray co2Data = jsonObject.getJSONArray("co2");
            JSONArray humidityData = jsonObject.getJSONArray("humidity");
            JSONArray temperatureData = jsonObject.getJSONArray("temperature");
            JSONArray pressureData = jsonObject.getJSONArray("pressure");
            JSONArray activityData = jsonObject.getJSONArray("activity");
            JSONArray infraredData = jsonObject.getJSONArray("infrared");
            JSONArray tvocData = jsonObject.getJSONArray("tvoc");
            JSONArray illuminationData = jsonObject.getJSONArray("illumination");
            JSONArray infrared_and_visibleData = jsonObject.getJSONArray("infrared_and_visible");

            // Mettre à jour les graphiques avec les données
            addDataToCo2Chart("CO2", co2Data);
            addDataToHumidityChart("Humidity", humidityData);
            addDataToTemperatureChart("Temperature", temperatureData);
            addDataToPressureChart("Pressure", pressureData);
            addDataToActivityityChart("Activity", activityData);
            addDataToInfraredChart("Infrared", infraredData);
            addDataToTvocChart("Tvoc", tvocData);
            addDataToIlluminationChart("Illumination", illuminationData);
            addDataToInfraredAndVisibleChart("Infrared and visible", infrared_and_visibleData);

            // ... (appeler les autres méthodes d'ajout de données)
        } catch (IOException e) {
            AlertUtilities.showAlert(AlertType.ERROR, "Error", "Failed to load data from JSON file.", e.getMessage());
        } catch (JSONException e) {
            AlertUtilities.showAlert(AlertType.ERROR, "Error", "Failed to parse JSON content.", e.getMessage());
        }
    }

    private void addDataToChart(LineChart<String, Number> chart, String seriesName, JSONArray data) {
        XYChart.Series<String, Number> series = chart.getData().stream()
                .filter(s -> s.getName().equals(seriesName)).findFirst().orElse(null);
        if (series == null) {
            series = new XYChart.Series<>();
            series.setName(seriesName);
            chart.getData().add(series);
        }

        // Ajouter des points de données à la série
        for (Object dataPointObj : data) {
            JSONObject dataPoint = (JSONObject) dataPointObj;
            String xValue = dataPoint.getString("x");
            double yValue = dataPoint.getDouble("y");
            series.getData().add(new XYChart.Data<>(xValue, yValue));
        }
    }

    public void addDataToCo2Chart(String seriesName, JSONArray data) {
        addDataToChart(co2Chart, seriesName, data);
    }

    public void addDataToHumidityChart(String seriesName, JSONArray data) {
        addDataToChart(humidityChart, seriesName, data);
    }

    public void addDataToTemperatureChart(String seriesName, JSONArray data) {
        addDataToChart(temperatureChart, seriesName, data);
    }

    public void addDataToPressureChart(String seriesName, JSONArray data) {
        addDataToChart(pressureChart, seriesName, data);
    }

    public void addDataToActivityityChart(String seriesName, JSONArray data) {
        addDataToChart(activityChart, seriesName, data);
    }

    public void addDataToInfraredChart(String seriesName, JSONArray data) {
        addDataToChart(infraredChart, seriesName, data);
    }

    public void addDataToTvocChart(String seriesName, JSONArray data) {
        addDataToChart(tvocChart, seriesName, data);
    }

    public void addDataToIlluminationChart(String seriesName, JSONArray data) {
        addDataToChart(illuminationChart, seriesName, data);
    }

    public void addDataToInfraredAndVisibleChart(String seriesName, JSONArray data) {
        addDataToChart(infrared_and_visibleChart, seriesName, data);
    }

}
