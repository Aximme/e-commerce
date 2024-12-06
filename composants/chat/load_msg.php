<?php
require_once '../../db.php';
session_start();
header('Content-Type: application/json');
try {
    if (!isset($_SESSION['client'])) {
        echo json_encode([]);
        exit;
    }
    $deleteQuery = "DELETE FROM Messages WHERE TIMESTAMPDIFF(MINUTE, date_envoi, NOW()) > 10";
    getBD($deleteQuery);
    $query = "SELECT nom, texte FROM Messages ORDER BY date_envoi ASC";
    $result = getBD($query);
    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
    echo json_encode($messages);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>