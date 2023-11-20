import yaml, json, signal, threading, sys, time
import paho.mqtt.client as mqtt

# Connexion au MQTT et abonnement au topic
def on_connect(client, userdata, flags, rc):
    client.subscribe(config["connection"]["topic"])
    print("🔗 Connecté avec le code " + str(rc))

# Réception des données
def on_message(client, userdata, msg):
    # Décodage du message
    payload = json.loads(msg.payload)

    # Vérification de la présence de données
    if not (msg.payload):
        return
    elif not (payload[1]):
        return
    
    # Découpage des données
    salle = payload[1]["room"]
    donnee = payload[0]
    temps = int(time.time())

    # Message dans la console
    print("📥 Données reçues de la salle \"" + salle + "\" (" + str(len(donnee)) + " données)")

    # Ajout des données voulues dans le jeu de données
    if salle not in data:
        data[salle] = {}
    
    data[salle][temps] = {}
    
    for (cle, valeur) in donnee.items():
        if (cle in config["collecte"]):
            data[salle][temps][cle] = valeur

            # Vérification des alertes
            if not (cle in config["alerte"]):
                continue
            if (config["alerte"][cle]["min"] > valeur or config["alerte"][cle]["max"] < valeur):
                if salle not in alerte:
                    alerte[salle] = {}
                if temps not in alerte[salle]:
                    alerte[salle][temps] = {}
                alerte[salle][temps][cle] = valeur

                # Message dans la console
                print("🚨 Anomalie dans la salle \"" + salle + "\" pour la donnée \"" + cle + "\" : " + str(valeur))

# Ecriture des données dans le fichier
def write():
    # Ecriture des données dans le fichier
    with open(config["ecriture"]["fichiers"]["data"] + ".json", "w") as file:
        json.dump(data, file)
    with open(config["ecriture"]["fichiers"]["alerte"] + ".json", "w") as file:
        json.dump(alerte, file)

    # Rafraichissement des données
    dataload()

    # Message dans la console
    print("💾 Données enregistrées")

    # Redémarrage du timer
    if (sys.platform.startswith("win")):
        timer = threading.Timer(config["ecriture"]["intervale"], write)
        timer.start()
    elif (sys.platform.startswith("linux")):
        signal.alarm(config["ecriture"]["intervale"])

# Lecture des données
def dataload():
    global config, data, alerte
    with open("config.yaml", "r") as file:
        config = yaml.safe_load(file)
    with open(config["ecriture"]["fichiers"]["data"] + ".json", "r") as file:
        data = json.load(file)
    with open(config["ecriture"]["fichiers"]["alerte"] + ".json", "r") as file:
        alerte = json.load(file)

# Initialisation des variables
dataload()

# Intervalle en fonction du système d'exploitation
if (sys.platform.startswith("win")):
    timer = threading.Timer(config["ecriture"]["intervale"], write)
    timer.start()
elif (sys.platform.startswith("linux")):
    signal.signal(signal.SIGALRM, write)

# Connexion au MQTT
client = mqtt.Client()
client.on_connect = on_connect
client.on_message = on_message
client.connect(config["connection"]["host"], config["connection"]["port"], 60)
client.loop_forever()