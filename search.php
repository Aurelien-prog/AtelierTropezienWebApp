<?php
try{ $mysqlClient = new PDO( 'mysql:host=localhost;dbname=BDD_EAN;charset=utf8', 'akost', '1234567'); }
catch (Exception $e) { die('Erreur : ' . $e->getMessage()); }

// Mot tapé par l'utilisateur
$term = htmlentities($_GET['word']);

$request = "SELECT DISTINCT * FROM produit WHERE reference LIKE :term ORDER BY reference ASC";
$recipes = $mysqlClient->prepare($request);
$recipes->execute(array('term' => '%'.$term.'%'));
$rec = $recipes->fetchAll();

$reference = array();

while($donnee = $requete->fetch()){
array_push($reference, $donnee['reference']);}        

echo json_encode($reference);
?>