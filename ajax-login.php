<?php
session_start();
require_once 'db.php';
header('Content-Type: application/json');

function setErrorResponse($message) {
    echo json_encode(['success' => false, 'message' => $message]);
    exit();
}

function setSuccessResponse($message) {
    echo json_encode(['success' => true, 'message' => $message]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    setErrorResponse('Méthode non autorisée.');
}

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    setErrorResponse('Veuillez remplir tous les champs.');
}

try {
    $sql = "SELECT * FROM Clients WHERE email = ?";
    $resultat = getBD($sql, [$email]);

    if ($resultat && $resultat->num_rows === 1) {
        $client = $resultat->fetch_assoc();

        if (password_verify($password, $client['mdp'])) {
            $_SESSION['client'] = array(
                'id_client' => $client['id_client'],
                'nom' => $client['nom'],
                'prenom' => $client['prenom'],
                'adresse' => $client['adresse'],
                'email' => $client['email'],
                'telephone' => $client['telephone'],
                'ID_STRIPE' => $client['ID_STRIPE']
            );
            setSuccessResponse('Connexion réussie.');
        } else {
            setErrorResponse('Email ou mot de passe incorrect.');
        }
    } else {
        setErrorResponse('Email ou mot de passe incorrect.');
    }
} catch (Exception $e) {
    error_log("Erreur lors de la connexion : " . $e->getMessage());
    setErrorResponse('Erreur serveur. Veuillez réessayer plus tard.');
}
?>