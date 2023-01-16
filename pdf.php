<?php
$ref = $_POST['reference'];
$couleur = $_POST['couleur'];
// Connexion à la BDD (à personnaliser)
$link = mysqli_connect('localhost','akost','1234567','BDD_EAN');
$requete = "SELECT * FROM produit WHERE reference = '$ref' AND couleur = '$couleur'";
$result = mysqli_query($link, $requete);
$data = mysqli_fetch_array($result);
mysqli_free_result($result);

// Appel de la librairie FPDF
require("fpdf/fpdf.php");

if ($data['marque'] == "ATELIER TROPEZIEN") {
  // Création de la class PDF
  class PDF extends FPDF {
    // Header
    function Header() {
      // Logo : 1 >position à gauche du document (en mm), 2 >position en haut du document, 80 >largeur de l'image en mm). La hauteur est calculée automatiquement.
      $this->Image('PHOTO/TAMPON-AT.png',30,0,150);//Seulement des images en png !
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
      $this->Image('PHOTO/TAMPON-ANA.png',35,20,150);//Seulement des images en png !
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
  $pdf->Image('PHOTO/'.$data['addrsImage'].'',130,50,70);
  $pdf->Ln(15);
  $pdf->Cell(25,10,"Pack de :       ".$data['colisage']."",0,1,'L');
  $pdf->Ln(5);
  $pdf->Image('PHOTO/'.$data['addrsScancode'].'',50,105,95);
} else {
  $pdf->SetFillColor(255,255,255);
  $pdf->cell(120,10,"Reference :   ".$data['reference']."",0,1,'L',1);
  $pdf->cell(120,10,"Couleur :       ".$data['couleur']."",0,1,'L',1);
  $pdf->Image('PHOTO/'.$data['addrsImage'].'',130,50,70);
  $pdf->Ln(15);
  $pdf->Cell(25,10,"Pack de :       ".$data['colisage']."",0,1,'L');
  $pdf->Ln(5);
  $pdf->Image('PHOTO/'.$data['addrsScancode'].'',50,105,95);
}

// Fonction en-tête des tableaux en 3 colonnes de largeurs variables
/*function entete_table($position_entete) {
  global $pdf;
  $pdf->SetDrawColor(183); // Couleur du fond RVB
  $pdf->SetFillColor(221); // Couleur des filets RVB
  $pdf->SetTextColor(0); // Couleur du texte noir
  $pdf->SetY($position_entete);
  // position de colonne 1 (10mm à gauche)  
  $pdf->SetX(10);
  $pdf->Cell(60,8,'Ville',1,0,'C',1);  // 60 >largeur colonne, 8 >hauteur colonne
  // position de la colonne 2 (70 = 10+60)
  $pdf->SetX(70); 
  $pdf->Cell(60,8,'Pays',1,0,'C',1);
  // position de la colonne 3 (130 = 70+60)
  $pdf->SetX(130); 
  $pdf->Cell(30,8,'Repas',1,0,'C',1);

  $pdf->Ln(); // Retour à la ligne
}
// AFFICHAGE EN-TÊTE DU TABLEAU
// Position ordonnée de l'entête en valeur absolue par rapport au sommet de la page (70 mm)
$position_entete = 70;
// police des caractères
$pdf->SetFont('Helvetica','',9);
$pdf->SetTextColor(0);
// on affiche les en-têtes du tableau
entete_table($position_entete);*/

// affichage à l'écran...
$pdf->Output('test.pdf','I');