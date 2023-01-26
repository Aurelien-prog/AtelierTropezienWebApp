<?php include('../database/logBDD.php');

$id = $_POST['id'];
$ref = $_POST['newreference'];
$coul = $_POST['newcouleur'];
$qte = $_POST['newquantite'];
$coli = $_POST['newcolisage'];
$pht = $_FILES['file']['name'];

if (isset($_POST['btn-delete'])) {
  if (!$bdd) { //Contrôler la connexion
    $MessageConnexion = die ("Connexion impossible");
  }
    //Requête de suppresion
    $req = "DELETE FROM produit WHERE Id = $id";

    //Exécution de la reqête
    mysqli_query($bdd, $req) or die('Erreur SQL ! '.$req.'<br>'.mysqli_error($bdd));
    echo "Suppression effectué !";
}

if (isset($_POST['btn-edit'])) {
  if ($pht == "") {
    $pht = "Pas de changement de photo !";
  } else {
    /////////////////////////////////////
    //  UPLOAD IMAGE -> DOSSIER PHOTO  //
    /////////////////////////////////////
    $target_dir = "../PHOTO/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
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
    if ($_FILES["file"]["size"] > 50000000) {
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
      if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        echo "Le fichier ". htmlspecialchars( basename( $_FILES["file"]["name"])). " à bien été télécharger.<br><br>";
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
}
if (isset($_POST['btn-imprime'])) {
  $link = mysqli_connect('localhost','akost','1234567','BDD_EAN');
  $requete = "SELECT * FROM produit WHERE reference = '$ref' AND couleur = '$coul'";
  $result = mysqli_query($link, $requete);
  $data = mysqli_fetch_array($result);
  mysqli_free_result($result);

  // Appel de la librairie FPDF
  require("../fpdf/fpdf.php");

  if ($data['marque'] == "ATELIER TROPEZIEN") {
    // Création de la class PDF
    class PDF extends FPDF {
      // Header
      function Header() {
        // Logo : 1 >position à gauche du document (en mm), 2 >position en haut du document, 80 >largeur de l'image en mm). La hauteur est calculée automatiquement.
        $this->Image('../PHOTO/TAMPON-AT.png',30,0,150);//Seulement des images en png !
        // Saut de ligne 20 mm
        $this->Ln(5);
        // Titre gras (B) police Helbetica de 11
        $this->SetFont('Helvetica','B',25);
        // position du coin supérieur gauche par rapport à la marge gauche (mm)
        $this->SetX(70);
        // Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok  
        $this->Cell(70,25,'ATELIER TROPEZIEN',0,1,'C');
        // Saut de ligne 10 mm
        $this->Ln(15);
      }
    }
  } else {
    // Création de la class PDF
    class PDF extends FPDF {
      // Header
      function Header() {
        // Logo : 1 >position à gauche du document (en mm), 2 >position en haut du document, 80 >largeur de l'image en mm). La hauteur est calculée automatiquement.
        $this->Image('../PHOTO/TAMPON-ANA.png',35,20,150);//Seulement des images en png !
        // Saut de ligne 5 mm
        $this->Ln(5);
        // Titre gras (B) police Helbetica de 11
        $this->SetFont('Helvetica','B',30);
        // position du coin supérieur gauche par rapport à la marge gauche (mm)
        $this->SetX(80);
        // Texte : 50 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok
        $this->SetFillColor(255,255,255);
        $this->Cell(50,10,"ANAMAIA",0,1,'C',1);
        // Saut de ligne 6 mm
        $this->Ln(20);
      }
    }
  }
  // On active la classe une fois pour toutes les pages suivantes
  // Format portrait (>P) ou paysage (>L), en mm (ou en points > pts), A4 (ou A5, etc.)
  $pdf = new PDF('P','mm','A4');
  $pdf->AddPage();
  $pdf->SetFont('Helvetica','B',25);
  $pdf->SetTextColor(0);

  if ($data['marque'] == "ATELIER TROPEZIEN") {
    $pdf->Cell(120,10,"Reference :   ".$data['reference']."",0,1,'L');
    $pdf->Cell(120,10,"Couleur :       ".$data['couleur']."",0,1,'L');
    $pdf->Image('../PHOTO/'.$data['addrsImage'].'',130,50,70);
    $pdf->Ln(15);
    $pdf->Cell(25,10,"Pack de :       ".$data['colisage']."",0,1,'L');
    $pdf->Ln(5);
    $pdf->Image('../PHOTO/'.$data['addrsScancode'].'',50,105,95);
  } else {
    $pdf->SetFillColor(255,255,255);
    $pdf->cell(120,10,"Reference :   ".$data['reference']."",0,1,'L',1);
    $pdf->cell(120,10,"Couleur :       ".$data['couleur']."",0,1,'L',1);
    $pdf->Image('../PHOTO/'.$data['addrsImage'].'',130,50,70);
    $pdf->Ln(15);
    $pdf->Cell(25,10,"Pack de :       ".$data['colisage']."",0,1,'L');
    $pdf->Ln(5);
    $pdf->Image('../PHOTO/'.$data['addrsScancode'].'',50,105,95);
  }  
// affichage à l'écran...
$pdf->Output('fiche.pdf','I');
}
if (isset($_POST['btn-imprime-all'])) {
  // Appel de la librairie FPDF
  require("../fpdf/fpdf.php");

  if ($data['marque'] == "ATELIER TROPEZIEN") {
    // Création de la class PDF
    class PDF extends FPDF {
      // Header
      function Header() {
        // Logo : 1 >position à gauche du document (en mm), 2 >position en haut du document, 80 >largeur de l'image en mm). La hauteur est calculée automatiquement.
        $this->Image('../PHOTO/TAMPON-AT.png',30,0,150);//Seulement des images en png !
        // Saut de ligne 20 mm
        $this->Ln(5);
        // Titre gras (B) police Helbetica de 11
        $this->SetFont('Helvetica','B',25);
        // position du coin supérieur gauche par rapport à la marge gauche (mm)
        $this->SetX(70);
        // Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok  
        $this->Cell(70,25,'ATELIER TROPEZIEN',0,1,'C');
        // Saut de ligne 10 mm
        $this->Ln(15);
      }
    }
  } else {
    // Création de la class PDF
    class PDF extends FPDF {
      // Header
      function Header() {
        // Logo : 1 >position à gauche du document (en mm), 2 >position en haut du document, 80 >largeur de l'image en mm). La hauteur est calculée automatiquement.
        $this->Image('../PHOTO/TAMPON-ANA.png',35,20,150);//Seulement des images en png !
        // Saut de ligne 5 mm
        $this->Ln(5);
        // Titre gras (B) police Helbetica de 11
        $this->SetFont('Helvetica','B',30);
        // position du coin supérieur gauche par rapport à la marge gauche (mm)
        $this->SetX(80);
        // Texte : 50 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok
        $this->SetFillColor(255,255,255);
        $this->Cell(50,10,"ANAMAIA",0,1,'C',1);
        // Saut de ligne 6 mm
        $this->Ln(20);
      }
    }
  }
  if ($data['marque'] == "ATELIER TROPEZIEN") {
    try {
      $pdo =  new PDO('mysql:host='.$PARAM_hote.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $req = $pdo->prepare("SELECT * FROM produit WHERE marque = 'ATELIER TROPEZIEN'");
      $req->execute();

      while ($donnees = $req->fetch(PDO::FETCH_OBJ)) {
        $pdf = new PDF('P','mm','A4');
        $pdf->AddPage();
        $pdf->SetFont('Helvetica','B',25);
        $pdf->SetTextColor(0);
          
        $pdf->Cell(120,10,"Reference :   ".$data['reference']."",0,1,'L');
        $pdf->Cell(120,10,"Couleur :       ".$data['couleur']."",0,1,'L');
        $pdf->Image('../PHOTO/'.$data['addrsImage'].'',130,50,70);
        $pdf->Ln(15);
        $pdf->Cell(25,10,"Pack de :       ".$data['colisage']."",0,1,'L');
        $pdf->Ln(5);
        $pdf->Image('../PHOTO/'.$data['addrsScancode'].'',50,105,95);
      }
    }
    catch(Exception $e) {echo "Scannez un code EAN !!";}
  } else {
    try {
      $pdo =  new PDO('mysql:host='.$PARAM_hote.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $req = $pdo->prepare("SELECT * FROM produit WHERE marque = 'ANAMAIA'");
      $req->execute();

      while ($donnees = $req->fetch(PDO::FETCH_OBJ)) {
        $pdf = new PDF('P','mm','A4');
        $pdf->AddPage();
        $pdf->SetFont('Helvetica','B',25);
        $pdf->SetTextColor(0);
          
        $pdf->Cell(120,10,"Reference :   ".$data['reference']."",0,1,'L');
        $pdf->Cell(120,10,"Couleur :       ".$data['couleur']."",0,1,'L');
        $pdf->Image('../PHOTO/'.$data['addrsImage'].'',130,50,70);
        $pdf->Ln(15);
        $pdf->Cell(25,10,"Pack de :       ".$data['colisage']."",0,1,'L');
        $pdf->Ln(5);
        $pdf->Image('../PHOTO/'.$data['addrsScancode'].'',50,105,95);
      }
    }
    catch(Exception $e) {echo "Scannez un code EAN !!";}
  }  
// affichage à l'écran...
$pdf->Output('fiche.pdf','I');
}
header('Location:../pages/stock.php');?>