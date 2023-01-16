<?php
// example_calc_checksum_only.php
//
// (c) 2003-2019 www.activebarcode.com
// Very simpe example that shows the usage of ActiveBarcode.ocx from php
// 
// ActiveBarcode.ocx is used to calculate a checksum only

$Barcode = new COM("ACTIVEBARCODE.BarcodeCtrl.1") or die("Unable to instanciate ActiveBarcode. Not installed? Correct rights?");
// DEBUG: 
// echo "Loaded ActiveBarcode version: *{$Barcode->Version}*<br />";

// Set the barcode properties 
$Barcode->Autotype = 0; // false;
$Barcode->TypeName = 'CODE 39 Checksum';
$Barcode->Text = '12ABC';

// ENG: output of barcode properties 
// GER: Ausgabe der zuvor gesetzten Barcode-Eigenschaften
echo '$Barcode->Text: ' . $Barcode->Text . '<br />';
echo '$Barcode->TypeName: ' . $Barcode->TypeName . '<br />';

// ENG: output of the checksum calculated by activebarcode
// GER: Ausgabe der von ActiveBarcode errechneten Prüfsumme:
echo '$Barcode->Checksum: ' . $Barcode->Checksum . '<br />';
?> 
