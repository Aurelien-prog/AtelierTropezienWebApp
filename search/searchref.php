<?php 
//connexion a la bdd
try {$bdd = new PDO('mysql:host=localhost;dbname=BDD_EAN;charset=utf8', 'akost', '1234567', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));}
catch (Exception $e){die('Erreur : ' . $e->getMessage());}

$term = $_GET['term'];
 
$requete = $bdd->prepare('SELECT * FROM produit WHERE reference LIKE :term'); // j'effectue ma requête SQL grâce au mot-clé LIKE
$requete->execute(array('term' => '%'.$term.'%'));
 
$array = array(); // on créé le tableau
 
while($donnee = $requete->fetch()) // on effectue une boucle pour obtenir les données
{
    array_push($array, $donnee['reference']); // et on ajoute celles-ci à notre tableau
}
 
echo json_encode($array);
?>