<?php
// example_show_version_only.php
// (c) 2003-2019 www.activebarcode.com
// Very simpe example that shows the usage of ActiveBarcode.ocx from php
//  
// ActiveBarcode.ocx is used to display the read only property "Version".
// This minimal example is a good start for debugging purpose.

$Barcode = new COM("ACTIVEBARCODE.BarcodeCtrl.1") or die("Unable to instanciate ActiveBarcode. Not installed? Correct rights?");
echo "Loaded ActiveBarcode version: *{$Barcode->Version}*<br />";
?> 
