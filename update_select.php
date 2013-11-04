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
    $result = mysql_query("SELECT subdivision_id, subdivision_name FROM $table3 ORDER BY subdivision_id");
    while($row = mysql_fetch_assoc($result))
    {  echo '<tr>';
       echo '<td>'.$row[subdivision_id].'</td><td>'.$row[subdivision_name].'</td>';
       echo '</tr>';
    }
    ?>
  </table>
  </center>
<p>

</body>
</html>
