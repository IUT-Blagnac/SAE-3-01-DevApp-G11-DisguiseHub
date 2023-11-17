import configparser
import os
import paho.mqtt.client as mqtt
import json
import csv
import time
from datetime import datetime
import threading

# Charger les paramètres depuis le fichier de configuration
config = configparser.ConfigParser()
config.read(os.path.join(os.path.dirname(__file__), 'Config.ini'))

broker_address = config['MQTT']['broker_address']
port = int(config['MQTT']['port'])
topic = config['MQTT']['topic']
room_key = config['observateur']['room']
humidity_key = config['observateur']['humidity']
temperature_key = config['observateur']['temperature']
co2_key = config['observateur']['co2']
tvoc_key = config['observateur']['tvoc']
seuil_temperature_key = config['observateur']['seuil_temperature']
seuil_humidity_key = config['observateur']['seuil_humidity']
seuil_co2_key = config['observateur']['seuil_co2']

# Chemins des fichiers d'alerte
chemin_alerte_temperature = r"alertes_temperature.txt"
chemin_alerte_humidity = r"alertes_humidity.txt"
chemin_alerte_co2 = r"alertes_co2.txt"

# Chemin du fichier CSV
chemin_fichier_csv = r"données.csv"

# Callback lorsque la connexion MQTT est établie
def on_connect(client, userdata, flags, rc):
    if rc == 0:
        print("Connexion établie avec succès.")
        # S'abonner au topic spécifique pour recevoir les données des capteurs
        client.subscribe(topic)
    else:
        print(f"Échec de la connexion avec le code de retour: {rc}")

# Fonction pour vérifier les seuils d'alerte
def verifier_alertes(tab1, tab2):
    # Vérifier les seuils de température
    temperature = float(tab1.get(temperature_key))
    temperature_max = float(tab2.get(seuil_temperature_key))
    if temperature > temperature_max:
        enregistrer_alerte(chemin_alerte_temperature, tab2.get(room_key), "Température", temperature)

    # Vérifier les seuils d'humidité
    humidity = float(tab1.get(humidity_key))
    humidity_max = float(tab2.get(seuil_humidity_key))
    if humidity > humidity_max:
        enregistrer_alerte(chemin_alerte_humidity, tab2.get(room_key), "Humidité", humidity)
    
    # Vérifier les seuils de CO2
    co2 = float(tab1.get(co2_key))
    co2_max = float(tab2.get(seuil_co2_key))
    if co2 > co2_max:
        enregistrer_alerte(chemin_alerte_co2, tab2.get(room_key), "CO2", co2)

# Fonction pour enregistrer une alerte dans un fichier
def enregistrer_alerte(chemin_alerte, room, type_alerte, valeur):
    with open(chemin_alerte, 'a', newline='', encoding='utf-8') as fichier_alerte:
        writer = csv.writer(fichier_alerte)
        writer.writerow([datetime.now(), room, type_alerte, valeur])


# Callback lorsqu'un message MQTT est reçu
def on_message(client, userdata, msg):
    try:
        # Charger le message JSON
        data = json.loads(msg.payload.decode())
        tab1 = data[0]
        tab2 = data[1]
        
        # Obtenir la date et l'heure actuelles
        now = datetime.now()
        date_heure_actuelles = now.strftime("%Y-%m-%d %H:%M:%S")
        
        # Afficher les données
        print("Données:")
        print(f"   room: {tab2.get(room_key)}")
        print(f"   Humidity: {tab1.get(humidity_key)}")
        print(f"   Temperature: {tab1.get(temperature_key)}")
        print(f"   CO2: {tab1.get(co2_key)}")
        print(f"   TVOC: {tab1.get(tvoc_key)}")

        # Vérifier les seuils d'alerte
        verifier_alertes(tab1, tab2)

        # Écriture des données dans le fichier CSV
        with open(chemin_fichier_csv, 'a', newline='', encoding='utf-8') as fichier_csv:
            writer = csv.writer(fichier_csv)
            writer.writerow([
                date_heure_actuelles,  # Ajout de la date et de l'heure actuelles
                tab2.get(room_key),
                tab1.get(humidity_key),
                tab1.get(temperature_key),
                tab1.get(co2_key),
                tab1.get(tvoc_key)
            ])
    except json.JSONDecodeError as e:
        print("Erreur de décodage JSON:", e)

# Initialiser le client MQTT
client = mqtt.Client()

# Configuration des callbacks
client.on_connect = on_connect
client.on_message = on_message

# Connexion au broker MQTT
client.connect(broker_address, port, 60)

# Maintenir la connexion MQTT active
client.loop_forever()


