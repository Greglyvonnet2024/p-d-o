<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'Enregistrement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 0;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            max-width: 100%;
            margin: auto;
        }

        h1 {
            color:
                /*#cc0000*/
                blue;
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #cc0000;
        }

        input[type="text"],
        input[type="email"],
        select {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #cc0000;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="radio"] {
            margin-right: 5px;
        }

        .radio-group {
            margin-bottom: 15px;
        }

        .radio-group label {
            font-weight: normal;
            display: inline;
            margin-right: 10px;
            color: #cc0000;
        }

        input[type="submit"] {
            background-color: #cc0000;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: black;
        }

        .message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            color: #fff;
        }

        .success {
            background-color: #2ecc71;
        }

        .error {
            background-color: #e74c3c;
        }

        /* Pour le tableau HTML */
        table.error-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 18px;
            text-align: left;
        }

        table.error-table th,
        table.error-table td {
            padding: 12px 15px;
            border: 1px solid #ffdddd;
        }

        table.error-table th {
            background-color: #ff6961;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        table.error-table td {
            background-color: #ffecec;
            color: #ff0000;
        }

        table.error-table tr:hover {
            background-color: #ffdddd;
        }
    </style>
</head>

<body>
    <form method="post" action="">
        <h1>Ajouter un Employé</h1>

        <label for="prenom">Prénom</label>
        <input type="text" id="prenom" name="prenom">

        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom">

        <label for="username">Pseudonyme</label>
        <input type="text" id="username" name="username">

        <label for="email">Email</label>
        <input type="email" id="email" name="email">

        <label for="telephone">Telephone</label>
        <input type="text" id="telephone" name="telephone">

        <div class="sexe">

            <label>Sexe</label><br>

            <select name="sexe" id="ma-seletion">
                <option value="choisir">Choisissez votre sexe</option>
                <option value="m">Homme</option>
                <option value="f">Femme</option>
            </select>

        </div>

        <label for="service">Service</label>
        <input type="text" id="service" name="service">

        <label for="date_embauche">Date d'embauche</label>
        <input type="text" id="date_embauche" name="date_embauche">

        <label for="salaire">Salaire</label>
        <input type="text" id="salaire" name="salaire">

        <input type="submit" value="Enregistrer" name="submit_form">
    </form>
</body>

</html>

<?php
// Information ou rappel: On echappe pas de données qui sont déstinées à la BDD pour plusieurs raisons : 

// 1 - La BDD n'en a pas besoin 
// 2 - Les requêtes préparées sont là pour ça (echapper les données et sécuriser contre les injections SQL)

// En revanche on echappe TOUJOURS lors de l'affichage de données

/** Exercice 1 : Validation de l'email
 * 
 *  Objectif : Ajouter un champ pour l'adresse e-mail dans le formulaire et valider que l'email est bien formaté avant de l'enregistrer dans la BDD
 *             Ajouter également l'email dans la BDD (vider les données avant) dans la table employes
 *  
 *  1 . Modifier le formulaire (formulaire_front) pour inclure un champ email
 * 
 * >>>DEJA FAIT
 * 
 *  2 . Ajouter la validation dans le code PHP pour vérifier que l'email est valide
 */

$pdo = new mysqli('localhost', 'root', '', 'societe');

if (!empty($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_form'])) {
    var_dump($_POST);
    if (!empty($_POST['email'])) {
        $point = strpos($_POST['email'], ".");
        $aroba = strpos($_POST['email'], "@");
        if ($point === false)
            echo 'Votre email doit comporter un point.';
        else if ($aroba === false)
            echo 'Votre email doit comporter un arobase.';
    }



    /** Exercice 2 : Validation numero téléphone
     * 
     *  Objectif : Ajouter un champ pour le numéro de téléphone
     *             Ajouter également dans la BDD dans la table employes
     * 
     *  1 . Ajouter champ téléphone au formulaire
     * 
     *  2 . Valider qu'il contient uniquement des chiffres et contient entre 10 et 20 caractères
     * 
     */
    if (empty($_POST['telephone']) || strlen($_POST['telephone']) < 10 && strlen($_POST['telephone']) > 20) {
        echo '<p> le numero de téléphone est incorrect </p>';
    }

    /** Exercice 3 : Valider le genre en menu déroulant
     * 
     *  Objectif : Modifier l'input de type radio pour en faire un select pour chaque genre
     * 
     *  1 . Modifier l'input en select 
     * 
     *  2 . Vérifier que les valeurs correspondent dans le PHP et soient validées
     * 
     * 
     */

    if (empty($_POST['sexe']) || ($_POST['sexe']) != 'm' && ($_POST['sexe']) != 'f' ) {
        $message .= '<p>Veuillez selection une option </p>';
    }

}
/** Exercice 4 : Validation de la date avec formatage
 * 
 *  Objectif : S'assurer que la date est au format 'jj-mm-aaaa' et la transformer en 'aaaa-mm-jj'
 * 
 *  1 . Valider le format de la date FR 
 * 
 *  2 . Reformater le format en US (aaaa-mm-jj)
 * 
 */


 

/** Exercice 5 : Validation du salaire avec format monétaire
 * 
 *  Objectif : Vérifier que le salaire est un montant monétaire valide (il ne peut pas être négatif par exemple)
 * 
 *  1 . Modifier la validation pour que le salaire soit un nombre positif avec jusqu'à 2 décimales
 * 
 *  2 . Utiliser des fonctions PHP vues en cours pour formater le salaire et le valider
 */


/** Exercice 6 : Validation de la longueur du nom d'utilisateur
 * 
 *  Objectif : Vérifier que le nom d'utilisateur a une longueur spécifique
 * 
 *  1 . Ajouter un champs dans le formulaire pour le nom d'utilisateur (username), dans la table employes egalement
 * 
 *  2 . Valider que l'utilisateur a entre 5 et 15 caractères
 * 
 * 
 */


/** Exercice 7 : Affichage des erreurs en tableau
 * 
 *  Objectif : Gérer les messages d'erreurs en tableau plûtot que séparement
 * 
 *  1 . Les erreurs doivent apparaître en tableau HTML 
 * 
 *  2 . Créer une variable au dessus du premier exercice $errors qui contiendra un tableau vide
 * 
 *  3 . utiliser cette variable dans chaque vérification 
 * 
 */


/** Exercice 8 : Utilisation des requêtes séparées
 * 
 *  Objectif : S'assurer que toutes les requêtes SQL vers la BDD soient préparée pour éviter les injections SQL
 * 
 *  1 . Utiliser PDO ou MySQLi pour assurer une connexion à la base de données
 *  2 . Préparer une requête SQL pour envoyer toutes les données du formulaire dans la BDD
 *  3 . Empecher l'envoi à la BDD si $errors contient des erreurs
 * 
 * 
 *  Aide : Voir cours sur PDO
 */


/** Exercice 9 : Ajouter photo profil (BONUS)
 * 
 *  Objectif : Ajouter une photo de profil à l'utilisateur (il faudra créer un nouveau formulaire 'modif user' et une requête UPDATE pour la BDD et non INSERT INTO), l'image doit être nullable
 *
 *  Attention : Ajouter enctype="multipart/form-data" au formulaire pour que ça fonctionne
 *  
 *  Faites des recherches sur $_FILES et la fonction move_uploaded_file()
 *  
 *  1 . Ajouter un champ pour ajouter des fichiers dans le formulaire
 * 
 *  2 . Traiter le champ dans PHP (ajouter une limite de taille de 20mb)
 * 
 *  3 . La photo uploadée doit être enregistrée dans un dossier img,photo comme vous voudrez
 * 
 *  4 . Une fois la vérification faite, l'enregistrée dans la BDD sur l'utilisateur souhaité (ou un nouveau si vous preferez dans ce cas ce sera INSERT INTO), ne pas oublier de selectionner un utilisateur (par son id)
 */




?>