<?php
session_start();
require_once '../db.php';

if (empty($_SESSION['auth_token']) || $_SESSION['auth_token'] !== $_POST['auth_token']) {
    $_SESSION['auth_token'] = bin2hex(random_bytes(128));
    echo "<meta http-equiv='refresh' content='0;url=../connexion.php?error=token'>";
    exit();
}

if (isset($_POST['id_art']) && isset($_POST['quantite'])) {
    $id_art = intval($_POST['id_art']);
    $quantite = intval($_POST['quantite']);

    if (!is_numeric($quantite) || $quantite <= 0) {
        echo "La quantité doit être un nombre valide.";
        exit();
    }

    $connexion = getBD();

    $sql_check_stock = "SELECT quantite FROM Articles WHERE id_art = ?";
    $stmt_check_stock = $connexion->prepare($sql_check_stock);
    $stmt_check_stock->bind_param("i", $id_art);
    $stmt_check_stock->execute();
    $result = $stmt_check_stock->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stock_disponible = intval($row['quantite']);

        if ($stock_disponible < $quantite) {
            echo "Quantité demandée supérieure au stock disponible.";
            exit();
        }

        $nouveau_stock = $stock_disponible - $quantite;
        $sql_update_stock = "UPDATE Articles SET quantite = ? WHERE id_art = ?";
        $stmt_update_stock = $connexion->prepare($sql_update_stock);
        $stmt_update_stock->bind_param("ii", $nouveau_stock, $id_art);
        $stmt_update_stock->execute();
    } else {
        echo "Article introuvable.";
        exit();
    }

    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = array();
    }

    $found = false;
    foreach ($_SESSION['panier'] as $key => $article) {
        if ($article['id_art'] == $id_art) {
            $_SESSION['panier'][$key]['quantite'] += $quantite;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['panier'][] = array(
            'id_art' => $id_art,
            'quantite' => $quantite
        );
    }

    $sql_insert_commande = "INSERT INTO Commandes (id_art, id_client, quantite) VALUES (?, ?, ?)";
    $stmt_insert_commande = $connexion->prepare($sql_insert_commande);
    $stmt_insert_commande->bind_param("iii", $id_art, $_SESSION['client']['id_client'], $quantite);
    $stmt_insert_commande->execute();

    echo '<meta http-equiv="refresh" content="0;url=../index.php">';
    exit();
} else {
    echo "Les données de l'article n'ont pas été correctement envoyées.";
}
?>