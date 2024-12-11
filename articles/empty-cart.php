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
    </nav>
</header>


<section class='empty-cart-container'>
    <div class='empty-cart-card'>
        <h3>Votre panier est vide</h3>
        <p>Vous n'avez actuellement aucun article dans votre panier.</p>
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
