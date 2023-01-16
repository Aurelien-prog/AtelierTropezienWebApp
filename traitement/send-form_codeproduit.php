<?php include ('../logBDD.php');

$cachet = 31912151;
$marque = $_POST['marque'];
$ref = $_POST['reference'];
$color = $_POST['couleur'];
$cdeEAN = $_POST['btnform_cdeproduit'];
$cde = $cachet."".$cdeEAN;
$qte = $_POST['quantite'];
$coli = $_POST['colisage'];
$pht = $_FILES['fileToUpload']['name'];
//$scan = $_FILES['fileToUpload2']['name'];

//$scan = $_POST['scanean'];
echo "Marque : ".$marque;?><br><?php
echo "Référence : ".$ref;?><br><?php
echo "Couleur : ".$color;?><br><?php
echo "code Produit : ".$cdeEAN;?><br><?php
echo "code EAN : ".$cde;?><br><?php
echo "Quantité : ".$qte;?><br><?php
echo "Photo : ".$pht;?><br><?php
//echo "Scan : ".$scan;?><br><br><?php

/////////////////////////////////////
//  UPLOAD IMAGE -> DOSSIER PHOTO  //
/////////////////////////////////////
$target_dir = "../PHOTO/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
//$target_file = $target_dir . basename($_FILES["fileToUpload2"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["photo"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "Ce fichier n'est pas une image !<br>";
    $uploadOk = 0;
  }
}
// Check if file already exists
if (file_exists($target_file)) {
  echo "Désolé, ce fichier existe déjà.<br>";
  $uploadOk = 0;
}
if (file_exists("TAMPON-AT.png")) {
  echo "Le Tampon a été associé au produit.<br>";
  $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 50000000) {
  echo "Désolé, ce fichier est trop gros.<br>";
  $uploadOk = 0;
}
//////
/*if ($_FILES["fileToUpload2"]["size"] > 50000000) {
  echo "Désolé, ce fichier est trop gros.<br>";
  $uploadOk = 0;
}*/
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Désolé, seulement ces extensions sont accepté => .jpg .png .jpeg .gif<br>";
  $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Votre fichier n'a pas été télécharger !<br>";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "Le fichier ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " à bien été télécharger.<br><br>";
  }
  /*if (move_uploaded_file($_FILES["fileToUpload2"]["tmp_name"], $target_file)) {
    echo "Le fichier ". htmlspecialchars( basename( $_FILES["fileToUpload2"]["name"])). " à bien été télécharger.<br><br>";
  }*/
  else {
    echo "Désolé, il y a eu une erreur durant le téléchargement de votre fichier.<br>";
  }
}
/////////////////////////////////////
if (!$bdd) { // Contrôler la connexion
    $MessageConnexion = die ("Connexion impossible");
}
else {
    if(isset($_POST['btnform_cdeproduit'])) {
      // Requête d'insertion
      $req="INSERT INTO produit (reference, couleur, quantite, colisage, numProd, CodeEAN, addrsImage) VALUES
          ('$ref', '$color', '$qte', '$coli', '$cdeEAN', '$cde', '$pht')";

      // Exécution de la reqête
      mysqli_query($bdd, $req) or die('Erreur SQL ! '.$req.'<br>'.mysqli_error($bdd));
    }
}
header("refresh:2;url=../codeproduit.php");?>