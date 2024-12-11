<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['client'])) {
    echo "<div class='panier-error'>Erreur : Connectez vous pour acceder à votre panier.</div>";
    exit();
}

if (!isset($_SESSION['panier']) || count($_SESSION['panier']) == 0) {
    echo '<meta http-equiv="refresh" content="0;url=../articles/empty-cart.php">';
    exit();
}

$panier = $_SESSION['panier'];
$total_commande = 0;


include '../composants/chat/chat_component.php';

?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>

<header class="header">
    <div class="logo-container">
        <img src="../images/logo_rbg.png" alt="AcheteTonAvion.gouv.fr Logo" class="logo">
    </div>

    <div class="centered-title">
        <h1>French Aeronautics</h1>
        <h2 class="welcome">Panier</h2>
    </div>

    <nav>
        <a href="../index.php" class="bn3">🏠 Accueil</a>
        <a href="../contact/contact.php" class="bn3">☎️ Contact</a>
        <a href="../deconnexion.php" class="bn3">🔓 Se déconnecter</a>
    </nav>
</header>

<section class="panier-container">
    <div class="panier-titles">
        <div class="panier-title-name"> </div>
        <div class="panier-title-price">Prix Unitaire (M€)</div>
        <div class="panier-title-quantity">Quantité</div>
        <div class="panier-title-total">Total (M€)</div>
    </div>
    <div class="panier-items">
        <?php
        foreach ($panier as $article) {
            $id_art = $article['id_art'];
            $quantite = $article['quantite'];

            $sql = "SELECT nom, prix FROM Articles WHERE id_art = '$id_art'";
            $resultat = getBD($sql);

            if ($resultat->num_rows > 0) {
                $id_art = $article['id_art'];
                $ligne = $resultat->fetch_assoc();
                $nom = $ligne['nom'];
                $prix_unitaire = floatval($ligne['prix']);
                $prix_total = $prix_unitaire * intval($quantite);

                $total_commande += $prix_total;

                echo "<div class='panier-item'>";
                echo "<div class='panier-item-name'>ID : $id_art | $nom</div>";
                echo "<div class='panier-item-price'>$prix_unitaire</div>";
                echo "<div class='panier-item-quantity'>$quantite</div>";
                echo "<div class='panier-item-total'>$prix_total</div>";
                echo "</div>";
            }
        }
        ?>
    </div>

    <div class="panier-summary">
        <h3>Total Commande : <?php echo $total_commande; ?> Millions d'euros</h3>
    </div>
</section>

<?php if ($total_commande > 0) : ?>
    <form action="commande.php" method="post" class="panier-commande">
        <input type="hidden" name="auth_token" value="<?php echo $_SESSION['auth_token']; ?>">
        <button type="submit" class="btn-commande">Passer la commande</button>
    </form>
<?php endif; ?>


<div id="footer-placeholder"></div>
<script>
    fetch("../composants/footer.html")
        .then(response => response.text())
        .then(data => {
            document.getElementById("footer-placeholder").innerHTML = data;
        });
</script>
</body>
</html>
