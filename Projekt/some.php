<?php
  include_once('connect.php');
	

 $php = "SELECT * FROM `zdjecia` WHERE `id_albumu` = ".$_POST['id']." ORDER BY `zdjecia`.`data` DESC";
 $results = mysqli_query($conn, $php);

  while($row = mysqli_fetch_array($results))
  {
    echo "<img src=img/".$row['id_albumu']."/m".$row['id'].">";
  }
 ?>
