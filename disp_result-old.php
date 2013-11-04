<?php require_once(dirname(__FILE__).'/db.php') ?>
<html>
<head>
<title>SuttaCentral.net [Online Sutta Correspondence Project]</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="sc.css" />
<script type="text/javascript" src="tooltip.js"></script>
</head>

<body>
  <?php include("header.htm"); ?>
  <br />
  <center>
  <table cellspacing="0" border="1">
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
    $abstractcount = 0;
    $acronym_alt = 0;
    $item = $_GET['item'];
    if(!$item) $item = $_POST['item'];
    $field = $_GET['field'];
    if(!$field) $field = $_POST['field'];
    function search_display($search_result)
    {  $table = 'correspondence';
       $table8 = 'reference';
       global $acronym_alt;
       while($row = mysql_fetch_assoc($search_result))
       {  if($row[sutta_text_url_link]) echo '<tr><td><a href="'.$row[sutta_text_url_link].'">'.$acronym.$row[sutta_acronym].'</a>';
            else echo '<tr><td>'.$acronym.$row[sutta_acronym];
          if($row[alt_sutta_acronym])
          {  echo ' ['.$row[alt_sutta_acronym].']';
             $acronym_alt = 1;
          }
          echo '</td>';
          echo '<td>' . $row['sutta_name'] . '&nbsp;</td>';
          echo '<td>'.$row[volpage_info].'&nbsp;</td>';
          $rowcheckquery=mysql_query("SELECT * FROM $table WHERE entry_id='$row[sutta_id]' OR corresp_entry_id='$row[sutta_id]'");
          $rowcheck=mysql_num_rows($rowcheckquery);
          echo '<td valign="top">';
          if($rowcheck>0) echo '<a href="disp_correspondence.php?division_acronym='.$acronym.'&sutta_number='.$row[sutta_number].'&sutta_coded_name='.$row[sutta_name].'&volpage_info='.$row[volpage_info].'&sutta_id='.$row[sutta_id].'"><img src="aet.png" border="0" /></a>&nbsp;</td>';
            else echo '&nbsp;</td>';
          //added 220608
          $translations = mysql_query("SELECT reference_language_id, reference_seq_nbr, reference_url_link, abstract_text FROM $table8 WHERE sutta_id='$row[sutta_id]' AND reference_type_id='1' ORDER BY reference_language_id, reference_seq_nbr");
          $translations_num = mysql_num_rows($translations);
          echo '<td valign="top">';
          if($translations_num) //echo $translations_num;
          {  while($trow = mysql_fetch_assoc($translations))
             {  //added 281008
                echo '<a href="'.$trow[reference_url_link].'"';
                if($trow[abstract_text])
                {  $abstractcount++;
                   echo ' onmouseout="popUp(event,\'abstract'.$abstractcount.'\')" onmouseover="popUp(event,\'abstract'.$abstractcount.'\')"';
                }
                echo '><img src="flag'.$trow[reference_language_id].'.svg.png" border="0" /></a>&nbsp;';
                if($trow[abstract_text]) echo '<div id="abstract'.$abstractcount.'" class="info">'.$trow[abstract_text].'</div>';
             }
          }
            else echo '&nbsp;';
          echo '</td></tr>';
          //end
       }
    }
    function search_add($search_result)
    {  global $search_name;
       while($row = mysql_fetch_assoc($search_result))
       {  array_push($search_name, $row);
//          $sutta_name=htmlspecialchars($row[sutta_coded_name]);
//          echo '<tr><td><a href="disp_correspondence.php?division_acronym='.$acronym.'&sutta_number='.$row[sutta_number].'&sutta_coded_name='.$sutta_name.'&volpage_info='.$row[volpage_info].'&sutta_id='.$row[sutta_id].'">'.$acronym.$row[sutta_acronym].'</a></td>';
//          echo '<td>' . $row['sutta_coded_name'] . '&nbsp;</td>';
//          echo '<td>'.$row[volpage_info].'&nbsp;</td></tr>';
       }
       sort($search_name);
    }
    function array_display($row)
    {  $table = 'correspondence';
       $table8 = 'reference';
       global $acronym_alt;

       //added 280408
       foreach($row as $key => $entry)
       {  $subdiv[$key]=$entry['subdivision_id'];
          $number[$key]=$entry['sutta_number'];
       }
       array_multisort($subdiv, SORT_ASC, $number, SORT_ASC, $row);
       //end

       for($j=0;$j<count($row);$j++)
       {  if($j==0) $num=$row[$j][sutta_number];
          if($j==0||$num<>$row[$j][sutta_number])
          {  $num=$row[$j][sutta_number];
             $id=$row[$j][sutta_id];
             echo '<tr><td>';
             if($row[$j][sutta_text_url_link]) echo '<a href="'.$row[$j][sutta_text_url_link].'">'.$acronym.$row[$j][sutta_acronym].'</a>';
               else echo $acronym.$row[$j][sutta_acronym];
             if($acronym.$row[$j][alt_sutta_acronym])
             {  echo ' ['.$acronym.$row[$j][alt_sutta_acronym].']';
                $acronym_alt = 1;
             }
             echo '</td>';
             echo '<td>' . $row[$j]['sutta_name'] . '&nbsp;</td>';
             echo '<td>'.$row[$j][volpage_info].'&nbsp;</td>';
             $rowcheckquery=mysql_query("SELECT * FROM $table WHERE entry_id='$id' OR corresp_entry_id='$id'");
             $rowcheck=mysql_num_rows($rowcheckquery);
             echo '<td valign="top">';
             if($rowcheck>0) echo '<a href="disp_correspondence.php?division_acronym='.$acronym.'&sutta_number='.$row[$j][sutta_number].'&sutta_coded_name='.$sutta_name.'&volpage_info='.$row[$j][volpage_info].'&sutta_id='.$row[$j][sutta_id].'"><img src="aet.png" border="0" /></a>&nbsp;</td>';
               else echo '&nbsp;</td>';
             //added 220608
             $translations = mysql_query("SELECT reference_language_id, reference_seq_nbr, reference_url_link, abstract_text FROM $table8 WHERE sutta_id='$id' AND reference_type_id='1' ORDER BY reference_language_id, reference_seq_nbr");
             $translations_num = mysql_num_rows($translations);
             echo '<td valign="top">';
             if($translations_num) //echo $translations_num;
             {  while($trow = mysql_fetch_assoc($translations))
                {  //added 281008
                   echo '<a href="'.$trow[reference_url_link].'"';
                   if($trow[abstract_text])
                   {  $abstractcount++;
                      echo ' onmouseout="popUp(event,\'abstract'.$abstractcount.'\')" onmouseover="popUp(event,\'abstract'.$abstractcount.'\')"';
                   }
                   echo '><img src="flag'.$trow[reference_language_id].'.svg.png" border="0" /></a>&nbsp;';
                   if($trow[abstract_text]) echo '<div id="abstract'.$abstractcount.'" class="info">'.$trow[abstract_text].'</div>';
                }
             }
               else echo '&nbsp;';
             echo '</td></tr>';
             //end
          }
       }
    }
    function array_sort()
    {
    }
    function fuzzy_display($search_result,$item)
    {  $table = 'correspondence';
       $table8 = 'reference';
       global $acronym_alt;
       $item_array=explode(' ',$item);
       array_pop($item_array);
       $rp_string=implode(' ',$item_array);
       $rp_string=$rp_string.' ';
       //echo $rp_string.'.....';
       $cp_string=str_replace($rp_string,'',$item);
       //echo $cp_string.'.....';
       while($row = mysql_fetch_assoc($search_result))
       {  //$results_index[]=$row[sutta_acronym];
          $results_index[]=str_replace($rp_string,'',$row[volpage_info]);
          $results[]=$row;
       }
       array_multisort($results_index,SORT_DESC,$results);
       $results_num=count($results);
       if(is_numeric($cp_string))
       {  $found=false;
          $count=0;
          while($found==false&&$count<$results_num)
          {  if($results_index[$count]<$cp_string)
             {  //echo 'loop....'; //$sutta_name=htmlspecialchars($results[$count][sutta_coded_name]);
                echo '<tr><td><a href="'.$results[$count][sutta_text_url_link].'">'.$acronym.$results[$count][sutta_acronym].'</a>';
                if($results[$count][alt_sutta_acronym]) echo '[]';
                echo '</td>';
                echo '<td>' . $results[$count]['sutta_name'] . '&nbsp;</td>';
                echo '<td>'.$results[$count][volpage_info].'</td>';

                $this_sutta_id = $results[$count][sutta_id];
                $rowcheckquery=mysql_query("SELECT * FROM $table WHERE entry_id='$this_sutta_id' OR corresp_entry_id='$this_sutta_id'");
                $rowcheck=mysql_num_rows($rowcheckquery);
                echo '<td valign="top">';
                if($rowcheck>0) echo '<a href="disp_correspondence.php?division_acronym='.$acronym.'&sutta_number='.$results[$count][sutta_number].'&sutta_coded_name='.$results[$count][sutta_name].'&volpage_info='.$results[$count][volpage_info].'&sutta_id='.$results[$count][sutta_id].'"><img src="aet.png" border="0" /></a>&nbsp;</td>';
                  else echo '&nbsp;</td>';

                //added 220608
                $translations = mysql_query("SELECT reference_language_id, reference_seq_nbr, reference_url_link, abstract_text FROM $table8 WHERE sutta_id='$this_sutta_id' AND reference_type_id='1' ORDER BY reference_language_id, reference_seq_nbr");
                $translations_num = mysql_num_rows($translations);
                echo '<td valign="top">';
                if($translations_num) //echo $translations_num;
                {  while($trow = mysql_fetch_assoc($translations))
                   {  //added 281008
                      echo '<a href="'.$trow[reference_url_link].'"';
                      if($trow[abstract_text])
                      {  $abstractcount++;
                         echo ' onmouseout="popUp(event,\'abstract'.$abstractcount.'\')" onmouseover="popUp(event,\'abstract'.$abstractcount.'\')"';
                      }
                      echo '><img src="flag'.$trow[reference_language_id].'.svg.png" border="0" /></a>&nbsp;';
                      if($trow[abstract_text]) echo '<div id="abstract'.$abstractcount.'" class="info">'.$trow[abstract_text].'</div>';
                   }
                }
                  else echo '&nbsp;';
                echo '</td></tr>';
                //end

                //echo '<td><a href="disp_correspondence.php?division_acronym='.$acronym.'&sutta_number='.$results[$count][sutta_number].'&sutta_coded_name='.$sutta_name.'&volpage_info='.$results[$count][volpage_info].'&sutta_id='.$results[$count][sutta_id].'">'.$acronym.$results[$count][sutta_acronym].'</a></td></tr>';
                $found=true;
             }
             $count++;
          }
       }
       else
       {  for($count=0;$count<$results_num;$count++)
          {  echo '<tr><td><a href="'.$results[$count][sutta_text_url_link].'">'.$acronym.$results[$count][sutta_acronym].'</a>';
             if($results[$count][alt_sutta_acronym])
             {  echo ' ['.$results[$count][alt_sutta_acronym].']';
                $acronym_alt = 1;
             }
             echo '</td>';
             //echo '<tr><td><a href="disp_correspondence.php?division_acronym='.$acronym.'&sutta_number='.$results[$count][sutta_number].'&sutta_coded_name='.$sutta_name.'&volpage_info='.$results[$count][volpage_info].'&sutta_id='.$results[$count][sutta_id].'">'.$acronym.$results[$count][sutta_acronym].'</a></td>';
             echo '<td>' . $results[$count]['sutta_name'] . '&nbsp;</td>';
             echo '<td>'.$results[$count][volpage_info].'</td>';

             $this_sutta_id = $results[$count][sutta_id];
             $rowcheckquery=mysql_query("SELECT * FROM $table WHERE entry_id='$this_sutta_id' OR corresp_entry_id='$this_sutta_id'");
             $rowcheck=mysql_num_rows($rowcheckquery);
             echo '<td valign="top">';
             if($rowcheck>0) echo '<a href="disp_correspondence.php?division_acronym='.$acronym.'&sutta_number='.$results[$count][sutta_number].'&sutta_coded_name='.$results[$count][sutta_name].'&volpage_info='.$results[$count][volpage_info].'&sutta_id='.$results[$count][sutta_id].'"><img src="aet.png" border="0" /></a>&nbsp;</td>';
               else echo '&nbsp;</td>';

             //added 220608
             $translations = mysql_query("SELECT reference_language_id, reference_seq_nbr, reference_url_link, abstract_text FROM $table8 WHERE sutta_id='$this_sutta_id' AND reference_type_id='1' ORDER BY reference_language_id, reference_seq_nbr");
             $translations_num = mysql_num_rows($translations);
             echo '<td valign="top">';
             if($translations_num) //echo $translations_num;
             {  while($trow = mysql_fetch_assoc($translations))
                {  //added 281008
                   echo '<a href="'.$trow[reference_url_link].'"';
                   if($trow[abstract_text])
                   {  $abstractcount++;
                      echo ' onmouseout="popUp(event,\'abstract'.$abstractcount.'\')" onmouseover="popUp(event,\'abstract'.$abstractcount.'\')"';
                   }
                   echo '><img src="flag'.$trow[reference_language_id].'.svg.png" border="0" /></a>&nbsp;';
                   if($trow[abstract_text]) echo '<div id="abstract'.$abstractcount.'" class="info">'.$trow[abstract_text].'</div>';
                }
             }
               else echo '&nbsp;';
             echo '</td></tr>';
             //end

          }
       }
    }
    error_reporting(0);
    echo "<tr><td colspan='5'>Search results for ".$item.$linkcheck."</tr>";
    if($item!=''&&$field=='name')
    {  $search_name=array();
       $item=ucfirst(strtolower($item));
       $search_unicodename=mysql_query("SELECT subdivision_id, sutta_id, sutta_number, sutta_acronym, alt_sutta_acronym, sutta_name, sutta_text_url_link, volpage_info FROM $table5 WHERE sutta_name='$item'");
       $search_unicodename_partial=mysql_query("SELECT subdivision_id, sutta_id, sutta_number, sutta_acronym, alt_sutta_acronym, sutta_name, sutta_text_url_link, volpage_info FROM $table5 WHERE sutta_name LIKE '%$item%'");
       $search_codedname=mysql_query("SELECT subdivision_id, sutta_id, sutta_number, sutta_acronym, alt_sutta_acronym, sutta_name, sutta_text_url_link, volpage_info FROM $table5 WHERE sutta_coded_name='$item'");
       $search_codedname_partial=mysql_query("SELECT subdivision_id, sutta_id, sutta_number, sutta_acronym, alt_sutta_acronym, sutta_name, sutta_text_url_link, volpage_info FROM $table5 WHERE sutta_coded_name LIKE '%$item%'");
       $search_plainname=mysql_query("SELECT subdivision_id, sutta_id, sutta_number, sutta_acronym, alt_sutta_acronym, sutta_name, sutta_text_url_link, volpage_info FROM $table5 WHERE sutta_plain_name='$item'");
       $search_plainname_partial=mysql_query("SELECT subdivision_id, sutta_id, sutta_number, sutta_acronym, alt_sutta_acronym, sutta_name, sutta_text_url_link, volpage_info FROM $table5 WHERE sutta_plain_name LIKE '%$item%'");
       if((mysql_num_rows($search_unicodename)==0)&&(mysql_num_rows($search_unicodename_partial)==0)&&(mysql_num_rows($search_codedname)==0)&&(mysql_num_rows($search_codedname_partial)==0)&&(mysql_num_rows($search_plainname)==0)&&(mysql_num_rows($search_plainname_partial)==0))
         echo "<tr><td colspan='5' bgcolor='#DBDBDB'>Empty string returned!</td></tr>";
       else
       {  echo "<tr><td bgcolor='#DBDBDB'>Abbreviation</td><td bgcolor='#DBDBDB'>Sutta Name</td><td bgcolor='#DBDBDB'>Vol/Page</td><td bgcolor='#DBDBDB'>Correspondences</td><td bgcolor='#DBDBDB'>Translations</td></tr>";
          if(mysql_num_rows($search_unicodename)!=0) search_add($search_unicodename);
          if(mysql_num_rows($search_unicodename_partial)!=0) search_add($search_unicodename_partial);
          if(mysql_num_rows($search_codedname)!=0) search_add($search_codedname);
          if(mysql_num_rows($search_codedname_partial)!=0) search_add($search_codedname_partial);
          if(mysql_num_rows($search_plainname)!=0) search_add($search_plainname);
          if(mysql_num_rows($search_plainname_partial)!=0) search_add($search_plainname_partial);
          array_display($search_name);
       }
    }
    elseif($item!=''&&$field=='acronym')
    {  $item=strtoupper($item);
       $search_acronym=mysql_query("SELECT sutta_id, sutta_number, sutta_acronym, alt_sutta_acronym, sutta_name, sutta_text_url_link, volpage_info FROM $table5 WHERE sutta_acronym='$item' OR alt_sutta_acronym='$item'");
       if(mysql_num_rows($search_acronym)==0) echo "<tr><td colspan='5' bgcolor='#DBDBDB'>Empty string returned!</td></tr>";
       else
       {  echo "<tr><td bgcolor='#DBDBDB'>Abbreviation</td><td bgcolor='#DBDBDB'>Sutta Name</td><td bgcolor='#DBDBDB'>Vol/Page</td><td bgcolor='#DBDBDB'>Correspondences</td><td bgcolor='#DBDBDB'>Translations</td></tr>";
          search_display($search_acronym);
       }
    }
    elseif($item!=''&&$field=='volpage')
    {  $item=strtoupper($item);
       $itemfuzzy=$item;
       $search_volpage=mysql_query("SELECT sutta_id, sutta_number, sutta_acronym, alt_sutta_acronym, sutta_name, sutta_text_url_link, volpage_info FROM $table5 WHERE volpage_info='$item'");
       $item_array=explode(' ',$item);
       array_pop($item_array);
       $item=implode(' ',$item_array);
       $item=$item.' %';
       $search_volpagefuzzy=mysql_query("SELECT sutta_id, sutta_number, sutta_acronym, alt_sutta_acronym, sutta_name, sutta_text_url_link, volpage_info FROM $table5 WHERE volpage_info LIKE '$item'");
       if(mysql_num_rows($search_volpage)==0&&mysql_num_rows($search_volpagefuzzy)==0) echo "<tr><td colspan='5' bgcolor='#DBDBDB'>Empty string returned!</td></tr>";
       else
       {  echo "<tr><td bgcolor='#DBDBDB'>Abbreviation</td><td bgcolor='#DBDBDB'>Sutta Name</td><td bgcolor='#DBDBDB'>Vol/Page</td><td bgcolor='#DBDBDB'>Correspondences</td><td bgcolor='#DBDBDB'>Translations</td></tr>";
          if(mysql_num_rows($search_volpage)!=0) search_display($search_volpage);
          elseif(mysql_num_rows($search_volpagefuzzy)!=0) fuzzy_display($search_volpagefuzzy,$itemfuzzy);
       }
    }
    else
    {  echo "Search string is either empty or unrecognised.";
	}
    ?>
  </table>
  <?php if($acronym_alt) echo '[...] indicates PTS numbering.';
  ?>
  </center>
<p>

</body>
</html>