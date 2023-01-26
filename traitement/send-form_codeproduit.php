<link rel="stylesheet" href="../style.css">
<?php include ('../database/logBDD.php');
      include ('../header.php');

$cachet = 31912151;
$ref = $_POST['reference'];
$color = $_POST['couleur'];
$cdeEAN = $_POST['btnform_cdeproduit'];
$cde = $cachet."".$cdeEAN;
$qte = $_POST['quantite'];
$coli = $_POST['colisage'];
$marque = $_POST['marque'];
$pht = $_FILES['file']['name'];
//$scan = $_FILES['fileToUpload2']['name'];?>

<div class="container-all-data">
  <p>Redirection dans 5s ....</p>
  <div>
      <?php echo $ref; ?>
      <?php echo $color; ?>
  </div>
  <div>
      <?php echo "Quantité : ".$qte; ?>
      <?php echo " / Colisage : ".$coli; ?>
  </div>
  <div>
    <?php echo $marque; ?>
  </div>
  <div>
    <?php echo $cdeEAN; ?>
  </div>
  <div>
    <?php echo $cde; ?>
  </div><br><br>
  <div><?php
    $nom_repertoire = '../PHOTO';
    $pointeur = opendir($nom_repertoire); 
    closedir($pointeur);
    echo '<img class="img-zoom" style="height:70px; width:150px;" src="'.$nom_repertoire.'/'.$pht.'"';?>
  </div><br><br>
  <div><?php
    //echo $cde;
    echo "<img src='../barcode/barcodeimage.php?code=EAN13&text=".$cde."&showtext=1&width=370&height=140&borderwidth=0'/>";?>
  </div>
</div><br><br><br>

<?php
/////////////////////////////////////
//  UPLOAD IMAGE -> DOSSIER PHOTO  //
/////////////////////////////////////
$target_dir = "../PHOTO/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
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
  echo "Ce fichier existe déjà.<br>";
  $uploadOk = 0;
}
if (file_exists("TAMPON-AT.png")) {
  echo "Le Tampon a été associé au produit.<br>";
  $uploadOk = 0;
}
// Check file size
if ($_FILES["file"]["size"] > 50000000) {
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
  if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    echo "Le fichier ". htmlspecialchars( basename( $_FILES["file"]["name"])). " à bien été télécharger.<br><br>";
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
      $imgcode = "$cde.jpeg";
      //echo $imgcode;
      $req="INSERT INTO produit (reference, couleur, quantite, colisage, marque, numProd, CodeEAN, addrsImage, addrsScancode) VALUES
          ('$ref', '$color', '$qte', '$coli', '$marque', '$cdeEAN', '$cde', '$pht', '$imgcode')";
      echo "<p style='color:red;'>PRODUIT AJOUTÉ AVEC SUCCES !</p>";
      // Exécution de la reqête
      mysqli_query($bdd, $req) or die('Erreur SQL ! '.$req.'<br>'.mysqli_error($bdd));
    }
}
header("refresh:5;url=../pages/codeproduit.php");?>