<?php
// example_create_current_time_as_code128.php
//
// (c) 2003-2019 www.activebarcode.com 
// This PHP-Source Code is free. 
// You may use and modify it freely for your needs.
// 
// barcodeimage.php is used to get an dynamic image src for a html <img> tag.
//

// $myText = 'Time: ' . datepart("h",now())&"."&datepart("n",now())&"."&datepart("s",now())

$myText = strftime("%H:%M:%S");
?> 
<html>
<head>
</head>
<body>
This is a simple expample that show the usage of <b>barcodeimage.php</b><br />
within the an image tag for the src parameter:<br />
<br />
<img src="barcodeimage.php?code=CODE39EXTENDED&text=<?php echo rawurlencode($myText); ?>&showtext=1&backcolor=yellow&forecolor=blue&width=380"/><br />
<br />
This Barcode was created with the following html-img tag:<br />
<br />
<b>
&lt;img src="barcodeimage.php?code=CODE39EXTENDED&text=<?php echo rawurlencode($myText); ?>&showtext=1&backcolor=yellow&forecolor=blue&width=380" /&gt
</b>
</body>
</html>