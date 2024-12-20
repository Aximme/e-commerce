<?php
session_start();
require_once '../db.php';
require_once '../vendor/autoload.php';
require_once '../stripe.php';

if (empty($_SESSION['auth_token']) || $_SESSION['auth_token'] !== $_POST['auth_token']) {
    $_SESSION['auth_token'] = bin2hex(random_bytes(128));
    echo "<meta http-equiv='refresh' content='0;url=../connexion.php?error=token'>";
    exit();
}

if (!isset($_SESSION['client'])) {
    echo "<div class='commande-error'>Erreur : Connectez-vous pour passer une commande.</div>";
    exit();
}

if (!isset($_SESSION['panier']) || count($_SESSION['panier']) == 0) {
    echo "<meta http-equiv='refresh' content='0;url=../articles/empty-cart.php'>";
    exit();
}

$connexion = getBD();
$panier = $_SESSION['panier'];
$total_commande = 0;
$client_stripe_id = $_SESSION['client']['ID_STRIPE'];
$toto = [];

foreach ($panier as $article) {
    $id_art = $article['id_art'];
    $quantite = $article['quantite'];

    $sql = "SELECT nom, prix, ID_STRIPE FROM Articles WHERE id_art = ?";
    $stmt = $connexion->prepare($sql);
    if (!$stmt) {
        exit("Erreur SQL : " . $connexion->error);
    }

    $stmt->bind_param("i", $id_art);
    $stmt->execute();
    $result = $stmt->get_result();
    $article_data = $result->fetch_assoc();

    if (!$article_data || empty($article_data['ID_STRIPE'])) {
        exit("Erreur : Article introuvable ou non valide.");
    }

    $toto[] = [
        'price' => $article_data['ID_STRIPE'],
        'quantity' => intval($quantite),
    ];

    $total_commande += floatval($article_data['prix']) * intval($quantite);
}

try {
    $checkout_session = $stripe->checkout->sessions->create([
        'customer' => $client_stripe_id,
        'success_url' => 'http://localhost:80/Miroff_Airplanes/articles/commande-ok.php',
        'cancel_url' => 'http://localhost:80/Miroff_Airplanes/index.php',
        'mode' => 'payment',
        'automatic_tax' => ['enabled' => false],
        'line_items' => $toto,
    ]);

    foreach ($panier as $article) {
        $id_art = intval($article['id_art']);
        $quantite = intval($article['quantite']);

        $sql_insert_commande = "INSERT INTO Commandes (id_art, id_client, quantite) VALUES (?, ?, ?)";
        $stmt_insert_commande = $connexion->prepare($sql_insert_commande);
        $stmt_insert_commande->bind_param("iii", $id_art, $_SESSION['client']['id_client'], $quantite);
        $stmt_insert_commande->execute();
    }

    unset($_SESSION['panier']);

    header("HTTP/1.1 303 See Other");
    header("Location: " . $checkout_session->url);
    exit();

} catch (\Stripe\Exception\ApiErrorException $e) {
    exit("Erreur Stripe : " . $e->getMessage());
}
?>