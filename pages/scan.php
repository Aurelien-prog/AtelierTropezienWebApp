<?php include('../header.php');
/////////////////////////
$PARAM_hote='localhost';        
$PARAM_nom_bd='BDD_EAN';
$PARAM_utilisateur='akost';
$PARAM_mot_passe='1234567';
/////////////////////////?>
<form class="top-scan" action="scan.php" method="POST">
    <input class="input" type="text" name="code" placeholder="<?php echo @$_POST['codeEAN']?>" autofocus></input>
    <button type="submit" class="button zoom" name="btn-add">AJOUTER</button>
    <button type="submit" class="button zoom" name="btn-delete">SUPPRIMER</button>
</form><?php
@$btn = $_POST['btn-add'];
@$btnd = $_POST['btn-delete'];

/*$dataList = [];

?><script>
(function iS() {
    var execJs= function eJs(){
    //refresh convertisseur
    function addList(){
        @$_POST['codeEAN'].push($dataList);
    }
    //Permet de d'appeller la fonction tout les 1000 millisecondes (1 seconde)
    setInterval(addList, 3000);
};
$(execJs);
})();
</script><?php

foreach ($dataList) {
    
}*/


if (isset($btnd)) {
    $code = $_POST['code'];
    try {
        $pdo =  new PDO('mysql:host='.$PARAM_hote.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $req = $pdo->prepare('SELECT * FROM produit WHERE CodeEAN = '.substr($code, 0, -1).'');
        $req->execute();

        while ($donnees = $req->fetch(PDO::FETCH_OBJ)) {
            $num = $donnees->CodeEAN;
            $ref = $donnees->reference;
            $couleur = $donnees->couleur;
            $coli = $donnees->colisage;
            $numprod = $donnees->numProd;
            $qte = $donnees->quantite;
        }
        $newqte = $qte - $coli;

        $req = $pdo->prepare('UPDATE produit SET quantite = '.$newqte.' WHERE numProd = '.$numprod.'');
        $req->execute();
        //$message = "wrong answer";
        //echo "<script type='text/javascript'>alert('$message');</script>";
        echo ''.$coli.' PAIRES RETIRÉS POUR : '.$ref.' '.$couleur.'';
    }
    catch(Exception $e) {echo "Scannez un code EAN !!";}    
}
if (isset($btn)) {
    $code = $_POST['code'];
    try {
        $pdo =  new PDO('mysql:host='.$PARAM_hote.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $req = $pdo->prepare('SELECT * FROM produit WHERE CodeEAN = '.substr($code, 0, -1).'');
        $req->execute();

        while ($donnees = $req->fetch(PDO::FETCH_OBJ)) {
            $num = $donnees->CodeEAN;
            $ref = $donnees->reference;
            $couleur = $donnees->couleur;
            $coli = $donnees->colisage;
            $numprod = $donnees->numProd;
            $qte = $donnees->quantite;
        }
        $newqte = $qte + $coli;

        $req = $pdo->prepare('UPDATE produit SET quantite = '.$newqte.' WHERE numProd = '.$numprod.'');
        $req->execute();

        echo ''.$coli.' PAIRES AJOUTÉS POUR : '.$ref.' '.$couleur.'';
    }
    catch(Exception $e) {echo "Scannez un code EAN !!";}    
}