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
    $division_id=$_GET['division_id'];
    $collection_name=$_GET['collection_name'];

//division_id=3&collection_name=Pali&division_name=&type=Division&division_acronym=SN

    $division_name=str_replace('\\','',$_GET['division_name']);
    $type=$_GET['type'];
    $division_acronym=$_GET['division_acronym'];
    echo '<td colspan="2">Collection - '.$collection_name.'<br>Division - '.$division_name.' - '.$division_acronym.'</td></tr>';
    echo '<tr><td bgcolor="#BDBDBD">Abbrev./Number</td><td bgcolor="#BDBDBD">Subdivision</td></tr>';
    $result = mysql_query("SELECT subdivision_name, subdivision_id, subdivision_acronym FROM $table3 WHERE division_id='$division_id' ORDER BY subdivision_id");
    while($row = mysql_fetch_assoc($result))
    {  $subdivision_name=htmlspecialchars($row[subdivision_name]);
       echo '<tr><td>'.$division_acronym.' '.$row['subdivision_acronym'].'</td>';
       echo '<td><a href="disp_sutta.php?subdivision_id='.$row[subdivision_id].'&subdivision_name='.$subdivision_name.'&collection_name='.$collection_name.'&division='.$division_acronym.'&acronym='.$row[subdivision_acronym].'&type=Subdivision">' . $row['subdivision_name'] . '</a></td>';
       echo '</tr>';
    }
    ?>
  </table>
  </center>
<p>

</body>
</html>
