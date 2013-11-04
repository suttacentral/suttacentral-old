<?php require_once(dirname(__FILE__).'/db.php') ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>SuttaCentral: Online Sutta Correspondence Project</title>
</head>
<body>
<?php include("header.htm");
      $table1 = 'collection';
      $table2 = 'division';
      $table3 = 'subdivision';
      $table4 = 'vagga';
      $table5 = 'sutta';
      $table6 = 'groups';
      $table7 = 'concordance';
      $table8 = 'reference';
      $table9 = 'groupinfo';
      $table10 = 'system_info';
?>
<div style="margin-left:3%; margin-right:3%;">
<table border="0" cellpadding="5" cellspacing="5">
<tr>
<td valign="top" rowspan="2">
<p align="justify">This facility enables one to identify the Chinese, Tibetan, and Sanskrit "parallels" or "counterparts" to the suttas of the four main Pali Nikayas - or vice versa. It is designed for those whose interest in the Early Buddhist discourses extends beyond the limits of the Pali Sutta-pi&#7789;aka to include the extensive corresponding materials found elsewhere: the Agamas and individual sutras preserved in Chinese, the occasional sutra translations contained in the Tibetan Kanjur, and the numerous published fragments of sutras in Sanskrit and related languages. It is an up-dated and revised successor to Akanuma's <i>Comparative Catalogue of Chinese Agamas & Pali Nikayas</i> (1929), and is the natural starting point in navigating around this vast mass of textual material.</p>
<p align="justify">As well as showing the correspondences as described above, Sutta Central allows one to access the texts directly in their original language (Pali, Chinese, etc.) and, where available, in modern language translation (e.g., English, French, German, Spanish).</p>
</td>
<td width="123" valign="top" bgcolor="#EEEEEE">
<table><tr><td align="center">
<p><?php
     $status_system = mysql_query("SELECT system_down_ind FROM $table10");
     $ind_status_system = mysql_result($status_system,0);
     echo '<img border="0" src="';
     if($ind_status_system=='N') echo 'yes';
       else echo 'no';
     echo '.gif" width="50" height="50">';
   ?>
<br><b>System Status</b><br>
<?php if($ind_status_system=='N')
      {  $msg_status_system = mysql_query("SELECT operational_message_text FROM $table10");
         echo mysql_result($msg_status_system,0);
      }
      if($ind_status_system=='Y')
      {  $msg_status_system = mysql_query("SELECT warning_message_text FROM $table10");
         if(mysql_result($msg_status_system,0)!='') echo mysql_result($msg_status_system,0).'<br>';
         $msg_status_system = mysql_query("SELECT down_message_text FROM $table10");
         echo '<font color="red">'.mysql_result($msg_status_system,0).'</font>';
      }
?>
</td></tr><tr><td align="center" nowrap><a href="vision.htm">Vision Statement</a><br /><a href="contacts.htm">Contacts</a></tr></table></td></table>
    <?php
    echo '<p><b>Collections:</b> ';
    $result = mysql_query("SELECT collection_name, collection_id FROM $table1 ORDER BY collection_id");
    $showbar=false;
    while($row = mysql_fetch_assoc($result))
    {  if($showbar) echo ' | ';
       echo '<a href="disp_division.php?collection_id='.$row[collection_id].'&collection_name='.$row[collection_name].'">' . $row['collection_name'] . '</a>';
       $showbar=true;
    }
    echo '</p>';
    ?>
<form method="GET" action="disp_result.php">
  <p><b>Search:</b> <input type="text" name="item" size="25"> [<a href="help.php">Help</a>]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Submit">&nbsp;<input type="reset" value="Reset"><br><input type="radio" value="name" checked name="field">Name<input type="radio" name="field" value="acronym">Abbreviation and number<input type="radio" name="field" value="volpage">Volume/Page reference</p>
</form>
</div>
</body>
</html>
