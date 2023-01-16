<?php include('header.php'); ?>

<form class="form-fiche-prod" method="post" action="pdf.php" name="form-search">
    <label class="lbl" for="">RÉFÉRENCE<span style="color:red;">*</span></label>
    <input class="input" type="search" autocomplete="off" name="reference" onkeyup="showResult(this.value)"/>
    <div id="recherche"></div>
    <label class="lbl" for="">COULEUR<span style="color:red;">*</span></label>
    <input class="input" type="search" autocomplete="off" name="couleur" style="margin-bottom:30px;"/>
    <button class="button zoom" type="submit" name="btn-inprim">IMPRIMER</button>
</form>

<script>
function showResult(str) {
if (str.length>1){

    var xmlhttp = new XMLHttpRequest();

  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("recherche").innerHTML=this.responseText;
      document.getElementById("recherche").style.background="white";
      document.getElementById("recherche").style.overflowY="scroll";
	  document.getElementById("recherche").style.boxShadow="0 10px 10px rgba(0, 0, 0, 0.33)";
    }
  }
  xmlhttp.open("GET","recherche.php?q="+str,true);
  xmlhttp.send()
}	
	else{
      document.getElementById("recherche").innerHTML="";
   
    return;}
}
</script>