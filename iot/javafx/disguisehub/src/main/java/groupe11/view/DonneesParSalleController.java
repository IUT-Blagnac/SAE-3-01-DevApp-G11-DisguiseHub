package groupe11.view;

import groupe11.control.DisguiseHubApp;
import groupe11.control.DonneesParSalle;
import groupe11.control.FichierDeConfig;
import groupe11.control.VoirLesAlertes;
import groupe11.tools.AlertUtilities;
import javafx.fxml.FXML;
import javafx.scene.chart.LineChart;
import javafx.scene.chart.XYChart;
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
    private LineChart<String, Number> chartIllumi;
    @FXML
    private LineChart<String, Number> chartCO2;
    @FXML
    private LineChart<String, Number> chartPression;
    @FXML
    private LineChart<String, Number> chartIfrared;
    @FXML
    private LineChart<String, Number> chartTVOC;
    @FXML
    private LineChart<String, Number> chartAct;
    @FXML
    private LineChart<String, Number> chartIfraredand;

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
        getdata();
        updateGraphData(chartTemp, listTemp);
        updateGraphData(chartCO2, listCO2);
        updateGraphData(chartIfrared, listIfrared);
        updateGraphData(chartIfraredand, listIfraredand);
        updateGraphData(chartIllumi, listIllumi);
        updateGraphData(chartTVOC, listTVOC);
        updateGraphData(chartPression, listPression);
        updateGraphData(chartAct, listAct);
        updateGraphData(chartHumidity, listHumidity);

    }

    private ArrayList<Double> listTemp = new ArrayList<Double>();
    private ArrayList<Double> listHumidity = new ArrayList<Double>();
    private ArrayList<Double> listIllumi = new ArrayList<Double>();
    private ArrayList<Double> listCO2 = new ArrayList<Double>();
    private ArrayList<Double> listPression = new ArrayList<Double>();
    private ArrayList<Double> listIfrared = new ArrayList<Double>();
    private ArrayList<Double> listTVOC = new ArrayList<Double>();
    private ArrayList<Double> listAct = new ArrayList<Double>();
    private ArrayList<Double> listIfraredand = new ArrayList<Double>();
    private ArrayList<String> listDate = new ArrayList<String>();
    private ArrayList<String> listSalle = new ArrayList<String>();

    private void getdata() {
        try {
            ObjectMapper mapper = new ObjectMapper();
            File file = new File("iot\\python\\data.json");
            JsonNode jsonNode = mapper.readTree(file);

            Iterator<Map.Entry<String, JsonNode>> fieldsIterator = jsonNode.fields();
            while (fieldsIterator.hasNext()) {
                Map.Entry<String, JsonNode> entry = fieldsIterator.next();
                String salle = entry.getKey();
                JsonNode sensorDataArray = entry.getValue();
                listSalle.add(salle);

                for (JsonNode sensorDataNode : sensorDataArray) {
                    String date = null;
                    Double temperature = 0.0;
                    Double humidity = 0.0;
                    Double activity = 0.0;
                    Double co2 = 0.0;
                    Double pressure = 0.0;
                    Double infrared = 0.0; // Ajoutez le
                    Double illuminance = 0.0; // Ajoutez
                    Double tvoc = 0.0; // Ajoutez le champ tvoc
                    Double infraredand = 0.0; // Ajoutez
                    try {
                        date = sensorDataNode.get("date").asText();
                        temperature = sensorDataNode.get("temperature").asDouble();
                        humidity = sensorDataNode.get("humidity").asDouble();
                        activity = sensorDataNode.get("activity").asDouble();
                        co2 = sensorDataNode.get("co2").asDouble();
                        pressure = sensorDataNode.get("pressure").asDouble();
                        infrared = sensorDataNode.get("infrared").asDouble(); // Ajoutez le
                        illuminance = sensorDataNode.get("illuminance").asDouble(); // Ajoutez
                        tvoc = sensorDataNode.get("tvoc").asDouble(); // Ajoutez le champ tvoc
                        infraredand = sensorDataNode.get("infraredand").asDouble(); // Ajoutez
                    } catch (Exception e) {
                    }

                    listDate.add(date);
                    listTemp.add(temperature);
                    listHumidity.add(humidity);
                    listAct.add(activity);
                    listCO2.add(co2);
                    listPression.add(pressure);
                    listIfrared.add(infrared);
                    listIllumi.add(illuminance);
                    listTVOC.add(tvoc);
                    listIfraredand.add(infraredand);
                }
            }
        } catch (Exception e) {
            e.printStackTrace(); // Gérer l'exception de manière appropriée
        }
    }

    private void updateGraphData(LineChart<String, Number> _graph, List<Double> _listData) {

        _graph.getData().clear();

        for (int index = 0; index < listSalle.size(); index++) {
            String id = listSalle.get(index);
            XYChart.Series<String, Number> series = new XYChart.Series<>();
            series.setName(id);

            double value = _listData.get(index);
            XYChart.Data<String, Number> chartData = new XYChart.Data<>(listDate.get(index),
                    value);
            series.getData().add(chartData);

            _graph.setLegendVisible(false);
            _graph.getData().add(series);
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