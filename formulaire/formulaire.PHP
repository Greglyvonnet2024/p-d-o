<?php

$pdo = new mysqli('localhost', 'root', '', 'societe');

$message = '';

if (!empty($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_form'])) {
   
    // var_dump($_POST['date_embauche']);
    // die();
   
    if (empty($_POST['prenom']) || strlen($_POST['prenom']) < 2) {
        $message .= '<p> le prenom doit comporter au minimum 2 caractères </p>';
    }
    if (empty($_POST['nom']) || strlen($_POST['nom']) < 2) {
        $message .= '<p> le nom doit comporter au minimum 2 caractères </p>';
    }

    if (empty($_POST['service']) || strlen($_POST['service']) < 2) {
        $message .= '<p> le service doit comporter au minimum 2 caractères </p>';
    }

    if (empty($_POST['sexe']) || ($_POST['sexe']) != 'm' && $_POST['sexe'] != 'f') {
        $message .= '<p> le sexe n\'est pas valide </p>';
    }

    if (empty($_POST['date_embauche']) || !strtotime($_POST['date_embauche'])) {
        $message .= '<p> la date doit doit etre remplis </p>';
    }

    if (empty($_POST['salaire']) || !is_numeric($_POST['salaire']) || ($_POST['salaire']) <= 0) {
        $message .= '<p> le salaire doit doit etre un nombre positif </p>';
    }

    if (empty($message)) {
        //On reformate la date recupérée du formulaire en date année-mois-jour (date comprise pas mysql)
        $date = new DateTime($_POST['date_embauche']);
        $date_embauche = $date->format('Y-m-d');

        //on prepare notre requete:
        $request = $pdo->prepare("INSERT INTO employes (prenom,nom,sexe,services,date_embauche,salaire)VALUES (?,?,?,?,?,?)");


        try {
            $resultat = $request->execute([$_POST['prenom'], $_POST['nom'], $_POST['sexe'], $_POST['service'], $date_embauche, $_POST['salaire']]);

            if($resultat){
                $message .= '<p class="success'> "L\'employé a bin été ajouté</p>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>formulaire</title>
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
            color: #cc0000;
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #cc0000;
        }

        input[type="text"] {
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

        .header-img {
            width: 200px;
            margin: 30px auto;

        }

        .header-img img {
            height: auto;
            width: 100%;
        }
    </style>


</head>

<body>

    <?php if (!empty($message)) { ?>
        <div>
            <?= $message ?>
        </div>
    <?php }  ?>


    <form action="" method="POST">
        <label for="prenom">prenom</label>
        <input type="text" id="prenom" name="prenom">


        <label for="nom">nom</label>
        <input type="text" id="nom" name="nom">

        <div>
            <label for="sexe">sexe</label>
            <input type="radio" name="sexe" value="m">homme
            <input type="radio" name="sexe" value="f">femme
        </div>

        <label for="service">service</label>
        <input type="text" id="service" name="service">

        <label for="date_embauche">date_embauche</label>
        <input type="text" id="date_embauche" name="date_embauche">

        <label for="salaire">salaire</label>
        <input type="text" id="salaire" name="salaire">

        <input type="submit" name="submit_form" value="Ajouter le nouvel employé">

    </form>




</body>

</html>