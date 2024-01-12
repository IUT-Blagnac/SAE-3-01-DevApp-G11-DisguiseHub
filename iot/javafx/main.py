# -*- coding: utf-8 -*-
#!/usr/bin/env python3

import os, yaml, json, signal, threading, sys, time
import paho.mqtt.client as mqtt

# Connexion au MQTT et abonnement au topic
def on_connect(client, userdata, flags, rc):
    client.subscribe(config["connection"]["topic"])
    print("🔗 Connecté avec le code " + str(rc) + " à " + config["connection"]["host"] + ":" + str(config["connection"]["port"]) + " sur le topic " + config["connection"]["topic"])

    # Intervalle en fonction du système d'exploitation (Linux : alertes)
    if (sys.platform.startswith("linux")):
        signal.signal(signal.SIGALRM, unixwrite)
        signal.alarm(config["ecriture"]["intervale"])
    else:
        timer = threading.Timer(config["ecriture"]["intervale"], write)
        timer.start()

# Réception des données
def on_message(client, userdata, msg):
    # Vérification du topic
    if(msg.topic == "AM107/by-room/undefined/data"):
        print("❌ Salle non définie")
        return
    
    # Décodage du message
    payload = json.loads(msg.payload)
    
    # Découpage des données
    salle = payload[1]["room"]
    donnee = payload[0]
    temps = int(time.time())
    isalerte = False

    # Message dans la console
    print("📥 Données reçues de la salle \"" + salle + "\" (" + str(len(donnee)) + " données)")

    # Ajout de la salle si elle n'existe pas
    if salle not in data:
        data[salle] = []

    # Création d'une nouvelle donnée avec la date actuelle
    data[salle].append( { "date": temps } )
    
    # Parcours des données
    for (cle, valeur) in donnee.items():
        # Ajout des données voulues dans la donnée
        if (cle in config["collecte"]):
            data[salle][len(data[salle]) - 1][cle] = valeur

            # Si conditions d'alertes non-fixées annuler
            if not (cle in config["alerte"]):
                continue
            # Vérification des alertes
            if (config["alerte"][cle]["min"] > valeur or config["alerte"][cle]["max"] < valeur):
                # Ajout de la salle si elle n'existe pas
                if salle not in alerte:
                    alerte[salle] = []
                
                # Création d'une nouvelle donnée avec la date actuelle
                if not isalerte:
                    alerte[salle].append( { "date": temps } )
                    isalerte = True

                # Ajout des données anormales dans la donnée
                alerte[salle][len(alerte[salle]) - 1][cle] = valeur

                # Message dans la console
                print("🚨 Anomalie dans la salle \"" + salle + "\" pour la donnée \"" + cle + "\" : " + str(valeur))

# Ecriture des données dans le fichier
def write():
    # Ecriture des données dans le fichier en fonction du système d'exploitation (Linux : appels système)
    if (sys.platform.startswith("linux")):
        try:
            os.write(os.open(config["ecriture"]["fichiers"]["data"] + ".json", os.O_WRONLY | os.O_TRUNC), json.dumps(data).encode())
            os.write(os.open(config["ecriture"]["fichiers"]["alerte"] + ".json", os.O_WRONLY | os.O_TRUNC), json.dumps(alerte).encode())
        except Exception as e:
            print("❌ Impossible d'écrire dans le fichier :", str(e))
    else:
        with open(config["ecriture"]["fichiers"]["data"] + ".json", "w") as file:
            json.dump(data, file)
        with open(config["ecriture"]["fichiers"]["alerte"] + ".json", "w") as file:
            json.dump(alerte, file)
    
    # Rafraichissement des données
    dataload()

    # Message dans la console
    print("💾 Données enregistrées")

    # Redémarrage du timer en fonction du système d'exploitation (Linux : alertes)
    if (sys.platform.startswith("linux")):
        signal.alarm(config["ecriture"]["intervale"])
    else:
        timer = threading.Timer(config["ecriture"]["intervale"], write)
        timer.start()

# Appel de write spécifique à UNIX car on a pas besoin de numero et frame (qui sont passés en paramètres par l'alerte)
def unixwrite(numero, frame):
	write()

# Lecture des données
def dataload():
    global config, data, alerte

    if os.path.exists("config.yaml"):
        if (sys.platform.startswith("linux")):
            config_fd = os.open("config.yaml", os.O_RDONLY)
            config_content = os.read(config_fd, os.path.getsize("config.yaml"))
            os.close(config_fd)
            config = yaml.safe_load(config_content)
        else:
            with open("config.yaml", "r") as file:
                config = yaml.safe_load(file)
    else:
        print("❌ Fichier de configuration introuvable")
        exit()

    data = readfile(config["ecriture"]["fichiers"]["data"] + ".json")
    
    alerte = readfile(config["ecriture"]["fichiers"]["alerte"] + ".json")

# Lecture du fichier, création si inexistant, retourne le contenu
def readfile(file):
    if (sys.platform.startswith("linux")):
        if os.path.getsize(file) > 0:
            data_fd = os.open(file, os.O_RDONLY)
            data_content = os.read(data_fd, os.path.getsize(file))
            os.close(data_fd)
            data = json.loads(data_content)
        else:
            data = {}
            try:
                data_fd = os.open(file, os.O_WRONLY | os.O_CREAT | os.O_TRUNC)
                os.write(data_fd, json.dumps(data).encode())
                print("📝 Fichier \"" + str(file) + "\" créé")
            except Exception as e:
                print("❌ Impossible de créer le fichier :", str(e))
    else:
        if os.path.exists(file):
            if os.path.getsize(file) > 0:
                with open(file, "r") as file:
                    data = json.load(file)
            else:
                data = {}
                with open(file, "w") as file:
                    json.dump(data, file)
                    print("📝 Fichier \"" + str(file) + "\" créé")
        else:
            data = {}
            with open(file, "w") as file:
                json.dump(data, file)
                print("📝 Fichier \"" + str(file) + "\" créé")
    return data

# Initialisation des variables
dataload()

# Connexion au MQTT
client = mqtt.Client()
client.on_connect = on_connect
client.on_message = on_message
client.connect(config["connection"]["host"], config["connection"]["port"], 60)
client.loop_forever()