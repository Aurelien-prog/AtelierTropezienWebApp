<?php 
//connexion a la bdd
try {$bdd = new PDO('mysql:host=localhost;dbname=BDD_EAN;charset=utf8', 'akost', '1234567', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));}
catch (Exception $e){die('Erreur : ' . $e->getMessage());}

$term = $_GET['term'];

$requete = $bdd->prepare('SELECT * FROM produit WHERE couleur LIKE :term');
$requete->execute(array('term' => '%'.$term.'%'));
 
$array = array();
 
while($donnee = $requete->fetch())
{
    array_push($array, $donnee['couleur']);
}
 
echo json_encode($array);?>