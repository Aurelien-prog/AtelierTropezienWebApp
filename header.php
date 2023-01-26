<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <link rel="icon" type="image/png" href="../Image/TAMPON-AT.ico"/>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <title>SUZETTE</title>
</head>
<link href='https://fonts.googleapis.com/css?family=Rock+Salt' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/main.css">
<!----------------------------------->
<body>
<header class="gradient">
    <a href="./generateur.php"><button class="button-menu zoom">GÉNÉRATEUR</button></a>
    <a href="./codeproduit.php"><button class="button-menu zoom">AJOUTER PRODUIT</button></a>
    <a href="./stock.php"><button class="button-menu zoom">STOCK</button></a>
    <a href="./scan.php"><button class="button-menu zoom">SCANNER</button></a>
    <a href="../Index.php"><button class="button_ zoom">MENU</button></a>
    <?php
    /*$day = date('d');
    $month = date('m');
    $year = date('Y');
    echo "<p class='clock'".$day." / ".$month." / ".$year."</p>";*/
    ?>
</header>
<style>
header {display: flex;gap: 2%;padding: 2% 0 2% 10%;}
.zoom:hover {transform: scale(1.2);transition: transform .3s;}
.button-menu {width: 160px;height: 30px;background-color: dodgerblue;border: none;border-radius: 8px;font-weight: bold;}
.button-menu:hover {background-color: deepskyblue;}
.button_ {width: 160px;height: 30px;background-color: cornflowerblue;border: none;border-radius: 10px;font-weight: bold;}
.gradient {background: linear-gradient(to right, #1DB1DD, #65D0D2);}
</style>