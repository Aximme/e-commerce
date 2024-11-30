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
        <h2 class="welcome">Nous Contacter / Présentation</h2>
    </div>

    <nav>
        <a href="../index.php" class="bn3">🏠 Accueil</a>
        <a href="../contact/contact.php" class="bn3">☎️ Contact</a>
    </nav>
</header>


<section class="team-member">
    <div class="card">
        <img src="../images/pp.png" alt="pp" class="card-img">
        <div class="card-content">
            <h2 class="card-title">Jean-Pierre Louis</h2>
            <p class="card-subtitle">Ancien pilote d'essai</p>
            <p class="card-text">
                Ingénieur aéronautique diplômé de l’École nationale de l’aviation civile, Jean-Pierre Louis est un pilote d'essai expérimenté. Après avoir débuté sa carrière chez <a href="https://www.airbus.com/en/products-services/defence">Airbus Space & Defense</a> où il a contribué au développement de lanceurs spatiaux, il a rejoint <a href="https://www.dassault-aviation.com/fr/">Dassault Aviation</a> en tant que pilote d'essai sur le programme Rafale.<br>Fort de milliers d'heures de vol, il a participé à la mise au point de nouvelles technologies et à l’évaluation des performances de l’avion. Passionné d'histoire de l'aviation, Jean-Pierre louis consacre une partie de son temps libre à la restauration d'avions anciens.
            </p>
            <a href="mailto:jean.louis@dassault.com" class="card-link">jean.louis@dassault.com</a>
        </div>
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
