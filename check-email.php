<?php
require_once 'db.php';

header('Content-Type: application/json');

if (isset($_POST['email'])) {
    $email = trim($_POST['email']);

    $sql = "SELECT COUNT(*) AS count FROM Clients WHERE email = ?";
    $result = getBD($sql, [$email]);
    $row = $result->fetch_assoc();

    echo json_encode(['exists' => (bool)$row['count']]);
    exit;
}

http_response_code(400);
echo json_encode(['error' => 'Paramètre email manquant']);
exit;