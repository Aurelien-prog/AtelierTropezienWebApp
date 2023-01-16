<?php
/*** 
barcodeimage.php (UTF-8, PSR-2)

Synopsis: barcodeimage.php is a wrapper for using 
activebarcode.ocx to create a png image of a desired barcode
The barcodeimage.php allows the EASY USAGE for creating dynamic barcodes with
the IMG-Tag within HTML-Pages like this:
<IMG SRC="barcodeimage.php" /> 

Parameters:

typeno=       Barcode-Type as number that you want to use for encoding i.e.: 14 (=CODE128)}
              Note: If you don't know the typenumber you can use the parameter "code" alternativly.
              This will set the barcode property "Type". I needed to rename the parameter 
              here because "Type" is a reservered PHP-word.
code=         Barcode-Type as a human readable name that you want to use for encoding i.e.: CODE128
              Note: It's better to set the parameter "typeno" because it's unique. 
              This will set the barcode property "TypeName"
text=         Text that you want to display as a barcode. This may be an article number or a 
              text message like "Hello World!"
              Make sure this parameter is URL-Encoded when sending it to barcodeimage.asp
showtext=     1 or 0    1 = display 'text' human readable below the barcode
fontsize=     Font Size as number. Default is 18.
width=        max. pixel to allow the barcode to use for horizontal space 
              size of the resulting png image
height=       max. pixel to allow the barcode to use for vertical space   
              size of the resulting png image
backcolor=    as html color 
              range: ffffff = white to 000000 = black
              you can also use color names like red, blue, white etc. here
              will be converted to RGB Colorcodes internaly
forecolor=    as html color 
              range: ffffff = white to 000000 = black
              you can also use color names like red, blue, white etc. here
              will be converted to RGB Colorcodes internaly
rotate=       0,90,180,270 degree
BorderWidth=  Border on left and right (free space)
BorderHeight= Border on top and and left (free space)
NotchHeightInPercent= High of the notches (EAN-13, UPC-A/E and others) in percent
alignment=    left, center or right

 Example:
 <IMG SRC="barcodeimage.php?code=CODE128&text=demo />
 <IMG SRC="barcodeimage.php?code=CODE128&text=demo&backcolor=ff00ff />
 <IMG SRC="barcodeimage.php?code=CODE128&text=demo&backcolor=%23ff00ff />  
 (this is allowed but not recommended. The %23 is a # sign)
 
 <IMG SRC="barcodeimage.php?code=CODE128&text=demo&backcolor=#ff00ff />   
 This will NOT work. The # Sign is NOT allowed in URLs.
 
 <IMG SRC="barcodeimage.php?code=CODE128&text=demo&backcolor=red />
 Known friendlynames are allowed for colors.

Further infos and REQUIREMENTS at:
http://www.activebarcode.com/iis/require_php.html

(c) 2003-2019 by www.activebarcode.com, www.activebarcode.de
    mailto: info@activebarcode.de
    Authors: Lars Schenk & Frank Horn

    Version 1.00 - 20.02.2005
    Version 1.01 - 31.08.2006 fontsize parameter added
    Version 1.02 - 09.12.2009 $_GET instead of $HTTP_GET_VARS solves some problems
    Version 1.03 - 16.05.2010 verifies if the PNG variant in line 300 
    is created correctly, hope this fixes a "brokes images issue" on some 
    systems by just doing the job again after a minimal delay
    Version 1.04 - 13.01.2017 Adding control characters as i.e. <CR>
    PSR-2 (mostly)
    Version 1.05 - 11.02.2017 Removed obsolete code. Updated documentation.
    Added alignment parameter
    Version 1.06 - 12.02.2017 Added $CATCH_ERRORS
    Version 1.07 - 15.02.2017 Improved error handling code. Streamlined documenation.
    Version 1.08 - 17.04.2017 Removed ParseControlCodes because it's done in the control now.
    Version 1.09 - 21.02.2019 Accept 0,1,2 as alignment parameter, too (ls)
                              fontname, fontsize, fontbold, fontitalic, 
                              fontunderline, fontstrikeout parmater added.
    Version 1.10 - 11.03.2019 Use new ProgID: ACTIVEBARCODE.BarcodeCtrl.1 (ls)
  
This program (barcodeimage.php) is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program (barcodeimage.php) is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You can also download a copy of the GNU General Public License at
http://www.gnu.org/licenses/gpl.txt

*/

// If $CATCH_ERRORS is set to true errors caused by COM/multithreads will tried to be catched.
// You can set $CATCH_ERRORS to false on a single thread environment. I.e. when you set
// FastCGI setting "Max. Instances" to 1 you will get speed improvements with $CATCH_ERRORS set to false.
// Otherwise if you experince broken images, set $CATCH_ERRORS to true. This is also the default mode.

$CATCH_ERRORS = true;

//------------ you don't need to understand what's going on below this line :-)  --------------------

// Declare and and get Parameter values and set defaults if parameters where not given
$typeno = 0;
$code = 'CODE128';
$text = "ActiveBarcode";
$showtext = 1;
$forecolor = '000000';
$backcolor = 'ffffff';
$width = 450;
$height = 150;
$borderwidth = 0;
$borderheight = 0;
$notchheightinpercent = 100;
$rotate = 0;
$alignment = 1; // center by default
$fontsize= 18;
$fontname = 'Courier New';
$fontbold = 0;
$fontitalic = 0;
$fontunderline = 0;
$fontstrikeout = 0;

if (isset($_GET['code'])) {
    $code = $_GET['code'];
}
if (isset($_GET['typeno'])) {
    if (is_numeric($_GET['typeno'])) {
        $typeno = $_GET['typeno'];
    }
}
if (isset($_GET['text'])) {
    $text = $_GET['text'];
}
if (isset($_GET['showtext'])) {
    $showtext = $_GET['showtext'];
}
if (isset($_GET['width'])) {
    if (is_numeric($_GET['width'])) {
        $width = $_GET['width'];
    }
}
if (isset($_GET['height'])) {
    if (is_numeric($_GET['height'])) {
        $height = $_GET['height'];
    }
}
if (isset($_GET['forecolor'])) {
    $forecolor = $_GET['forecolor'];
}
if (isset($_GET['backcolor'])) {
    $backcolor = $_GET['backcolor'];
}
if (isset($_GET['rotate'])) {
    if (is_numeric($_GET['rotate'])) {
        $rotate = $_GET['rotate'];
    }
}
if (isset($_GET['borderwidth'])) {
    if (is_numeric($_GET['borderwidth'])) {
        $borderwidth= $_GET['borderwidth'];
    }
}
if (isset($_GET['borderheight'])) {
    if (is_numeric($_GET['borderheight'])) {
        $borderheight= $_GET['borderheight'];
    }
}
if (isset($_GET['notchheightinpercent'])) {
    if (is_numeric($_GET['notchheightinpercent'])) {
        $notchheightinpercent = $_GET['notchheightinpercent'];
    }
}
if (isset($_GET['fontname'])) {
    $fontname = $_GET['fontname'];
}
if (isset($_GET['fontsize'])) {
    if (is_numeric($_GET['fontsize'])) {
        $fontsize = $_GET['fontsize'];
    }
}
if (isset($_GET['fontbold'])) {
    $fontbold = $_GET['fontbold'];
}
if (isset($_GET['fontitalic'])) {
    $fontitalic = $_GET['fontitalic'];
}
if (isset($_GET['fontunderline'])) {
    $fontunderline = $_GET['fontunderline'];
}
if (isset($_GET['fontstrikeout'])) {
    $fontstrikeout = $_GET['fontstrikeout'];
}
if (isset($_GET['alignment'])) {
    switch (strtolower($_GET['alignment']))
    {
    	case '0':
    	case 'left':
            $alignment = 0;
            break;
    	case '2':
        case 'right':
            $alignment = 2;
            break;
    }
}


//
// @TODO nice to have: Check up parameters for valid values here
//
if ($rotate<>0 and $rotate<>90 and $rotate <>180 and $rotate <>270) {
    $rotate = 0;
}


// helper function
// synopsis: convert a human readable color to html color code
function HTMLColorTextToColor($HTMLColorText)
{
    // @TODO: Check these values - I'm not sure about all of them.
    switch (strtolower($HTMLColorText))
    {
        case "aqua":
            $result = "#0000FF";
            break;
        case "black":
            $result = "#000000";
            break;
        case "blue":
            $result = "#0000FF";
            break;
        case "fuchsia":
            $result = "#FF00FF";
            break;
        case "gray":
            $result = "#808080";
            break;
        case "green":
            $result = "#00FFFF";
            break;
        case "lime":
            $result = "#FF0000";
            break;
        case "maroon":
            $result = "#800000";
            break;
        case "navy":
            $result = "#800000";
            break;
        case "olive":
            $result = "#808000";
            break;
        case "purple":
            $result = "#800080";
            break;
        case "red":
            $result = "#FF0000";
            break;
        case "silver":
            $result = "#C0C0C0";
            break;
        case "teal":
            $result = "#808000";
            break;
        case "white":
            $result = "#FFFFFF";
            break;
        case "yellow":
            $result = "#FFFF00";
            break;
        default:
            $result = '';
    } // switch
    return $result;
}

// helper function
// synopsis: convert a html color code to a RGB-color-color value
// Parameter
// $HTMLColor accepts 
// - Friendly color name (red, blue, black, white ...)
// - HTML color codes like ffffff, ff00ee ...
// - HTML color codes like #ffffff, #ff00ee ... (must be transmitted like %23ffffff in the URL)
// Result is RGB-color-code value (ActiveBarcode need to get colors as RGB values)
function HTML2RGB($HTMLColor)
{
    $RGBColor = '';
    if (strpos($HTMLColor, '#') === false) { // if there is no # sign in the parameter
        $RGBColor = HTMLColorTextToColor($HTMLColor); // try to convert friendly name
        if ($RGBColor == '') { // if no friendly color name was found
            $RGBColor = '#'.$HTMLColor; // add the # sign to allow 'ffffff' instead of '#ffffff'
        }
        $HTMLColor = $RGBColor;
    }
    $HTML2RGB = hexdec(substr($HTMLColor, 5, 2) . substr($HTMLColor, 3, 2) . substr($HTMLColor, 1, 2));
    // DEBUG
    // echo "[HTML2RGB] HTMLColor = $HTMLColor == HTML2RGB = $HTML2RGB <br />";
    return $HTML2RGB;
}

if ($CATCH_ERRORS == true) {
    $maxRetry = 4; // raise if you experience broken images and need more retries.
    $maxrnd = 999999; // raise if you experience broken images even with more then 3 retries.

    $tryCounter = 0;
    while (isset($Barcode) == false && $tryCounter < $maxRetry) {
        $tryCounter++;
        if ($tryCounter == $maxRetry) {
            usleep(rand(1000,$maxrnd));    
            $Barcode = new COM("ACTIVEBARCODE.BarcodeCtrl.1") or die("Unable to instanciate ActiveBarcode. Not installed? Correct rights?");
        } else {
            usleep(rand(1000,$maxrnd));
            $Barcode = new COM("ACTIVEBARCODE.BarcodeCtrl.1");
        }
    }   
} else { 
    $Barcode = new COM("ACTIVEBARCODE.BarcodeCtrl.1") or die("Unable to instanciate ActiveBarcode. Not installed? Correct rights?");
}

// DEBUG: 
// echo "Loaded ActiveBarcode version: *{$Barcode->Version}*<br />";


$Barcode->Autotype = 0; // false;
$Barcode->TypeName = $code;
if ($typeno > 0) {
    $Barcode->Type = $typeno;
}
$Barcode->Text = $text;
$Barcode->ShowText  = 0; // false;
if (($showtext == 1) or (strtolower($showtext) == "true" )) {
    $Barcode->ShowText = 1; // true;
}
$Barcode->BackColor = HTML2RGB($backcolor);
$Barcode->ForeColor = HTML2RGB($forecolor);
$Barcode->Rotate = $rotate;
$Barcode->Borderwidth = $borderwidth;
$Barcode->Borderheight= $borderheight;
$Barcode->NotchHeightInPercent = $notchheightinpercent;
$Barcode->Font->Name = $fontname;
$Barcode->Font->Size = $fontsize;
$Barcode->Font->Bold = $fontbold;
if ($fontitalic == '1' || strtolower($fontitalic) == 'on' || strtolower($fontitalic) == 'true') {
    $Barcode->Font->Italic = 1;
}
if ($fontunderline == '1' || strtolower($fontunderline) == 'on' || strtolower($fontunderline) == 'true') {
    $Barcode->Font->Underline = 1;
}
if ($fontstrikeout == '1' || strtolower($fontstrikeout) == 'on' || strtolower($fontstrikeout) == 'true') {
    $Barcode->Font->Strikethrough = 1;
}
$Barcode->Alignment = $alignment; 


// PNG output
// DEBUG: If you want to see text output you need to comment out the following line
header("Content-type: image/png"); //we are sending a PNG image to the client

$varARRAY = new Variant('', VT_ARRAY | VT_UI1); // 1-byte unsigned integer.
$varARRAY = $Barcode->BinaryWriteAsPNGBySize($width, $height);


if ($CATCH_ERRORS) {
    // following code is to find out if the variant is correctly created, if not, do it again!
    $tryCounter = 0;
    while (@variant_get_type($varARRAY) != 8209 && $tryCounter < $maxRetry) {
        $tryCounter++;
        usleep(200000);
        $varARRAY = $Barcode->BinaryWriteAsPNGBySize($width, $height);
    }
}

// output the PNG picture bytes
foreach ($varARRAY as $obj) {
     echo chr($obj);
}