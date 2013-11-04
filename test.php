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
          $result=mysql_query("SELECT * FROM $table5");
//    $result = mysql_query("SELECT entry_id, partial_corresp_ind, footnote_text FROM $table7");
//           echo mysql
          $number=mysql_num_rows($result);
    echo $number;

?>