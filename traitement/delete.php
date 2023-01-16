<?php include('../logBDD.php');

$id = $_POST['id'];

echo "Id : ".$id."<br>";

if (!$bdd) { //Contrôler la connexion
    $MessageConnexion = die ("Connexion impossible");
}
else {
    if(isset($_POST['btn-edit'])) {
        //Requête d'insertion
        $req = "DELETE FROM produit WHERE Id = $id";

        //Exécution de la reqête
        mysqli_query($bdd, $req) or die('Erreur SQL ! '.$req.'<br>'.mysqli_error($bdd));
        echo "Suppression effectué !";
    }
}
header("refresh:2;url=../stock.php");?>