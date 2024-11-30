<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['client'])) {
    echo "<p>Vous devez être connecté pour voir l'historique des commandes.</p>";
    exit();
}

$id_client = $_SESSION['client']['id_client'];

$conn = getBD();

$sql = "
        SELECT c.id_commande, c.id_art, a.nom, a.prix, c.quantite, c.envoi
        FROM Commandes c
        INNER JOIN Articles a ON c.id_art = a.id_art
        WHERE c.id_client = ?
    ";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    throw new Exception("Erreur de préparation de la requête : " . $conn->error);
}

$stmt->bind_param("i", $id_client);
$stmt->execute();
$result = $stmt->get_result();

include '../composants/chat/chat_component.php';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <title>Historique des commandes</title>
</head>
<body>

<header class="header">
    <div class="logo-container">
        <img src="../images/logo_rbg.png" alt="AcheteTonAvion.gouv.fr Logo" class="logo">
    </div>

    <div class="centered-title">
        <h1>French Aeronautics</h1>
        <h2 class="welcome">Historique des commandes</h2>
    </div>

    <nav>
        <a href="../index.php" class="bn3">🏠 Accueil</a>
        <a href="../contact/contact.php" class="bn3">☎️ Contact</a>
        <a href="../deconnexion.php" class="bn3">🔓 Se déconnecter</a>
    </nav>
</header>

<h2>Historique de vos commandes</h2>

<?php
if ($result->num_rows > 0) {
    ?>
    <table border="1">
        <tr>
            <th>ID Commande</th>
            <th>ID Article</th>
            <th>Nom de l'article</th>
            <th>Prix</th>
            <th>Quantité</th>
            <th>État</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            $etat_commande = $row['envoi'] ? '<div class="etat-envoye">Envoyée</div>' : '<div class="etat non-envoye">Non envoyée</div>';
            ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id_commande']); ?></td>
                <td><?php echo htmlspecialchars($row['id_art']); ?></td>
                <td><?php echo htmlspecialchars($row['nom']); ?></td>
                <td><?php echo htmlspecialchars($row['prix']); ?> €</td>
                <td><?php echo htmlspecialchars($row['quantite']); ?></td>
                <td><?php echo $etat_commande; ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
} else {
    echo '<div class="login-for-cart">';
    echo "<p>Vous n'avez pas encore passé de commandes.</p>";
    echo '</div>';
}

$stmt->close();
$conn->close();
?>

</body>
</html>
