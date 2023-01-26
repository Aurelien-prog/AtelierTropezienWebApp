<?php include('../header.php');
      include('../database/logBDD.php');
      include('../database/request.php');?>      
<section class="container-scan">
    <form class="container-scancode" action="scan.php" method="POST">
        <!-- Input d'entrée avec bouton d'envoie -->
        <div style="display:flex;flex-direction:row;align-items:center;gap:5%;">
            <input class="input-search input-scan" type="text" name="code" autofocus></input>
            <button type="submit" class="button zoom" name="button">
                <svg style="width: 18px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg>
            </button>
        </div>
    <?php ShowButton(); ?>
    </form>
    <div class="container-list"><?php
    if (isset($code) == NULL) { //AFFICHE LA LISTE AU RETOUR SUR LA PAGE
        ShowList();
    }
    if (isset($btn)) { //AJOUTER LES COLIS A LA LISTE D'ENREGISTREMENT
        AddList();
    }
    if (isset($btnstock)) { //AJOUTER LES COLIS AU STOCK
        AddStock();    
    }
    if (isset($btndestock)) { //DEDUIRE LES COLIS DU STOCK
        Destock();
    }
    if (isset($btndelete)) { //EFFACER TOUTE LA LISTE D'ENREGISTREMENT
        AllDelete();    
    }?>
    </div>
</section>