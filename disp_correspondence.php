<?php require_once(dirname(__FILE__).'/db.php') ?>
<html>
<head>
<title>SuttaCentral.net [Online Sutta Correspondence Project]</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="tooltip.js"></script>
<link rel="stylesheet" type="text/css" href="sc.css" />
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
    $table9 = 'sutta_group';
    $table10 = 'collection_language';
    $table11 = 'biblio_entry';
    $table12 = 'sutta_group_member';
    $pluscount = 0;
    $infocount = 0;
    $acronym_alt = 0;
    $volpage_alt = 0;
    $division_acronym = $_GET['division_acronym'];
    $sutta_number = $_GET['sutta_number'];
    $sutta_coded_name = $_GET['sutta_coded_name'];
    $volpage_info = $_GET['volpage_info'];
    $sutta_id = $_GET['sutta_id'];

    $sutta_coded_name=str_replace('\\','',$sutta_coded_name);
    $someguide=FALSE;
    $showmore=TRUE;
    $retrieve_sutta_acronym=mysql_query("SELECT sutta_acronym, sutta_name, sutta_text_url_link, alt_sutta_acronym, alt_volpage_info FROM $table5 WHERE sutta_id='$sutta_id'");
    $retrieve_info=mysql_fetch_assoc($retrieve_sutta_acronym);
    echo "<tr><td colspan='4'>Correspondences for:<br>";
    if($retrieve_info['sutta_text_url_link']) echo "<a href='".$retrieve_info['sutta_text_url_link']."'>";
    echo $retrieve_info['sutta_acronym']."</a>";
    if($retrieve_info['alt_sutta_acronym'])
    {  echo " [".$retrieve_info['alt_sutta_acronym']."] ";
       $acronym_alt = 1;
    }
    echo " - ".$retrieve_info['sutta_name']." - ".$volpage_info;
    if($retrieve_info['alt_volpage_info'])
    {  echo " &lt;".$retrieve_info['alt_volpage_info']."&gt;";
       $volpage_alt = 1;
    }
    echo "<tr><td bgcolor='#DBDBDB'>Language</td><td bgcolor='#DBDBDB'>Abbreviation</td><td bgcolor='#DBDBDB'>Sutta Name</td><td bgcolor='#DBDBDB'>Vol/Page</td></tr>";
//************************************************************************************************************
    $correspondence = array();
    $result = mysql_query("SELECT corresp_entry_id, corresp_type_code, partial_corresp_ind, footnote_text FROM $table7 WHERE entry_id='$sutta_id'");
    while($row = mysql_fetch_assoc($result))
    {  $correspondence[]=array('sutta_id'=>$row['corresp_entry_id'],'type'=>$row['corresp_type_code'],'partial'=>$row['partial_corresp_ind'],'footnote'=>$row['footnote_text']);
    }
    $result = mysql_query("SELECT entry_id, partial_corresp_ind, footnote_text FROM $table7 WHERE corresp_entry_id='$sutta_id'");
    while($row = mysql_fetch_assoc($result))
    {  $correspondence[]=array('sutta_id'=>$row['entry_id'],'partial'=>$row['partial_corresp_ind'],'footnote'=>$row['footnote_text']);
       if($row['partial_corresp_ind']=='N')
       {  $result2 = mysql_query("SELECT corresp_entry_id, partial_corresp_ind, footnote_text FROM $table7 WHERE entry_id='$row[entry_id]'");
          while($row2 = mysql_fetch_assoc($result2))
          {  if(($row2['partial_corresp_ind']=='N')&&($row2['corresp_entry_id']!=$sutta_id))
               $correspondence[]=array('sutta_id'=>$row2['corresp_entry_id'],'partial'=>$row2['partial_corresp_ind'],'footnote'=>$row2['footnote_text']);
          }
       }
    }
    foreach($correspondence as &$record)
    {  //$result2 = mysql_query("SELECT subdivision_id, sutta_id, sutta_acronym, sutta_number, sutta_coded_name, sutta_text_url_link, volpage_info, collection_language_name, biblio_entry_id from $table5, $table10 WHERE $table5.sutta_id='$row[entry_id]' AND $table5.collection_language_id=$table10.collection_language_id");
       if($record[type]=='SG')
       {  $result1 = mysql_query("SELECT sutta_group_acronym, sutta_group_name FROM $table9 WHERE sutta_group_id='$record[sutta_id]'");
          $info1 = mysql_fetch_assoc($result1);
          $record['name']=$info1['sutta_group_name'];
          $record['acronym']=$info1['sutta_group_acronym'];
          $result2 = mysql_query("SELECT sutta_id FROM $table12 WHERE sutta_group_id='$record[sutta_id]'");
          $info2 = mysql_fetch_assoc($result2);
          $result3 = mysql_query("SELECT sutta_number, subdivision_id, sutta_text_url_link, volpage_info, collection_language_name FROM $table5, $table10 WHERE $table5.sutta_id='$info2[sutta_id]' AND $table5.collection_language_id=$table10.collection_language_id");
          $info3 = mysql_fetch_assoc($result3);
          $record['url_link']=$info3['sutta_text_url_link'];
          $record['language']=$info3['collection_language_name'];
          $record['volpage_info']=$info3['volpage_info'];
          $record['subdiv_id']=$info3['subdivision_id'];
          $record['number']=$info3[sutta_number];
          $record['type']=2;
       }
       else
       {  $result1 = mysql_query("SELECT subdivision_id, sutta_id, sutta_acronym, alt_volpage_info, alt_sutta_acronym, sutta_number, sutta_name, sutta_text_url_link, volpage_info, collection_language_name, biblio_entry_id from $table5, $table10 WHERE $table5.sutta_id='$record[sutta_id]' AND $table5.collection_language_id=$table10.collection_language_id");
          $info1 = mysql_fetch_assoc($result1);
          $record['acronym']=$info1['sutta_acronym'];
          $record['alt_acronym']=$info1['alt_sutta_acronym'];
          $record['alt_volpage']=$info1['alt_volpage_info'];
          $record['url_link']=$info1['sutta_text_url_link'];
          $record['name']=$info1['sutta_name'];
          $record['language']=$info1['collection_language_name'];
          $record['volpage_info']=$info1['volpage_info'];
          $record['biblio_entry_id']=$info1['biblio_entry_id'];
          $record['subdiv_id']=$info1['subdivision_id'];
          $record['number']=$info1['sutta_number'];
          $record['type']=1;
       }

    }

//    echo "<br>before sort<br><br>";

//    foreach($correspondence as &$record)
//   {  echo $record['acronym'].' - ';
//       echo $record['name'].' - ';
//       echo $record['language'].' - ';
//       echo $record['volpage_info'];
//       echo "<br>";

//    }

    foreach($correspondence as $key => $row)
    {  $language[$key]=$row['language'];
       $partial[$key]=$row['partial'];

       //modified 270408
       //$suttaid[$key]=$row['sutta_id'];
       $subdiv[$key]=$row['subdiv_id'];
       $number[$key]=$row['number'];
       $type[$key]=$row['type'];
    }
    array_multisort($language, SORT_ASC, $partial, SORT_ASC, $subdiv, SORT_ASC, $number, SORT_ASC, $type, SORT_ASC, $correspondence);

//    echo "<br>after sort<br><br>";

    foreach($correspondence as &$record)
    {  
       echo '<tr><td valign="top">'.$record['language'].'&nbsp;</td><td valign="top">';
       if($record['url_link']<>NULL)
         echo '<a href="'.$record['url_link'].'">'.$record[acronym].'</a>&nbsp;';
       else
         echo $record[acronym].'&nbsp;';
       if($record['alt_acronym'])
       {  echo '['.$record['alt_acronym'].']&nbsp;';
          $acronym_alt = 1;
       }
       if($record[partial]=='Y')
       {  echo '*';
          $someguide=TRUE;
       }
       echo '</td><td valign="top">'.$record['name'].'&nbsp;</td><td valign="top">';

       if($record[biblio_entry_id])
       {  $result5 = mysql_result(mysql_query("SELECT biblio_entry_text from $table11 WHERE biblio_entry_id='$record[biblio_entry_id]'"),0);

          echo '<a href="javascript:toggleLayer(\'';
          $pluscount++;
          echo $pluscount.'\');" title="Toggle bibliographic information"><img style="position:relative; bottom:-2px" name="button'.$pluscount.'" src="sc-0.gif" border="0" /></a>';
          echo ' '.$record[volpage_info];
          //added 090530
          if($record['alt_volpage_info'])
          {  echo ' &lt;'.$record['alt_volpage_info'].'&gt;';
             $volpage_alt = 1;
          }
          //end
	}
	else
        {  echo $record[volpage_info];
           //added 090530
           if($record['alt_volpage'])
           {  echo ' &lt;'.$record['alt_volpage'].'&gt;';
              $volpage_alt = 1;
           }
           else echo '&nbsp;';
           //end
        }
	if($record[footnote])
	{  $infocount++;
           echo ' <a href="#" onmouseout="popUp(event,\'info'.$infocount.'\')" onmouseover="popUp(event,\'info'.$infocount.'\')"  onclick="return false"><img style="position:relative; bottom:-2px" src="sc-i.gif" border="0" /></a>';
           echo '<div id="info'.$infocount.'" class="info">[Footnote]<br>'.$record[footnote].'</div>';
           // echo ' [<b><span class="sc" title="'.$record[footnote].'"> i </span></b>]';
        }
       if($record[biblio_entry_id]) echo '<div class="plus" id="'.$pluscount.'">'.$result5.'</div>';
	   echo '</td></tr>';

    }



  ?>




  </table>
  <?php if($someguide) echo '* Partial parallel.<br/>';
        if($acronym_alt) echo '[...] indicates alternative PTS or Taisho numbering.<br/>';
        if($volpage_alt) echo '<...> refers to PTS 1998 (Somaratne) edition of SN Vol I.';
  ?>
  </center>


</body>
</html>
