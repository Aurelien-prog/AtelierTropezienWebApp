<?php include('../logBDD.php');

$id = $_POST['id'];
$ref = $_POST['newreference'];
$coul = $_POST['newcouleur'];
$qte = $_POST['newquantite'];
$coli = $_POST['newcolisage'];
$pht = $_FILES['newimage']['name'];

/*echo "Id : ".$id."<br>";
echo "Ref : ".$ref."<br>";
echo "Couleur : ".$coul."<br>";
echo "Quantite : ".$qte."<br>";
echo "Colisage : ".$coli."<br>";
echo "Photo : ".$pht."<br>";*/

if ($pht == "") {
  $pht = "Pas de changement de photo !";
} else {
  /////////////////////////////////////
  //  UPLOAD IMAGE -> DOSSIER PHOTO  //
  /////////////////////////////////////
  $target_dir = "../PHOTO/";
  $target_file = $target_dir . basename($_FILES["newimage"]["name"]);
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
  if ($_FILES["newimage"]["size"] > 50000000) {
    echo "Désolé, ce fichier est trop gros.<br>";
    $uploadOk = 0;
  }
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
    if (move_uploaded_file($_FILES["newimage"]["tmp_name"], $target_file)) {
      echo "Le fichier ". htmlspecialchars( basename( $_FILES["newimage"]["name"])). " à bien été télécharger.<br><br>";
    } else {
      echo "Désolé, il y a eu une erreur durant le téléchargement de votre fichier.<br>";
    }
  }
  if (!$bdd) { //Contrôler la connexion
    $MessageConnexion = die ("Connexion impossible");
  }
  else {
      if(isset($_POST['btn-edit'])) {
          //Requête d'insertion
          $req = "UPDATE produit SET reference = '$ref', couleur = '$coul', quantite = '$qte', colisage = '$coli', addrsImage = '$pht' WHERE Id = $id";

          //Exécution de la reqête
          mysqli_query($bdd, $req) or die('Erreur SQL ! '.$req.'<br>'.mysqli_error($bdd));
          echo "Modification effectué !";
      }
  }
}
echo "Id : ".$id."<br>";
echo "Ref : ".$ref."<br>";
echo "Couleur : ".$coul."<br>";
echo "Quantite : ".$qte."<br>";
echo "Colisage : ".$coli."<br>";
echo "Photo : ".$pht."<br>";
if (!$bdd) { //Contrôler la connexion
    $MessageConnexion = die ("Connexion impossible");
}
else {
    if(isset($_POST['btn-edit'])) {
        //Requête d'insertion
        $req = "UPDATE produit SET reference = '$ref', couleur = '$coul', quantite = '$qte', colisage = '$coli' WHERE Id = $id";

        //Exécution de la reqête
        mysqli_query($bdd, $req) or die('Erreur SQL ! '.$req.'<br>'.mysqli_error($bdd));
        echo "Modification effectué !";
    }
}
//header("refresh:2;url=../stock.php");
header('Location:../stock.php');?>