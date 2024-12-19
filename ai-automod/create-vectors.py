import mysql.connector
from sentence_transformers import SentenceTransformer
import pickle

connexion = mysql.connector.connect(
    host="localhost",
    user="root",
    password="root",
    database="MIROFF_Airplanes"
)
curseur = connexion.cursor()

model = SentenceTransformer('paraphrase-multilingual-MiniLM-L12-v2', device='cpu')

with open('bad-words.txt', 'r', encoding='utf-8') as file:
    insultes = [line.strip() for line in file.readlines()]

for mot in insultes:
    vecteur = model.encode(mot)
    vecteur_binaire = pickle.dumps(vecteur)
    
    curseur.execute(
        "INSERT INTO insultvectors (mot, vecteur) VALUES (%s, %s)",
        (mot, vecteur_binaire)
    )

connexion.commit()
curseur.close()
connexion.close()
print("Base de données remplie avec succès.")