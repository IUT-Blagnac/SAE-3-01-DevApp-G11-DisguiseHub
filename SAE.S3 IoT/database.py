import dataclasses
import json
import sqlite3
from datetime import datetime

# Connexion à la base de données SQLite (crée le fichier s'il n'existe pas)
conn = sqlite3.connect('mqtt_data.db')
cursor = conn.cursor()

# Création de la table si elle n'existe pas
cursor.execute('''
    CREATE TABLE IF NOT EXISTS sensor_data (
        timestamp TEXT,
        topic TEXT,
        data TEXT
    )
''')
conn.commit()

# Fonction pour écrire les données dans la base de données
def write_to_database(data):
    timestamp = str(datetime.now())
    topic = data.get('topic', '')
    data_json = json.dumps(data)
    
    # Insertion des données dans la table
    cursor.execute('''
        INSERT INTO sensor_data (timestamp, topic, data)
        VALUES (?, ?, ?)
    ''', (timestamp, topic, data_json))
    
    conn.commit()

# Utilisation de la fonction dans la callback on_message
# ...
# Dans la fonction on_message, après avoir ajouté un horodatage aux données
write_to_database(dataclasses)
# ...
