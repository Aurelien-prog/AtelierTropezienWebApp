<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<?php
@$btn = $_POST['button'];
@$btnstock = $_POST['btn-stock'];
@$btndestock = $_POST['btn-destock'];
@$btndelete = $_POST['btn-delete'];
@$btndeleteonly = $_POST['btn-delete-only'];
@$code = $_POST['code'];
///////////////////////////
function ShowButton() {
    $PARAM_hote ='localhost';
    $PARAM_nom_bd ='BDD_EAN';
    $PARAM_utilisateur ='akost';
    $PARAM_mot_passe ='1234567';
    try { //REGARDE SI IL Y A ÉLÉMENT(S) DANS LA TABLE 'list'
        $pdo =  new PDO('mysql:host='.$PARAM_hote.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $req = $pdo->prepare('SELECT COUNT(*) AS data FROM list');
        $req->execute();
        $result = $req->fetch();

        $data = $result['data'];
        //echo 'data ? : '.$data;

        if ($data >= 1) { ?>
            <button type="submit" class="button-stock zoom" name="btn-stock">Ajouter au stock</button>
            <button type="submit" class="button-stock zoom" name="btn-destock">Enlever du stock</button>
            <button type="submit" class="button-stock zoom" name="btn-delete">Réinitialiser</button><?php
        }
    } catch(Exception $e) {echo "ERREUR";}
}
function Delete() {
    $PARAM_hote ='localhost';
    $PARAM_nom_bd ='BDD_EAN';
    $PARAM_utilisateur ='akost';
    $PARAM_mot_passe ='1234567';
    try {
        $pdo =  new PDO('mysql:host='.$PARAM_hote.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $req = $pdo->prepare("DELETE FROM list WHERE id = ".@$id."");
        $req->execute();
    }
    catch(Exception $e) {echo "ERREUR !";}
    echo 'click';
}
function ShowList() {
    $PARAM_hote ='localhost';
    $PARAM_nom_bd ='BDD_EAN';
    $PARAM_utilisateur ='akost';
    $PARAM_mot_passe ='1234567';
    try { //REGARDE SI IL Y A ÉLÉMENT(S) DANS LA TABLE 'list'
        $pdo =  new PDO('mysql:host='.$PARAM_hote.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $req = $pdo->prepare('SELECT COUNT(*) AS data FROM list');
        $req->execute();
        $result = $req->fetch();
        $data = $result['data'];

        if ($data >= 1) {
            $req = $pdo->prepare('SELECT * FROM list ORDER BY id DESC');
            $req->execute();

            while ($donnees = $req->fetch(PDO::FETCH_OBJ)) {
                $id = $donnees->id;
                $code = $donnees->scancode;
                $req2 = $pdo->prepare('SELECT * FROM produit WHERE CodeEAN = '.$code.'');
                $req2->execute();                        

                while ($donnees = $req2->fetch(PDO::FETCH_OBJ)) {
                    $num = $donnees->CodeEAN;
                    $ref = $donnees->reference;
                    $couleur = $donnees->couleur;
                    $coli = $donnees->colisage;
                    $numprod = $donnees->numProd;
                    $marque = $donnees->marque;
                    $qte = $donnees->quantite;
                }?>
                <form style="padding:0 0 4px 0;display: flex;flex-direction: row;gap: 6%;align-items: center;font-weight: bold;margin: 1% 0;border-bottom:solid 2px black;" action="scan.php" method="POST">
                    <div style="width: 10%;margin: 0 0 0 5%">
                        <?php //echo $id; ?>
                        <?php echo $ref; ?>
                    </div>
                    <div style="width: 8%;">
                        <?php echo $couleur; ?>
                    </div>
                    <div style="width: 8%;">
                        <?php echo $code; ?>
                    </div>
                    <div style="width: 25%;margin: 0 0 0 3%">
                        <?php echo $marque; ?>
                    </div>
                    <div style="width: 5%;">
                        <?php echo '+ '.$coli; ?>
                    </div>
                    <div>
                        <button style="width: 30px;height: 25px;" type="submit" class="button zoom" name="btn-delete-only">
                            <svg style="width: 15px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"/></svg>
                        </button>
                    </div>
            </form><?php
            }
        }        
    } catch(Exception $e) {echo "ERREUR !";}
}
function AddList() {
    $PARAM_hote ='localhost';
    $PARAM_nom_bd ='BDD_EAN';
    $PARAM_utilisateur ='akost';
    $PARAM_mot_passe ='1234567';
    $code = substr($_POST['code'], 0, -1);
    try {
        $pdo =  new PDO('mysql:host='.$PARAM_hote.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $req = $pdo->prepare('INSERT INTO list (scancode) VALUES ('.$code.')');
        $req->execute();

        ShowList();

        $req1 = $pdo->prepare('SELECT scancode FROM list WHERE EXISTS (SELECT CodeEAN FROM produit WHERE '.$code.' = CodeEAN) AS scancode_exists');
        $req1->execute();
        $result = $req1->fetch();

        if ($result['scancode_exists'] == true) {
            echo 'true';
        } else {
            echo 'code introuvable !';
        }

    } catch(Exception $e) {}
}
function AddStock() {
    $PARAM_hote ='localhost';
    $PARAM_nom_bd ='BDD_EAN';
    $PARAM_utilisateur ='akost';
    $PARAM_mot_passe ='1234567';
    try {
        $pdo =  new PDO('mysql:host='.$PARAM_hote.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $req = $pdo->prepare('SELECT * FROM list');
        $req->execute();

        while ($donnees = $req->fetch(PDO::FETCH_OBJ)) {
            $id = $donnees->id;
            $codex = $donnees->scancode;

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

            echo ''.$coli.' PAIRES AJOUTÉS DE : '.$ref.' '.$couleur.'<br>';
        }
        $req5 = $pdo->prepare("TRUNCATE TABLE list");
        $req5->execute();
    }
    catch(Exception $e) {echo "Scannez un code EAN !!";}
}
function Destock() {
    $PARAM_hote ='localhost';
    $PARAM_nom_bd ='BDD_EAN';
    $PARAM_utilisateur ='akost';
    $PARAM_mot_passe ='1234567';
    try {
        $pdo =  new PDO('mysql:host='.$PARAM_hote.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $req = $pdo->prepare('SELECT * FROM list');
        $req->execute();

        while ($donnees = $req->fetch(PDO::FETCH_OBJ)) {
            $id = $donnees->id;
            $codex = $donnees->scancode;

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
        $req5 = $pdo->prepare("TRUNCATE TABLE list");
        $req5->execute();
    }
    catch(Exception $e) {echo "ERREUR !";}
}
function AllDelete() {
    $PARAM_hote ='localhost';
    $PARAM_nom_bd ='BDD_EAN';
    $PARAM_utilisateur ='akost';
    $PARAM_mot_passe ='1234567';
    try {
        $pdo =  new PDO('mysql:host='.$PARAM_hote.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $req = $pdo->prepare("TRUNCATE TABLE list");
        $req->execute();

        echo "<p style='color:green;font-size: 20px;opacity:0.9;background-color:lightskyblue;'>TOUT LES ENREGISTREMENT ONT ÉTÉ SUPPRIMÉ !!</p>";
    }
    catch(Exception $e) {echo "ERREUR !";}
}