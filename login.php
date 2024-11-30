<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/style.css">
    <title>Connexion - AcheteTonAvion.gouv.fr</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
<header class="header">
    <div class="logo-container">
        <img src="../Miroff_Airplanes/images/logo_rbg.png" alt="AcheteTonAvion.gouv.fr Logo" class="logo">
    </div>

    <div class="centered-title">
        <h1>French Aeronautics</h1>
        <h2 class="welcome">Connectez-vous à votre compte</h2>
    </div>

    <nav>
        <a href="index.php" class="bn3">🏠 Accueil</a>
        <a href="../Miroff_Airplanes/contact/contact.php" class="bn3">☎️ Contact</a>
    </nav>
</header>

<main>
    <section class="form-container">
        <h2>Connexion</h2>
        <form id="ajax-login-form" class="modern-form">
            <div id="response-message" style="display: none;"></div>

            <div class="form-group">
                <label for="email">Adresse e-mail</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <input type="submit" value="Se connecter" class="submit-btn">
            </div>
        </form>

        <div class="form-footer">
            <p>Pas encore de compte ? <a href="create-account.php">Créer un compte</a></p>
        </div>
    </section>
</main>
<div id="footer-placeholder"></div>

<script>
    $(document).ready(function () {
        $('#ajax-login-form').on('submit', function (e) {
            e.preventDefault();
            const formData = $(this).serialize();
            $.ajax({
                url: 'ajax-login.php',
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    const $responseMessage = $('#response-message');
                    if (response.success) {
                        $responseMessage
                            .text(response.message)
                            .css({ color: 'green', display: 'block' });
                        setTimeout(() => {
                            window.location.href = 'index.php';
                        }, 1000);
                    } else {
                        $responseMessage
                            .text(response.message)
                            .css({ color: 'red', display: 'block' });
                    }
                },
                error: function () {
                    $('#response-message')
                        .text('Erreur lors de la connexion. Veuillez réessayer.')
                        .css({ color: 'red', display: 'block' });
                }
            });
        });
    });
</script>
</body>
</html>