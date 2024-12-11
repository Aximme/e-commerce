<?php
require_once '../../db.php';
session_start();
header('Content-Type: application/json');

try {
    if (!isset($_SESSION['client'])) {
        http_response_code(401);
        echo json_encode(['message' => '🚫 Vous devez être <a href="/../login.php">connecté</a> pour utiliser le chat.']);
        exit;
    }

    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($input['csrf_token']) || $input['csrf_token'] !== $_SESSION['auth_token']) {
        http_response_code(403);
        echo json_encode(['error' => 'Token CSRF invalide']);
        exit;
    }

    if (!isset($input['texte']) || strlen($input['texte']) > 256) {
        http_response_code(400);
        echo json_encode(['error' => 'Message invalide ou trop long']);
        exit;
    }

    $texte = $input['texte'];

    // verif msg offensant
    $score_map_path = '/Applications/MAMP/htdocs/Miroff_Airplanes/tf-idf_automod/score_map.json';
    if (file_exists($score_map_path)) {
        $score_map_json = file_get_contents($score_map_path);
        $score_map = json_decode($score_map_json, true);

        function preprocess_text($text) {
            $text = mb_strtolower($text, 'UTF-8');
            $words = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
            return $words;
        }

        function classify_text($text, $score_map) {
            $words = preprocess_text($text);
            $score_total = 0;
            foreach ($words as $word) {
                if (isset($score_map[$word])) {
                    $score_total += $score_map[$word];
                }
            }
            return $score_total;
        }

        $score_total = classify_text($texte, $score_map);
        if ($score_total <= 0) {
            http_response_code(403);
            echo json_encode(['message' => '🚫 Message offensant.']);
            exit;
        }
    }

    // Msg valide
    $texte = htmlspecialchars($texte);
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