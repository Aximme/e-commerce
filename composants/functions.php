<?php
function checkAuthToken()
{
    if (empty($_SESSION['auth_token'])) {
        setErrorMessage("Vous devez être connecté pour accéder à cette page.");
        header('Location: login.php');
        exit();
    }
}


?>