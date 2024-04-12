<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Style pour le header */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: beige;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            margin-bottom: 20px; 
        }

        /* Style pour le logo */
        .logo {
            width: 40px; /* Modification de la taille du logo */
            margin-right: 10px; /* Réduction de la marge */
        }

        /* Style pour les liens */
        .header-links {
            color: #fff;
            text-decoration: none;
            margin: 0 10px;
        }

        /* Style pour le champ de recherche */
        .search-container {
            flex: 1;
            display: flex;
            align-items: center;
            margin: 0 20px;
        }

        /* Style pour le champ de recherche */
        .search-input {
            padding: 8px;
            border-radius: 5px;
            border: black;
            width: 70%;
            margin-right: 10px;
        }

        /* Style pour le bouton recherche */
        .search-button {
            padding: 8px 15px;
            background-color: black;
            color: white;
            border: black;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Style pour les boutons de navigation */
        .nav-button {
            padding: 8px 15px;
            background-color: black;
            color: white;
            border: black;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>


</head>

<body>
<?php
// Gestion de la recherche
if(isset($_GET['pseudo'])) {
    $pseudo = $_GET['pseudo'];

    // Votre logique de vérification du pseudo et redirection ici
    // Vous pouvez utiliser des requêtes SQL pour vérifier si le pseudo existe dans votre base de données

    // Exemple de redirection
    if(pseudoExiste($pseudo)) {
        header("Location: profil_utilisateur.php?pseudo=".$pseudo);
        exit();
    } else {
        header("Location: index.php");
        exit();
    }
}

// Fonction pour vérifier si le pseudo existe (vous devez l'implémenter)
// function pseudoExiste($pseudo) {
//     // Votre logique de vérification du pseudo dans la base de données
//     // Retournez vrai si le pseudo existe, sinon retournez faux
// }
?>
<header>
    <a href="index.php" class="logo"><img src="images\logo.jpeg" alt="Logo"></a>
    <a href="index.php" class="header-links nav-button">Accueil</a>
    <form action="index.php" method="GET"> <!-- Formulaire de recherche -->
        <div class="search-container">
            <input type="text" name="pseudo" placeholder="Recherche" class="search-input">
            <button type="submit" class="search-button">Recherche</button>
        </div>
    </form>
    <a href="#" class="header-links nav-button">Profil</a>
    <a href="inscription.php" class="header-links nav-button">S'inscrire</a>
</header>
