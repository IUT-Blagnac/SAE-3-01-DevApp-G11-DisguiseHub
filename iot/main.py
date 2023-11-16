import yaml, json, os, sys, time
import paho.mqtt.client as mqtt
import pandas as pd

donnee_par_salle = {}

def on_connect(client, userdata, flags, rc):
    print("Connected with result code "+str(rc))
    client.subscribe("AM107/by-room/+/data")

def on_message(client, userdata, msg):
    print(msg.topic+" "+str(msg.payload))
    payload = json.loads(msg.payload)

    # salle[msg.topic.split("/")[2]] = msg.payload

    salle = payload[1]["room"]
    donnee = payload[0]

    temps = time.time()

    if salle not in donnee_par_salle:
        donnee_par_salle[salle] = {}

    donnee_par_salle[salle][temps] = donnee

    temps_ecoule = time.time() - temps_final_lecture

    if temps_ecoule > config["capteur"]["ecriture"]["temps"] / 1000:
        write()

def write():
    if(sys.platform.startswith("win")):
        print("Windows")
    elif(sys.platform.startswith("linux")):
        print("Linux")
    
    with open("data.json", "w") as file:
        json.dump(donnee_par_salle, file)

    global temps_final_ecriture
    temps_final_lecture = time.time()
    

client = mqtt.Client()
client.on_connect = on_connect
client.on_message = on_message

with open("config.yaml", "r") as file:
    config = yaml.safe_load(file)

client.connect(config["capteur"]["connection"]["host"], config["capteur"]["connection"]["port"], 60)

temps_final_lecture = time.time()

client.loop_forever()