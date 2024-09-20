<?php

//**************************PDO */

//connection a la basse de données


//new PDO est une classe qui va permettre la connexrion a la base de données precisée
//(mysql:host=localhost): on lui dit qu'on utilise le SGBD (systeme de gestion de la base de donnnées) qui est MySQL et qu'on l'utilise avec localhost
//dbname=societe : l'identifiant et le mot de passede notre base de données (par éfaut en local root)

$pdo = new PDO('mysql:host=localhost;dbname=societe','root','', [PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'set NAMES utf8']);

// $employe1 = $pdo->exec("INSERT INTO employes (prenom,nom,sexe,services,date_embauche,salaire) VALUES('Gerard','Bouchard','m','developpement','2007-06-27',3500)");


//Il va nous donner le nombre effectuées par la requete
// echo "nombre de ligne affectées par le INSERT:$employe1 <br>";

//On peut recuperer le dernier id inserer dans la base de données
echo "dernier ID généré: " . $pdo->lastInsertId();


// Suppression de gerard dans la base de données

// DELETE FROM fait partie du CRUD (Create - Read - Update - Delete)

// exec() est une méthode utilisée qui ne retournent pas de résultat (autre que SELECT)

$employe1 = $pdo->exec("DELETE FROM employes WHERE id = 1"); 


// si $employe 'reussi', alors il retournera le nombre de ligne affectées par la requete(ici 1 ), sinon il retournera false.
if($employe1){
echo'employe supprimé';
}else{
    echo 'Erreur';
}
/* Valeur de retour: 
- Succes: Renvoie le nombre de ligne affectées par la requête
- Echec: retourne false*/


// Méthode query():
// la méthode query() ^peut etre utiliser pour les requête qui retourne un ou plusieur résultats 

// $employe1 = $pdo->exec("INSERT INTO employes (prenom,nom,sexe,services,date_embauche,salaire) VALUES('Gregory','L','m','developpeur','2024-06-27',2500)");

$resultat = $pdo->query("SELECT * FROM employes WHERE prenom= 'Gregory'");


//$resultat est le résultat de la requpete mais inexploitable pour le moment
echo  $resultat; // Impossible a afficher

// pour recuperer les données de maniere exploitable, on va utiliser la méthode fetch();

$gregory = $resultat ->fetch();//fetch renverra un tableau

echo'<pre>';
var_dump($gregory);
echo '<pre>';

//$gregory = $resultat->fetch(PDO::FETCH_ASSOC); //Renverra seulement un tableau associatif

//$gregory = $resultat->fetch(PDO::FETCH_NUM); // renverra seulement un tableau indéxé

//$gregory = $resultat->fetch(PDO::FETCH_OBJ); // Renverra un objet

// fetch() 



// echo '<pre>';
// var_dump($sirine);
// echo '</pre>';

// fetchAll()
// fetchAll va permettre de retourner plusieurs résultats à la fois 

$sql = $pdo->query('SELECT * FROM employes');

$all = $sql->fetchAll(PDO::FETCH_ASSOC);

echo '<pre>';
var_dump($all);
echo '</pre>';

echo '<ul>';

// Vu qu'on récupère un tableau (multidimensionnel ici) on peut boucler dessus pour afficher les éléments qui nous interessent
foreach ($all as $values) {
    echo "<li>$values[prenom]</li>";
    echo "<li>$values[date_embauche]</li>";
}
echo '</ul>';

// Requêtes préparées : 

// Préparation de la requête
// On prépare la requête avec notre requête SQL, sauf qu'on lui donne un paramètre à la place de la valeur attendue, la requête ne s'executera pas maintenant
$sirine2 = $pdo->prepare("SELECT * FROM employes WHERE prenom = :prenom");

// exemple de variable contenant un prenom
$prenom = 'Sirine';
// bindParam : 
// On fourni à la méthode ce qu'on veut comme valeur de paramètre, petite précision : On peut changer la valeur de la variable, bindParam prendra la nouvelle valeur

$sirine2->bindParam(':prenom', $prenom);

$prenom = 'gustave';

// On execute la méthode

$sirine2->execute();
// on peut changer la valeur de prenom APRES l'execute, il suffira juste de faire la meme manipulation et execute()

// On n'oublie pas de fetch le resultat ! TOUJOURS FETCH avec une requête SELECT
$nouvelleSirine = $sirine2->fetchAll();

echo '<pre>';
print_r($nouvelleSirine);
echo '</pre>';

foreach ($nouvelleSirine as $value) {
    echo "<p> $value[prenom] </p>";
}

// bindValue()

$request = $pdo->prepare('SELECT * FROM employes WHERE nom = :nom AND prenom = :prenom');

$nom = 'Ben';
$prenom = 'Sirine';
$request->bindValue(':nom', $nom);
$request->bindValue(':prenom', $prenom);
$nom = "Autre chose";

$request->execute();

$resultat = $request->fetchAll();

// 3 eme façon 

$sql = $pdo->prepare('SELECT * FROM employes WHERE id=:id AND prenom = :prenom');

$id = 40;

// On peut mettre les paramètres directement dans la méthode(fonction) execute();

$sql->execute([$id, $prenom]);

$resultat = $sql->fetch(); // on récupère 1 resultat avec l'id donc on fetch() et non fetchAll()

// L'extension mySQLI :

// Connexion BDD
$mysqli = new mysqli('localhost', 'root', '', 'societe');

// Exemple de requête : 

$sirine3 = $mysqli->query('SELECT * FROM employes');







?>