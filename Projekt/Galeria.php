<!-- https://css-tricks.com/snippets/css/a-guide-to-flexbox/ FLexbox do stron -->

<!-- SELECT albumy.*, min(zdjecia.id) AS foto_id, uzytkownicy.login
     FROM albumy
        LEFT JOIN zdjecia ON albumy.id=zdjecia.id_albumu
        LEFT JOIN uzytkownicy ON albumy.id_uzytkownika=uzytkownicy.id
     WHERE zdjecia.zaakceptowane
     GROUP BY albumy.id
     ORDER BY albumy.tytul   //Tu dalej limity itd.-->
<!-- SELECT albumy.*, zdjecia.id, uzytkownicy.login FROM albumy LEFT JOIN zdjecia ON albumy.id=zdjecia.id_albumu LEFT JOIN uzytkownicy ON albumy.id_uzytkownika=uzytkownicy.id WHERE zdjecia.zaakceptowane ORDER BY albumy.tytul
-->

<!-- By było responsywne -->
<!-- tytul itp przy najezdzaniu na miniaturke  -->

<!-- Zmienić szatę graficzną -->

<?php
  session_start();
  include_once('menu.php');
  include('connect.php');
 ?>
 <html>
 <head></head>
  <body>
    <div id="outer-galeria">
      <br><br><h1> Znajdujesz się w galerii. </h1><br><br>
    	<div id="container-galeria">
        <?php

    			echo "<b><p style='color: #bfd7ff; font-size:23px;'>Albumy</p></b>";
    		 	$str = (isset($_SESSION['galeria']['str'])) ? $_SESSION['galeria']['str'] : 1;
    			if(!isset($_SESSION['galeria']['jak'])) $_SESSION['galeria']['jak']= 'ASC';

          if(!isset($_SESSION['galeria']['sort'])) $_SESSION['galeria']['sort']='tytul';
    			if(isset($_GET['sort'])) $_SESSION['galeria']['sort']=$_GET['sort'];

      		if($_SESSION['galeria']['jak'] == $_GET['jak'])
    			{

    				if($_SESSION['galeria']['jak'] == 'ASC') $_SESSION['galeria']['jak'] = 'DESC';
    				else $_SESSION['galeria']['jak'] = 'ASC';
    			} // jeśli tak samo to zamień
    			if($_SESSION['galeria']['sort'] != $_GET['sort'])
    			{
    				$_SESSION['galeria']['jak'] = 'ASC';
    			} // jeśli nowe sortowanie to przywróć na rosnąco


    			if($_SESSION['galeria']['jak']=='ASC'){echo "<p>Sortuj wg: rosnąco </p>";}else{echo "Sortuj wg: malejąco <br>";}
    			if($_SESSION['galeria']['sort']=='tytul'){
    				echo "<a href = '".$_SERVER["PHP_SELF"]."?sort=tytul&jak=".$_SESSION['galeria']['jak']."' class='aktywny'>Tytuł   |</a>";}
    			else {
    				echo "<a href = '".$_SERVER["PHP_SELF"]."?sort=tytul&jak=".$_SESSION['galeria']['jak']."' class='nieaktywny'>Tytuł   |</a>";}
    			if($_SESSION['galeria']['sort']=='data'){
    				echo "<a href = '".$_SERVER["PHP_SELF"]."?sort=data&jak=".$_SESSION['galeria']['jak']."' class='aktywny'>Data powstania  |</a>";}
    			else {
    				echo "<a href = '".$_SERVER["PHP_SELF"]."?sort=data&jak=".$_SESSION['galeria']['jak']."' class='nieaktywny'>Data powstania   |</a>";}
    			if($_SESSION['galeria']['sort']=='uzytkownicy.login'){
    				echo "<a href = '".$_SERVER["PHP_SELF"]."?sort=uzytkownicy.login&jak=".$_SESSION['jak']."' class='aktywny'>Właściciel   |</a><br>";}
    			else {
    				echo "<a href = '".$_SERVER["PHP_SELF"]."?sort=uzytkownicy.login&jak=".$_SESSION['jak']."' class='nieaktywny'>Właściciel   |</a><br>";}

        	$sql = "SELECT albumy.*, min(zdjecia.id) AS foto_id, uzytkownicy.login FROM albumy
    							LEFT JOIN zdjecia ON albumy.id=zdjecia.id_albumu
    							LEFT JOIN uzytkownicy ON albumy.id_uzytkownika=uzytkownicy.id
    							WHERE zdjecia.zaakceptowane
    							GROUP BY albumy.id
    							ORDER BY ".$_SESSION['galeria']['sort']." ".$_SESSION['galeria']['jak']." LIMIT ".(($str - 1) * 20).",20;";
    			$sql_c = "SELECT count(*) AS ile FROM albumy LEFT JOIN zdjecia ON albumy.id=zdjecia.id_albumu WHERE zdjecia.zaakceptowane GROUP BY albumy.id";
    			$result_c = mysqli_query($conn, $sql_c);
    			$r = mysqli_num_rows($result_c);

    			$ile_stron = ceil($r / 20);
    				for($i=1; $i<=$ile_stron; $i++)
    				{
    					echo "<a href='".$_SERVER["PHP_SELF"]."?str=".$i."'><button>".$i."</button>";
    				}
    				echo "<br>";
    				$result = mysqli_query($conn, $sql);

    				if (!$result) {
    					printf("Error: %s\n", mysqli_error($conn));
    					exit();
    				}
    				while($row = mysqli_fetch_assoc($result))
    				{
    					echo "<a href='album.php?alb=".$row['id']."&str=1'
    							class='zdjecie'><img src='img/".$row['id']."/m".$row[foto_id]."'
    							width='180px' height='180px'
    							title='".$row['tytul'].", ".$row['login'].", ".$row['data']."'/></a></td>";
    				}
    				echo "<br>";
    				for($i=1; $i<=$ile_stron; $i++)
    				{
    					echo "<a href='".$_SERVER["PHP_SELF"]."?str=".$i."><button>".$i."</button></a>";
    				}
    			?>
    	</div>
    </div>

  </body>
</html>
