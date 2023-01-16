<?php include('header.php'); ?>

<form class="form-fiche-prod" method="post" action="pdf.php" name="form-search">
    <label class="lbl" for="">RÉFÉRENCE<span style="color:red;">*</span></label>
    <input class="input" type="search" autocomplete="off" name="reference" id="tags" autofocus/>
    <div id="recherche"></div>
    <label class="lbl" for="">COULEUR<span style="color:red;">*</span></label>
    <input class="input" type="search" autocomplete="off" name="couleur" style="margin-bottom:30px;" id="tag"/>
    <button class="button zoom" type="submit" name="btn-inprim">IMPRIMER</button>
</form>
<script>
$( function() {
    $( "#tags" ).autocomplete({
        source: "./search/searchref.php",
        minLength: 1
    });
});
$( function() {
    $( "#tag" ).autocomplete({
        source: "./search/searchcolor.php",
        minLength: 1
    });
});
</script>