<?php
// Connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe = "";
$base_de_donnees = "MMA";

$connexion = mysqli_connect($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

// Vérifier la connexion
if (!$connexion) {
    die("La connexion à la base de données a échoué : " . mysqli_connect_error());
}

// Vérifier si le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $identifiant = mysqli_real_escape_string($connexion, $_POST['username']);
    $mot_de_passe = mysqli_real_escape_string($connexion, $_POST['password']);

    // Requête SQL pour vérifier les informations d'identification
    $requete = "SELECT * FROM utilisateurs WHERE nom_utilisateur = '$identifiant' AND mot_de_passe = '$mot_de_passe'";

    // Exécuter la requête
    $resultat = mysqli_query($connexion, $requete);

    // Vérifier s'il y a une correspondance d'identifiants dans la base de données
    if (mysqli_num_rows($resultat) == 1) {
        // Authentification réussie
        session_start();
        $_SESSION['loggedin'] = true; // Marquer l'utilisateur comme connecté
        $_SESSION['identifiant'] = $identifiant; // Enregistrer l'identifiant de l'utilisateur en session
        header("Location: Acceuil.php"); // Rediriger vers la page d'accueil
        exit; // Arrêter l'exécution du script après la redirection
    } else {
        // Authentification échouée
        echo "Identifiant ou mot de passe incorrect.";
    }

    // Libérer le résultat de la requête
    mysqli_free_result($resultat);
}

// Fermer la connexion à la base de données
mysqli_close($connexion);
?>
