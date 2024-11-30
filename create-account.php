<?php
session_start();
require_once 'db.php';

$nom = isset($_GET['nom']) ? $_GET['nom'] : '';
$prenom = isset($_GET['prenom']) ? $_GET['prenom'] : '';
$adresse = isset($_GET['adresse']) ? $_GET['adresse'] : '';
$telephone = isset($_GET['telephone']) ? $_GET['telephone'] : '';
$email = isset($_GET['email']) ? $_GET['email'] : '';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/style.css">
    <title>AcheteTonAvion.gouv.fr</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<header class="header">
    <div class="logo-container">
        <img src="../Miroff_Airplanes/images/logo_rbg.png" alt="AcheteTonAvion.gouv.fr Logo" class="logo">
    </div>

    <div class="centered-title">
        <h1>French Aeronautics</h1>
        <h2 class="welcome">Crée ton compte sur le site de vente d'appareils aéronautiques français !</h2>
    </div>

    <nav>
        <a href="index.php" class="bn3">🏠 Accueil</a>
        <a href="../Miroff_Airplanes/contact/contact.php" class="bn3">☎️ Contact</a>
    </nav>
</header>

<main>
    <section class="form-container">
        <h2>Créer votre compte</h2>
        <form id="ajax-registration-form" class="modern-form">
            <div id="response-message" style="display: none;"></div>
            <?php if (isset($_SESSION['error_message'])):?>
                <p style="color: red;"><?php echo htmlspecialchars($_SESSION['error_message']); ?></p>
                <?php unset($_SESSION['error_message']);?>
            <?php endif; ?>
            <div class="form-group">
                <label for="n">Nom</label>
                <input type="text" id="n" name="n" value="<?php echo htmlspecialchars($nom); ?>" required>
                <p class="error-message"></p>
            </div>

            <div class="form-group">
                <label for="p">Prénom</label>
                <input type="text" id="p" name="p" value="<?php echo htmlspecialchars($prenom); ?>" required>
                <p class="error-message"></p>
            </div>

            <div class="form-group">
                <label for="adr">Adresse</label>
                <input type="text" id="adr" name="adr" value="<?php echo htmlspecialchars($adresse); ?>" required>
                <p class="error-message"></p>
            </div>

            <div class="form-group">
                <label for="num">Numéro de téléphone</label>
                <input type="tel" id="num" name="num" value="<?php echo htmlspecialchars($telephone); ?>" required>
                <p class="error-message"></p>
            </div>

            <div class="form-group">
                <label for="mail">Adresse e-mail</label>
                <input type="email" id="mail" name="mail" value="<?php echo htmlspecialchars($email); ?>" required>
                <p class="error-message"></p>
            </div>

            <div class="form-group">
                <label for="mdp1">Mot de passe</label>
                <input type="password" id="mdp1" name="mdp1" required>
                <p class="error-message"></p>
            </div>

            <div class="form-group">
                <label for="mdp2">Confirmer votre mot de passe</label>
                <input type="password" id="mdp2" name="mdp2" required>
                <p class="error-message"></p>
            </div>

            <div class="form-group">
                <input type="submit" value="Créer votre compte" class="submit-btn">
                <input type="hidden" name="auth_token" value="<?php echo $_SESSION['auth_token']; ?>">
            </div>
        </form>
        <div class="form-footer">
            <p>Déjà un compte ? <a href="login.php">Connexion</a></p>
        </div>
    </section>
</main>
<div id="footer-placeholder"></div>

<script>
    $(document).ready(function () {
        $('#ajax-registration-form').on('submit', function (e) {
            e.preventDefault();
            const formData = $(this).serialize();
            $.ajax({
                url: 'enregistrement.php',
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    const $responseMessage = $('#response-message');

                    if (response.success) {
                        $responseMessage
                            .text('Compte créé avec succès ! Redirection...')
                            .css({ color: 'green', display: 'block' });

                        setTimeout(() => {
                            window.location.href = 'index.php';
                        }, 1000);
                    } else {
                        $responseMessage
                            .text(response.error)
                            .css({ color: 'red', display: 'block' });
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Erreur AJAX :', error);
                    $('#response-message')
                        .text('Erreur lors de la création du compte. Veuillez réessayer.')
                        .css({ color: 'red', display: 'block' });
                }
            });
        });

        function validateField(field, condition, message) {
            const $field = $(field);
            const $message = $field.siblings('.error-message');

            if (condition) {
                $field.removeClass('invalid').addClass('valid');
                $message.text('');
            } else {
                $field.removeClass('valid').addClass('invalid');
                $message.text(message);
            }
            validateForm();
        }

        function validateForm() {
            const visibleInputs = $('.form-group input').filter(':visible').not('.submit-btn').not('[name="auth_token"]');
            const totalInputs = visibleInputs.length;
            const validInputs = visibleInputs.filter('.valid').length;
            $('.submit-btn').prop('disabled', validInputs !== totalInputs);
        }

        $('#num').on('input', function () {
            const phone = $(this).val().trim();
            const phoneRegex = /^(0[1-9]\d{8}|(\+?\d{1,3})[1-9]\d{8,14})$/;

            validateField(this, phoneRegex.test(phone), 'Numéro de téléphone invalide.');
        });

        $('#mail').on('input', function () {
            const email = $(this).val().trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!email) {
                validateField(this, false, 'Ce champ est requis.');
                return;
            }

            if (!emailRegex.test(email)) {
                validateField(this, false, 'Adresse email invalide.');
                return;
            }

            const $emailField = $(this);

            $.ajax({
                url: 'check-email.php',
                method: 'POST',
                data: { email: email },
                dataType: 'json',
                success: function (response) {
                    validateField($emailField, !response.exists, response.exists ? 'Cet email est déjà utilisé.' : '');
                },
                error: function () {
                    validateField($emailField, false, 'Erreur de vérification. Veuillez réessayer.');
                }
            });
        });

        $('#mdp1').on('input', function () {
            const password = $(this).val();
            const passwordRegex = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{3,}$/;

            validateField(this, passwordRegex.test(password), 'Le mot de passe doit contenir au moins 1 lettre, 1 chiffre, et 1 caractère spécial.');
        });

        $('#mdp2').on('input', function () {
            const confirmPassword = $(this).val();
            const password = $('#mdp1').val();

            validateField(
                this,
                confirmPassword === password,
                confirmPassword ? 'Les mots de passe ne correspondent pas.' : 'Veuillez confirmer votre mot de passe.'
            );
        });

        $('#n, #p, #adr').on('input', function () {
            validateField(this, $(this).val().trim() !== '', 'Ce champ est requis.');
        });
    });
</script>
</body>
</html>