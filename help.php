<html>
<head>
<title>SuttaCentral: Online Sutta Correspondence Project</title>

</head>
<body>
<?php include("header.htm"); ?>
<div style="margin-left:3%; margin-right:3%;">
<?php
  $t = $_GET['t'];
  switch($t)
  {  case 'diacritics': include ("diacritics.sc");
                        break;
     case 'velthuis': include ("velthuis.sc");
                      break;
     case 'abbreviations': include ("abbreviations.sc");
                           break;
     case 'sanskrit': include ("sanskrit.sc");
                      break;
     case 'chinese': include ("chinese.sc");
                      break;
     case 'parallel': include ("parallel.sc");
                      break;
     case 'bibliography': include ("bibliography.sc");
                          break;
     default: include("main.sc");
  }
?>
</div>
</body>
</html>