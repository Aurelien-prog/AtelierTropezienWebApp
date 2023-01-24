<?php include('../header.php');
/////////////////////////
$PARAM_hote='localhost';
$PARAM_nom_bd='BDD_EAN';
$PARAM_utilisateur='akost';
$PARAM_mot_passe='1234567';
/////////////////////////?>
<?php
if (isset($_POST['btn-search'])) {
    if ($_POST['search_box'] == "") {?>
        <section class="container-search">
            <div class="container-left-stock">
                <a href="stock.php"><button class="button-filtre zoom return">RETOUR</button></a>
                <form class="form-stock" action="stock.php" method="POST">                
                    <input class="input input-search" type="search" autocomplete="off" name="search_box" id="tags"></input>
                    <button class="button-filtre zoom" name="btn-search" type="submit">RECHERCHER</button><br>
                    <button class="button-filtre zoom" type="submit" name="btn-imprime-all">IMPRIMER</button>
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
                                    <button class="button-stock zoom" type="submit" name="btn-edit">MODIFIER</button>
                                    <button class="button-stock zoom" type="submit" name="btn-delete">SUPPRIMER</button>
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
                <a href="stock.php"><button class="button-filtre zoom return">RETOUR</button></a>
                <form class="form-stock" action="stock.php" method="POST">                
                    <input class="input input-search" type="search" autocomplete="off" name="search_box" id="tags" placeholder="<?php echo @$_POST['search_box']?>"></input>
                    <button class="button-filtre zoom" name="btn-search" type="submit">RECHERCHER</button><br>
                    <button class="button-filtre zoom" type="submit" name="btn-imprime-all">IMPRIMER</button>
                </form>
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
                                    <button class="button-stock zoom" type="submit" name="btn-edit">MODIFIER</button>
                                    <button class="button-stock zoom" type="submit" name="btn-delete">SUPPRIMER</button>
                                    <button class="button-stock zoom" type="submit" name="btn-imprime">IMPRIMER</button>
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
                <?php include('../autocomplete-with-recent-searches-using-javascript-php-mysql/search.html'); ?>
                <!--<input class="input input-search" type="search" name="search_box" id="search_box" data-toggle="dropdown" aria-haspopup="true" 
                    aria-expanded="false" onkeyup="javascript:load_data(this.value)" onfocus="javascript:load_search_history()"></input>-->
                <button class="button-filtre zoom" name="btn-search" type="submit">RECHERCHER</button><br>
                <button class="button-filtre zoom" type="submit" name="btn-imprime-all">IMPRIMER</button>
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
/*function delete_search_history(id)
{
	fetch("../autocomplete-with-recent-searches-using-javascript-php-mysql/process_data.php", {

		method: "POST",

		body: JSON.stringify({
			action:'delete',
			id:id
		}),

		headers:{
			'Content-type' : 'application/json; charset=UTF-8'
		}

	}).then(function(response){

		return response.json();

	}).then(function(responseData){
		load_search_history();
	});
}

function load_search_history()
{
	var search_query = document.getElementsByName('search_box')[0].value;

	if(search_query == '')
	{

		fetch("../autocomplete-with-recent-searches-using-javascript-php-mysql/process_data.php", {

			method: "POST",

			body: JSON.stringify({
				action:'fetch'
			}),

			headers:{
				'Content-type' : 'application/json; charset=UTF-8'
			}

		}).then(function(response){

			return response.json();

		}).then(function(responseData){

			if(responseData.length > 0)
			{

				var html = '<ul class="list-group">';

				html += '<li class="list-group-item d-flex justify-content-between align-items-center"><b class="text-primary"><i>Your Recent Searches</i></b></li>';

				for(var count = 0; count < responseData.length; count++)
				{

					html += '<li class="list-group-item text-muted" style="cursor:pointer"><i class="fas fa-history mr-3"></i><span onclick="get_text(this)">'+responseData[count].search_query+'</span> <i class="far fa-trash-alt float-right mt-1" onclick="delete_search_history('+responseData[count].id+')"></i></li>';

				}

				html += '</ul>';

				document.getElementById('search_result').innerHTML = html;

			}

		});

	}
}

function get_text(event)
{
	var string = event.textContent;

	//fetch api

	fetch("../autocomplete-with-recent-searches-using-javascript-php-mysql/process_data.php", {

		method:"POST",

		body: JSON.stringify({
			search_query : string
		}),

		headers : {
			"Content-type" : "application/json; charset=UTF-8"
		}
	}).then(function(response){

		return response.json();

	}).then(function(responseData){

		document.getElementsByName('search_box')[0].value = string;
	
		document.getElementById('search_result').innerHTML = '';

	});

	

}

function load_data(query)
{
	if(query.length > 2)
	{
		var form_data = new FormData();

		form_data.append('query', query);

		var ajax_request = new XMLHttpRequest();

		ajax_request.open('POST', 'process_data.php');

		ajax_request.send(form_data);

		ajax_request.onreadystatechange = function()
		{
			if(ajax_request.readyState == 4 && ajax_request.status == 200)
			{
				var response = JSON.parse(ajax_request.responseText);

				var html = '<div class="list-group">';

				if(response.length > 0)
				{
					for(var count = 0; count < response.length; count++)
					{
						html += '<a href="#" class="list-group-item list-group-item-action" onclick="get_text(this)">'+response[count].reference+'</a>';
					}
				}
				else
				{
					html += '<a href="#" class="list-group-item list-group-item-action disabled">No Data Found</a>';
				}

				html += '</div>';

				document.getElementById('search_result').innerHTML = html;
			}
		}
	}
	else
	{
		document.getElementById('search_result').innerHTML = '';
	}
}

/*var ignore_element = document.getElementById('search_box');

document.addEventListener('click', function(event) {
    var check_click = ignore_element.contains(event.target);
    if (!check_click) 
    {
        document.getElementById('search_result').innerHTML = '';
    }
});*/
</script>