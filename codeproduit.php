<?php include('header.php');
      include('logBDD.php');      
// Requête pour récuperer le plus grand numéro de produit.
$cachet = 31912151;
try{ $mysqlClient = new PDO( 'mysql:host=localhost;dbname=BDD_EAN;charset=utf8', 'akost', '1234567'); }
catch (Exception $e) { die('Erreur : ' . $e->getMessage()); }

$request = 'SELECT MAX(numProd) as maxCode FROM produit';
$recipes = $mysqlClient->prepare($request);
$recipes->execute();
$rec = $recipes->fetchAll();
foreach ($rec as $rec) {
    if ($rec['maxCode'] == NULL){
        $cde = 1008;
    } else {
        $cde = $rec['maxCode'];
    }    
}?>
<form class="container-product" action="traitement/send-form_codeproduit.php" method="post" enctype="multipart/form-data">
    <div class="container-cp">
        <div class="data-cp top-cp">
            <label class="lbl">MARQUE<span style="color:red;">*</span></label>
            <select class="input" name="marque">
                <option value="ATELIER TROPEZIEN">ATELIER TROPEZIEN</option>
                <option value="ANAMAÏA">ANAMAÏA</option>
            </select>
        </div>
        <div class="data-cp">
            <label class="lbl" for="">RÉFERENCE<span style="color:red;">*</span></label>
            <input class="input" type="text" name="reference" required/>
        </div>
        <div class="data-cp">
            <label class="lbl" for="">COULEUR<span style="color:red;">*</span></label>
            <input class="input" type="text" name="couleur" required/>
        </div>
        <div class="data-cp">
            <label class="lbl" for="">CODE EAN</label>
            <input class="input" type="text" disabled="disabled" name="cdeEAN" value="<?php echo $cachet, $cde += 1; ?>"/>
        </div>
    </div>
    <div class="container-cp">
        <div class="data-cp top-cp">
            <label class="lbl" for="">QUANTITÉ<span style="color:red;">*</span></label>
            <input class="input" type="text" name="quantite" required/>
        </div>
        <div class="data-cp">
            <label class="lbl" for="">COLISAGE<span style="color:red;">*</span></label>
            <input class="input" type="text" name="colisage" required/>
        </div>
        <div class="data-cp">
            <label class="lbl" for="">IMAGE</label>
            <input class="input" type="file" name="fileToUpload" id="fileToUpload">
        </div>
        <div class="data-cp">
            <button class="button zoom btn-top-cp" type="submit" name="btnform_cdeproduit" value="<?php echo $cde; ?>">INSÉRER</button>
        </div>
    </div>
    <div class="container-right-cp">
    <div><?php echo "<img class='top-scan-cp' src='barcode/barcodeimage.php?code=EAN13&text=".$cachet, $cde."&showtext=1&width=220&height=90&borderwidth=0'/>";?></div>
    </div>
</form>