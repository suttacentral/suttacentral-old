<?php require_once(dirname(__FILE__).'/db.php') ?>
<html>
<head>
<title>SuttaCentral.net [Online Sutta Correspondence Project]</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>

<body>
  <?php include("header.htm"); ?>
  <br />
  <center>
  <table cellspacing="0" border="1">
    <tr>
      <td bgcolor="#BDBDBD">Collection -
    <?php
    $table1 = 'collection';
    $table2 = 'division';
    $table3 = 'subdivision';
    $table4 = 'vagga';
    $table5 = 'sutta';
    $table6 = 'groups';
    $table7 = 'concordance';
    $table8 = 'reference';
    $table9 = 'groupinfo';
    $collection_name = $_GET['collection_name'];
    $collection_id = $_GET['collection_id'];
    echo $collection_name."</td><td bgcolor='#BDBDBD'>Abbreviation</td></tr>";
    $result = mysql_query("SELECT division_name, division_id, division_acronym, subdiv_ind FROM $table2 WHERE collection_id='$collection_id' ORDER BY division_id");
    while($row = mysql_fetch_assoc($result))
    {  echo '<tr>';
       echo "<td><a href='disp_";
       if($row['subdiv_ind']=='Y') echo "subdivision";
         else echo "sutta";
       $division_name=htmlspecialchars($row[division_coded_name]);
       echo ".php?division_id=".$row[division_id]."&collection_name=".$collection_name."&division_name=".$row[division_name]."&type=Division&division_acronym=".$row['division_acronym']."'>" . $row['division_name'] . "</a></td>";
       echo "<td>" . $row['division_acronym'] . "</td></tr>";
    }
    ?>
  </table>
  <?php
  if($collection_id==1)
  {  echo '<p><img src="acrobat.jpg" /> <a href="Digha-View.pdf">DN</a> | <a href="Majjhima-View.pdf">MN</a> | <a href="Samyutta-View.pdf">SN</a> | <a href="Anguttara-View.pdf">AN</a></p>';
     echo '<p><a href="http://www.adobe.com/products/acrobat/readstep2.html"><img src="http://www.adobe.com/images/shared/download_buttons/get_adobe_reader.gif" border="0" /></a></p>';
  }
  ?>
  </center>
<p>

</body>
</html>
