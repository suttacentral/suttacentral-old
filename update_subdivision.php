<?php require_once(dirname(__FILE__).'/db.php') ?>
<html>
<head>
<title>SuttaCentral.net [Online Sutta Correspondence Project]</title>
</head>

<body>
  <center>
  <form method="POST" action="renew_subdivision.php">
  <table cellspacing="0" border="1">
    <tr>
      <td bgcolor="#BDBDBD">ID</td><td bgcolor="#BDBDBD">Coded Name</td><td bgcolor="#BDBDBD">Name</td><td bgcolor="#BDBDBD">Enter new name or leave blank</td>
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
    $result = mysql_query("SELECT subdivision_id, subdivision_name, subdivision_coded_name FROM $table3 ORDER BY subdivision_id");
    while($row = mysql_fetch_assoc($result))
    {  echo '<tr>';
       echo '<td>'.$row[subdivision_id].'</td><td>'.$row[subdivision_coded_name].'</td><td>'.$row[subdivision_name].'</td><td><input type="text" name="item[]" size="35"></td>';
       echo '</tr>';
    }
    $count = mysql_num_rows($result);
    ?>
  </table>
  <input type="submit" value="Submit" name="submit"> &nbsp; <input type="reset" value="Reset" name="reset">
  <input type="hidden" value="<?php echo $count; ?>" name="count">
  </form>
  </center>
<p>

</body>
</html>
