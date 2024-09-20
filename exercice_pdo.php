<?php

// pour les exercices, vous allez créer une table dans la BDD societe qui s'appelera, dirigeants

/** Cette table contiendra
 * 
 *  'id'(INT,clé primaire, auto-incrémentée)
 *  'prenom'(VARCHAR,255)
 *  'nom'(VARCHAR,255)
 *  'poste'(VARCHAR,255)
 *  'email'(VARCHAR,255,unique)
 *  'salaire'(FLOAT)
 *  'date_embauche'(DATE)
 * 
 */

/** Exercice 1 : Connexion à une base de données 
 * 
 *  Objectif : Se connecter à notre BDD
 * 
 *  1 . Commencer par utiliser l'objet PDO pour se connecter à la base de donnée MySQL (ou MySQLi si vous preférez)
 * 
 *  2 . S'assurer de gérer les erreurs de connexion de manière appropriée en affichant un message d'erreur si la connexion echoue
 */
echo 'Exercice 1';

$pdo = new PDO('mysql:host=localhost;dbname=societe','root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'set NAMES utf8']);



/** Exercice 2 : Insérer des données avec exec()
 * 
 *  Objectif : insérer des données dans la BDD 
 * 
 *  1 . Utiliser la méthode exec() pour insérer un nouvel dirigeant dans la table dirigeants. Afficher le nombre de lignes affectées par l'insertion et l'id du dirigeant inséré
 * 
 */

echo 'Exercice 2';
//  $dirigeants1= $pdo->exec("INSERT INTO dirigeants(prenom,nom,poste,email,salaire,date_embauche) VALUES('Greg','Mario','informaticien','greg@gmail.com',2500,'2024-05-13')");

//  $dirigeants2=$pdo ->exec("INSERT INTO dirigeants(prenom,nom,poste,email,salaire,date_embauche) VALUES('Eva','L','directrice','eva@gmail.com',4300,'2017-04-01')");

// echo "dernier ID généré: " . $pdo->lastInsertId();





/** Exercice 3 : Récupérer et afficher l'enregistrement avec query()
 * 
 *  Objectif : récupérer notre dirigeant de la BDD
 * 
 *  1 . Utiliser query() pour séléectionner les informations d'un dirigeant spécifique dans la table 'employes' (par exemple, par son prenom)
 * 
 * 
 *  2 . Afficher les résultats sous forme de tableau associatif en utilisant fetch(PDO::FETCH_ASSOC)
 * 
 */

echo 'Exercice 3';

$resultat = $pdo->query("SELECT * FROM dirigeants WHERE prenom= 'Eva'");

$eva = $resultat->fetch();

echo '<pre>';
var_dump($eva);
echo '</pre>';

echo '<hr>';

/** Exercice 4 : Affichage avec différents types de fetch
 * 
 * Objectif : Reprendre l'exercice précédent
 * 
 *  1 . Modifier le fetch(PDO::xxx) pour le remplacer par les trois autres types : FETCH_NUM,FETCH_ASSOC et FETCH_OBJ, Analyser et comparer
 * 
 */
echo 'Exercice 4';

$resultat = $pdo->query("SELECT * FROM dirigeants WHERE prenom= 'Eva'");

// $eva = $resultat->fetch(PDO::FETCH_ASSOC);
// $eva = $resultat->fetch(PDO::FETCH_NUM);
$eva = $resultat->fetch(PDO::FETCH_OBJ);


echo '<pre>';
var_dump($eva);
echo '</pre>';

echo '<hr>';
/** Exercice 5 : Récupérer tous les enregistrements avec fetchAll()
 * 
 * Objectif : Récupérer toutes les lignes d'une table 
 * 
 *  1 . Récuperer les enregistrements de la table dirigeants avec fecthAll(PDO::FETCH_ASSOC)
 * 
 *  2 . Afficher les données dans un tableau HTML (vous pouvez reprendre celui du cours)
 * 
 *  3 . S'assurer que chaque dirigeant est affiché sur une ligne distincte
 * 
 */
echo 'Exercice 5';

$sql = $pdo->query('SELECT * FROM dirigeants');

$all = $sql->fetchAll(PDO::FETCH_ASSOC);

echo '<pre>';
var_dump($all);
echo '</pre>';


echo '<hr>';
/** Exercice 6 : Utilisation de requêtes préparées avec bindParam()
 * 
 *  Objectif : Sécuriser l'envoi de nos données à la BDD avec des requêtes préparées
 * 
 *  1 . Créer une requête pour selectionner un dirigeant par son nom
 * 
 *  2. Utiliser bindParam() pour lier les valeurs des paramètres et afficher les informations du dirigeant
 * 
 * 
 */
echo 'Exercice 6';

$eva = $pdo->prepare("SELECT * FROM dirigeants WHERE prenom = :prenom");

$prenom = 'Eva';

$eva->bindParam(':prenom', $prenom);

$eva ->execute();

$evaN = $eva->fetchAll();

echo '<pre>';
print_r($evaN); 
echo '</pre>';



echo '<hr>';
/** Exercice 7 : Requêtes préparées avec bindValue()
 * 
 * Objectif : Reprendre l'exercice précédent et refaire la même chose à la place de bindParams()
 * 
 * Modifier la valeur du paramètre pour observer le comportement de la requête
 * 
 */

 echo 'Exercice 7';

$request = $pdo->prepare("SELECT * FROM dirigeants WHERE nom= :nom");


 $nom = 'L';

$request->bindValue(':nom',$nom);

$request->execute();

$resultat=$request->fetchAll();


echo '<pre>';
print_r($request);
echo '</pre>';




/** Exercice 8 : Utilisation des marqueurs "?" dans une requête préparée
 * 
 *  Objectif : utiliser les marqueurs ? pour préparer nos valeurs 
 * 
 *  1 . Creer une requête pour séléctionner un dirigeant par son nom ET son prénom
 * 
 *  2 . Utiliser bindValue() ou passer directement les valeurs via un tableau dans la fonction execute()
 * 
 *  3 . Afficher les résultats
 */

echo 'Exercice 8';

$request = $pdo->prepare("SELECT * FROM dirigeants WHERE nom= ? AND prenom=?");


$nom = 'Mario';
$prenom= 'Greg';

$request->bindValue('?', $nom);
$request->bindValue('?', $prenom);

$request->execute();

$resultat = $request->fetchAll();


 ?>