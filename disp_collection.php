<?php require_once(dirname(__FILE__).'/db.php') ?>
<html>
<head>
<title>SuttaCentral.net [Online Sutta Correspondence Project]</title>
</head>

<body>
  <center>
  <table cellspacing="0" border="1">
    <tr>
      <td bgcolor="#BDBDBD">Collection</td>
    </tr>
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
    $result = mysql_query("SELECT collection_name, collection_id FROM $table1 ORDER BY collection_id");
    while($row = mysql_fetch_assoc($result))
    {  echo '<tr>';
       echo '<td><a href="disp_division.php?collection_id='.$row[collection_id].'&collection_name='.$row[collection_name].'">' . $row['collection_name'] . '</a></td>';
       echo '</tr>';
    }
    ?>
  </table>
  </center>
<p>

</body>
</html>
