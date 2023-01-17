<?php include('../header.php');
/////////////////////////
$PARAM_hote='localhost';
$PARAM_nom_bd='BDD_EAN';
$PARAM_utilisateur='akost';
$PARAM_mot_passe='1234567';
/////////////////////////?>
<?php
if (isset($_POST['btn-search'])) {
    if ($_POST['word'] == "") {?>
        <section class="container-search">
            <div class="container-left-stock">
                <a href="stock.php"><button class="button zoom petit">RETOUR</button></a>
                <form class="form-stock" action="stock.php" method="POST">                
                    <input class="input input-search" type="search" autocomplete="off" name="word" id="search"></input>
                    <button class="button zoom btn-stock" name="btn-search" type="submit">RECHERCHER</button>
                </form>
            </div>
            <div class="container-right-search"><?php
                try{ $mysqlClient = new PDO( 'mysql:host=localhost;dbname=BDD_EAN;charset=utf8', 'akost', '1234567'); }
                catch (Exception $e) { die('Erreur : ' . $e->getMessage()); }
                
                @$marque = $_POST['selection'];
                $request = 'SELECT * FROM produit WHERE marque = "'.$marque.'"';
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
                            <form action="../traitement/edit.php" method="post" enctype="multipart/form-data">
                                <input name="id" type='hidden' value="<?php echo $rec['Id'];?>"/>
                                <td class="td-search-ref"><input name="newreference" class="input-edit" type="text" value="<?php echo $rec['reference'];?>"></input></td>
                                <td class="td-search"><input name="newcouleur" class="input-edit" type="text" value="<?php echo $rec['couleur'];?>"></input></td>
                                <td class="td-little"><input name="newquantite" class="input-edit" type="text" value="<?php echo $rec['quantite'];?>"></input></td>
                                <td class="td-little"><input name="newcolisage" class="input-edit" type="text" value="<?php echo $rec['colisage'];?>"></input></td>
                                <td><?php echo $rec['CodeEAN'];?></td>
                                <?php $cde = $rec['CodeEAN']; ?>
                                <td><?php 
                                    $nom_repertoire = '../PHOTO';
                                    $pointeur = opendir($nom_repertoire); 
                                    closedir($pointeur);
                                    echo '<img class="img-zoom" style="height:40px; width:80px;" src="'.$nom_repertoire.'/'.$rec["addrsScancode"].'"';?></td>
                                <td class="td-search-pht"><?php
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
        <section class="container-search">
            <div class="container-left-stock">
                <a href="stock.php"><button class="button zoom petit">RETOUR</button></a>
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
                            <form action="../traitement/edit.php" method="post" enctype="multipart/form-data">
                                <input name="id" type='hidden' value="<?php echo $rec['Id'];?>"/>
                                <td class="td-search-ref"><input name="newreference" class="input-edit" type="text" value="<?php echo $rec['reference'];?>"></input></td>
                                <td class="td-search"><input name="newcouleur" class="input-edit" type="text" value="<?php echo $rec['couleur'];?>"></input></td>
                                <td class="td-little"><input name="newquantite" class="input-edit" type="text" value="<?php echo $rec['quantite'];?>"></input></td>
                                <td class="td-little"><input name="newcolisage" class="input-edit" type="text" value="<?php echo $rec['colisage'];?>"></input></td>
                                <td><?php echo $rec['CodeEAN'];?></td>
                                <?php $cde = $rec['CodeEAN']; ?>
                                <td><?php 
                                    $nom_repertoire = '../PHOTO';
                                    $pointeur = opendir($nom_repertoire); 
                                    closedir($pointeur);
                                    echo '<img class="img-zoom" style="height:40px; width:80px;" src="'.$nom_repertoire.'/'.$rec["addrsScancode"].'"';?></td>
                                <td class="td-search-pht"><?php
                                    echo '<img class="img-zoom" style="height:40px; width:80px;" src="'.$nom_repertoire.'/'.$rec["addrsImage"].'"';?>
                                </td>
                                <td class="td-file">
                                    <input name="newimage" class="input-files" type="file"></input>
                                    <button class="button-edit zoom" type="submit" name="btn-edit">MODIFIER</button>
                                    <button class="btn-delete zoom" type="submit" name="btn-delete"><svg class="img-cross" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M175 175C184.4 165.7 199.6 165.7 208.1 175L255.1 222.1L303 175C312.4 165.7 327.6 165.7 336.1 175C346.3 184.4 346.3 199.6 336.1 208.1L289.9 255.1L336.1 303C346.3 312.4 346.3 327.6 336.1 336.1C327.6 346.3 312.4 346.3 303 336.1L255.1 289.9L208.1 336.1C199.6 346.3 184.4 346.3 175 336.1C165.7 327.6 165.7 312.4 175 303L222.1 255.1L175 208.1C165.7 199.6 165.7 184.4 175 175V175zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/></svg></button>
                                </td>
                            </form>
                        </tr>
                    <?php
                    }?>
                </table>
                </div>
            </div>
        </section><?php
    }
} else {?>
    <section class="container-stock">
        <div class="container-left-stock">            
            <form class="form-stock" action="stock.php" method="POST">
                <select class="input inputPlus" name="selection" id="trie-stock">
                    <option value="TRI">TRIER</option>
                    <option value="ATELIER TROPEZIEN">ATELIER TROPEZIEN</option>
                    <option value="ANAMAÏA">ANAMAÏA</option>
                </select><br>
                <input class="input input-search" type="search" name="word" id="tags"></input>
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
                        <td><?php 
                            $nom_repertoire = '../PHOTO';
                            $pointeur = opendir($nom_repertoire);
                            closedir($pointeur);
                            echo '<img class="img-zoom" style="height:40px; width:80px;" src="'.$nom_repertoire.'/'.$rec["addrsScancode"].'"';?></td>
                        <td><?php                            
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
$( function() {
    $( "#tags" ).autocomplete({
        source: "../search/searchref.php",
        minLength: 1
    });
});
</script>