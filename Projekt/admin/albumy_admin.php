<div id="outer-galeria-konto">
	<div id="container-galeria-konto">
	<?php
		 	$str = (isset($_GET['str'])) ? $_GET['str'] : 1;
			if(!isset($_SESSION['admin']['jak'])) $_SESSION['admin']['jak']= 'ASC';
			if($_SESSION['admin']['jak'] == $_GET['jak'])
			{
				if($_SESSION['admin']['jak'] == 'ASC') $_SESSION['admin']['jak'] = 'DESC';
				else $_SESSION['admin']['jak'] = 'ASC';
			}
			if($_SESSION['admin']['sort'] != $_GET['sort'])
			{
				$_SESSION['admin']['jak'] = 'ASC';
			}
			if(!isset($_SESSION['admin']['sort'])) $_SESSION['admin']['sort']= 'tytul';
			if(isset($_GET['sort'])) $_SESSION['admin']['sort']=$_GET['sort'];
			if($_SESSION['admin']['jak']=='ASC'){echo "Sortuj wg: rosnąco <br>";}else{echo "Sortuj wg: malejąco <br>";}
			if($_SESSION['admin']['sort']=='tytul'){
				echo "<a href = 'index.php?content=albumy_admin&sort=tytul&jak=".$_SESSION['admin']['jak']."' class='aktywny'>Tytuł</a>";}
			else {
				echo "<a href = 'index.php?content=albumy_admin&sort=tytul&jak=".$_SESSION['admin']['jak']."' class='nieaktywny'>Tytuł</a>";}
			if($_SESSION['admin']['sort']=='data'){
				echo "<a href = 'index.php?content=albumy_admin&sort=data&jak=".$_SESSION['admin']['jak']."' class='aktywny'>Data powstania</a>";}
			else {
				echo "<a href = 'index.php?content=albumy_admin&sort=data&jak=".$_SESSION['admin']['jak']."' class='nieaktywny'>Data powstania</a>";}
			if($_SESSION['admin']['sort']=='uzytkownicy.login'){
				echo "<a href = 'index.php?content=albumy_admin&sort=uzytkownicy.login&jak=".$_SESSION['admin']['jak']."' class='aktywny'>Właściciel</a><br>";}
			else {
				echo "<a href = 'index.php?content=albumy_admin&sort=uzytkownicy.login&jak=".$_SESSION['admin']['jak']."' class='nieaktywny'>Właściciel</a><br>";}
			$sql = "SELECT albumy.*, min(zdjecia.id) AS foto_id, uzytkownicy.login FROM albumy
							LEFT JOIN zdjecia ON albumy.id=zdjecia.id_albumu
							LEFT JOIN uzytkownicy ON albumy.id_uzytkownika=uzytkownicy.id
							GROUP BY albumy.id
							ORDER BY ".$_SESSION['admin']['sort']." ".$_SESSION['admin']['jak']." LIMIT ".(($str - 1) * 20).",20;";
			$sql_c = "SELECT count(*) AS ile FROM albumy LEFT JOIN zdjecia ON albumy.id=zdjecia.id_albumu GROUP BY albumy.id";
			$result_c = mysqli_query($conn, $sql_c);
			$r = mysqli_num_rows($result_c);
			$ile_stron = ceil($r / 20);

				for($i=1; $i<=$ile_stron; $i++)
				{
					echo "<a href='index.php?content=albumy_admin&str=".$i."'><button>".$i."</button></a>";
				}
				echo "<br>";
				$result = mysqli_query($conn, $sql);
				if (!$result) {
					printf("Error: %s\n", mysqli_error($conn));
					exit();
				}
				print_r($d);
				while($row = mysqli_fetch_array($result))
				{
					$sql_d = "SELECT count(*) as ile , albumy.id
										FROM zdjecia
										LEFT JOIN albumy ON albumy.id=zdjecia.id_albumu
										WHERE zdjecia.zaakceptowane = 0 AND albumy.id = ".$row['id']."
										GROUP BY albumy.id";
					$result_d = mysqli_query($conn, $sql_d);
					$d = mysqli_fetch_assoc($result_d);
					if($row['id']==$d['id']){
					echo "<div id='img_oczekujace'>Oczekujące Zdjęcia: ".$d['ile']."</div>
					<a href='../album.php?albb=".$row['id']."&dest=admin'
							class='zdjecie'><img src='../img/".$row['id']."/m".$row['foto_id']."'></a>
							<div id='img_opis'>Tytuł: ".$row['tytul']."<br>
											   Autor: ".$row['login']."<br>
											   Utworzone: ".$row['data']."</div>";
					}
					else
					{
					echo "<div id='img_oczekujace'>Oczekujące Zdjęcia: 0</div>
					<a href='../album.php?albb=".$row['id']."&dest=admin'
							class='zdjecie'><img src='../img/".$row['id']."/m".$row['foto_id']."'></a>
							<div id='img_opis'>Tytuł: ".$row['tytul']."<br>
											   Autor: ".$row['login']."<br>
											   Utworzone: ".$row['data']."</div>";
					}
				}
				echo "<br>";
				for($i=1; $i<=$ile_stron; $i++)
				{
					echo "<a href='konto.php?content=mojealbumy&str=".$i."'><button>".$i."</button></a>";
				}
			?>
	</div>
</div>
