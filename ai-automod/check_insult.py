import mysql.connector
from sentence_transformers import SentenceTransformer, util
import pickle
import sys
import json
import torch

model = SentenceTransformer('paraphrase-multilingual-MiniLM-L12-v2', device='cpu')

connexion = mysql.connector.connect(
    host="localhost",
    user="root",
    password="root",
    database="MIROFF_Airplanes"
)

curseur = connexion.cursor()
curseur.execute("SELECT mot, vecteur FROM insultvectors")
insultes = []
vecteurs = []

for mot, vecteur_binaire in curseur.fetchall():
    insultes.append(mot)
    vecteurs.append(pickle.loads(vecteur_binaire))

curseur.close()
connexion.close()

message = sys.argv[1]

vecteur_message = model.encode(message, convert_to_tensor=True)

# comparaison avec les vecteurs des autres insultes
similarites = util.pytorch_cos_sim(vecteur_message, vecteurs)
max_similarite = similarites.max().item()

if max_similarite > 0.8:
    print(json.dumps({"insulte": True, "max_similarite": max_similarite}))
else:
    print(json.dumps({"insulte": False, "max_similarite": max_similarite}))