<?php include('../header.php');?>
<section class="container-home">
    <form class="container-left-home" action="generateur.php" method="post">
        <div class="data-home top">
            <label class="lbl" for="">CODE EAN<span style="color:red;">*</span></label>
            <input class="input" name="code" type="text" required/>
        </div>
        <div class="data-home">
            <label class="lbl" for="">NOMBRE<span style="color:red;">*</span></label>
            <input class="input" name="compteur" type="text" value="1" maxlength="2">
        </div>
        <div class="data-home">
            <button class="button zoom" name="btn-scancode" type="submit">CRÉER</button>
        </div>
    </form>
    <div class="container-right-home"><?php
        $compt = 0;
        $a = 0;
        @$EAN = $_POST['code'];
        @$compt = $_POST['compteur'];
        @$btn = $_POST['btn-scancode'];
        if (isset($btn)) {
            //WARNING SI IL Y A + OU - DE 7 NUMÉROS
            if(strlen($EAN) <= "6" or strlen($EAN) >= "8" & strlen($EAN) <= "11" or strlen($EAN) >= "13") {?>
                <p class="warning"><?php echo "LE CODE '" .$EAN. "' N'EST PAS CORRECT !<br><br>VEUILLEZ INSÉRER 7 OU 12 NUMÉROS."?></p><?php
            }
            //AFFICHAGE DES CODE EAN SI IL Y A LES 7 OU 12 NUMÉROS
            if(strlen($EAN) == "7") {
                while ($a < $compt) {
                    ?><div>
                        <div><?php echo "<img src='../barcode/barcodeimage.php?code=EAN8&text=".$EAN."&showtext=
                            1&width=210&height=70&borderwidth=0'/>";?></div>
                        <div style="font-size:20px;text-align:center;font-weight:bold;text-decoration:overline;"><?php echo $EAN;?></div>
                    </div><?php
                    $a++;
                    $EAN++;
                }
            } elseif(strlen($EAN) == "12") {
                while ($a < $compt) {
                    ?><div class="scanEAN">
                        <div><?php echo "<img src='../barcode/barcodeimage.php?code=EAN13&text=".$EAN."&showtext=
                            1&width=210&height=70&borderwidth=0'/>";?></div>
                        <div style="font-size:20px;text-align:center;font-weight:bold;text-decoration:overline;"><?php echo $EAN;?></div>
                    </div><?php
                    $a++;
                    $EAN++;
                }
            }
        }else {?><p class="warning"><?php echo "INDIQUER LE CODE ET LE NOMBRE DE CODE-EAN QUE VOUS SOUHAITEZ !"?></p><?php }?>
    </div>
</section>