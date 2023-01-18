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
</form>
<div class="container-scan"><?php
@$btn = $_POST['btn-add'];
if (isset($btn)) {
    @$code = $_POST['code'];
    $code = substr($code, 0, -1);
    try {
        $pdo =  new PDO('mysql:host='.$PARAM_hote.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $req = $pdo->prepare('INSERT INTO list (scancode) VALUES ('.$code.')');
        $req->execute();

        $req2 = $pdo->prepare('SELECT * FROM list');
        $req2->execute();

        while ($donnees = $req2->fetch(PDO::FETCH_OBJ)) {
            $code = $donnees->scancode;
            //echo $code.'<br>';
            $req3 = $pdo->prepare('SELECT * FROM produit WHERE CodeEAN = '.$code.'');
            $req3->execute();

            while ($donnees = $req3->fetch(PDO::FETCH_OBJ)) {
                $num = $donnees->CodeEAN;
                $ref = $donnees->reference;
                $couleur = $donnees->couleur;
                $coli = $donnees->colisage;
                $numprod = $donnees->numProd;
                $qte = $donnees->quantite;
            }
            echo ''.$ref.' - '.$couleur.' - '.$code.'<br>';
        }
    }
    catch(Exception $e) {echo "Scannez un code EAN !!";}?>
    <form action="scan.php" method="post">
        <button type="submit" class="button zoom" name="btn-stock">STOCK</button>
        <button type="submit" class="button zoom" name="btn-destock">DÉSTOCK</button>
        <button type="submit" class="button zoom" name="btn-all-delete">TOUT SUPPRIMER</button>
    </form><?php
} else {
    try {
        $pdo =  new PDO('mysql:host='.$PARAM_hote.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $req = $pdo->prepare('SELECT * FROM list');
        $req->execute();
    
        while ($donnees = $req->fetch(PDO::FETCH_OBJ)) {
            $code = $donnees->scancode;
            echo $code.'<br>';
        }?>
        <form action="scan.php" method="post">
            <button type="submit" class="button zoom" name="btn-stock">STOCK</button>
            <button type="submit" class="button zoom" name="btn-destock">DÉSTOCK</button>
            <button type="submit" class="button zoom" name="btn-all-delete">TOUT SUPPRIMER</button>
        </form><?php
    }
    catch(Exception $e) {echo "Scannez un code EAN !!";}
}
if (isset($_POST['btn-stock'])) {
    try {
        $pdo =  new PDO('mysql:host='.$PARAM_hote.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $req = $pdo->prepare('SELECT * FROM list');
        $req->execute();

        while ($donnees = $req->fetch(PDO::FETCH_OBJ)) {
            $id = $donnees->id;
            $codex = $donnees->scancode;
            //echo 'Id : '.$id.'<br>';
            //echo 'Code : '.$codex.'<br>';
            $req2 = $pdo->prepare('SELECT * FROM produit WHERE CodeEAN = '.$codex.'');
            $req2->execute();

            while ($donnees = $req2->fetch(PDO::FETCH_OBJ)) {
                $ref = $donnees->reference;
                $couleur = $donnees->couleur;
                $qte = $donnees->quantite;
                $coli = $donnees->colisage;
            }
            $newqte = $qte + $coli;
            $req3 = $pdo->prepare('UPDATE produit SET quantite = '.$newqte.' WHERE CodeEAN = '.$codex.'');
            $req3->execute();

            $req4 = $pdo->prepare('DELETE FROM list WHERE id = '.$id.'');
            $req4->execute();
            echo ''.$coli.' PAIRES AJOUTÉS POUR : '.$ref.' '.$couleur.'<br>';
        }
    }
    catch(Exception $e) {echo "Scannez un code EAN !!";}    
}
if (isset($_POST['btn-destock'])) {
    try {
        $pdo =  new PDO('mysql:host='.$PARAM_hote.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $req = $pdo->prepare('SELECT * FROM list');
        $req->execute();

        while ($donnees = $req->fetch(PDO::FETCH_OBJ)) {
            $id = $donnees->id;
            $codex = $donnees->scancode;
            //echo 'Id : '.$id.'<br>';
            //echo 'Code : '.$codex.'<br>';
            $req2 = $pdo->prepare('SELECT * FROM produit WHERE CodeEAN = '.$codex.'');
            $req2->execute();

            while ($donnees = $req2->fetch(PDO::FETCH_OBJ)) {
                $ref = $donnees->reference;
                $couleur = $donnees->couleur;
                $qte = $donnees->quantite;
                $coli = $donnees->colisage;
            }
            $newqte = $qte - $coli;
            $req3 = $pdo->prepare('UPDATE produit SET quantite = '.$newqte.' WHERE CodeEAN = '.$codex.'');
            $req3->execute();

            $req4 = $pdo->prepare('DELETE FROM list WHERE id = '.$id.'');
            $req4->execute();
            echo ''.$coli.' PAIRES RETIRÉ POUR : '.$ref.' '.$couleur.'<br>';
        }
    }
    catch(Exception $e) {echo "Scannez un code EAN !!";}    
}
if (isset($_POST['btn-all-delete'])) {
    try {
        $pdo =  new PDO('mysql:host='.$PARAM_hote.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $req = $pdo->prepare('TRUNCATE TABLE list');
        $req->execute();
    }
    catch(Exception $e) {echo "Scannez un code EAN !!";}    
}?>
</div>