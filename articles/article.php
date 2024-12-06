<?php
session_start();
require_once '../db.php';

$id_art = $_GET['id_art'];

$sql = "SELECT * FROM Articles WHERE id_art = '$id_art'";
$resultat = getBD($sql);

if ($resultat->num_rows > 0) {
    $ligne = $resultat->fetch_assoc();

    include '../composants/chat/chat_component.php';

    ?>
    <html lang="fr">
    <head>
        <title><?php echo $ligne['nom']; ?></title>
        <link rel="stylesheet" href="../styles/style.css">
    </head>
    <body>
    <header class="header">
        <div class="logo-container">
            <img src="../images/logo_rbg.png" alt="AcheteTonAvion.gouv.fr Logo" class="logo">
        </div>

        <div class="centered-title">
            <h1>French Aeronautics</h1>
            <h2 class="welcome"><?php echo $ligne['nom']; ?></h2>
        </div>

        <nav>
            <a href="../index.php" class="bn3">🏠 Accueil</a>
            <a href="../contact/contact.php" class="bn3">☎️ Contact</a>
        </nav>
    </header>

    <section class="rafale-section">
        <div class="rafale-image-container">
            <img src="../images/article<?php echo $ligne['id_art']; ?>.png" alt="<?php echo $ligne['nom']; ?>" width="500">
        </div>
        <div style="height: 20px;"></div>

        <div class="description-container">
            <h2><?php echo $ligne['nom']; ?></h2>
            <p><?php echo $ligne['description']; ?></p>
            <p><b>Quantité en stock :</b> <?php echo $ligne['quantite']; ?></p>
            <p><b>Prix :</b> <?php echo $ligne['prix']; ?> €</p>


            <?php
            if (isset($_SESSION['client'])) {
                ?>
                <form action="add_article.php" method="POST">
                    <input type="hidden" name="id_art" value="<?php echo $ligne['id_art']; ?>">

                    <div class="quantity-container">
                        <label for="quantite">Quantité :</label>
                        <input type="number" id="quantite" name="quantite" min="1" max="<?php echo $ligne['quantite']; ?>" value="1" required>
                    </div>

                    <div class="add-cart-button">
                        <input type="submit" value="Ajoutez à votre panier">
                        <input type="hidden" name="auth_token" value="<?php echo $_SESSION['auth_token']; ?>">
                    </div>
                </form>
                <?php
            } else {
                echo '<div class="login-for-cart">';
                echo '<p>Veuillez vous <b>connecter</b> pour ajouter cet article à votre panier.</p>';
                echo '</div>';        }
            ?>
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
    <?php
} else {
    echo "Aucun article avec cet id n'a été trouvé\nID ARTICLE : " . $id_art;
}
?>
