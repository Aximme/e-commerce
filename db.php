<?php
function getBD($sql = null, $params = []) { //si pas de select, passage sur le insert
    static $connexion = null;
    if ($connexion === null) {
        $server = "localhost";
        $user = "root";
        $password = "root";
        $database_name = "MIROFF_Airplanes";

        $connexion = new mysqli($server, $user, $password, $database_name);

        if ($connexion->connect_error) {
            throw new Exception("Échec de la connexion à la base de données : " . $connexion->connect_error);
        }
    }
    if ($sql !== null) {
        $stmt = $connexion->prepare($sql);



           //          GESTION DES ERREURS DANS LE CAS OU LAPPEL RENVOIE RIEN          //
        if (!$stmt) {
            throw new Exception("Erreur de préparation de la requête : " . $connexion->error);
        }

        if (!empty($params)) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }

        if (!$stmt->execute()) {
            throw new Exception("Erreur d'exécution de la requête : " . $stmt->error);
        }

        return $stmt->get_result();
    }
    return $connexion;
}
?>