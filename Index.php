<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <link rel="icon" type="image/png" href="./Image/TAMPON-AT.ico"/>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <title>SUZETTE</title>
</head>
<body class="gradient">
<div class="title">SUZETTE</div>
<section>
    <div style="text-align:center;">
        <img src="./Image/TAMPON_blue.png">
    </div>
    <div class="menu">
        <a href="pages/generateur.php"><button class="button zoom">GÉNÉRATEUR</button></a>
        <a href="pages/codeproduit.php"><button class="button zoom">AJOUTER PRODUIT</button></a>
        <a href="pages/stock.php"><button class="button zoom">STOCK</button></a>
        <a href="pages/scan.php"><button class="button zoom">SCANNER</button></a>
    </div>    
    <div style="text-align:center;">
        <img src="./Image/TAMPON_blue.png">
    </div>
</section>
</body>
<style>
body {padding: 0; margin: 0;user-select: none;}
.title {font-size: 30px;font-weight: bold;text-align: center;margin: 5% auto 0 auto;text-decoration: underline;}
.menu {width: 50%;display: flex;flex-direction: column;align-items:center;gap: 20px;}
section {padding: 2%;display: flex;flex-direction: row;align-items:center;gap: 20px;}
.zoom:hover {transform: scale(1.2);transition: transform .3s;}
.button {width: 170px;height: 32px;background-color: dodgerblue;border: none;border-radius: 8px;font-weight: bold;font-size: 15px;}
.button:hover {background-color: deepskyblue;}
.gradient {background: linear-gradient(to right, #1DB1DD, #65D0D2);}
img {width: 80%;}
</style>