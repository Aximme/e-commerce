import os
import csv
import json
from collections import Counter
import pandas as pd

# Prétraitement du texte : mise en minuscule et séparation en mots
def preprocess_text(text):
    return text.lower().split()

# Chargement des textes et labels depuis le CSV et les fichiers texte
def load_text_data(csv_path, texts_folder):
    textes, labels = [], []
    with open(csv_path, 'r', encoding='utf-8') as csv_file:
        csv_reader = csv.reader(csv_file)
        next(csv_reader)
        for row in csv_reader:
            label, text_file_name = row[4], row[0]
            text_file_path = os.path.join(texts_folder, f"{text_file_name}.txt")
            if os.path.exists(text_file_path):
                with open(text_file_path, 'r', encoding='utf-8') as file:
                    textes.append(file.read().strip())
                    labels.append(label)
    return textes, labels

# Calcul de l'IDF pour chaque mot
def calculate_idf(textes):
    word_document_count = Counter()
    for text in textes:
        word_document_count.update(set(preprocess_text(text)))
    total_documents = len(textes)
    return {word: total_documents / (count + 1) for word, count in word_document_count.items()}

# Création du ScoreMap en fonction des texte et label
def create_score_map(textes, labels, idf):
    score_map = {word: 0 for word in idf.keys()}
    for i, text in enumerate(textes):
        words, label = preprocess_text(text), labels[i]
        for word in words:
            tf_idf = (words.count(word) / len(words)) * idf[word]
            score_map[word] += tf_idf if label != 'hate' else -tf_idf
    return score_map

# Classification d'un texte avec le ScoreMap
def classify_text(text, score_map):
    words = preprocess_text(text)
    score_total = sum(score_map.get(word, 0) for word in words)
    return {'texte': text, 'score_total': score_total, 'valide': score_total > 0}

# Sauvegarde du ScoreMap dans un fichier JSON
def save_scoremap_to_json(score_map, output_path='score_map.json'):
    with open(output_path, 'w', encoding='utf-8') as f:
        json.dump(score_map, f, ensure_ascii=False, indent=4)

def main():
    csv_path = 'sampled_train/annotations_metadata.csv'
    texts_folder = 'sampled_train/sampled_train/'
    textes, labels = load_text_data(csv_path, texts_folder)
    idf = calculate_idf(textes)
    score_map = create_score_map(textes, labels, idf)
    save_scoremap_to_json(score_map, 'score_map.json')

    # Test de classification
    test_text = "hi, how are you"
    result = classify_text(test_text, score_map)
    print("Texte : " + result['texte'] + ", Score : " + str(result['score_total']) + ", Valide : " + str(
        result['valide']))

if __name__ == "__main__":
    main()