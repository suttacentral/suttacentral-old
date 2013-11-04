<?php require_once(dirname(__FILE__).'/db.php') ?>
<html>
<head>
<title>SuttaCentral.net [Online Sutta Correspondence Project]</title>
</head>

<body>
  <center>
    <?php
    if($submit) {
       $table1 = 'collection';
       $table2 = 'division';
       $table3 = 'subdivision';
       $table4 = 'vagga';
       $table5 = 'sutta';
       $table6 = 'groups';
       $table7 = 'concordance';
       $table8 = 'reference';
       $table9 = 'groupinfo';
       echo '<b>Updating in progress... DO NOT PRESS THE STOP BUTTON!</b>';
       if($count>0)
       {  echo '<p>'.$count.' items in process...</p>';
          $total=0;
          for($step=0; $step<$count; $step++)
          {  $subdivision_id = $step+1;
             if($item[$step]=='') echo '<p>skip item #'.$subdivision_id.'</p>';
             else
             {  echo '<p>update item #'.$subdivision_id.': '.$item[$step].'</p>';
                $new_subdivision_name = $item[$step];
                $result = mysql_query("UPDATE `$table3` SET `subdivision_name`='$new_subdivision_name' WHERE `subdivision_id`=$subdivision_id");
                $total = $total + mysql_affected_rows();
             }
          }
          echo '<p /><p><b>'.$total.' rows updated.</p>';
//          echo 'count:'.$item[$count];
//          echo 'count-1:'.$item[$count-1];
       }
    }
    ?>
  <p>CLICK HERE TO CHECK RESULTS >>> <a href="http://www.suttacentral.net/update_subdivision.php">http://www.suttacentral.net/update_subdivision.php</a>
  </center>
</body>
</html>
