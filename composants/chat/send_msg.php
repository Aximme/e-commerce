<?php
require_once '../../db.php';
session_start();
header('Content-Type: application/json');
try {
    if (!isset($_SESSION['client'])) {
        http_response_code(403);
        echo json_encode(['error' => 'Non autorisé']);
        exit;
    }
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($input['texte']) || strlen($input['texte']) > 256) {
        http_response_code(400);
        echo json_encode(['error' => 'Message invalide ou trop long']);
        exit;
    }
    $texte = htmlspecialchars($input['texte']);
    $nom = htmlspecialchars($_SESSION['client']['prenom']);
    $query = "INSERT INTO Messages (nom, texte, date_envoi) VALUES (?, ?, NOW())";
    $stmt = getBD()->prepare($query);
    $stmt->bind_param("ss", $nom, $texte);
    $stmt->execute();
    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>