<?php include('../header.php');
/////////////////////////
$PARAM_hote='localhost';
$PARAM_nom_bd='BDD_EAN';
$PARAM_utilisateur='akost';
$PARAM_mot_passe='1234567';
/////////////////////////?>
<?php
if (isset($_POST['btn-trie'])) {?>
    <section class="container-search">
        <div class="container-left-stock">
            <form class="form_search" action="stock.php" method="POST">
                <input class="input-search" type="text" name="search_box" placeholder="Rechercher" id="search_box" data-toggle="dropdown" aria-haspopup="true" 
                aria-expanded="false" onkeyup="javascript:load_data(this.value)" onfocus="javascript:load_search_history()" autocomplete="off" placeholder="<?php echo @$_POST['search_box']?>"/>
                <span id="search_result" class="span-search"></span>
                <button type="submit" class="button zoom" name="btn-search">
                    <svg style="width: 10px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352c79.5 0 144-64.5 144-144s-64.5-144-144-144S64 128.5 64 208s64.5 144 144 144z"/></svg>
                </button>
            </form>
            <form class="form-stock" action="stock.php" method="POST" style="width: 100%;text-align: center;">
                <select class="select-search" name="selection" id="trie-stock" style="width: 82%;">
                    <option value="TRI">TRIER</option>
                    <option value="ATELIER TROPEZIEN">ATELIER TROPEZIEN</option>
                    <option value="ANAMAÏA">ANAMAÏA</option>
                </select>
                <button type="submit" class="button zoom" name="btn-trie">
                    <svg style="width: 10px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352c79.5 0 144-64.5 144-144s-64.5-144-144-144S64 128.5 64 208s64.5 144 144 144z"/></svg>
                </button>
            </form>
            <a href="stock.php"><button class="button-return zoom">RETOUR</button></a>
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
                        <form action="../traitement/params.php" method="post" enctype="multipart/form-data">
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
                                <div style="display:flex;flex-direction: row;gap: 10%">
                                    <button style="width: 35px;height: 30px;" class="button-stock zoom" type="submit" name="btn-edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.8 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"/></svg>
                                    </button>
                                    <button style="width: 35px;height: 30px;" class="button-stock zoom" type="submit" name="btn-delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"/></svg>
                                    </button>
                                    <button style="width: 35px;height: 30px;" class="button-stock zoom" type="submit" name="btn-imprime">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M128 0C92.7 0 64 28.7 64 64v96h64V64H354.7L384 93.3V160h64V93.3c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0H128zM384 352v32 64H128V384 368 352H384zm64 32h32c17.7 0 32-14.3 32-32V256c0-35.3-28.7-64-64-64H64c-35.3 0-64 28.7-64 64v96c0 17.7 14.3 32 32 32H64v64c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V384zm-16-88c-13.3 0-24-10.7-24-24s10.7-24 24-24s24 10.7 24 24s-10.7 24-24 24z"/></svg>
                                    </button>
                                </div>
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
if (isset($_POST['btn-search'])) {?>
    <section class="container-search">
        <div class="container-left-stock">
            <form class="form_search" action="stock.php" method="POST">
                <input class="input-search" type="text" name="search_box" placeholder="Rechercher" id="search_box" data-toggle="dropdown" aria-haspopup="true" 
                aria-expanded="false" onkeyup="javascript:load_data(this.value)" onfocus="javascript:load_search_history()" autocomplete="off" placeholder="<?php echo @$_POST['search_box']?>"/>
                <span id="search_result" class="span-search"></span>
                <button type="submit" class="button zoom" name="btn-search">
                    <svg style="width: 10px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352c79.5 0 144-64.5 144-144s-64.5-144-144-144S64 128.5 64 208s64.5 144 144 144z"/></svg>
                </button>
            </form>
            <a href="stock.php"><button class="button-return zoom">RETOUR</button></a>
        </div>
        <div class="container-right-search"><?php
            try{ $mysqlClient = new PDO( 'mysql:host=localhost;dbname=BDD_EAN;charset=utf8', 'akost', '1234567'); }
            catch (Exception $e) { die('Erreur : ' . $e->getMessage()); }
            
            $motEntree = htmlentities($_POST['search_box']);
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
                        <form action="../traitement/params.php" method="post" enctype="multipart/form-data">
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
                                <div style="display:flex;flex-direction: row;gap: 10%">
                                    <button style="width: 35px;height: 30px;" class="button-stock zoom" type="submit" name="btn-edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.8 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"/></svg>
                                    </button>
                                    <button style="width: 35px;height: 30px;" class="button-stock zoom" type="submit" name="btn-delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"/></svg>
                                    </button>
                                    <button style="width: 35px;height: 30px;" class="button-stock zoom" type="submit" name="btn-imprime">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M128 0C92.7 0 64 28.7 64 64v96h64V64H354.7L384 93.3V160h64V93.3c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0H128zM384 352v32 64H128V384 368 352H384zm64 32h32c17.7 0 32-14.3 32-32V256c0-35.3-28.7-64-64-64H64c-35.3 0-64 28.7-64 64v96c0 17.7 14.3 32 32 32H64v64c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V384zm-16-88c-13.3 0-24-10.7-24-24s10.7-24 24-24s24 10.7 24 24s-10.7 24-24 24z"/></svg>
                                    </button>
                                </div>
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
if (isset($_POST['btn-search']) == NULL && isset($_POST['btn-trie']) == NULL) {?>
    <section class="container-stock">
        <div class="container-left-stock">
            <form class="form_search" action="stock.php" method="POST">
                <input class="input-search" type="text" name="search_box" placeholder="Rechercher" id="search_box" data-toggle="dropdown" aria-haspopup="true" 
                aria-expanded="false" onkeyup="javascript:load_data(this.value)" onfocus="javascript:load_search_history()" autocomplete="off"/>
                <span id="search_result" class="span-search"></span>
                <button type="submit" class="button zoom" name="btn-search">
                    <svg style="width: 10px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352c79.5 0 144-64.5 144-144s-64.5-144-144-144S64 128.5 64 208s64.5 144 144 144z"/></svg>
                </button>
            </form>
            <form class="form-stock" action="stock.php" method="POST" style="width: 100%;text-align: center;">
                <select class="select-search" name="selection" id="trie-stock">
                    <option value="TRI">TRIER</option>
                    <option value="ATELIER TROPEZIEN">ATELIER TROPEZIEN</option>
                    <option value="ANAMAÏA">ANAMAÏA</option>
                </select>
                <button type="submit" class="button zoom" name="btn-trie">
                    <svg style="width: 10px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352c79.5 0 144-64.5 144-144s-64.5-144-144-144S64 128.5 64 208s64.5 144 144 144z"/></svg>
                </button>
            </form>
            <button class="button-imprim zoom">IMPRIMER</button>
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
}
include ('../traitement/search.php');