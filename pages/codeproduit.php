<?php include('../header.php');
      include('../database/logBDD.php');
// Requête pour récuperer le plus grand numéro de produit.
$cachet = 31912151;
try{ $mysqlClient = new PDO( 'mysql:host=localhost;dbname=BDD_EAN;charset=utf8', 'akost', '1234567'); }
catch (Exception $e) { die('Erreur : ' . $e->getMessage()); }

$request = 'SELECT MAX(numProd) as maxCode FROM produit';
$recipes = $mysqlClient->prepare($request);
$recipes->execute();
$rec = $recipes->fetchAll();
foreach ($rec as $rec) {
    if ($rec['maxCode'] == NULL) {
        $cde = 1008;
    } else {
        $cde = $rec['maxCode'];
    }
}?>
<form class="container-product" action="../traitement/send-form_codeproduit.php" method="post" enctype="multipart/form-data">
    <div style="display: flex;flex-direction: row;height: 80%">
        <div class="container-cp">
            <div class="data-cp top-cp" style="text-align: center;">
                <h3>AJOUTER UN PRODUIT</h3>
            </div>
            <div class="data-cp">
                <select class="input" name="marque">
                    <option value="ATELIER TROPEZIEN">ATELIER TROPEZIEN</option>
                    <option value="ANAMAIA">ANAMAÏA</option>
                </select>
            </div>
            <div class="data-cp">
                <label class="lbl-cp" for="">Réference<span style="color:red;">*</span></label>
                <input class="input" type="text" name="reference" required/>
            </div>
            <div class="data-cp">
                <label class="lbl-cp" for="">Couleur<span style="color:red;">*</span></label>
                <input class="input" type="text" name="couleur" required/>
            </div>
            <div class="data-cp">
                <label class="lbl-cp" for="">Quantité<span style="color:red;">*</span></label>
                <input class="input" type="text" name="quantite" required/>
            </div>
            <div class="data-cp">
                <label class="lbl-cp" for="">Colisage<span style="color:red;">*</span></label>
                <input class="input" type="text" name="colisage" required/>
            </div>        
        </div>
        <div class="container-right-cp">
            <div class="custom-file" style="display: flex;flex-direction: column;align-items: center;">
                <input type="file" name="file" id="file" class="inputfile" accept="image/png, image/jpeg"/>
                <label for="file">Choisir une image</label>
                <img id="preview" style="width: 80%;margin: 10% 0 20% 0;border: solid 4px blue;height: 120px;">
            </div>
            <div><?php echo "<img class='top-scan-cp' name='img-download' src='../barcode/barcodeimage.php?code=EAN13&text=".$cachet, $cde."&showtext=1&width=220&height=90&borderwidth=0'/>";?></div>
            <div class="data-cp" style="align-items: center;margin: 5% 0;">
                <input class="input input-cp" type="text" disabled="disabled" name="cdeEAN" value="<?php echo $cachet, $cde += 1; ?>"/>
            </div>
        </div>
    </div>
    <div style="margin: 2% auto;">
        <button class="button zoom btn-cp" type="submit" name="btnform_cdeproduit" value="<?php echo $cde; ?>">CRÉER</button>
    </div>
</form>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function (e) {
        $('input[type="file"]').on('change', (e) => {
            console.log('change file');
            let that = e.currentTarget
            if (that.files && that.files[0]) {
                $(that).next('.custom-file-label').html(that.files[0].name)
                let reader = new FileReader()
                reader.onload = (e) => {
                    $('#preview').attr('src', e.target.result)
                }
                reader.readAsDataURL(that.files[0])
            }
        })
    });
</script>