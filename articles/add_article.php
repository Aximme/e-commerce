<?php
session_start();

if (empty($_SESSION['auth_token']) || $_SESSION['auth_token'] !== $_POST['auth_token']) {
    $_SESSION['auth_token'] = bin2hex(random_bytes(128));
    echo "<meta http-equiv='refresh' content='0;url=../connexion.php?error=token'>";
    exit();
}

if (isset($_POST['id_art']) && isset($_POST['quantite'])) {
    $id_art = $_POST['id_art'];
    $quantite = $_POST['quantite'];

    if (!is_numeric($quantite)) {
        echo "La quantité doit être un nombre.";
        exit();
    }

    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = array();
    }

    $article = array(
        'id_art' => $id_art,
        'quantite' => $quantite
    );

    array_push($_SESSION['panier'], $article);

    print_r($_SESSION['panier']);

    echo '<meta http-equiv="refresh" content="0;url=../index.php">';
    exit();
} else {
    echo "Les données de l'article n'ont pas été correctement envoyées.";
}
?>