<?php require_once(dirname(__FILE__).'/db.php') ?>
<html>
<head>
<title>SuttaCentral.net [Online Sutta Correspondence Project]</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="sc.css" />
<script type="text/javascript" src="tooltip.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
var count=0;
function toggleLayer(whichLayer)
{
if (document.getElementById)
{
// this is the way the standards work
var style2 = document.getElementById(whichLayer).style;
//style2.display = style2.display? "":"block";
}
else if (document.all)
{
// this is the way old msie versions work
var style2 = document.all[whichLayer].style;
//style2.display = style2.display? "":"block";
}
else if (document.layers)
{
// this is the way nn4 works
var style2 = document.layers[whichLayer].style;
//style2.display = style2.display? "":"block";
}

var buttonid = "button"+whichLayer;

if(style2.display=="")
{  style2.display="block";
   document[buttonid].src = "sc-1.gif";
}
else
{  style2.display="";
   document[buttonid].src = "sc-0.gif";
}

}
//  End -->
</script>
</head>

<body>
  <?php include("header.htm"); ?>
  <br />
  <center>
  <table cellspacing="0" border="1" width="80%">
    <?php
    $table1 = 'collection';
    $table2 = 'division';
    $table3 = 'subdivision';
    $table4 = 'vagga';
    $table5 = 'sutta';
    $table6 = 'groups';
    $table7 = 'correspondence';
    $table8 = 'reference';
    $table9 = 'groupinfo';
    $table10 = 'biblio_entry';
    $pluscount = 0;
    $abstractcount = 0;
    $division_id = $_GET['division_id'];
    $subdivision_id=$_GET['subdivision_id'];
    $collection_name = $_GET['collection_name'];
    $division_name = $_GET['division_name'];
    $subdivision_name = $_GET['subdivision_name'];
    $division = $_GET['division'];
    $acronym = $_GET['acronym'];
    $type = $_GET['type'];
    $division_acronym = $_GET['division_acronym'];
    $acronym_alt = 0;
    $volpage_alt = 0;
    echo "<tr><td colspan='5'>Collection - ".$collection_name;
    if($type=='Subdivision')
    {  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Division - ";
       $result = mysql_result(mysql_query("SELECT division_name FROM $table2 WHERE division_acronym='$division'"),0);
       echo $result;
    }
    echo "<br>".$type." - ";
    $division_name=str_replace('\\','',$division_name);
    $subdivision_name=str_replace('\\','',$subdivision_name);
    if($type=='Division') echo $division_name;
      else echo $subdivision_name;
    if($type=='Division') $acronym=$division_acronym;
      else $acronym=$division.' '.$acronym;
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Abbreviation - ".$acronym."</td></tr>";
    echo "<tr><td bgcolor='#DBDBDB'>Number</td><td bgcolor='#DBDBDB'>Sutta Name</td><td bgcolor='#DBDBDB'>Vol/Page</td><td bgcolor='#DBDBDB'>Correspondences</td><td bgcolor='#DBDBDB'>Translations</td></tr>";
    if($division_id)
    {  $subdiv_retreive=mysql_query("SELECT subdivision_id FROM $table3 WHERE division_id='$division_id'");
       $firstrow=mysql_fetch_assoc($subdiv_retreive);
       $subdivision_id=$firstrow[subdivision_id];
    }
    $result = mysql_query("SELECT sutta_acronym, alt_sutta_acronym, alt_volpage_info, sutta_name, sutta_number, volpage_info, sutta_text_url_link, sutta_id, biblio_entry_id FROM $table5 WHERE subdivision_id='$subdivision_id' ORDER BY sutta_number");
    while($row = mysql_fetch_assoc($result))
    {  $sutta_name=$row[sutta_name];
       if($row['sutta_text_url_link']) echo '<tr><td valign="top"><a href="'.$row['sutta_text_url_link'].'">'.$row[sutta_acronym].'</a>';
         else echo '<tr><td valign="top">'.$row[sutta_acronym];
       if($row['alt_sutta_acronym'])
       {  echo ' ['.$row['alt_sutta_acronym'].']</td>';
          $acronym_alt = 1;
       }
         else echo '</td>';
       echo '<td valign="top">' . $row['sutta_name'] . '&nbsp;</td>';
       echo '<td>';
       if($row[biblio_entry_id])
       {  $result2 = mysql_result(mysql_query("SELECT biblio_entry_text from $table10 WHERE biblio_entry_id='$row[biblio_entry_id]'"),0);
          //added 080706
          echo '<a href="javascript:toggleLayer(\'';
          $pluscount++;
          echo $pluscount.'\');" title="Toggle bibliographic information"><img style="position:relative; bottom:-2px" name="button'.$pluscount.'" src="sc-0.gif" border="0" /></a>';
          echo ' '.$row[volpage_info];
          //added 090530
          if($row['alt_volpage_info'])
          {  echo ' &lt;'.$row['alt_volpage_info'].'&gt;';
             $volpage_alt = 1;
          }
          //end
          echo '<div class="plus" id="'.$pluscount.'">'.$result2.'</div></td>';
          //end;
       }
       else
       {  echo $row[volpage_info];
          //added 090530
          if($row['alt_volpage_info'])
          {  echo ' &lt;'.$row['alt_volpage_info'].'&gt;</td>';
             $volpage_alt = 1;
          }
            else echo '&nbsp;</td>';
          //end
       }
       $showlink_fwd = mysql_num_rows(mysql_query("SELECT corresp_entry_id FROM $table7 WHERE entry_id='$row[sutta_id]'"));
       $showlink_rev = mysql_num_rows(mysql_query("SELECT entry_id FROM $table7 WHERE corresp_entry_id='$row[sutta_id]'"));
       if($showlink_fwd||$showlink_rev) echo '<td valign="top"><a href="disp_correspondence.php?division_acronym='.$acronym.'&sutta_number='.$row[sutta_number].'&sutta_coded_name='.$sutta_name.'&volpage_info='.$row[volpage_info].'&sutta_id='.$row[sutta_id].'"><img src="aet.png" border="0" /></a>&nbsp;</td>';
         else echo '<td valign="top">&nbsp;</td>';
       $translations = mysql_query("SELECT reference_language_id, reference_seq_nbr, reference_url_link, abstract_text FROM $table8 WHERE sutta_id='$row[sutta_id]' AND reference_type_id='1' ORDER BY reference_language_id, reference_seq_nbr");
       $translations_num = mysql_num_rows($translations);
       if($translations_num) //echo '<td valign="top">'.$translations_num.' translation</td>';
         {  echo '<td valign="top">';
            while($row = mysql_fetch_assoc($translations))
            {  echo '<a href="'.$row[reference_url_link].'"';
               if($row[abstract_text])
               {  $abstractcount++;
                  echo ' onmouseout="popUp(event,\'abstract'.$abstractcount.'\')" onmouseover="popUp(event,\'abstract'.$abstractcount.'\')"';
               }
               echo '><img src="flag'.$row[reference_language_id].'.svg.png" border="0" /></a>&nbsp;';
               if($row[abstract_text]) echo '<div id="abstract'.$abstractcount.'" class="info">'.$row[abstract_text].'</div>';
            }
            echo '</td>';
         }
         else echo '<td valign="top">&nbsp;</td>';
       echo '</tr>';
    }
    ?>
  </table>
  <?php if($acronym_alt) echo '[...] indicates alternative PTS or Taisho numbering.<br/>';
        if($volpage_alt) echo '<...> refers to PTS 1998 (Somaratne) edition of SN Vol I.';
  ?>
  </center>
<p>

</body>
</html>
