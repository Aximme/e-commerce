<?php
session_start();
require_once '../../db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['client'])) {
    error_log("Utilisateur non connecté.");
    http_response_code(401);
    echo json_encode(['error' => 'Vous devez être connecté pour envoyer un message.']);
    exit;
}

function verifier_insulte($message) {
    error_log("Appel à vérifier_insulte avec message : $message");
    $escaped_message = escapeshellarg($message);
    $output = shell_exec("/Library/Frameworks/Python.framework/Versions/3.12/bin/python3 /Applications/MAMP/htdocs/Miroff_Airplanes/ai-automod/check_insult.py $escaped_message");

    if ($output === null) {
        error_log("Erreur : script Python n'a pas pu être exécuté.");
        return ['error' => 'Erreur interne lors de la vérification des insultes.'];
    }

    error_log("Réponse du script Python : $output");

    $result = json_decode($output, true);
    if ($result === null) {
        error_log("Erreur : JSON retourné par le script Python invalide.");
        return ['error' => 'Erreur lors de l’analyse du message.'];
    }

    return $result;
}

$data = json_decode(file_get_contents('php://input'), true);
$message = trim($data['texte'] ?? '');

$insulte_check = verifier_insulte($message);
if (isset($insulte_check['error'])) {
    http_response_code(500);
    echo json_encode(['error' => $insulte_check['error']]);
    exit;
}

if ($insulte_check['insulte']) {
    http_response_code(403);
    echo json_encode(['error' => 'Message offensant détecté.']);
    exit;
}

try {
    error_log("Insertion du message : " . $message);
    getBD(
        "INSERT INTO messages (nom, texte, date_envoi) VALUES (?, ?, NOW())",
        [$_SESSION['client']['prenom'], $message]

    );
    echo json_encode(['success' => true]);
    error_log("Message inséré avec succès.");
} catch (Exception $e) {
    error_log("Erreur lors de l'insertion : " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors de l\'insertion du message.', 'details' => $e->getMessage()]);
    exit;
}
?>