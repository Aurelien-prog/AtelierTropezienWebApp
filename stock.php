<?php include('header.php');
/////////////////////////
$PARAM_hote='localhost';
$PARAM_nom_bd='BDD_EAN';
$PARAM_utilisateur='akost';
$PARAM_mot_passe='1234567';
/////////////////////////?>
<?php
if (isset($_POST['btn-search'])) {?>
    <section class="container-search">
        <div class="container-left-stock">
            <a class="" href="stock.php"><button class="button zoom petit">RETOUR</button></a>
            <select class="select-stock" name="selection" id="trie-stock">
                <option value="TRI">TRIER</option>
                <option value="ATELIER TROPEZIEN">ATELIER TROPEZIEN</option>
                <option value="ANAMAÏA">ANAMAÏA</option>
            </select>
            <form class="form-stock" action="stock.php" method="POST">
                <input class="input input-search" type="search" autocomplete="off" name="word" id="search" placeholder="<?php echo @$_POST['word']?>"></input>
                <button class="button zoom btn-stock" name="btn-search" type="submit">RECHERCHER</button>
            </form>
        </div>
        <div class="container-right-search"><?php
            try{ $mysqlClient = new PDO( 'mysql:host=localhost;dbname=BDD_EAN;charset=utf8', 'akost', '1234567'); }
            catch (Exception $e) { die('Erreur : ' . $e->getMessage()); }
            
            $motEntree = htmlentities($_POST['word']);
            $request = 'SELECT * FROM produit WHERE reference = "'.$motEntree.'"';
            $recipes = $mysqlClient->prepare($request);
            $recipes->execute();
            $rec = $recipes->fetchAll();?>
            <div class="scroll">
            <table class="table-stock">
                <tr>
                    <th>Référence</th>
                    <th>Couleur</th>
                    <th>Qte</th>
                    <th>Colisage</th>
                    <th colspan="2">Code EAN</th>
                    <th>Photo</th>                    
                    <th>PARAM</th>
                </tr><?php
                    foreach ($rec as $rec) {?>
                    <tr class="tr-table-stock">
                        <form action="traitement/edit.php" method="post" enctype="multipart/form-data">
                            <input name="id" type='hidden' value="<?php echo $rec['Id'];?>"/>
                            <td class="td-search-ref"><input name="newreference" class="input-edit" type="text" value="<?php echo $rec['reference'];?>"></input></td>
                            <td class="td-search"><input name="newcouleur" class="input-edit" type="text" value="<?php echo $rec['couleur'];?>"></input></td>
                            <td class="td-little"><input name="newquantite" class="input-edit" type="text" value="<?php echo $rec['quantite'];?>"></input></td>
                            <td class="td-little"><input name="newcolisage" class="input-edit" type="text" value="<?php echo $rec['colisage'];?>"></input></td>
                            <td><?php echo $rec['CodeEAN'];?></td>
                            <?php $cde = $rec['CodeEAN']; ?>
                            <td><?php echo "<img name='scanean' class='img-zoom'
                                src='barcode/barcodeimage.php?code=EAN13&text=".$cde."&showtext=1&width=110&height=40&borderwidth=0'/>";?></td>
                            <td class="td-search-pht"><?php
                                $nom_repertoire = './PHOTO';
                                $pointeur = opendir($nom_repertoire); 
                                closedir($pointeur);
                                echo '<img class="img-zoom" style="height:40px; width:80px;" src="'.$nom_repertoire.'/'.$rec["addrsImage"].'"';?>
                            </td>
                            <td class="td-file">
                                <input name="newimage" class="input-files" type="file"></input>
                                <button class="button-edit zoom" type="submit" name="btn-edit">MODIFIER</button>
                            </td>
                        </form>
                    </tr>
                <?php
                }?>
            </table>
            </div>
        </div>
    </section><?php
} else {?>
    <section class="container-stock">
        <div class="container-left-stock">
            <select class="select-stock" name="selection" id="trie-stock">
                <option value="TRI">TRIER</option>
                <option value="ATELIER TROPEZIEN">ATELIER TROPEZIEN</option>
                <option value="ANAMAÏA">ANAMAÏA</option>
            </select>
            <form class="form-stock" action="stock.php" method="POST">
                <input class="input input-search" type="search" name="word"></input>
                <button class="button zoom btn-stock" name="btn-search" type="submit">RECHERCHER</button>
            </form>
        </div>
        <div class="container-right-stock"><?php
            try{ $mysqlClient = new PDO( 'mysql:host=localhost;dbname=BDD_EAN;charset=utf8', 'akost', '1234567'); }
            catch (Exception $e) { die('Erreur : ' . $e->getMessage()); }
            
            $request = 'SELECT * FROM produit';
            $recipes = $mysqlClient->prepare($request);
            $recipes->execute();
            $rec = $recipes->fetchAll();?>
            <div class="scroll">
            <table class="table-stock">
                <tr>
                    <th>Référence</th>
                    <th>Couleur</th>
                    <th>Quantité</th>
                    <th colspan="2">Code EAN</th>
                    <th>Photo</th>
                </tr><?php
                    foreach ($rec as $rec) {?>
                    <tr class="tr-table-stock">
                        <td><?php echo $rec['reference'];?></td>
                        <td><?php echo $rec['couleur'];?></td>
                        <td><?php echo $rec['quantite'];?></td>
                        <td><?php echo $rec['CodeEAN'];?></td>
                        <?php $cde = $rec['CodeEAN']; ?>
                        <td><?php echo "<img name='scanean' class='img-zoom'
                            src='barcode/barcodeimage.php?code=EAN13&text=".$cde."&showtext=1&width=110&height=40&borderwidth=0'/>";?></td>
                        <td><?php
                            $nom_repertoire = './PHOTO';
                            $pointeur = opendir($nom_repertoire); 
                            closedir($pointeur);
                            echo '<img class="img-zoom" style="height:40px; width:80px;" src="'.$nom_repertoire.'/'.$rec["addrsImage"].'"';?>
                        </td>
                    </tr>
                <?php
                }?>
            </table>
            </div>
        </div>
    </section><?php
}?>
<script>
$(document).ready(function() {
    $('#search').autocomplete({
        source: 'search.php',
        minLength: 0
    });
});
</script>