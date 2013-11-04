<?php require_once(dirname(__FILE__).'/db.php') ?>
<html>
<head>
  <title>wizard-070520</title>
</head>
<body>
  <?php

    include("header-07.sc");
    $page=$_GET['page'];
    if($page=="correspondence")
      echo 'Correspondences for:<br />';









    $table1 = 'collection';
    $table2 = 'division';
    $table3 = 'subdivision';
    $table4 = 'vagga';
    $table5 = 'sutta';
    $table6 = 'groups';
    $table7 = 'correspondence';
    $table8 = 'reference';
    $table9 = 'groupinfo';
    $table10 = 'collection_language';
    $table11 = 'biblio_entry';
    $pluscount = 0;
    $infocount = 0;
    $division_acronym = $_GET['division_acronym'];
    $sutta_number = $_GET['sutta_number'];
    $sutta_coded_name = $_GET['sutta_coded_name'];
    $volpage_info = $_GET['volpage_info'];
    $sutta_id = $_GET['sutta_id'];
    echo "SUTTA ID: ".$sutta_id."<br>";
    $correspondence = array();
    $result = mysql_query("SELECT corresp_entry_id, partial_corresp_ind, footnote_text FROM $table7 WHERE entry_id='$sutta_id'");
    while($row = mysql_fetch_assoc($result))
    {  $correspondence[]=array('sutta_id'=>$row['corresp_entry_id'],'partial'=>$row['partial_corresp_ind'],'footnote'=>$row['footnote_text']);
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
       $result1 = mysql_query("SELECT subdivision_id, sutta_id, sutta_acronym, sutta_number, sutta_coded_name, sutta_text_url_link, volpage_info, collection_language_name, biblio_entry_id from $table5, $table10 WHERE $table5.sutta_id='$record[sutta_id]' AND $table5.collection_language_id=$table10.collection_language_id");
       //$row2 = mysql_fetch_assoc($result2);
       $info1 = mysql_fetch_assoc($result1);

       //$result3 = mysql_query("SELECT division_id, subdivision_acronym from $table3 WHERE subdivision_id='$row2[subdivision_id]'");
       ///$result2 = mysql_query("SELECT division_id, subdivision_acronym from $table3 WHERE subdivision_id='$info1[subdivision_id]'");
       //$row3 = mysql_fetch_assoc($result3);
       ///$info2 = mysql_fetch_assoc($result2);

       //$result4 = mysql_query("SELECT division_acronym from $table2 WHERE division_id='$row3[division_id]'");
       ///$result3 = mysql_query("SELECT division_acronym from $table2 WHERE division_id='$info2[division_id]'");
       //$row4 = mysql_fetch_assoc($result4);
       ///$info3 = mysql_fetch_assoc($result3);

       $record['acronym']=$info1['sutta_acronym'];
       $record['url_link']=$info1['sutta_text_url_link'];
       $record['name']=$info1['sutta_coded_name'];
       $record['language']=$info1['collection_language_name'];
       $record['volpage_info']=$info1['volpage_info'];
    }

    echo "<br>before sort<br><br>";

    foreach($correspondence as &$record)
    {  echo $record['acronym'].' - ';
       echo $record['name'].' - ';
       echo $record['language'].' - ';
       echo $record['volpage_info'];
       echo "<br>";

    }

    foreach($correspondence as $key => $row)
    {  $language[$key]=$row['language'];
       $partial[$key]=$row['partial'];
       $suttaid[$key]=$row['sutta_id'];
    }
    array_multisort($language, SORT_ASC, $partial, SORT_ASC, $suttaid, SORT_ASC, $correspondence);

    echo "<br>after sort<br><br>";

    foreach($correspondence as &$record)
    {  echo $record['acronym'].' - ';
       echo $record['name'].' - ';
       echo $record['language'].' - ';
       echo $record['volpage_info'];
       echo "<br>";

    }
  ?>
</body>
</html>