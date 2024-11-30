<?php
session_start();
require_once 'db.php';
require_once 'stripe.php';
header('Content-Type: application/json');

function setErrorResponse($message) {
    echo json_encode(['success' => false, 'error' => $message]);
    exit();
}

function setSuccessResponse($message) {
    echo json_encode(['success' => true, 'message' => $message]);
    exit();
}

function emailExiste($email) {
    try {
        $sql = "SELECT COUNT(*) as total FROM Clients WHERE email = ?";
        $resultat = getBD($sql, [$email]);

        $row = $resultat->fetch_assoc();
        return ($row['total'] > 0);
    } catch (Exception $e) {
        error_log("Erreur dans emailExiste : " . $e->getMessage());
        return false;
    }
}

function enregistrer($nom, $prenom, $adresse, $telephone, $email, $motDePasse, $idStripe) {
    try {
        $sql = "INSERT INTO Clients (nom, prenom, adresse, telephone, email, mdp, ID_STRIPE) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $connexion = getBD();
        $stmt = $connexion->prepare($sql);

        if (!$stmt) {
            throw new Exception('Erreur de préparation SQL : ' . $connexion->error);
        }

        $stmt->bind_param('sssssss', $nom, $prenom, $adresse, $telephone, $email, $motDePasse, $idStripe);

        if (!$stmt->execute()) {
            throw new Exception('Erreur d\'exécution SQL : ' . $stmt->error);
        }

        return true;
    } catch (Exception $e) {
        error_log("Erreur dans enregistrer : " . $e->getMessage());
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    setErrorResponse('Méthode non autorisée.');
}

$nom = $_POST['n'] ?? '';
$prenom = $_POST['p'] ?? '';
$adresse = $_POST['adr'] ?? '';
$telephone = $_POST['num'] ?? '';
$email = $_POST['mail'] ?? '';
$motDePasse = $_POST['mdp1'] ?? '';
$confirmMotDePasse = $_POST['mdp2'] ?? '';

if (empty($nom) || empty($prenom) || empty($adresse) || empty($telephone) || empty($email) || empty($motDePasse)) {
    setErrorResponse('Tous les champs sont requis.');
}

if ($motDePasse !== $confirmMotDePasse) {
    setErrorResponse('Les mots de passe ne correspondent pas.');
}

if (emailExiste($email)) {
    setErrorResponse('Cet email est déjà utilisé.');
}

$motDePasseCrypt = password_hash($motDePasse, PASSWORD_DEFAULT);

try {
    $customer = $stripe->customers->create([
        'name' => $prenom . ' ' . $nom,
        'email' => $email,
        'phone' => $telephone,
        'address' => [
            'line1' => $adresse,
        ],
    ]);

    $idStripe = $customer->id;
} catch (\Stripe\Exception\ApiErrorException $e) {
    setErrorResponse('Erreur lors de la création du compte Stripe : ' . $e->getMessage());
}

if (enregistrer($nom, $prenom, $adresse, $telephone, $email, $motDePasseCrypt, $idStripe)) {
    setSuccessResponse('Compte créé avec succès.');
} else {
    setErrorResponse('Erreur lors de l’enregistrement en base de données.');
}
?>