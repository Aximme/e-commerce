<?php
require_once 'db.php';
session_start();
if(isset($_SESSION['client'])) {
    if(empty($_SESSION['auth_token'])) {
        $_SESSION['auth_token'] = bin2hex(random_bytes(128));
    }
}

include 'composants/chat/chat_component.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./styles/style.css">
    <title>AcheteTonAvion.gouv.fr</title>
</head>

<body>

<header class="header">
    <div class="logo-container">
        <img src="../Miroff_Airplanes/images/logo_rbg.png" alt="AcheteTonAvion.gouv.fr Logo" class="logo">
    </div>

    <div class="centered-title">
        <h1>French Aeronautics</h1>
        <h2 class="welcome">
            <?php if (isset($_SESSION['client'])): ?>
                Bienvenue, <?php echo htmlspecialchars($_SESSION['client']['prenom'] . ' ' . $_SESSION['client']['nom']); ?> !
            <?php else: ?>
                Bienvenue sur notre site de vente d'avions militaires français !
            <?php endif; ?>
        </h2>
    </div>

    <nav>
        <a href="index.php" class="bn3">🏠 Accueil</a>
        <a href="../Miroff_Airplanes/contact/contact.php" class="bn3">☎️ Contact</a>

        <?php if (!isset($_SESSION['client'])): ?>
            <a href="login.php" class="bn3">📥 Connexion</a>
            <a href="create-account.php" class="bn3">👤 Créer un compte</a>
        <?php else: ?>
            <a href="./articles/cart.php" class="bn3">🛒 Panier</a>
            <a href="./articles/historique.php" class="bn3">📝 Historique</a>
            <a href="deconnexion.php" class="bn3">🔓 Se déconnecter</a>
        <?php endif; ?>
    </nav>
</header>

<main>
    <table border="1">
        <thead>
        <tr>
            <th>Identifiant Article</th>
            <th>Descriptif de l'Article</th>
            <th>Quantité en Stock</th>
            <th>Prix (en Millions d'€)</th>
        </tr>
        </thead>
        <tbody>
        <?php
        try {
            $sql = "SELECT id_art, nom, quantite, prix FROM Articles";
            $resultat = getBD($sql);

            if ($resultat->num_rows > 0) {
                while ($ligne = $resultat->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($ligne["id_art"]) . "</td>";
                    echo "<td><a href='articles/article.php?id_art=" . urlencode($ligne["id_art"]) . "'>" . htmlspecialchars($ligne["nom"]) . "</a></td>";
                    echo "<td>" . htmlspecialchars($ligne["quantite"]) . "</td>";
                    echo "<td>" . htmlspecialchars($ligne["prix"]) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Aucun article disponible</td></tr>";
            }
        } catch (Exception $e) {
            echo "Une erreur s'est produite : " . htmlspecialchars($e->getMessage());
        }
        ?>
        </tbody>
    </table>
</main>
</body>

<div id="footer-placeholder"></div>

<script>
    fetch("../Miroff_Airplanes/composants/footer.html")
        .then(response => response.text())
        .then(data => {
            document.getElementById("footer-placeholder").innerHTML = data;
        });
</script>
</html>