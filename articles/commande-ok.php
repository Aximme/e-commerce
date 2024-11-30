<?php
session_start();

if (isset($_SESSION['panier'])) {
    unset($_SESSION['panier']);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../styles/style.css">
    <title>Contact</title>
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


<section class='empty-cart-container'>
    <div class='okCommand-cart-card'>
        <h3>Commande Effectuée</h3>
        <p>Votre commande a bien été prise en compte !</p>
        <a href='../index.php' class='panier-btn'>Retour à l'accueil</a>
    </div>
</section>
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
